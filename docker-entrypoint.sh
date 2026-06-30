#!/bin/sh
set -e

/usr/local/bin/docker-bootstrap.sh

php artisan config:cache || echo "[entrypoint] WARNING: config:cache failed — continuing with existing config."

exec "$@"
