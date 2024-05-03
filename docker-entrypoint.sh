#!/bin/bash
set -e

cd /usr/src/bettingpros
composer install --no-interaction --quiet
exec php parser.php "$@"
