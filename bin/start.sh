#!/bin/sh
set -e

echo "🚀 Starting SSDJ Application..."

# Wait for MySQL to be ready
echo "⏳ Waiting for MySQL to be ready..."
for i in $(seq 1 30); do
    if php -r "new PDO('mysql:host=mysql;port=3306', '$DB_USERNAME', '$DB_PASSWORD');" 2>/dev/null; then
        echo "✅ MySQL is ready!"
        break
    fi
    echo "  Attempt $i/30: MySQL not ready yet, retrying in 1 second..."
    sleep 1
done

# Run migrations if needed
echo "📊 Running migrations..."
php artisan migrate --force || echo "⚠️  Migrations already completed or skipped"

# Start PHP server
echo "🌐 Starting PHP server on 0.0.0.0:${PORT:-8080}..."
exec php -S 0.0.0.0:${PORT:-8080} -t public 
