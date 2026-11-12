#!/bin/sh
set -eu

cd /var/www/html

if [ -z "${APP_URL:-}" ] && [ -n "${RENDER_EXTERNAL_URL:-}" ]; then
    export APP_URL="$RENDER_EXTERNAL_URL"
fi

touch database/database.sqlite
chown -R www-data:www-data database storage bootstrap/cache

runuser -u www-data -- php artisan migrate --force
runuser -u www-data -- php artisan db:seed --force

exec apache2-foreground
