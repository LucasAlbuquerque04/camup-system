#!/bin/bash

set -e

echo "==> Iniciando CamUp em producao..."

# Aguardar banco estar pronto
echo "==> Aguardando banco de dados..."
sleep 5

# Verificar se APP_KEY está configurada
if [ -z "$APP_KEY" ]; then
    echo "ERRO: APP_KEY nao configurada nas variaveis de ambiente!"
    echo "Configure APP_KEY no Railway antes de continuar."
    exit 1
fi
echo "==> APP_KEY configurada!"


# Rodar migrations
echo "==> Executando migrations..."
php artisan migrate --force --no-interaction || echo "Migrations falharam, continuando..."

# Otimizações
echo "==> Otimizando aplicacao..."
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true
php artisan storage:link || true

# Permissões
echo "==> Ajustando permissoes..."
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache 2>/dev/null || true
chmod -R 775 /var/www/storage /var/www/bootstrap/cache 2>/dev/null || true

echo "==> Aplicacao pronta!"
echo "==> Iniciando Nginx e PHP-FPM..."

# Iniciar supervisor em foreground (IMPORTANTE: -n flag)
exec /usr/bin/supervisord -n -c /etc/supervisor/conf.d/supervisord.conf
