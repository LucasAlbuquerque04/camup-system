#!/bin/bash

echo "🚀 Building frontend assets..."

# Build dos assets dentro do container
docker exec camup_app npm install
docker exec camup_app npm run build

echo "✅ Build concluído! Os assets estão em src/public/build/"
