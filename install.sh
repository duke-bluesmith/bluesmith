#!/bin/sh -e

##
# Bluesmith Install Script
#
# To be run after the code is pulled to the to install/upgrade
# the dependencies, database, and assets. Safe to rerun every update.
##

SCRIPT=`dirname "$0"`
cd "$SCRIPT"

composer check-platform-reqs
composer install
php spark migrate --all
php spark db:seed InitialSeeder
php spark publish
php spark handlers:cache
