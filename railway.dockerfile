# Dockerfile otimizado para produção no Railway
# Build: 2026-01-27 v2
FROM php:8.2-fpm

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
  git \
  unzip \
  zip \
  curl \
  libpng-dev \
  libonig-dev \
  libxml2-dev \
  libzip-dev \
  nginx \
  supervisor \
  && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/*

# Instalar Node.js 20 LTS
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
  && apt-get install -y nodejs \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Configurar diretório de trabalho
WORKDIR /var/www

# Copiar arquivos do projeto
COPY src/ /var/www/

# Instalar dependências PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Instalar dependências Node e compilar assets
RUN npm install && npm run build

# Configurar permissões do Laravel
RUN chown -R www-data:www-data /var/www \
  && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Copiar configuração do Nginx
COPY docker/nginx/railway.conf /etc/nginx/sites-available/default

# Copiar configuração do Supervisor
COPY docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Expor porta 8080 (padrão do Railway)
EXPOSE 8080

# Criar script de inicialização
COPY docker/scripts/railway-start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Nota: O comando de start é controlado pelo railway.json
