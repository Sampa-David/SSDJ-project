# ⚡ Quick Start Guide

## 🚀 30-Second Setup

```bash
cd "s:\php(Laravel)\S²DJ"
composer install && npm install
php artisan migrate:fresh --seed
php artisan serve
```

**Result**: Application running at http://localhost:8000

---

## 🔑 Test Credentials

```
Email:    alice@example.com
Password: password123
```

Also works: bob@example.com, carol@example.com, david@example.com, emma@example.com

---

## 🗂️ Key Files Map

| Task | File |
|------|------|
| User Authentication | `app/Http/Controllers/AuthController.php` |
| Ticket Management | `app/Http/Controllers/TicketController.php` |
| User Model | `app/Models/User.php` |
| Ticket Model | `app/Models/Ticket.php` |
| All Routes | `routes/web.php` |
| User Dashboard | `resources/views/dashboard.blade.php` |
| Ticket Purchase | `resources/views/tickets/purchase.blade.php` |
| Database Schema | `database/migrations/2025_11_20_031548_*` |

---

## 📋 Essential Commands

```bash
# Development
php artisan serve                    # Start server at localhost:8000
npm run dev                         # Watch assets for changes

# Database
php artisan migrate                 # Run migrations
php artisan migrate:fresh           # Reset + run migrations
php artisan migrate:fresh --seed    # Reset + run + seed test data

# Debugging
php artisan tinker                  # Interactive shell
php artisan route:list              # View all routes
php artisan cache:clear             # Clear cache

# Utilities
php artisan make:model ModelName    # Create new model
php artisan make:controller NameController  # Create controller
php artisan make:migration table_name       # Create migration
```

---

## 🌐 URL Quick Links

```
🏠 Home:              http://localhost:8000/
📝 Register:          http://localhost:8000/register
🔐 Login:             http://localhost:8000/login
🎫 Buy Tickets:       http://localhost:8000/buy-tickets
📊 Dashboard:         http://localhost:8000/dashboard (auth)
📋 My Tickets:        http://localhost:8000/my-tickets (auth)
📅 Schedule:          http://localhost:8000/schedule
👥 Speakers:          http://localhost:8000/speakers
📍 Venue:             http://localhost:8000/venue
```

---

## 🧪 Quick Testing

### Test Registration
1. Navigate to `/register`
2. Fill form with any data
3. Click Register
4. Should redirect to login

### Test Login
1. Go to `/login`
2. Email: `alice@example.com`
3. Password: `password123`
4. Click Login
5. Should see dashboard

### Test Purchase
1. On dashboard, click "Buy More Tickets"
2. Select ticket type
3. Choose quantity (1-10)
4. Click "Buy Now"
5. See confirmation

### Test Ticket Management
1. Click "My Tickets"
2. Click "Details" on a ticket
3. See ticket info with QR code
4. Can click "Cancel" to cancel

---

## 🔍 Database Queries in Tinker

```bash
php artisan tinker

# View users
>>> App\Models\User::all();

# View tickets
>>> App\Models\Ticket::all();

# Get user with tickets
>>> $user = App\Models\User::first();
>>> $user->tickets;

# Get specific user's tickets
>>> App\Models\Ticket::where('user_id', 1)->get();

# Count active tickets
>>> App\Models\Ticket::where('status', 'active')->count();

# Calculate total revenue
>>> App\Models\Ticket::where('status', '!=', 'cancelled')->sum('price');

# Create test user
>>> App\Models\User::create([
    'name' => 'Test User',
    'email' => 'test@test.com',
    'password' => bcrypt('password'),
    'phone' => '123456',
    'company' => 'Test'
]);
```

---

## 🛠️ Common Fixes

| Problem | Solution |
|---------|----------|
| "Undefined method 'tickets'" | Run: `php artisan migrate` |
| Database connection error | Check .env credentials |
| View not found | Clear cache: `php artisan view:clear` |
| Port 8000 in use | Use: `php artisan serve --port=8001` |
| Blank page | Check `storage/logs/laravel.log` |
| Migrations not running | Verify MySQL is running |

---

## 📊 System Statistics

```
Models:       2 (User, Ticket)
Controllers:  2 (AuthController, TicketController)
Views:        8 (register, login, dashboard, purchase, my-tickets, show, confirmation, header)
Routes:       19 (8 auth + 8 ticket + 3 general)
Migrations:   1 (tickets table)
Documentation: 6 files
Test Users:   5 (created via seeder)
```

---

