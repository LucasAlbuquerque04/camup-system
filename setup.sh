#!/bin/bash

echo "🚀 Iniciando setup do CamUp Financeiro..."

echo "📦 Subindo containers..."
docker compose up -d --build

echo "⏳ Aguardando containers..."
sleep 5

echo "🔧 Instalando dependências PHP..."
docker compose exec app composer install

echo "⚙️ Configurando ambiente..."
docker compose exec app cp .env.example .env

echo "🔑 Gerando APP_KEY..."
docker compose exec app php artisan key:generate

echo "🗄️ Rodando migrations (Schema Financeiro)..."
docker compose exec app php artisan migrate

echo "🔐 Ajustando permissões..."
docker compose exec app chown -R www-data:www-data storage bootstrap/cache
docker compose exec app chmod -R 775 storage bootstrap/cache

echo "🚀 Building frontend assets..."

docker exec camup_app npm install
docker exec camup_app npm run build

echo "✅ Build concluído! Os assets estão em src/public/build/"

echo "✅ Setup finalizado!"
echo "🌐 Acesse: http://localhost:8010"
