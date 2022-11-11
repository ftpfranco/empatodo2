heroku run -a sadministracion php artisan migrate 
heroku run -a sadministracion php artisan db:seed --class TipoPagoSeeder 
heroku run -a sadministracion php artisan db:seed --class VentasEstadoEnvioSeeder


#php artisan vendor:publish --provider="Mews\Purifier\PurifierServiceProvider"
