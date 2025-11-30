#!/bin/sh
set -e

echo "🚀 Starting SSDJ Application..."
echo "🌐 Starting PHP server on 0.0.0.0:${PORT:-8080}..."

# Start PHP server immediately without waiting for migrations
# Migrations should be run manually or via deployment hooks
exec php -S 0.0.0.0:${PORT:-8080} -t public 
