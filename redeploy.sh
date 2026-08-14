#!/bin/bash
# Redeploy apos git pull. Roda no VPS em /var/www/nc5mail.
# Sequencia importa: pull -> autoload -> migrate -> clear -> cache -> permissoes -> reload.
set -e

APP_DIR="/var/www/nc5mail"
cd "$APP_DIR"

echo "==> git pull"
git pull --ff-only

echo "==> composer install"
composer install --no-dev --optimize-autoloader

echo "==> composer dump-autoload"
composer dump-autoload -o

echo "==> php artisan migrate --force"
php artisan migrate --force

echo "==> php artisan storage:link (idempotente)"
php artisan storage:link || true

echo "==> optimize:clear + rebuild caches"
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> permissoes"
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

echo "==> reload php-fpm + nginx + supervisor (queue worker)"
sudo systemctl reload php8.2-fpm
sudo systemctl reload nginx
if command -v supervisorctl >/dev/null 2>&1; then
    sudo supervisorctl restart nc5mail-worker:* || true
fi

echo "==> Redeploy concluido."
