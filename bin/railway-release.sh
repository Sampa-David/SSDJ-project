#!/bin/bash

# Railway Release Phase - Runs before web dyno starts
set -e

echo "🚀 Starting Railway Release Phase..."
echo ""

# Set error handling
trap 'echo "❌ Release failed: $1"; exit 1' ERR

# Run migrations
echo "📦 Running database migrations..."
php artisan migrate --force --no-interaction

# Cache configuration for better performance
echo "⚙️ Caching configuration..."
php artisan config:cache

# Cache routes for better performance
echo "📍 Caching routes..."
php artisan route:cache

# Clear old cache
echo "🧹 Clearing old cache..."
php artisan cache:clear

echo ""
echo "✅ Release phase completed successfully!"
