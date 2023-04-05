#!/usr/bin/env sh

# Run user scripts, if they exist
for f in /var/www/html/.fly/scripts/*.sh; do
    # Bail out this loop if any script exits with non-zero status code
    bash "$f" || break
done
chown -R webuser:webgroup /var/www/html
# chown -R www-data:www-data /var/www/html

if [ $# -gt 0 ]; then
    # If we passed a command, run it as root
    exec "$@"

    # exec nohup /usr/bin/php /var/www/html/artisan queue:work  --sleep=3 --tries=3 --timeout=3600   </dev/null &>/dev/null &
    #  nohup /usr/bin/php /var/www/html/artisan queue:work  --sleep=3 --tries=3 --timeout=3600   </dev/null &>/dev/null &
    # exec /usr/bin/supervisord -c /etc/supervisor/supervisord.conf

else
    # exec /usr/bin/supervisord -c /etc/supervisor/supervisord.conf
    # exec /usr/bin/supervisord -c /etc/supervisor/supervisord.conf & disown
    exec /init 
fi

# nohup /usr/bin/php /var/www/html/artisan queue:work  --sleep=3 --tries=3 --timeout=3600   </dev/null &>/dev/null &
