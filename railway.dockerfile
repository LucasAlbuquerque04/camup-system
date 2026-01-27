# Dockerfile otimizado para produção no Railway
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

# Criar script de inicialização inline
RUN echo '#!/bin/bash\n\
  set -e\n\
  echo "🚀 Iniciando CamUp..."\n\
  \n\
  # Gerar APP_KEY se não existir\n\
  if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "base64:" ]; then\n\
  echo "⚠️  Gerando APP_KEY..."\n\
  php artisan key:generate --force\n\
  fi\n\
  \n\
  # Rodar migrations\n\
  echo "📊 Rodando migrations..."\n\
  php artisan migrate --force --no-interaction || true\n\
  \n\
  # Otimizar aplicação\n\
  echo "⚡ Otimizando..."\n\
  php artisan config:cache\n\
  php artisan route:cache\n\
  php artisan view:cache\n\
  \n\
  # Link do storage\n\
  php artisan storage:link || true\n\
  \n\
  # Permissões\n\
  chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache\n\
  chmod -R 775 /var/www/storage /var/www/bootstrap/cache\n\
  \n\
  echo "✅ Inicialização completa!"\n\
  \n\
  # Iniciar Supervisor\n\
  exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf\n\
  ' > /usr/local/bin/start.sh && chmod +x /usr/local/bin/start.sh

# Iniciar aplicação
CMD ["/usr/local/bin/start.sh"]
