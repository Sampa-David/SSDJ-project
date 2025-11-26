@echo off
REM Railway Configuration Validation Script for Windows

setlocal enabledelayedexpansion

echo.
echo Checking Railway Configuration...
echo ==================================
echo.

set pass=0
set fail=0

REM Check files exist
if exist "composer.json" (
    echo [OK] composer.json exists
    set /a pass+=1
) else (
    echo [FAIL] composer.json NOT found
    set /a fail+=1
)

if exist "railway.yaml" (
    echo [OK] railway.yaml exists
    set /a pass+=1
) else (
    echo [FAIL] railway.yaml NOT found
    set /a fail+=1
)

if exist ".env.production" (
    echo [OK] .env.production exists
    set /a pass+=1
) else (
    echo [FAIL] .env.production NOT found
    set /a fail+=1
)

if exist "bin\railway-deploy.sh" (
    echo [OK] bin/railway-deploy.sh exists
    set /a pass+=1
) else (
    echo [FAIL] bin/railway-deploy.sh NOT found
    set /a fail+=1
)

if exist "Procfile" (
    echo [OK] Procfile exists
    set /a pass+=1
) else (
    echo [FAIL] Procfile NOT found
    set /a fail+=1
)

echo.
echo Checking for Heroku References...
echo ===================================
echo.

findstr /m "heroku" composer.json > nul
if errorlevel 1 (
    echo [OK] No Heroku in composer.json
    set /a pass+=1
) else (
    echo [FAIL] Heroku found in composer.json
    set /a fail+=1
)

findstr /m "heroku-php-apache2" Procfile > nul
if errorlevel 1 (
    echo [OK] No heroku-php-apache2 in Procfile
    set /a pass+=1
) else (
    echo [FAIL] heroku-php-apache2 found in Procfile
    set /a fail+=1
)

findstr /m "php -S 0.0.0.0" Procfile > nul
if not errorlevel 1 (
    echo [OK] Procfile uses PHP server
    set /a pass+=1
) else (
    echo [FAIL] PHP server NOT configured in Procfile
    set /a fail+=1
)

echo.
echo Checking Railway Configuration...
echo ==================================
echo.

findstr /m "buildCommand:" railway.yaml > nul
if not errorlevel 1 (
    echo [OK] buildCommand defined
    set /a pass+=1
) else (
    echo [FAIL] buildCommand NOT defined
    set /a fail+=1
)

findstr /m "startCommand:" railway.yaml > nul
if not errorlevel 1 (
    echo [OK] startCommand defined
    set /a pass+=1
) else (
    echo [FAIL] startCommand NOT defined
    set /a fail+=1
)

findstr /m "php -S 0.0.0.0:8080" railway.yaml > nul
if not errorlevel 1 (
    echo [OK] startCommand is correct
    set /a pass+=1
) else (
    echo [FAIL] startCommand incorrect
    set /a fail+=1
)

findstr /m "DB_HOST: ssdj-db" railway.yaml > nul
if not errorlevel 1 (
    echo [OK] DB_HOST set to ssdj-db
    set /a pass+=1
) else (
    echo [FAIL] DB_HOST not configured correctly
    set /a fail+=1
)

echo.
echo Checking .env.production...
echo ============================
echo.

findstr /m "APP_ENV=production" .env.production > nul
if not errorlevel 1 (
    echo [OK] APP_ENV=production
    set /a pass+=1
) else (
    echo [FAIL] APP_ENV not set to production
    set /a fail+=1
)

findstr /m "APP_DEBUG=false" .env.production > nul
if not errorlevel 1 (
    echo [OK] APP_DEBUG=false
    set /a pass+=1
) else (
    echo [FAIL] APP_DEBUG not disabled
    set /a fail+=1
)

findstr /m "DB_HOST=ssdj-db" .env.production > nul
if not errorlevel 1 (
    echo [OK] DB_HOST=ssdj-db
    set /a pass+=1
) else (
    echo [FAIL] DB_HOST not configured
    set /a fail+=1
)

echo.
echo ========================
echo Results: !pass! passed, !fail! failed
echo ========================

if !fail! equ 0 (
    echo.
    echo SUCCESS: All checks passed - Ready for Railway deployment!
    exit /b 0
) else (
    echo.
    echo FAILURE: Some checks failed - Review configuration
    exit /b 1
)