## 🎯 Feature Checklist

```
✅ User Registration with validation
✅ User Login with session management
✅ User Logout with session cleanup
✅ Dashboard with statistics
✅ 3-tier ticket pricing ($75, $125, $195)
✅ Bulk ticket purchase (1-10)
✅ Unique ticket numbers (TKT-XXXXXXXXXX)
✅ QR code generation per ticket
✅ Ticket list with pagination
✅ Ticket details view
✅ Ticket cancellation
✅ Mobile responsive design
✅ CSRF protection
✅ Authorization checks
✅ Error handling
```

---

## 💡 Pro Tips

### Debugging
```bash
# Watch logs in real-time
tail -f storage/logs/laravel.log

# Use Chrome DevTools (F12) to inspect:
# - Network requests
# - Session cookies
# - Local storage
# - Console for JS errors
```

### Performance
```bash
# Check query count
php artisan tinker
>>> DB::enableQueryLog();
>>> App\Models\User::with('tickets')->get();
>>> DB::getQueryLog();
```

### Database
```bash
# Connect to MySQL directly
mysql -u s2dj_user -p ssdj

# View tables
SHOW TABLES;

# View table structure
DESCRIBE users;
DESCRIBE tickets;

# View data
SELECT * FROM users;
SELECT * FROM tickets;
```

---

## 📚 Documentation Files

- **README_TICKET_SYSTEM.md** - Complete overview (start here!)
- **SYSTEM_DOCUMENTATION.md** - Architecture & design
- **DEVELOPMENT_COMMANDS.md** - All dev commands
- **TESTING_GUIDE.md** - 13 test scenarios
- **DEPLOYMENT_CHECKLIST.md** - Production launch
- **PROJECT_SUMMARY.md** - What was built
- **ARCHITECTURE_DIAGRAM.md** - Visual architecture

---

## 🔄 Development Workflow

```bash
# 1. Start development
php artisan serve              # Terminal 1: Server
npm run dev                    # Terminal 2: Assets

# 2. Make changes to:
# - app/Http/Controllers/*.php
# - app/Models/*.php
# - resources/views/*.blade.php
# - routes/web.php

# 3. Refresh browser (Cmd+R or F5)

# 4. Check errors:
# - Browser console (F12)
# - Terminal output
# - Laravel logs (tail -f storage/logs/laravel.log)

# 5. Commit changes
git add .
git commit -m "Add feature description"
git push origin main
```

---

## 🚀 Production Deployment

```bash
# Before deployment
php artisan config:cache        # Cache config
php artisan route:cache         # Cache routes
php artisan view:cache          # Cache views
php artisan optimize            # Optimize app

# Set production mode
.env: APP_ENV=production
.env: APP_DEBUG=false

# Install production dependencies
composer install --optimize-autoloader --no-dev

# Deploy to server
git push heroku main            # Or your hosting
```

---

## 📞 Support Resources

```
Laravel Docs:     https://laravel.com/docs
Bootstrap Docs:   https://getbootstrap.com/docs
MySQL Docs:       https://dev.mysql.com/doc/
GitHub:           https://github.com
Stack Overflow:   https://stackoverflow.com
```

---

## ✨ Next Features to Add

```
Priority High:
□ Email notifications
□ PDF ticket download
□ Payment integration

Priority Medium:
□ Admin panel
□ Check-in system
□ Ticket transfers

Priority Low:
□ SMS notifications
□ Group discounts
□ Refunds
```

---

## 🎓 Learning Path

1. **Understand Architecture**
   - Read: SYSTEM_DOCUMENTATION.md
   - Review: ARCHITECTURE_DIAGRAM.md

2. **Setup Environment**
   - Run: 30-Second Setup commands
   - Login with test credentials

3. **Explore Codebase**
   - Review: Controllers & Models
   - Test: All features

4. **Run Tests**
   - Follow: TESTING_GUIDE.md
   - Verify: All scenarios pass

5. **Deploy**
   - Follow: DEPLOYMENT_CHECKLIST.md
   - Monitor: Production

---

## 🎉 Success Indicators

```
✅ php artisan serve runs without errors
✅ npm run dev compiles assets
✅ Can access http://localhost:8000
✅ Can register new user
✅ Can login with test credentials
✅ Dashboard loads with stats
✅ Can purchase tickets
✅ Tickets appear in "My Tickets"
✅ Mobile design looks good
✅ No console errors (F12)
```

---

**You're all set! Start with `php artisan serve` and explore! 🚀**

