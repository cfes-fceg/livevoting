#!/usr/bin/env bash
if [ $APP_ENV == 'local' ] || [ $APP_ENV == 'staging'  ] ; then
    composer install
    composer mfs
else
    php artisan migrate --force
fi
