# ✅ Checklist Déploiement SSDJ Production sur Render

## 🔍 Vérifications Avant Déploiement

### ✅ Code & Git
- [ ] Tous les changements commités
- [ ] Branche `main` à jour
- [ ] Pas de fichiers non tracés
- [ ] `.gitignore` correct
- [ ] `composer.lock` commité
- [ ] `package-lock.json` commité

### ✅ Configuration Production
- [ ] `render.yaml` correct
- [ ] `Procfile` présent
- [ ] `bin/deploy.sh` exécutable
- [ ] `.env.example` à jour
- [ ] APP_DEBUG = false
- [ ] APP_ENV = production

### ✅ Base de Données
- [ ] Migrations créées et testées
- [ ] Pas d'erreurs migration
- [ ] Foreign keys OK
- [ ] Seeders prêts (si besoin)
- [ ] Migration de roles complète
- [ ] Migration de role_user complète

### ✅ Sécurité
- [ ] Pas de credentials en dur
- [ ] Pas d'affichage de secrets
- [ ] Passwords hashés (bcrypt)
- [ ] HTTPS forcé
- [ ] CSRF protection actif
- [ ] Middleware d'authentification appliqué

### ✅ Fonctionnalités Critiques
- [ ] Authentification admin@gmail.com → rôle admin
- [ ] Middleware admin protège /admin/*
- [ ] Dashboard admin accessible
- [ ] Menu "My Account" adapté au rôle
- [ ] Tickets visibles et gérables
- [ ] Charts fonctionnels

## 🚀 Déploiement Render

### Avant Render
- [ ] Dernier commit poussé
- [ ] Compte Render créé
- [ ] GitHub connecté à Render

### Sur Render Dashboard
- [ ] Sélectionner Blueprint
- [ ] Valider render.yaml
- [ ] Attendre les logs de build
- [ ] Vérifier le status = "running"

### Variables d'Environnement
- [ ] APP_ENV = production ✓
- [ ] APP_DEBUG = false ✓
- [ ] APP_KEY = généré ✓
- [ ] DB_* = auto (depuis MySQL service) ✓
- [ ] LOG_LEVEL = error ✓
- [ ] SESSION_DRIVER = database ✓

## ✔️ Tests Post-Déploiement Immédiats

### Navigation & Accès
- [ ] URL principale charge
- [ ] Pas d'erreur 502/503/500
- [ ] CSS et JS chargés
- [ ] Images affichées
- [ ] Responsive (mobile/desktop)

### Authentification
- [ ] Page `/login` accessible
- [ ] Page `/register` accessible
- [ ] Enregistrement avec `admin@gmail.com` crée admin
- [ ] Login réussit
- [ ] Logout fonctionne
- [ ] Session persiste entre pages

### Utilisateur Admin
- [ ] Redirection `/admin/dashboard` OK
- [ ] Dashboard affiche stats
- [ ] Charts visibles et interactifs
- [ ] Menu "My Account" → Admin Dashboard, Users, Tickets, Stats
- [ ] Gestion des utilisateurs OK
- [ ] Gestion des tickets OK
- [ ] Pagination fonctionne

### Utilisateur Simple
- [ ] Dashboard user accessible
- [ ] Pas d'accès à /admin
- [ ] Menu "My Account" → Dashboard, My Tickets
- [ ] Achat de tickets possible
- [ ] Liste des tickets visible

### Base de Données
- [ ] Migrations s'exécutées
- [ ] Utilisateurs créés avec succès
- [ ] Rôles assignés correctement
- [ ] Sessions stockées en DB
- [ ] Pas d'erreur de connexion

## 📊 Monitoring Post-Déploiement

### Première Heure
- [ ] Vérifier les logs pour erreurs
- [ ] Tester toutes les routes principales
- [ ] Tester login/logout/register
- [ ] Vérifier les performances

### Premières 24 Heures
- [ ] Surveiller les erreurs 500
- [ ] Monitorer les connexions DB
- [ ] Vérifier les timeouts
- [ ] Vérifier les migrations
- [ ] Tester le cold start (redémarrage après inactivité)

### Continue
- [ ] Vérifier logs quotidiennement
- [ ] Monitorer les performances
- [ ] Vérifier l'uptime
- [ ] Surveiller l'utilisation des ressources

## 🆘 Dépannage Rapide

### Erreur 502 Bad Gateway
```
→ Les logs disent quoi ?
→ L'app démarre-t-elle ?
→ Déclencher "Manual Deploy"
```

### App lente/timeout
```
→ Vérifier les logs pour les queries lentes
→ Augmenter les limites si nécessaire
→ Vérifier la pool de connexions DB
```

### DB connection failed
```
→ Vérifier les variables DB_*
→ Vérifier que MySQL service est "running"
→ Redéployer si nécessaire
```

### Migrations non exécutées
```
→ Vérifier les logs de build
→ Chercher "Running migrations"
→ Redéployer manuellement
```

## 📝 Checkliste Quotidienne Production

### Matin
- [ ] App accessible ?
- [ ] Pas d'erreurs critiques dans les logs ?
- [ ] DB en bon état ?

### Midi
- [ ] Performances OK ?
- [ ] Connexions DB normales ?
- [ ] Aucune erreur 500 ?

### Soir
- [ ] Aucun problème signalé ?
- [ ] Logs vérifiés ?
- [ ] Monitoring en place ?

## ✅ Fonctionnalités à Tester

| Fonctionnalité | Test | Status |
|---|---|---|
| Accueil public | Charger la page | ☐ |
| Enregistrement | Créer un compte user | ☐ |
| Login | Se connecter | ☐ |
| Admin Detection | Créer avec admin@gmail.com | ☐ |
| Dashboard User | Accès après login | ☐ |
| Dashboard Admin | Accessible pour admins | ☐ |
| Ticket View | Voir liste tickets | ☐ |
| Stats | Charts affichés | ☐ |
| User Mgmt | CRUD utilisateurs | ☐ |
| Ticket Mgmt | CRUD tickets | ☐ |
| Logout | Déconnexion | ☐ |

## 🔄 En Cas de Problème

### Diagnostic
1. Vérifier les logs Render
2. Vérifier l'état DB
3. Vérifier les variables env
4. Redéployer si nécessaire

### Rollback d'Urgence
```bash
git revert HEAD  # Annuler le dernier commit
git push origin main
# Render redéploiera automatiquement
```

## 📞 Ressources

- [Render Dashboard](https://dashboard.render.com)
- [Render Docs](https://render.com/docs)
- [Laravel Docs](https://laravel.com/docs)
- [Logs Render](https://dashboard.render.com → ssdj-app → Logs)

---

**Checklist Version**: 2.0 (Production)
**Date**: 25 Novembre 2025
**Environnement**: Production sur Render
**Status**: ✅ Ready to Deploy

### ✅ Models & Controllers
- [ ] `app/Models/User.php` - Updated with ticket relationships
- [ ] `app/Models/Ticket.php` - Complete with business logic
- [ ] `app/Http/Controllers/AuthController.php` - Auth methods implemented
- [ ] `app/Http/Controllers/TicketController.php` - All 9 methods working

### ✅ Routes
- [ ] All routes defined in `routes/web.php`
- [ ] Auth routes (register, login, logout) configured
- [ ] Ticket routes protected with `auth` middleware
- [ ] `/dashboard` route mapped to `TicketController@dashboard`
- [ ] `/buy-tickets` route mapped to `TicketController@showPurchase`

### ✅ Views Created
- [ ] `resources/views/auth/register.blade.php`
- [ ] `resources/views/auth/login.blade.php`
- [ ] `resources/views/dashboard.blade.php`
- [ ] `resources/views/tickets/purchase.blade.php`
- [ ] `resources/views/tickets/my-tickets.blade.php`
- [ ] `resources/views/tickets/show.blade.php`
- [ ] `resources/views/tickets/confirmation.blade.php`

### ✅ Components Updated
- [ ] `resources/views/components/header.blade.php` - Auth nav links added
- [ ] `resources/views/layouts/app.blade.php` - Ready to use

## Testing Scenarios

### Scenario 1: New User Registration
**Steps:**
1. Navigate to `/register`
2. Enter: Name, Email, Password (confirmed), Phone, Company
3. Click Register

**Expected Results:**
- ✓ User created in database
- ✓ Redirected to login page
- ✓ Success message displayed
- ✓ Can login with new credentials

**SQL Query to Verify:**
```sql
SELECT * FROM users ORDER BY created_at DESC LIMIT 1;
```

---

### Scenario 2: User Login
**Steps:**
1. Navigate to `/login`
2. Enter registered email and password
3. Check "Remember Me" (optional)
4. Click Login

**Expected Results:**
- ✓ Session created
- ✓ Redirected to dashboard
- ✓ User name displayed in header
- ✓ "My Account" menu visible

**Browser DevTools Check:**
- Verify session cookie created
- Check local storage for any tokens

---

### Scenario 3: Ticket Purchase Flow
**Steps:**
1. From dashboard, click "Buy More Tickets"
2. Select ticket type (e.g., Premium - $195)
3. Choose quantity (e.g., 3)
4. Click "Buy Now"

**Expected Results:**
- ✓ Form validates quantity (1-10)
- ✓ 3 tickets created with unique numbers
- ✓ Redirected to confirmation page
- ✓ Confirmation shows ticket type, price, number
- ✓ Email would be sent (mock in dev)

**SQL Query to Verify:**
```sql
SELECT * FROM tickets WHERE user_id = ? ORDER BY created_at DESC;
```

---

### Scenario 4: View My Tickets
**Steps:**
1. From dashboard, click "My Tickets"
2. Review ticket list with pagination

**Expected Results:**
- ✓ All purchased tickets displayed
- ✓ Correct status badges (Active/Cancelled)
- ✓ Pagination shows 10 per page
- ✓ Each ticket has Details and Cancel buttons
- ✓ Stats updated correctly

**Stats to Verify:**
- Total tickets = sum of all
- Active = status = 'active'
- Cancelled = status = 'cancelled'
- Total spent = SUM(price) WHERE status != 'cancelled'

---

### Scenario 5: View Ticket Details
**Steps:**
1. Click "Details" on any ticket
2. Review ticket information

**Expected Results:**
- ✓ Ticket number displayed
- ✓ Status badge shown
- ✓ Type, price, dates visible
- ✓ QR code displayed
- ✓ Purchase date shown
- ✓ Valid Until date shown
- ✓ Cancel button visible if active
- ✓ Print button functional

---

### Scenario 6: Cancel Ticket
**Steps:**
1. From ticket details, click "Cancel"
2. Confirm cancellation

**Expected Results:**
- ✓ Status changed to 'cancelled'
- ✓ Success message displayed
- ✓ Redirect to previous page
- ✓ Stats updated (active count -1)
- ✓ Cancel button disappears

**SQL Query to Verify:**
```sql
SELECT * FROM tickets WHERE id = ? AND status = 'cancelled';
```

---

### Scenario 7: Authorization (Security)
**Steps:**
1. Copy direct URL: `/tickets/5` (another user's ticket)
2. Try accessing without being owner

**Expected Results:**
- ✓ 403 Forbidden error
- ✓ Cannot view/modify other user's tickets

---

### Scenario 8: Logout
**Steps:**
1. Click "Logout" from user menu
2. Try accessing `/dashboard`

**Expected Results:**
- ✓ Session destroyed
- ✓ Redirected to home/login
- ✓ Header shows login buttons
- ✓ Cannot access protected routes

---

## Performance Checks

### Load Time Targets
- [ ] Homepage: < 2s
- [ ] Dashboard: < 1.5s
- [ ] Ticket purchase: < 1s
- [ ] Database queries: < 100ms per page

### Query Optimization
- [ ] Dashboard loads tickets with pagination (not all at once)
- [ ] Check N+1 query problems in ticket list
- [ ] Ensure indexes on user_id, status fields

**Recommended SQL Indexes:**
```sql
CREATE INDEX idx_tickets_user_id ON tickets(user_id);
CREATE INDEX idx_tickets_status ON tickets(status);
CREATE INDEX idx_users_email ON users(email) UNIQUE;
```

---

## Error Handling Tests

### Test Cases
- [ ] Invalid email format on registration
- [ ] Duplicate email on registration
- [ ] Password mismatch on registration
- [ ] Wrong password on login
- [ ] Non-existent user on login
- [ ] Invalid quantity (0 or > 10) on purchase
- [ ] Missing required fields
- [ ] Accessing routes without authentication

---

## Browser Compatibility

- [ ] Chrome/Edge (Latest)
- [ ] Firefox (Latest)
- [ ] Safari (Latest)
- [ ] Mobile Chrome
- [ ] Mobile Safari

---

## Code Quality Checks

### Before Production
```bash
# Run tests
php artisan test

# Check code style
php artisan pint

# Check for unused imports
composer dump-autoload

# Verify all routes
php artisan route:list
```

### Enable in Production
- [ ] Set `APP_DEBUG=false` in `.env`
- [ ] Set `APP_ENV=production` in `.env`
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`

---

## Deployment Steps

### 1. Environment Setup
```bash
# Copy to production server
git clone <repository> /var/www/ssdj

# Install dependencies
composer install --optimize-autoloader --no-dev

# Copy environment
cp .env.example .env
php artisan key:generate
```

### 2. Database Setup
```bash
# Create database on production MySQL
mysql -u root -p
> CREATE DATABASE ssdj_prod;
> GRANT ALL ON ssdj_prod.* TO 'ssdj_user'@'localhost' IDENTIFIED BY 'password';

# Update .env with production database credentials

# Run migrations
php artisan migrate --force
```

### 3. Asset Compilation
```bash
npm run build  # or: npm run prod
```

### 4. Permissions
```bash
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

### 5. Cache & Optimization
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### 6. Enable HTTPS
- [ ] Install SSL certificate
- [ ] Configure web server (Nginx/Apache)
- [ ] Update `APP_URL` in `.env` to https://

---

## Monitoring & Maintenance

### Regular Tasks
- [ ] Monitor error logs: `storage/logs/laravel.log`
- [ ] Check database backups
- [ ] Monitor server resources (CPU, Memory, Disk)
- [ ] Review failed login attempts
- [ ] Monitor API response times

### Backup Strategy
- [ ] Daily database backups
- [ ] Weekly file backups
- [ ] Store backups off-site
- [ ] Test restore procedure monthly

---

## Rollback Plan

If issues occur:

1. **Check Logs**
   ```bash
   tail -f storage/logs/laravel.log
   ```

2. **Rollback Migration**
   ```bash
   php artisan migrate:rollback
   ```

3. **Clear Caches**
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan route:clear
   php artisan view:clear
   ```

4. **Previous Code Deployment**
   ```bash
   git checkout <previous-commit>
   composer install
   php artisan migrate
   ```

---

## Sign-Off

- [ ] All tests passed
- [ ] Security audit completed
- [ ] Performance benchmarks met
- [ ] Team review approved
- [ ] Ready for production deployment

**Checked by:** _________________
**Date:** _________________
**Environment:** [ ] Development [ ] Staging [ ] Production

