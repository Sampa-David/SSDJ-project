# Déploiement sur Render

## Prérequis

- Compte Render (https://render.com)
- Repository GitHub avec le code du projet

## Étapes de déploiement

### 1. Préparer le repository GitHub

```bash
git add .
git commit -m "Prepare for Render deployment"
git push origin main
```

### 2. Créer un service sur Render

1. Allez sur https://dashboard.render.com
2. Cliquez sur "New +" → "Web Service"
3. Connectez votre repository GitHub
4. Sélectionnez votre repository `SSDJ-project`

### 3. Configurer le Web Service

**Paramètres généraux :**
- Name: `ssdj-app`
- Environment: `Docker` ou `Native`
- Build Command: `composer install && php artisan migrate --force`
- Start Command: `vendor/bin/heroku-php-apache2 public/`

**Variables d'environnement :**

Allez dans "Environment" et ajoutez :

```
APP_ENV=production
APP_DEBUG=false
APP_KEY=[Générer une clé]
DB_CONNECTION=mysql
DB_HOST=[À compléter avec votre MySQL]
DB_PORT=3306
DB_DATABASE=[Nom de la BD]
DB_USERNAME=[Username]
DB_PASSWORD=[Password]
LOG_CHANNEL=stack
SESSION_DRIVER=database
CACHE_STORE=database
```

### 4. Configurer la Base de Données

**Option A : MySQL externe (recommandé)**

Utilisez un service MySQL externe comme :
- CleartDB
- JawsDB
- ElephantSQL (PostgreSQL)

Ajoutez les credentials dans les variables d'environnement.

**Option B : MySQL sur Render** *(Payant)*

Créez un MySQL service dans Render Dashboard.

### 5. Déployer

Une fois configuré, Render déploiera automatiquement votre application.

## Vérification après déploiement

```bash
# Vérifier les logs
# Dans Render Dashboard → Logs

# Vérifier les migrations
# Les migrations s'exécutent automatiquement au déploiement

# Tester l'application
# Allez sur https://votre-app.onrender.com
```

## Troubleshooting

### Erreur : "BUILD FAILED"
- Vérifiez que `composer.lock` existe
- Vérifiez la version PHP (doit être ^8.2)

### Erreur : "Database connection failed"
- Vérifiez les credentials DB
- Vérifiez que la BD est accessible depuis Render

### Erreur : "APP_KEY missing"
- Générez une clé : `php artisan key:generate`
- Ajoutez-la dans Render Environment

## Configuration supplémentaire

### Pour les fichiers statiques (CSS, JS)

```bash
npm install
npm run build
```

Assurez-vous que ces commandes sont dans votre build command.

### Pour les emails (SMTP)

Utilisez un service comme Mailtrap.io :

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=votre_username
MAIL_PASSWORD=votre_password
```

## Support

Pour plus d'informations :
- Documentation Render : https://render.com/docs
- Documentation Laravel : https://laravel.com/docs
