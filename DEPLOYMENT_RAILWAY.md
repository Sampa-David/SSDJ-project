# 🚀 Guide Complet Déploiement SSDJ sur Railway

## ✅ Prérequis

- ✔️ Compte Railway gratuit (https://railway.app)
- ✔️ Repository GitHub `SSDJ-project`
- ✔️ Fichiers de configuration: `railway.yaml`, `bin/railway-deploy.sh`
- ✔️ Toutes les migrations Laravel créées

## 📋 Étape 1: Préparer le Repository

### Vérifier que tout est prêt

```bash
# Vérifier le statut Git
git status

# Ajouter tous les changements
git add .

# Commiter
git commit -m "Prepare production deployment on Railway"

# Pousser vers GitHub (branche main)
git push origin main
```

### Fichiers nécessaires (vérification)

```
✓ railway.yaml          - Configuration Railway
✓ Procfile              - Commande de démarrage (legacy)
✓ bin/railway-deploy.sh - Script de déploiement Railway
✓ composer.json         - Dépendances PHP
✓ package.json          - Dépendances Node.js
✓ .env.example          - Variables d'environnement
```

## 🎯 Étape 2: Déployer sur Railway

### Méthode 1: Via Railway CLI (Recommandée)

1. **Installer Railway CLI** :
```bash
npm install -g @railway/cli
```

2. **Vous authentifier** :
```bash
railway login
```

3. **Initialiser le projet** :
```bash
cd s:\php(Laravel)\S²DJ
railway init
```

4. **Configurer les variables** :
```bash
railway variables set APP_ENV production
railway variables set APP_DEBUG false
railway variables set SESSION_DRIVER database
railway variables set CACHE_DRIVER database
```

5. **Déployer** :
```bash
railway up
```

### Méthode 2: Via Dashboard Railway (Plus Simple)

1. **Accédez à Railway** : https://railway.app
2. **Cliquez sur "New Project"**
3. **Sélectionnez "Deploy from GitHub"**
4. **Authentifiez-vous et connectez le repo** `SSDJ-project`
5. **Railway détectera le `railway.yaml` automatiquement**
6. **Cliquez "Deploy"**

### Méthode 3: Via GitHub Integration (Automatique)

1. Allez sur https://railway.app/new
2. Connectez votre GitHub
3. Sélectionnez `SSDJ-project`
4. Railway lira `railway.yaml` et créera les services
5. Déploiement automatique à chaque push sur `main`

## 🔧 Étape 3: Configurer les Variables d'Environnement

Sur Railway Dashboard, ajoutez ces variables:

| Variable | Valeur | Notes |
|----------|--------|-------|
| APP_ENV | production | |
| APP_DEBUG | false | |
| APP_KEY | [généré] | Railway l'auto-génère |
| APP_NAME | SSDJ Event System | |
| APP_URL | https://ssdj.railway.app | Auto |
| DB_CONNECTION | mysql | |
| DB_HOST | [MySQL service] | Auto-lié |
| DB_PORT | 3306 | |
| DB_DATABASE | ssdj | |
| DB_USERNAME | ssdj_user | Auto-créé |
| DB_PASSWORD | [sécurisé] | Auto-généré |
| LOG_LEVEL | error | Production |
| SESSION_DRIVER | database | |
| CACHE_DRIVER | database | |
| QUEUE_CONNECTION | database | |

## ⚡ Étape 4: Processus de Déploiement Automatique

Quand vous déployez, Railway exécute automatiquement:

```bash
# 1. Installation des dépendances
composer install --prefer-dist --optimize-autoloader

# 2. Génération de la clé APP_KEY
php artisan key:generate --force

# 3. Migrations de la base de données
php artisan migrate --force

# 4. Compilation des assets (si npm disponible)
npm install --production
npm run build

# 5. Optimisations production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 6. Démarrage du serveur Apache PHP
vendor/bin/heroku-php-apache2 public/
```

## ✔️ Étape 5: Vérifier le Déploiement

### Accéder à l'application

```
🌐 URL: https://ssdj.railway.app
```

(ou le domaine custom si configuré)

### Suivre les logs en temps réel

```bash
railway logs ssdj-app
```

Ou via Dashboard:
1. Railway Dashboard → Project → ssdj-app
2. Onglet "Logs"

### Test complet

1. **Page d'accueil** : https://ssdj.railway.app/
2. **Enregistrement** :
   - Email: `admin@gmail.com` (obtient rôle admin)
   - Password: Votre mot de passe
3. **Login** avec le compte admin
4. **Dashboard Admin** : Devrait redirecter vers `/admin/dashboard`
5. **Fonctionnalités** :
   - Voir les stats
   - Gérer les utilisateurs
   - Gérer les tickets

## 🐛 Dépannage

### ❌ Erreur: "Build FAILED"

**Solution** :
```bash
# Sur votre machine locale
composer install
composer update

git add .
git commit -m "Fix composer dependencies"
git push origin main

# Railway redéploiera automatiquement
```

### ❌ Erreur: "Cannot connect to database"

**Vérifier** :
1. Les services MySQL est "Running"
2. Les credentials sont corrects
3. La base de données `ssdj` existe

**Solution** :
- Railway Dashboard → Variables
- Vérifiez les DB_* variables
- Cliquez "Redeploy"

### ❌ APP_KEY manquant

Railway génère cela automatiquement. Si erreur:

1. Railway Dashboard → Variables
2. Supprimez APP_KEY
3. Railway le régénérera au prochain déploiement

### ❌ Migrations ne s'exécutent pas

**Vérifier les logs** :
```bash
railway logs ssdj-app | grep -i "migrate"
```

**Forcer manuellement** (via Railway CLI):
```bash
railway run php artisan migrate --force
```

### ❌ Erreur 502 Bad Gateway

**Signifie** : L'app n'a pas démarré correctement

**Solution** :
1. Vérifiez les logs pour les erreurs
2. Redéployez : `railway redeploy`
3. Vérifiez que `public/index.php` existe

### ❌ La base de données est vide

**Solution** :
```bash
# Via Railway CLI
railway run php artisan migrate --force
railway run php artisan db:seed --force
```

Ou via le dashboard Railway, trouvez le MySQL service et exécutez les commandes.

## 📊 Surveillance en Production

### Accéder aux métriques

Railway Dashboard → Project → ssdj-app → "Metrics"

Surveiller:
- ✓ CPU Usage
- ✓ Memory Usage
- ✓ Network I/O
- ✓ Disk Usage
- ✓ HTTP Requests

### Logs en temps réel

```bash
# CLI
railway logs -f

# Dashboard
Railway → Logs
```

Cherchez les erreurs:
- `[ERROR]`
- `[WARNING]`
- `Connection failed`

### Auto-restart

Railway redémarre automatiquement l'app si elle s'arrête ou utilise trop de RAM.

## 🔄 Mettre à Jour après Déploiement

### Après des modifications de code

```bash
git add .
git commit -m "Production update: [description]"
git push origin main
```

Railway redéploiera **automatiquement** si GitHub Integration est activé.

### Forcer un redéploiement

```bash
railway redeploy
```

Ou via Dashboard:
1. Railway Dashboard → Deployments
2. Cliquez le déploiement
3. Cliquez "Redeploy"

### Ajouter une nouvelle migration

1. Créez la migration localement
2. Testez sur votre machine
3. Committez et poussez vers GitHub
4. La migration s'exécutera au prochain deploy

## 🚀 Optimisations Production

Ces commandes s'exécutent automatiquement dans `bin/railway-deploy.sh`:

```bash
# Configuration optimisée
php artisan config:cache

# Routes cachées (compilation des routes)
php artisan route:cache

# Views compilées
php artisan view:cache

# Assets minifiées
npm run build

# Autoloader optimisé
composer install --optimize-autoloader
```

## 💾 Backup de la Base de Données

### Via Railway CLI

```bash
# Exporter la BD
railway run mysqldump -h $DB_HOST -u $DB_USERNAME -p$DB_PASSWORD $DB_DATABASE > backup.sql

# Importer
railway run mysql -h $DB_HOST -u $DB_USERNAME -p$DB_PASSWORD $DB_DATABASE < backup.sql
```

### Via Dashboard

1. Railway Dashboard → MySQL service
2. Onglet "Data"
3. Vous pouvez voir/gérer les données

## 📱 Fonctionnalités Testées

À vérifier après déploiement:

- ✅ Accueil public accessible
- ✅ Enregistrement avec admin@gmail.com
- ✅ Connexion fonctionnelle
- ✅ Dashboard user visible
- ✅ Dashboard admin accessible pour admins
- ✅ Gestion des utilisateurs
- ✅ Gestion des tickets
- ✅ Statistiques visibles
- ✅ Charts fonctionnels
- ✅ Pagination fonctionne
- ✅ Sessions persistent
- ✅ Cache fonctionnel

## 💵 Tarification Railway

**Plan Gratuit** (parfait pour démarrer):
- $5 crédits gratuits/mois
- Arrêt après inactivité (hibernation)
- Redémarrage automatique à l'accès

**Plan Usage** (pay-as-you-go):
- $0.000463 par heure (environ $0.34/mois pour une petite app)
- Pas d'hibernation
- Support prioritaire

## 🆚 Render vs Railway

| Feature | Render | Railway |
|---------|--------|---------|
| Free Plan | Oui | Oui ($5 credits) |
| Hibernation | Oui | Oui |
| MySQL | Oui | Oui |
| Deploy Speed | Moyen | Rapide |
| CLI | Non | Oui |
| Pricing | Gratuit/Pay | Gratuit/Pay |
| Support | Bon | Très bon |

## 📞 Support et Ressources

- 📖 [Railway Documentation](https://docs.railway.app)
- 📖 [Railway CLI Docs](https://docs.railway.app/cli)
- 📖 [Laravel Deployment Guide](https://laravel.com/docs/deployment)
- 💬 [Railway Discord Support](https://discord.gg/railway)

## 🔐 Sécurité en Production

Railway géré automatiquement:
- ✅ SSL/HTTPS (certificat gratuit Let's Encrypt)
- ✅ Firewall
- ✅ DDoS protection
- ✅ Data encryption en transit
- ✅ Backup automatiques

---

**Status**: ✅ Production Ready
**Version**: 1.0
**Dernière mise à jour**: 26 Novembre 2025
**Plateforme**: Railway avec MySQL
