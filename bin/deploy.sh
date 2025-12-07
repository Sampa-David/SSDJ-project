#!/bin/bash
set -e

echo "🚀 SSDJ Deployment on Render..."
echo "================================"

# Navigate to app directory
cd /opt/render/project/src || true

# Update composer dependencies
echo "📦 Installing dependencies..."
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

# Run database seeders
echo "🌱 Seeding database..."
php artisan db:seed --force

# Build frontend assets
echo "🎨 Building assets..."
npm install --production
npm run build

# Optimize for production
echo "⚡ Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Deployment complete!"
echo "🌐 Your app will be available at: https://ssdj-app.onrender.com"
