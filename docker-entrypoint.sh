#!/bin/sh
set -e

/usr/local/bin/docker-bootstrap.sh

php artisan config:cache

exec "$@"
