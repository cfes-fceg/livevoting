#!/bin/sh

# Update Composer binary.

export COMPOSER_HOME=/root

sudo COMPOSER_MEMORY_LIMIT=-1 php -d memory_limit=-1 /usr/bin/composer.phar self-update
