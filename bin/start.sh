#!/bin/sh
set -e

echo "🚀 Starting SSDJ Application..."

# Wait for MySQL to be ready on the network
echo "⏳ Waiting for MySQL to be ready..."
MYSQL_HOST="${DB_HOST:-mysql}"
MYSQL_PORT="${DB_PORT:-3306}"

for i in $(seq 1 60); do
    if nc -z "$MYSQL_HOST" "$MYSQL_PORT" 2>/dev/null; then
        echo "✅ MySQL is ready on $MYSQL_HOST:$MYSQL_PORT!"
        break
    fi
    echo "  Attempt $i/60: MySQL not accessible yet, retrying..."
    sleep 1
    
    if [ $i -eq 60 ]; then
        echo "❌ MySQL did not become available after 60 seconds"
        exit 1
    fi
done

# Give MySQL a bit more time to stabilize
sleep 2

# Run migrations if needed
echo "📊 Running migrations..."
php artisan migrate --force || echo "⚠️  Migrations already completed or skipped"

# Start PHP server
echo "🌐 Starting PHP server on 0.0.0.0:${PORT:-8080}..."
exec php -S 0.0.0.0:${PORT:-8080} -t public 
