# Railway Configuration Validation Script (PowerShell)

param(
    [switch]$Verbose = $false
)

$ErrorActionPreference = "Continue"

Write-Host "🔍 SSDJ Railway Configuration Validation" -ForegroundColor Cyan
Write-Host "=========================================" -ForegroundColor Cyan
Write-Host ""

$pass = 0
$fail = 0

function Check {
    param(
        [bool]$condition,
        [string]$message
    )
    
    if ($condition) {
        Write-Host "✅ $message" -ForegroundColor Green
        $script:pass++
    } else {
        Write-Host "❌ $message" -ForegroundColor Red
        $script:fail++
    }
}

# ========== FILE CHECKS ==========
Write-Host "📋 FILE CHECKS" -ForegroundColor Yellow
Write-Host "-------------" -ForegroundColor Yellow

$files = @(
    ("composer.json", "composer.json exists"),
    ("railway.yaml", "railway.yaml exists"),
    (".env.production", ".env.production exists"),
    ("bin/railway-deploy.sh", "bin/railway-deploy.sh exists"),
    ("Procfile", "Procfile exists")
)

foreach ($file in $files) {
    $exists = Test-Path -Path $file[0] -PathType Leaf
    Check $exists $file[1]
}

Write-Host ""

# ========== HEROKU CLEANUP CHECKS ==========
Write-Host "🔐 HEROKU CLEANUP CHECKS" -ForegroundColor Yellow
Write-Host "------------------------" -ForegroundColor Yellow

$composerContent = Get-Content -Path "composer.json" -Raw
Check (-not ($composerContent -match "heroku")) "No Heroku in composer.json"

$procfileContent = Get-Content -Path "Procfile" -Raw
Check (-not ($procfileContent -match "heroku-php-apache2")) "No heroku-php-apache2 in Procfile"

$deployContent = Get-Content -Path "bin/railway-deploy.sh" -Raw
Check (-not ($deployContent -match "/app")) "No /app path in deployment script"

$railwayContent = Get-Content -Path "railway.yaml" -Raw
Check (-not ($railwayContent -match "heroku")) "No Heroku references in railway.yaml"

Write-Host ""

# ========== PROCFILE VALIDATION ==========
Write-Host "🔧 PROCFILE VALIDATION" -ForegroundColor Yellow
Write-Host "----------------------" -ForegroundColor Yellow

$procfileContent = Get-Content -Path "Procfile" -Raw
Check ($procfileContent -match "php -S 0.0.0.0") "Procfile uses PHP built-in server"
Check ($procfileContent -match "public/") "Procfile targets public directory"

Write-Host ""

# ========== RAILWAY.YAML VALIDATION ==========
Write-Host "⚙️  RAILWAY.YAML VALIDATION" -ForegroundColor Yellow
Write-Host "--------------------------" -ForegroundColor Yellow

$railwayContent = Get-Content -Path "railway.yaml" -Raw
Check ($railwayContent -match "buildCommand:") "buildCommand defined"
Check ($railwayContent -match "startCommand:") "startCommand defined"
Check ($railwayContent -match "php -S 0.0.0.0:8080") "startCommand is correct"
Check ($railwayContent -match "DB_HOST: ssdj-db") "DB_HOST set to ssdj-db"
Check ($railwayContent -match "ssdj-db") "Database service configured"

Write-Host ""

# ========== .ENV.PRODUCTION VALIDATION ==========
Write-Host "📝 .ENV.PRODUCTION VALIDATION" -ForegroundColor Yellow
Write-Host "-----------------------------" -ForegroundColor Yellow

$envContent = Get-Content -Path ".env.production" -Raw
Check ($envContent -match "APP_ENV=production") "APP_ENV=production"
Check ($envContent -match "APP_DEBUG=false") "APP_DEBUG=false"
Check ($envContent -match "DB_HOST=ssdj-db") "DB_HOST=ssdj-db"
Check ($envContent -match "SESSION_DRIVER=database") "SESSION_DRIVER=database"
Check ($envContent -match "CACHE_DRIVER=database") "CACHE_DRIVER=database"

Write-Host ""

# ========== DEPLOYMENT SCRIPT VALIDATION ==========
Write-Host "📦 DEPLOYMENT SCRIPT VALIDATION" -ForegroundColor Yellow
Write-Host "-------------------------------" -ForegroundColor Yellow

Check ($deployContent -match "composer install") "Composer install step exists"
Check ($deployContent -match "artisan migrate --force") "Database migration step exists"
Check ($deployContent -match "artisan key:generate") "APP_KEY generation step exists"
Check ($deployContent -match "npm run build") "NPM build step exists"

Write-Host ""

# ========== SUMMARY ==========
Write-Host "📊 SUMMARY" -ForegroundColor Cyan
Write-Host "==========" -ForegroundColor Cyan
Write-Host "Passed: $(Write-Host "$pass" -ForegroundColor Green -NoNewline)" -NoNewline
Write-Host " | Failed: $(Write-Host "$fail" -ForegroundColor Red -NoNewline)" -NoNewline
Write-Host ""
Write-Host ""

if ($fail -eq 0) {
    Write-Host "✅ ALL CHECKS PASSED - Ready for Railway deployment!" -ForegroundColor Green
    exit 0
} else {
    Write-Host "❌ Some checks failed - Review configuration before deploying" -ForegroundColor Red
    exit 1
}
