#!/bin/bash

echo "Iniciando o deploy do NC5 Mail..."

# 1. Atualizar sistema e instalar pacotes essenciais
sudo apt-get update -y
sudo apt-get install -y git curl unzip software-properties-common

# 2. Instalar PHP 8.2 e Extensões
sudo add-apt-repository -y ppa:ondrej/php
sudo apt-get update -y
sudo apt-get install -y nginx mysql-server redis-server
sudo apt-get install -y php8.2-fpm php8.2-cli php8.2-mysql php8.2-mbstring php8.2-xml php8.2-curl php8.2-zip php8.2-gd php8.2-intl php8.2-bcmath

# 3. Instalar Composer
curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer

# 4. Instalar Docker
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh
sudo systemctl enable --now docker

# 5. Clonar o repositório
cd /var/www
sudo git clone https://github.com/joselopesnei50/web-mail.git nc5mail
sudo chown -R $USER:www-data nc5mail
cd nc5mail

# 6. Configurar Laravel
composer install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate
sudo chmod -R 775 storage bootstrap/cache

# 7. Iniciar Servidor de E-mail
sudo docker compose -f docker-compose.prod.yml up -d

echo "================================================="
echo " Instalação concluída com sucesso!"
echo " Próximos passos:"
echo " 1. Edite o arquivo .env e configure o banco de dados"
echo " 2. Execute: php artisan migrate --seed"
echo "================================================="
