#!/bin/sh
set -e

echo "🚀 Starting SSDJ Application..."

# Run migrations if needed
echo "📊 Running migrations..."
php artisan migrate --force || echo "⚠️  Migrations already completed or skipped"

# Start PHP server
echo "🌐 Starting PHP server on 0.0.0.0:${PORT:-8080}..."
exec php -S 0.0.0.0:${PORT:-8080} -t public 
