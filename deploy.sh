#!/bin/bash
# Deploy INICIAL do NC5 Mail (bootstrap de VPS zerada).
# Para redeploys apos git pull, usar ./redeploy.sh
set -e

echo "==> Iniciando bootstrap do NC5 Mail..."

# 1. Sistema base
sudo apt-get update -y
sudo apt-get install -y git curl unzip software-properties-common

# 2. PHP 8.2 + extensoes
sudo add-apt-repository -y ppa:ondrej/php
sudo apt-get update -y
sudo apt-get install -y nginx mysql-server redis-server
sudo apt-get install -y php8.2-fpm php8.2-cli php8.2-mysql php8.2-mbstring php8.2-xml php8.2-curl php8.2-zip php8.2-gd php8.2-intl php8.2-bcmath

# 3. Composer
curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer

# 4. Docker
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh
sudo systemctl enable --now docker

# 5. Clone
cd /var/www
sudo git clone https://github.com/joselopesnei50/web-mail.git nc5mail
sudo chown -R $USER:www-data nc5mail
cd nc5mail

# 6. Laravel
composer install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate
php artisan storage:link
php artisan migrate --force
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

# 7. Caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 8. Mailserver Docker
sudo docker compose -f docker-compose.prod.yml up -d

echo "================================================="
echo " Bootstrap concluido."
echo " Proximos passos MANUAIS:"
echo " 1. Editar .env: APP_ENV=production, APP_DEBUG=false,"
echo "    APP_URL=https://app.nc5hubdigital.com.br,"
echo "    DB_*, MAIL_*, IMAP_* com credenciais reais,"
echo "    QUEUE_CONNECTION=database, CORS_ALLOWED_ORIGINS=..."
echo " 2. Copiar nginx-laravel.conf para /etc/nginx/sites-available/nc5mail"
echo "    e ativar via symlink em sites-enabled + certbot para SSL."
echo " 3. Configurar supervisor para queue worker (ver docs/supervisor.conf)"
echo " 4. Adicionar cron: * * * * * cd /var/www/nc5mail && php artisan schedule:run >> /dev/null 2>&1"
echo "================================================="
