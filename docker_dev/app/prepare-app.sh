#!/bin/sh

set -e

cd /var/www

if [ ! -d "vendor" ]
then
  echo "Composer install"
  composer install --no-interaction --optimize-autoloader
fi

echo "Composer dump"
composer dump-autoload --optimize

if [ ! -h "public/storage" ]
then
  echo "Storage link"
  php artisan storage:link
fi

echo "Clean app cache"
php artisan config:clear
php artisan cache:clear
php artisan optimize:clear
php artisan route:clear
php artisan view:clear
