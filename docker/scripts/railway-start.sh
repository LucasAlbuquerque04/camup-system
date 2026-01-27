#!/bin/bash

# Script de inicialização para produção no Railway
# Este script roda automaticamente antes do container iniciar

set -e

echo "🚀 Iniciando CamUp em produção..."

# 1. Verificar se APP_KEY existe
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "base64:" ]; then
    echo "⚠️  APP_KEY não configurada. Gerando..."
    php artisan key:generate --force
fi

# 2. Rodar migrations automaticamente
echo "📊 Rodando migrations..."
php artisan migrate --force --no-interaction

# 3. Limpar e cachear configurações
echo "⚡ Otimizando aplicação..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 4. Criar link simbólico para storage (se necessário)
if [ ! -L "/var/www/public/storage" ]; then
    echo "🔗 Criando link do storage..."
    php artisan storage:link
fi

# 5. Ajustar permissões finais
echo "🔐 Ajustando permissões..."
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

echo "✅ Inicialização completa!"
echo "🌐 Aplicação pronta para receber requisições"

# Iniciar Supervisor
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
