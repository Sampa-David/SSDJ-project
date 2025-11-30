#!/bin/sh
set -e

echo "🚀 SSDJ Railway Deployment..."
echo "=============================="

# Get current working directory (Railway uses /workspace)
APP_DIR=$(pwd)
echo "📂 Working directory: $APP_DIR"

# 1. Install PHP dependencies
echo ""
echo "📦 Installing PHP dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# 2. Install Node dependencies and build assets
echo ""
echo "🎨 Building frontend assets..."
if [ -f "package.json" ]; then
    npm ci --omit=dev 2>/dev/null || npm install --omit=dev 2>/dev/null || true
    npm run build 2>/dev/null || echo "⚠️  npm build failed, continuing..."
else
    echo "⚠️  package.json not found, skipping npm build"
fi

# 3. Generate APP_KEY if not already set
echo ""
if [ -z "$APP_KEY" ]; then
    echo "🔑 Generating APP_KEY..."
    php artisan key:generate --force
else
    echo "✅ APP_KEY already set"
fi

# 4. Clear all caches (important for fresh deployment)
echo ""
echo "🧹 Clearing caches..."
php artisan config:clear || true
php artisan cache:clear || true
php artisan view:clear || true
php artisan route:clear || true

# 5. Optimize configuration for production
echo ""
echo "⚡ Optimizing for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 6. Run database migrations
echo ""
echo "📊 Running database migrations..."
php artisan migrate --force --no-interaction || true

# 7. Seed database (optional, only if needed)
echo ""
echo "🌱 Seeding database..."
# Skip seeding during build - will run at startup if needed
echo "⏳ Database seeding will run at startup if needed"

# 8. Set proper permissions
echo ""
echo "🔒 Setting permissions..."
chmod -R 755 storage bootstrap/cache 2>/dev/null || true

echo ""
echo "✅ Build complete!"
echo "🌐 App will start and run migrations at startup"
