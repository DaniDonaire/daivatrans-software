#!/bin/bash





echo "Vamos a limpiar tu cache"

php artisan cache:clear
php artisan route:clear
php artisan config:clear 
php artisan view:clear 
php artisan clear-compiled 
composer dump-autoload