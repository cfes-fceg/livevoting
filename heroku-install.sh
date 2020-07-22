#!/usr/bin/env bash
if [ $APP_ENV == 'local' ] || [ $APP_ENV == 'staging'  ] ; then
    composer install --dev
    composer mfs
else
    php artisan migrate
fi

php artisan passport:keys
