# 🚀 S²DJ Railway Deployment Guide

## Configuration Railway

### 1. **Procfile** (Exécution automatique)
```plaintext
release: php artisan migrate --force
web: php -S 0.0.0.0:${PORT:-8080} -t public
```

**Explication:**
- `release:` → Exécuté AVANT le démarrage (migrations de base de données)
- `web:` → Serveur PHP pour répondre aux requêtes

### 2. **Variables d'Environnement Railway**

Ajouter dans Railway Dashboard:

```env
# Application
APP_NAME=S²DJ
APP_ENV=production
APP_KEY=base64:... (générer avec php artisan key:generate)
APP_DEBUG=false
APP_URL=https://your-app.up.railway.app

# Database (PostgreSQL/MySQL)
DB_CONNECTION=mysql
DB_HOST=containers.railway.app
DB_PORT=3306
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=... (généré par Railway)

# Mail (optionnel)
MAIL_DRIVER=log
MAIL_FROM_ADDRESS=noreply@ssdj.app
```

### 3. **Health Check Routes**

Vérifier l'état de l'application:

```bash
# Status simple (OK/ERROR)
GET /status

# Status détaillé (tables, base de données)
GET /health
```

---

## Problèmes Courants et Solutions

### ❌ Erreur: "Table 'users' doesn't exist"

**Cause:** Les migrations n'ont pas été exécutées

**Solution:**
1. Vérifier `/status` → doit retourner "ok"
2. Vérifier `/health` → doit afficher l'état des tables
3. Redéployer → la phase `release` devrait lancer les migrations

### ❌ Erreur 500 sur `/admin/data-generator/generate`

**Cause:** Accès en GET au lieu de POST, ou tables manquantes

**Solution:**
1. Accéder à `/admin/data-generator` (GET)
2. Soumettre le formulaire (POST)
3. Si erreur persiste, vérifier `/health`

### ❌ Application lente au redémarrage

**Raison:** Les migrations et cache:clear prennent du temps

**Normal:** Attendre 30-60 secondes après redéploiement

---

## Déploiement Rapide

### Via Railway CLI:
```bash
railway login
railway link
git push
```

### Via GitHub (recommandé):
1. Pousser vers GitHub
2. Railway déploie automatiquement
3. Regarder les logs: `railway logs`

---

## Monitoring

### Logs Railway:
```bash
railway logs -d
```

### Vérifier les migrations:
```bash
# Via artisan (sur Railway shell)
railway shell
php artisan migrate:status
```

### Vérifier les tables:
```bash
# Accéder au endpoint de santé
curl https://your-app.up.railway.app/health
```

---

## Script de Release Personnalisé

Utiliser le script: `bin/railway-release.sh`

Exécute:
1. ✅ Migrations (`migrate --force`)
2. ✅ Cache configuration (`config:cache`)
3. ✅ Cache routes (`route:cache`)
4. ✅ Clear cache (`cache:clear`)

---

## Données de Test

### Générer des données:
1. Accéder à `https://your-app.up.railway.app/admin/data-generator`
2. Entrer le nombre d'utilisateurs et d'événements
3. Soumettre

Les factories (`UserFactory`, `EventFactory`) généreront les données.

---

## Important

- ✅ Les factories ET migrations sont dans GitHub
- ✅ Les migrations s'exécutent AUTOMATIQUEMENT via Procfile
- ✅ Le DataGeneratorController vérifie que les tables existent
- ⚠️ NE PAS éditer manuellement les migrations
- ⚠️ NE PAS mettre les .env en production - utiliser Railway Variables

---

## Support

En cas de problème:
1. Vérifier les logs: `railway logs`
2. Vérifier `/health` endpoint
3. Vérifier `/status` endpoint
4. Relancer: `railway redeploy`
