#!/bin/bash

echo "🚀 Building frontend assets..."

# Build assets inside the container
docker exec camup_app npm install
docker exec camup_app npm run build

echo "✅ Build completed! Assets are in src/public/build/"
