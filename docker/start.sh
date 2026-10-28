#!/bin/sh
# Prepares the app on every start, then runs Apache.
set -e
cd /var/www/html

# A key is needed to encrypt sessions. Use APP_KEY if the host provides one.
if [ -z "$APP_KEY" ]; then
  export APP_KEY="$(php artisan key:generate --show)"
fi

# SQLite database file (created on first start).
if [ "$DB_CONNECTION" = "sqlite" ]; then
  DB_FILE="${DB_DATABASE:-/var/www/html/database/database.sqlite}"
  mkdir -p "$(dirname "$DB_FILE")"
  [ -f "$DB_FILE" ] || touch "$DB_FILE"
  chown -R www-data:www-data "$(dirname "$DB_FILE")"
fi

php artisan storage:link >/dev/null 2>&1 || true
php artisan migrate --force
php artisan db:seed --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
chown -R www-data:www-data storage bootstrap/cache

exec apache2-foreground
