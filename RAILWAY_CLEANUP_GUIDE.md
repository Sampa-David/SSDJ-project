# 🚀 Railway Cleanup & Deployment Guide

## ✅ AVANT DE DÉPLOYER

Assurez-vous que tout est configuré correctement :

### 1. Fichiers Nettoyés

✅ **composer.json** - Dépendance `heroku/heroku-buildpack-php` supprimée
✅ **Procfile** - Remplacé par : `web: php -S 0.0.0.0:${PORT:-8080} -t public`
✅ **railway.yaml** - Configuration complète et correcte
✅ **bin/railway-deploy.sh** - Script de déploiement Railway-compatible
✅ **.env.production** - Template d'environnement créé

### 2. Fichiers à Supprimer (Heroku Legacy)

Il n'y a plus de fichiers Heroku legacy dans votre projet.

### 3. Configuration Laravel

Assurez-vous que votre `.env.production` contient:
- `APP_ENV=production`
- `APP_DEBUG=false`
- `DB_HOST=ssdj-db` (service name Railway)
- `DB_CONNECTION=mysql`
- `SESSION_DRIVER=database`
- `CACHE_DRIVER=database`

---

## 🚀 DÉPLOIEMENT RAILWAY (Étapes)

### Étape 1: Validation locale
```bash
# Testez localement
php artisan serve
```

### Étape 2: Commit des changements
```bash
git add -A
git commit -m "chore: clean up Heroku config, prepare for Railway"
git push origin main
```

### Étape 3: Déploiement Railway
1. Accédez à https://railway.app/dashboard
2. Cliquez sur votre projet "SSDJ-project"
3. Onglet "Deployments" → "Redeploy"
4. Attendez que le build se termine (3-5 minutes)

### Étape 4: Vérification
```bash
# Testez l'URL de production
curl https://web-production-b7b89.up.railway.app
```

Vous devriez voir la page d'accueil HTML (HTTP 200).

---

## ⚙️ CONFIGURATION FINALE

### railway.yaml - Nouvelle structure

**Services:**
- `web`: Laravel app (PHP 8.2)
  - Build: `bash ./bin/railway-deploy.sh`
  - Start: `php -S 0.0.0.0:8080 -t public`
  - Port: 8080
  - Health check: `/`
  
- `database`: MySQL 8.0
  - User: `railway`
  - Password: `railway`
  - Database: `ssdj`

### Pas de Heroku:
❌ Aucune référence à `heroku-php-apache2`
❌ Aucune référence à `php-fpm`
❌ Aucune dépendance Heroku dans composer
❌ Aucun buildpack Heroku

### Tout est natif PHP:
✅ PHP built-in server : `php -S 0.0.0.0:8080 -t public`
✅ Migrations auto : dans railway-deploy.sh
✅ Assets compilés : npm build dans railway-deploy.sh
✅ APP_KEY générée : dans railway-deploy.sh

---

## 🔍 LOGS EN CAS DE PROBLÈME

### Dans Railway Dashboard:
1. Projet → "SSDJ-project"
2. Service `ssdj-web` → Onglet "Logs"
3. Cherchez les erreurs PHP

### Erreurs courantes résolues:

**❌ "heroku-php-apache2: command not found"**
✅ **RÉSOLU**: Utilisez `php -S 0.0.0.0:8080 -t public`

**❌ "php-fpm: command not found"**
✅ **RÉSOLU**: Aucune dépendance php-fpm, tout en PHP natif

**❌ "DB_PASSWORD undefined"**
✅ **RÉSOLU**: Explicitement défini dans railway.yaml

**❌ "cd /app not found"**
✅ **RÉSOLU**: Script utilise `pwd` (Railway utilise `/workspace`)

---

## 📋 CHECKLIST FINAL

Avant de cliquer "Redeploy" sur Railway:

- [ ] `git push origin main` effectué
- [ ] `bin/railway-deploy.sh` sans erreurs localement
- [ ] `composer.json` sans dépendance Heroku
- [ ] `Procfile` contient `php -S 0.0.0.0:...`
- [ ] `railway.yaml` avec structure correcte
- [ ] `.env.production` créé et configuré
- [ ] Migrations prêtes (`database/migrations/`)
- [ ] `storage/` et `bootstrap/cache/` existence vérifiée

---

## ✅ RÉSULTAT ATTENDU

Après redéploiement Railway:
- ✅ Aucune erreur Heroku
- ✅ Aucune erreur php-fpm
- ✅ App répond sur HTTPS (HTTP 200)
- ✅ Dashboard admin accessible (`/admin/dashboard`)
- ✅ Authentification fonctionnelle
- ✅ Database connectée et migrations exécutées

---

**Créé:** 26 Nov 2025
**Status:** ✅ Prêt pour production Railway
