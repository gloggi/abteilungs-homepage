#!/bin/bash

composer install --no-interaction --no-plugins --no-scripts --prefer-dist

if [[ ! -f .env ]]; then
    cp .env.example .env
    while [ ! -f .env ]; do
        sleep 1
    done
    php artisan key:generate
    php artisan config:cache
    php artisan config:clear
fi

php artisan storage:link
chmod 777 -R storage bootstrap/cache

php artisan db:wait

php artisan migrate

php artisan db:seed

apache2-foreground
