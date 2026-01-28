#!/bin/bash

set -e

echo "==> Iniciando CamUp em producao..."

# Exportar variáveis explicitamente com valores padrão do Railway
export APP_NAME="${APP_NAME:-CamUp}"
export APP_ENV="${APP_ENV:-production}"
export APP_DEBUG="${APP_DEBUG:-false}"
export DB_CONNECTION="${DB_CONNECTION:-mysql}"

# Debug: mostrar variáveis disponíveis
echo "==> Debug: Verificando variaveis de ambiente..."
echo "APP_NAME: $APP_NAME"
echo "APP_ENV: $APP_ENV"
echo "APP_KEY: ${APP_KEY:0:20}..."
echo "DB_CONNECTION: $DB_CONNECTION"
echo "DB_HOST: $DB_HOST"
echo "DB_PORT: $DB_PORT"
echo "DB_DATABASE: $DB_DATABASE"
echo ""

# Usar variáveis MySQL do Railway com fallbacks explícitos
export DB_HOST="${DB_HOST:-mysql.railway.internal}"
export DB_PORT="${DB_PORT:-3306}"
export DB_DATABASE="${DB_DATABASE:-railway}"
export DB_USERNAME="${DB_USERNAME:-root}"
export DB_PASSWORD="${DB_PASSWORD:-}"

# APP_KEY: usar valor configurado ou gerar um padrão
if [ -z "$APP_KEY" ]; then
    echo "AVISO: APP_KEY vazia, usando valor padrao..."
    export APP_KEY="base64:giLgDlAD0HuRvfWJQa7GxOoKDfuQQOvfFx8Kw1b5jK8="
fi

echo "==> Valores finais que serao usados:"
echo "DB_HOST: $DB_HOST"
echo "DB_PORT: $DB_PORT"
echo "DB_DATABASE: $DB_DATABASE"
echo "DB_USERNAME: $DB_USERNAME"
echo "APP_KEY: ${APP_KEY:0:20}..."
echo ""

# Se APP_URL estiver vazio, usar o domínio público do Railway
if [ -z "$APP_URL" ]; then
    if [ -n "$RAILWAY_PUBLIC_DOMAIN" ]; then
        export APP_URL="https://$RAILWAY_PUBLIC_DOMAIN"
        echo "==> APP_URL configurado automaticamente: $APP_URL"
    else
        export APP_URL="http://localhost:8080"
        echo "AVISO: APP_URL nao configurado, usando localhost"
    fi
fi

# Criar .env mínimo para Laravel (ele precisa do arquivo)
echo "==> Criando arquivo .env..."
cat > /var/www/.env << EOF
APP_NAME=${APP_NAME}
APP_ENV=${APP_ENV}
APP_KEY=${APP_KEY}
APP_DEBUG=${APP_DEBUG}
APP_URL=${APP_URL}
DB_CONNECTION=${DB_CONNECTION}
DB_HOST=${DB_HOST}
DB_PORT=${DB_PORT}
DB_DATABASE=${DB_DATABASE}
DB_USERNAME=${DB_USERNAME}
DB_PASSWORD=${DB_PASSWORD}
SESSION_DRIVER=${SESSION_DRIVER:-database}
CACHE_STORE=${CACHE_STORE:-database}
LOG_LEVEL=${LOG_LEVEL:-error}
EOF

# Aguardar banco estar pronto
echo "==> Aguardando banco de dados..."
sleep 5

# Rodar migrations
echo "==> Executando migrations..."
php artisan migrate --force --no-interaction || echo "Migrations falharam, continuando..."

# IMPORTANTE: Limpar cache ANTES de otimizar (pode estar corrompido)
echo "==> Limpando cache corrompido..."
rm -rf /var/www/bootstrap/cache/*.php || true
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true
php artisan cache:clear || true

# Otimizações (agora com cache limpo)
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
