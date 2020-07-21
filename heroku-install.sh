#!/usr/bin/env bash
if [ $APP_ENV == 'local' ] || [ $APP_ENV == 'staging'  ] ; then
    npm run prod
    composer install --dev
    composer mfs
else
    php artisan migrate
fi
