# Development Commands Reference

## 🚀 Quick Start

```bash
# Navigate to project
cd "s:\php(Laravel)\S²DJ"

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Create database
mysql -u root -p
> CREATE DATABASE ssdj;
> GRANT ALL ON ssdj.* TO 's2dj_user'@'localhost' IDENTIFIED BY 'password';

# Run migrations
php artisan migrate

# Start development server
php artisan serve

# Build frontend assets (in another terminal)
npm run dev
```

## 🗄️ Database Commands

### Migrations
```bash
# Run all pending migrations
php artisan migrate

# Rollback all migrations
php artisan migrate:reset

# Rollback last batch
php artisan migrate:rollback

# Refresh database (rollback + migrate)
php artisan migrate:refresh

# Fresh start (rollback all + migrate + seed)
php artisan migrate:fresh

# Create new migration
php artisan make:migration create_table_name
```

### Database Queries
```bash
# Open Tinker interactive shell
php artisan tinker

# Example commands in Tinker:
>>> App\Models\User::all();
>>> App\Models\Ticket::where('user_id', 1)->get();
>>> App\Models\User::find(1)->tickets;
>>> App\Models\Ticket::create(['user_id' => 1, 'ticket_type' => 'premium', ...]);
```

### MySQL Direct Commands
```bash
# Connect to database
mysql -u s2dj_user -p ssdj

# View users
SELECT * FROM users;

# View tickets
SELECT * FROM tickets;

# View user tickets
SELECT * FROM tickets WHERE user_id = 1;

# Count tickets by status
SELECT status, COUNT(*) FROM tickets GROUP BY status;

# Total revenue
SELECT SUM(price) FROM tickets WHERE status != 'cancelled';
```

## 🎨 Asset Commands

```bash
# Install npm dependencies
npm install

# Run webpack in development (watch mode)
npm run dev

# Build assets for production
npm run build

# Watch for changes
npm run watch
```

## 🧪 Testing Commands

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test tests/Feature/AuthTest.php

# Run tests with coverage
php artisan test --coverage

# Stop on first failure
php artisan test --stop-on-failure
```

## 🔧 Development Tools

### Code Quality
```bash
# Format code with Pint
./vendor/bin/pint

# Check for issues without fixing
./vendor/bin/pint --test

# Analyze code with Laravel Insights
php artisan insights
```

### Debugging
```bash
# Check all routes
php artisan route:list

# Check registered events
php artisan event:list

# Check scheduled tasks
php artisan schedule:list

# Check cache
php artisan cache:forget

# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## 👤 User Management (via Tinker)

```bash
# Create test user
php artisan tinker

>>> $user = App\Models\User::create([
...   'name' => 'Test User',
...   'email' => 'test@example.com',
...   'password' => bcrypt('password'),
...   'phone' => '123456789',
...   'company' => 'Test Corp'
... ]);

# View user tickets
>>> $user->tickets;

# Get user stats
>>> $user->getTotalSpentAttribute();
>>> $user->activeTickets()->count();
```

## 🎫 Ticket Management (via Tinker)

```bash
php artisan tinker

# Create ticket
>>> $ticket = App\Models\Ticket::create([
...   'user_id' => 1,
...   'ticket_type' => 'premium',
...   'price' => 195,
...   'ticket_number' => App\Models\Ticket::generateTicketNumber(),
...   'status' => 'active',
...   'purchased_at' => now(),
...   'valid_from' => now(),
...   'valid_until' => now()->addDays(180)
... ]);

# Check if ticket valid
>>> $ticket->isValid();

# Get ticket display info
>>> $ticket->type_label;
>>> $ticket->price_display;

# Cancel ticket
>>> $ticket->update(['status' => 'cancelled']);
```

## 📊 Database Seeding

```bash
# Create seeder class
php artisan make:seeder TicketSeeder

# Run seeders
php artisan db:seed

# Run specific seeder
php artisan db:seed --class=TicketSeeder

# Seed fresh database
php artisan migrate:fresh --seed
```

## 🔐 Security

```bash
# Generate new application key
php artisan key:generate

# Verify environment file
php artisan tinker
>>> config('app.key');

# Check password hashing
>>> bcrypt('mypassword');
```

## 🚀 Production Deployment

```bash
# Install dependencies (production only)
composer install --optimize-autoloader --no-dev

# Generate cache for config
php artisan config:cache

# Cache all routes
php artisan route:cache

# Cache all views
php artisan view:cache

# Full optimization
php artisan optimize

# Clear all caches
php artisan optimize:clear
```

## 📝 Logs & Debugging

```bash
# View recent logs
tail -f storage/logs/laravel.log

# Clear all logs
php artisan log:clear

# Monitor logs in real-time
tail -f storage/logs/laravel.log | grep -i error
```

## 🐛 Common Issues & Solutions

### Issue: "Undefined method 'tickets'"
**Solution:** Run migrations
```bash
php artisan migrate
```

### Issue: "Column not found"
**Solution:** Check migration and run migrate fresh
```bash
php artisan migrate:fresh
```

### Issue: "Database connection refused"
**Solution:** Check .env file database credentials
```bash
# Verify connection
php artisan tinker
>>> DB::connection()->getPdo();
```

### Issue: "Class not found"
**Solution:** Regenerate autoloader
```bash
composer dump-autoload
```

### Issue: "CSRF token mismatch"
**Solution:** Ensure forms have @csrf in Blade
```blade
<form method="POST" action="/route">
    @csrf
    <!-- form fields -->
</form>
```

### Issue: "View not found"
**Solution:** Check view path and file exists
```bash
# View cache might be stale
php artisan view:clear

# Check file exists
ls -la resources/views/tickets/
```

## 📚 Useful Links

- Laravel Documentation: https://laravel.com/docs
- MySQL Documentation: https://dev.mysql.com/doc/
- Bootstrap Documentation: https://getbootstrap.com/docs
- Blade Syntax: https://laravel.com/docs/blade
- Eloquent ORM: https://laravel.com/docs/eloquent

## 🔄 Git Commands

```bash
# Add all changes
git add .

# Commit with message
git commit -m "Add ticket management system"

# View status
git status

# Push to repository
git push origin main

# Check logs
git log --oneline -10
```

## 📞 Quick Reference

| Task | Command |
|------|---------|
| Start server | `php artisan serve` |
| Run migrations | `php artisan migrate` |
| Clear caches | `php artisan cache:clear` |
| View routes | `php artisan route:list` |
| Open Tinker | `php artisan tinker` |
| Build assets | `npm run build` |
| Watch assets | `npm run dev` |
| Check migrations | `php artisan migrate:status` |

---

**Last Updated:** November 2025
**Version:** 1.0
