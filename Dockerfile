ARG PHP_VERSION=7.4
ARG NODE_VERSION=14
FROM fh1703/ubuntu18_nginx_php:7.4 as base

# PHP_VERSION needs to be repeated here
# See https://docs.docker.com/engine/reference/builder/#understand-how-arg-and-from-interact
ARG PHP_VERSION

LABEL fly_launch_runtime="laravel"

RUN apt-get update && apt-get install -y \
    git curl zip unzip rsync ca-certificates nano htop cron \
    php${PHP_VERSION}-pgsql php${PHP_VERSION}-bcmath \
    php${PHP_VERSION}-swoole php${PHP_VERSION}-xml php${PHP_VERSION}-mbstring \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* \
    && apt-get install -yq tzdata && \
    ln -fs /usr/share/zoneinfo/America/Argentina/Tucuman /etc/localtime && \
    dpkg-reconfigure -f noninteractive tzdata

WORKDIR /var/www/html
# copy application code, skipping files based on .dockerignore
COPY . /var/www/html

RUN composer install    \
    && mkdir -p storage/logs \
    && php artisan optimize:clear \
    && chown -R www-data:www-data /var/www/html \
    && sed -i 's/protected \$proxies/protected \$proxies = "*"/g' app/Http/Middleware/TrustProxies.php \
    && echo "MAILTO=\"\"\n* * * * * webuser /usr/bin/php /var/www/html/artisan schedule:run" > /etc/cron.d/laravel \
    && rm -rf /etc/cont-init.d/* \
    && cp .fly/nginx-websockets.conf /etc/nginx/conf.d/websockets.conf \
    && cp .fly/entrypoint.sh /entrypoint \
    && chmod +x /entrypoint

# If we're using Octane...
RUN if grep -Fq "laravel/octane" /var/www/html/composer.json; then \
        rm -rf /etc/services.d/php-fpm; \
        if grep -Fq "spiral/roadrunner" /var/www/html/composer.json; then \
            mv .fly/octane-rr /etc/services.d/octane; \
            if [ -f ./vendor/bin/rr ]; then ./vendor/bin/rr get-binary; fi; \
            rm -f .rr.yaml; \
        else \
            mv .fly/octane-swoole /etc/services.d/octane; \
        fi; \
        cp .fly/nginx-default-swoole /etc/nginx/sites-available/default; \
    else \
        cp .fly/nginx-default /etc/nginx/sites-available/default; \
    fi

# Multi-stage build: Build static assets
# This allows us to not include Node within the final container
FROM node:${NODE_VERSION} as node_modules_go_brrr

RUN mkdir /app

RUN mkdir -p  /app
WORKDIR /app
COPY . .
COPY --from=base /var/www/html/vendor /app/vendor

# Use yarn or npm depending on what type of
# lock file we might find. Defaults to
# NPM if no lock file is found.
# Note: We run "production" for Mix and "build" for Vite
RUN if [ -f "vite.config.js" ]; then \
        ASSET_CMD="build"; \
    else \
        ASSET_CMD="production"; \
    fi; \
    if [ -f "yarn.lock" ]; then \
        yarn install --frozen-lockfile; \
        yarn $ASSET_CMD; \
    elif [ -f "package-lock.json" ]; then \
        npm ci --no-audit; \
        npm run $ASSET_CMD -f; \
    else \
        npm install -f; \
        npm run $ASSET_CMD -f; \
    fi;

# From our base container created above, we
# create our final image, adding in static
# assets that we generated above
FROM base

# Packages like Laravel Nova may have added assets to the public directory
# or maybe some custom assets were added manually! Either way, we merge
# in the assets we generated above rather than overwrite them
COPY --from=node_modules_go_brrr /app/public /var/www/html/public-npm
RUN rsync -ar /var/www/html/public-npm/ /var/www/html/public/ \
    && rm -rf /var/www/html/public-npm \
    && chown -R www-data:www-data /var/www/html/public

EXPOSE 8080
EXPOSE 6001

ENTRYPOINT ["/entrypoint"]
