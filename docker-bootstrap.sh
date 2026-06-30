#!/bin/sh
# Writable dirs, migrations, public storage link, and bundled upload sync.
# Used by docker-entrypoint.sh on container start and by the Helm pre-upgrade Job.
set -e

mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/framework/testing
mkdir -p storage/logs
mkdir -p storage/app/public
mkdir -p bootstrap/cache

chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true
chmod -R ug+rwx storage bootstrap/cache 2>/dev/null || true

if [ "${RUN_MIGRATIONS_ON_START:-true}" != "false" ]; then
  echo "[bootstrap] Running database migrations..."
  php artisan migrate --force
else
  echo "[bootstrap] Skipping migrations (RUN_MIGRATIONS_ON_START=false)."
fi

if [ "${RUN_SEEDERS_ON_START:-false}" = "true" ]; then
  echo "[bootstrap] Running database seeders..."
  php artisan db:seed --class=ModelSeeder --force
  php artisan db:seed --class=BlogSeeder --force
  php artisan db:seed --class=TestimonialSeeder --force
fi

if [ -d /var/www/html/storage-app-public-seed ]; then
  if [ ! -d storage/app/public/uploads/models ] || [ -z "$(ls -A storage/app/public/uploads/models 2>/dev/null)" ]; then
    echo "[bootstrap] Copying bundled public storage into mounted volume..."
    cp -a /var/www/html/storage-app-public-seed/. storage/app/public/
  fi
fi

if [ "${RUN_STORAGE_LINK_ON_START:-true}" != "false" ]; then
  echo "[bootstrap] Linking public storage..."
  php artisan storage:link --force
else
  echo "[bootstrap] Skipping storage:link (RUN_STORAGE_LINK_ON_START=false)."
fi

echo "[bootstrap] Done."
