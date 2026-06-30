#!/bin/sh
# Writable dirs, migrations, public storage link, and bundled upload sync.
# Used by docker-entrypoint.sh on container start and by the Helm migrate Job.
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
  attempts=0
  max_attempts=6
  migrated=false
  while [ "$attempts" -lt "$max_attempts" ]; do
    if php artisan migrate --force; then
      migrated=true
      break
    fi
    attempts=$((attempts + 1))
    if [ "$attempts" -lt "$max_attempts" ]; then
      echo "[bootstrap] Migration attempt ${attempts}/${max_attempts} failed, retrying in 5s..."
      sleep 5
    fi
  done
  if [ "$migrated" != "true" ]; then
    echo "[bootstrap] WARNING: migrations failed after ${max_attempts} attempts — continuing startup."
  fi
else
  echo "[bootstrap] Skipping migrations (RUN_MIGRATIONS_ON_START=false)."
fi

if [ "${RUN_SEEDERS_ON_START:-false}" = "true" ]; then
  echo "[bootstrap] Running database seeders..."
  php artisan db:seed --class=ModelSeeder --force || echo "[bootstrap] WARNING: ModelSeeder failed."
  php artisan db:seed --class=BlogSeeder --force || echo "[bootstrap] WARNING: BlogSeeder failed."
  php artisan db:seed --class=TestimonialSeeder --force || echo "[bootstrap] WARNING: TestimonialSeeder failed."
fi

if [ -d /var/www/html/storage-app-public-seed ]; then
  echo "[bootstrap] Syncing bundled public storage into mounted volume..."
  find /var/www/html/storage-app-public-seed -type f | while read -r seed_file; do
    rel="${seed_file#/var/www/html/storage-app-public-seed/}"
    dest="storage/app/public/${rel}"
    if [ ! -f "$dest" ]; then
      mkdir -p "$(dirname "$dest")"
      cp -a "$seed_file" "$dest"
    fi
  done
fi

if [ "${RUN_STORAGE_LINK_ON_START:-true}" != "false" ]; then
  echo "[bootstrap] Linking public storage..."
  php artisan storage:link --force
else
  echo "[bootstrap] Skipping storage:link (RUN_STORAGE_LINK_ON_START=false)."
fi

echo "[bootstrap] Done."
