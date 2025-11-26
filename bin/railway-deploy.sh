#!/bin/bash
set -e

echo "🚀 SSDJ Deployment on Railway..."
echo "================================"

# Navigate to app directory
cd /app || true

# Update composer dependencies
echo "📦 Installing PHP dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader

# Generate APP_KEY if not exists
if [ -z "$APP_KEY" ]; then
  echo "🔑 Generating APP_KEY..."
  php artisan key:generate --force
fi

# Clear all caches
echo "🧹 Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Run database migrations
echo "📊 Running migrations..."
php artisan migrate --force

# Build frontend assets
echo "🎨 Building assets..."
npm install --production 2>/dev/null || echo "npm install skipped"
npm run build 2>/dev/null || echo "npm build skipped"

# Optimize for production
echo "⚡ Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Deployment complete!"
echo "🌐 Your app will be available at: https://ssdj.railway.app"
