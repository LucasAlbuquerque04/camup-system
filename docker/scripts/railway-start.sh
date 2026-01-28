#!/bin/bash

set -e

echo "==> Iniciando CamUp em producao..."

# Exportar variáveis explicitamente
export APP_NAME="${APP_NAME:-CamUp}"
export APP_ENV="${APP_ENV:-production}"
export APP_DEBUG="${APP_DEBUG:-false}"
export APP_KEY="${APP_KEY}"
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
echo "==> Variaveis MySQL do Railway:"
echo "MYSQLHOST: $MYSQLHOST"
echo "MYSQLPORT: $MYSQLPORT"
echo "MYSQLDATABASE: $MYSQLDATABASE"
echo "MYSQLUSER: $MYSQLUSER"
echo ""
echo "==> TODAS as variaveis MySQL disponiveis:"
env | grep -i mysql | head -20 || echo "Nenhuma variavel MySQL encontrada"
echo ""

# Usar variáveis MySQL do Railway como fallback
export DB_HOST="${DB_HOST:-$MYSQLHOST}"
export DB_PORT="${DB_PORT:-$MYSQLPORT}"
export DB_DATABASE="${DB_DATABASE:-$MYSQLDATABASE}"
export DB_USERNAME="${DB_USERNAME:-$MYSQLUSER}"
export DB_PASSWORD="${DB_PASSWORD:-$MYSQLPASSWORD}"

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
SESSION_DRIVER=${SESSION_DRIVER}
CACHE_STORE=${CACHE_STORE}
LOG_LEVEL=${LOG_LEVEL}
EOF

# Aguardar banco estar pronto
echo "==> Aguardando banco de dados..."
sleep 5

# Verificar se APP_KEY está configurada
if [ -z "$APP_KEY" ]; then
    echo "ERRO: APP_KEY nao configurada nas variaveis de ambiente!"
    echo "Por favor, adicione APP_KEY nas variaveis do Railway."
    echo "Valor sugerido: base64:giLgDlAD0HuRvfWJQa7GxOoKDfuQQOvfFx8Kw1b5jK8="
    # Não sair, apenas avisar e continuar (temporário para debug)
    echo "AVISO: Continuando sem APP_KEY para debug..."
else
    echo "==> APP_KEY configurada!"
fi


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
