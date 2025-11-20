# Deployment & Testing Checklist

## Pre-Launch Checklist

### ✅ Database
- [ ] Migration file created: `2025_11_20_031548_create_tickets_table.php`
- [ ] Run `php artisan migrate` to create tables
- [ ] Verify MySQL has database `ssdj` with `s2dj_user` credentials
- [ ] Check foreign key constraints are created

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

