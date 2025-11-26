#!/bin/bash
set -e

echo "🔍 SSDJ Railway Configuration Validation"
echo "========================================="
echo ""

# Colors
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m'

# Counter
PASS=0
FAIL=0

# Function to print result
check() {
    if [ $1 -eq 0 ]; then
        echo -e "${GREEN}✅ $2${NC}"
        ((PASS++))
    else
        echo -e "${RED}❌ $2${NC}"
        ((FAIL++))
    fi
}

# Function to check file exists
file_exists() {
    test -f "$1"
}

# Function to check string NOT exists in file
not_grep() {
    ! grep -q "$2" "$1" 2>/dev/null
}

echo "📋 FILE CHECKS"
echo "-------------"

# Check critical files exist
file_exists "composer.json"
check $? "composer.json exists"

file_exists "railway.yaml"
check $? "railway.yaml exists"

file_exists ".env.production"
check $? ".env.production exists"

file_exists "bin/railway-deploy.sh"
check $? "bin/railway-deploy.sh exists"

file_exists "Procfile"
check $? "Procfile exists"

echo ""
echo "🔐 HEROKU CLEANUP CHECKS"
echo "------------------------"

# Check Heroku references removed
not_grep "composer.json" "heroku"
check $? "No Heroku in composer.json"

not_grep "Procfile" "heroku-php-apache2"
check $? "No heroku-php-apache2 in Procfile"

not_grep "bin/railway-deploy.sh" "/app"
check $? "No /app path in deployment script"

not_grep "railway.yaml" "heroku"
check $? "No Heroku references in railway.yaml"

echo ""
echo "🔧 PROCFILE VALIDATION"
echo "----------------------"

grep -q "php -S 0.0.0.0" "Procfile"
check $? "Procfile uses PHP built-in server"

grep -q "public/" "Procfile"
check $? "Procfile targets public directory"

echo ""
echo "⚙️  RAILWAY.YAML VALIDATION"
echo "--------------------------"

grep -q "buildCommand:" "railway.yaml"
check $? "buildCommand defined"

grep -q "startCommand:" "railway.yaml"
check $? "startCommand defined"

grep -q "php -S 0.0.0.0:8080" "railway.yaml"
check $? "startCommand is correct"

grep -q "DB_HOST: ssdj-db" "railway.yaml"
check $? "DB_HOST set to ssdj-db"

grep -q "ssdj-db" "railway.yaml"
check $? "Database service configured"

echo ""
echo "📝 .ENV.PRODUCTION VALIDATION"
echo "-----------------------------"

grep -q "APP_ENV=production" ".env.production"
check $? "APP_ENV=production"

grep -q "APP_DEBUG=false" ".env.production"
check $? "APP_DEBUG=false"

grep -q "DB_HOST=ssdj-db" ".env.production"
check $? "DB_HOST=ssdj-db"

grep -q "SESSION_DRIVER=database" ".env.production"
check $? "SESSION_DRIVER=database"

grep -q "CACHE_DRIVER=database" ".env.production"
check $? "CACHE_DRIVER=database"

echo ""
echo "📦 DEPLOYMENT SCRIPT VALIDATION"
echo "-------------------------------"

grep -q "composer install" "bin/railway-deploy.sh"
check $? "Composer install step exists"

grep -q "artisan migrate --force" "bin/railway-deploy.sh"
check $? "Database migration step exists"

grep -q "artisan key:generate" "bin/railway-deploy.sh"
check $? "APP_KEY generation step exists"

grep -q "npm run build" "bin/railway-deploy.sh"
check $? "NPM build step exists"

echo ""
echo "📊 SUMMARY"
echo "=========="
echo -e "Passed: ${GREEN}$PASS${NC}"
echo -e "Failed: ${RED}$FAIL${NC}"
echo ""

if [ $FAIL -eq 0 ]; then
    echo -e "${GREEN}✅ ALL CHECKS PASSED - Ready for Railway deployment!${NC}"
    exit 0
else
    echo -e "${RED}❌ Some checks failed - Review configuration before deploying${NC}"
    exit 1
fi
