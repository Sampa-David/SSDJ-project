# Global Tech Summit 2026 - Ticket Management System

## 📋 Overview

This is a complete Laravel-based ticket management system for the Global Tech Summit 2026 event. It includes user authentication, ticket purchasing with 3 pricing tiers, and a comprehensive dashboard for ticket management.

## 🏗️ Architecture

### Database Schema
- **users table**: Stores user information (name, email, password, phone, company)
- **tickets table**: Stores ticket information with relationships to users
  - `ticket_type`: early_bird, regular, premium
  - `status`: active, cancelled, used
  - `qr_code`: Unique QR code for each ticket
  - Validity periods and tracking data

### Models
1. **User** (`app/Models/User.php`)
   - HasMany relationship to Ticket
   - Helper methods: `activeTickets()`, `getTotalSpentAttribute()`, `getTicketCountByType()`

2. **Ticket** (`app/Models/Ticket.php`)
   - BelongsTo relationship to User
   - Helper methods: `isValid()`, `generateTicketNumber()`, type/price display accessors

### Controllers
1. **AuthController** (`app/Http/Controllers/AuthController.php`)
   - Registration: `showRegister()`, `register()`
   - Login: `showLogin()`, `login()`
   - Logout: `logout()`

2. **TicketController** (`app/Http/Controllers/TicketController.php`)
   - Dashboard: `dashboard()`
   - Purchase: `showPurchase()`, `purchase()`
   - Management: `myTickets()`, `show()`, `cancel()`, `download()`
   - Confirmation: `confirmation()`

### Routes
All routes are configured in `routes/web.php`:
- Public routes: Home, Schedule, Speakers, Venue, Terms, Privacy, Contact
- Auth routes: `/register`, `/login`, `/logout`
- Ticket routes (auth-protected):
  - GET `/dashboard` - User dashboard
  - GET `/buy-tickets` - Ticket purchase page
  - POST `/tickets/purchase` - Create purchase
  - GET `/my-tickets` - Ticket list
  - GET `/tickets/{ticket}` - Ticket details
  - DELETE `/tickets/{ticket}/cancel` - Cancel ticket
  - GET `/tickets/{ticket}/download` - Download ticket

### Views
1. **Authentication**
   - `resources/views/auth/register.blade.php`
   - `resources/views/auth/login.blade.php`

2. **Dashboard & Tickets**
   - `resources/views/dashboard.blade.php` - Main user dashboard
   - `resources/views/tickets/purchase.blade.php` - 3-tier ticket selection
   - `resources/views/tickets/my-tickets.blade.php` - Ticket list
   - `resources/views/tickets/show.blade.php` - Ticket details with QR code
   - `resources/views/tickets/confirmation.blade.php` - Purchase confirmation

## 💰 Pricing Tiers

| Tier | Price | Features |
|------|-------|----------|
| Early Bird | $75 | Access to all sessions, Networking events, Lunch & Coffee |
| Regular | $125 | Access to all sessions, Networking events, Lunch |
| Premium | $195 | VIP experience, Meet speakers, Certificate of participation |

## 🎨 Design System

- **Primary Gradient**: #667eea to #764ba2 (used in headers and CTAs)
- **Card Design**: Bootstrap 5 cards with shadows
- **Icons**: Emoji icons for visual appeal
- **Layout**: Responsive Bootstrap 5 grid

## 🚀 Setup & Installation

### Prerequisites
- PHP 8.1+
- MySQL 8.0+
- Composer
- Laravel 11

### Installation Steps

1. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

2. **Environment Configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Database Setup**
   ```bash
   php artisan migrate
   ```

4. **Build Assets** (if needed)
   ```bash
   npm run build
   ```

5. **Start Development Server**
   ```bash
   php artisan serve
   ```

## 📝 Testing the System

### Test User Registration
1. Navigate to `/register`
2. Fill in:
   - Name: John Doe
   - Email: john@example.com
   - Password: password123 (confirmed)
   - Phone: +1234567890 (optional)
   - Company: Tech Corp (optional)
3. Click Register
4. Should redirect to login page

### Test User Login
1. Navigate to `/login`
2. Enter email and password from registration
3. Click Login
4. Should redirect to dashboard

### Test Ticket Purchase
1. From dashboard or `/buy-tickets`, select ticket type
2. Choose quantity (1-10)
3. Click "Buy Now"
4. Should show confirmation page with ticket details
5. Can view ticket in "My Tickets" page

### Test Ticket Management
1. Go to "My Tickets" page
2. View individual ticket details (shows QR code, validity period)
3. Can cancel active tickets
4. Cancelled tickets show updated status

## 🔒 Security Features

- CSRF protection on all forms
- Password hashing using bcrypt
- Authorization checks for user-specific resources
- Foreign key constraints for data integrity
- Validation on all inputs

## 📊 Database Relationships

```
Users (1) ──────→ (Many) Tickets
  ├─ id (PK)
  ├─ name
  ├─ email (UNIQUE)
  ├─ password
  ├─ phone
  └─ company

Tickets
  ├─ id (PK)
  ├─ user_id (FK → users.id)
  ├─ ticket_type (ENUM)
  ├─ price (DECIMAL)
  ├─ ticket_number (UNIQUE)
  ├─ status (ENUM)
  ├─ purchased_at (DATETIME)
  ├─ valid_from (DATETIME)
  ├─ valid_until (DATETIME)
  ├─ qr_code (TEXT)
  ├─ notes (TEXT)
  └─ timestamps
```

## 🛠️ Key Features

✅ **User Authentication**
- Secure registration with validation
- Login with remember-me option
- Session management with logout

✅ **Ticket Management**
- 3 pricing tiers with distinct features
- Bulk purchase (1-10 tickets at once)
- Unique ticket numbers (TKT-XXXXXXXXXX format)
- QR code generation for each ticket

✅ **Dashboard Analytics**
- Total tickets count
- Active tickets display
- Cancelled tickets tracking
- Total spent calculation

✅ **Responsive Design**
- Mobile-friendly interface
- Bootstrap 5 components
- Consistent gradient theme
- Accessible color schemes

## 📞 Support

For issues or questions about the system, refer to:
- Laravel Documentation: https://laravel.com/docs
- Bootstrap Documentation: https://getbootstrap.com/docs
- Project Comments in Code

## 📄 License

This project is part of the Global Tech Summit 2026 event management system.

---

**Last Updated**: November 2025
**Version**: 1.0
