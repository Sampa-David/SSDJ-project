# 🚀 Guide Complet Déploiement SSDJ sur Render

## ✅ Prérequis

- ✔️ Compte Render gratuit (https://render.com)
- ✔️ Repository GitHub `SSDJ-project`
- ✔️ Fichiers de configuration: `render.yaml`, `Procfile`, `bin/deploy.sh`
- ✔️ Toutes les migrations Laravel créées

## 📋 Étape 1: Préparer le Repository

### Vérifier que tout est prêt

```bash
# Vérifier le statut Git
git status

# Ajouter tous les changements
git add .

# Commiter
git commit -m "Prepare production deployment on Render"

# Pousser vers GitHub (branche main)
git push origin main
```

### Fichiers nécessaires (vérification)

```
✓ render.yaml          - Configuration Render Blueprint
✓ Procfile             - Commande de démarrage
✓ bin/deploy.sh        - Script de déploiement
✓ composer.json        - Dépendances PHP
✓ package.json         - Dépendances Node.js
✓ .env.example         - Variables d'environnement
```

## 🎯 Étape 2: Déployer sur Render (avec Blueprint)

### Méthode 1: Via Render Dashboard (Recommandée)

1. **Accédez à Render** : https://dashboard.render.com
2. **Connectez GitHub** :
   - Cliquez sur "New +"
   - Sélectionnez "Blueprint"
   - Authentifiez-vous avec GitHub
3. **Sélectionnez le repository** : `SSDJ-project`
4. **Autorisez Render** à accéder à votre repo
5. **Validez** - Render détectera automatiquement `render.yaml`

### Méthode 2: Manuel (si Blueprint ne fonctionne pas)

1. Cliquez sur **"New +"** → **"Web Service"**
2. Connectez votre repository GitHub
3. Configurez manuellement:
   - **Name**: `ssdj-app`
   - **Runtime**: `PHP 8.2`
   - **Build Command**: `bash ./bin/deploy.sh`
   - **Start Command**: `vendor/bin/heroku-php-apache2 public/`

## 🔧 Étape 3: Variables d'Environnement

Render configurera automatiquement via `render.yaml` :

| Variable | Valeur | Source |
|----------|--------|--------|
| APP_ENV | production | Render |
| APP_DEBUG | false | Render |
| APP_KEY | [généré] | Render (auto-generated) |
| APP_URL | https://ssdj-app.onrender.com | Service URL |
| DB_CONNECTION | mysql | Render |
| DB_HOST | [auto] | MySQL service |
| DB_PORT | 3306 | MySQL service |
| DB_DATABASE | [auto] | MySQL service |
| DB_USERNAME | [auto] | MySQL service |
| DB_PASSWORD | [auto] | MySQL service |
| LOG_LEVEL | error | Production |
| SESSION_DRIVER | database | Render |
| CACHE_DRIVER | database | Render |

## ⚡ Étape 4: Processus de Déploiement Automatique

Quand vous déployez, Render exécute automatiquement:

```bash
# 1. Installation des dépendances
composer install --prefer-dist --optimize-autoloader

# 2. Génération de la clé APP_KEY
php artisan key:generate --force

# 3. Migrations de la base de données
php artisan migrate --force

# 4. Compilation des assets
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
🌐 URL: https://ssdj-app.onrender.com
```

### Suivre les logs

1. Render Dashboard → `ssdj-app`
2. Onglet "Logs"
3. Vérifier qu'il n'y a pas d'erreurs

### Test complet

1. **Page d'accueil** : https://ssdj-app.onrender.com/
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
```

### ❌ Erreur: "Cannot connect to database"

**Vérifier** :
1. Les credentials MySQL sont corrects
2. La base de données existe
3. L'utilisateur a les permissions

**Solution** :
- Render Dashboard → Environment
- Vérifiez les variables `DB_*`
- Cliquez "Manual Deploy" pour réessayer

### ❌ APP_KEY manquant

Render génère cela automatiquement. Si vous voyez une erreur:

1. Render Dashboard → `ssdj-app`
2. Cliquez "Manual Deploy"
3. Render régénérera la clé

### ❌ Migrations ne s'exécutent pas

**Vérifier les logs** :
```
Render Dashboard → Logs → Cherchez "migrate"
```

**Forcer manuellement** (SSH si disponible):
```bash
php artisan migrate --force
```

### ❌ Erreur 502 Bad Gateway

**Signifie** : L'app n'a pas démarré correctement

**Solution** :
1. Vérifiez les logs pour les erreurs
2. Redéployez : "Manual Deploy"
3. Vérifiez que `public/index.php` existe

## 📊 Surveillance en Production

### Accéder aux métriques

Render Dashboard → `ssdj-app` → "Metrics"

Surveiller:
- ✓ CPU Usage
- ✓ Memory Usage
- ✓ Disk Usage
- ✓ Database Connections

### Logs en temps réel

```
Render Dashboard → `ssdj-app` → "Logs"
```

Cherchez les erreurs de type:
- `[ERROR]`
- `[WARNING]`
- `Connection failed`

### Auto-restart

Render redémarre automatiquement l'app si elle s'arrête.

## 🔄 Mettre à Jour après Déploiement

### Après des modifications de code

```bash
git add .
git commit -m "Production update: [description]"
git push origin main
```

Render redéploiera automatiquement.

### Forcer un redéploiement

1. Render Dashboard → `ssdj-app`
2. Cliquez "Manual Deploy"
3. Sélectionnez "Deploy Latest"

### Ajouter une nouvelle migration

1. Créez la migration localement
2. Testez sur votre machine
3. Committez et poussez vers GitHub
4. La migration s'exécutera au prochain deploy

## 🚀 Optimisations Production

Ces commandes s'exécutent automatiquement:

```bash
# Configuration optimisée
php artisan config:cache

# Routes cachées (compilation des routes)
php artisan route:cache

# Views compilées
php artisan view:cache

# Assets minifiées
npm run build  # Crée public/build/manifest.json

# Autoloader optimisé
composer install --optimize-autoloader
```

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

## 💾 Backup de la Base de Données

Pour créer un backup:

```bash
# Via SSH Render (si disponible)
mysqldump -h [DB_HOST] -u [DB_USER] -p[DB_PASS] [DB_NAME] > backup.sql
```

## 📞 Support et Ressources

- 📖 [Render PHP Documentation](https://render.com/docs/php)
- 📖 [Render Environment Variables](https://render.com/docs/environment-variables)
- 📖 [Laravel Deployment Guide](https://laravel.com/docs/deployment)
- 💬 [Render Community Support](https://render.com/support)

---

**Status**: ✅ Production Ready
**Version**: 1.0
**Dernière mise à jour**: 25 Novembre 2025
**Déploiement**: Blueprint Render avec MySQL
