#!/bin/sh -e

##
# Bluesmith Upgrade Script
#
# To be run after the code is updated to the
# latest version (e.g. `git pull`) to upgrade
# the dependencies, database, and assets.
##

SCRIPT=`dirname "$0"`
cd "$SCRIPT"

composer check-platform-reqs
composer install
php spark db:migrate --all
php spark db:seed InitialSeeder
php spark assets:publish
