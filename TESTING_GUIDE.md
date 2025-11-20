# 🧪 Testing Guide - Global Tech Summit 2026 Ticket System

## Pre-Testing Setup

### Step 1: Prepare Database
```bash
# Navigate to project
cd "s:\php(Laravel)\S²DJ"

# Fresh database setup
php artisan migrate:fresh --seed

# This will:
# ✓ Drop all tables
# ✓ Run all migrations (creating users & tickets tables)
# ✓ Run DatabaseSeeder which runs TicketSystemSeeder
# ✓ Create 5 test users with 1-5 tickets each
```

### Step 2: Start Development Server
```bash
# Terminal 1: Start Laravel server
php artisan serve

# Terminal 2: Build assets (in another terminal)
npm run dev

# Browser: Open http://localhost:8000
```

### Step 3: Verify Database
```bash
# Check if data was seeded
php artisan tinker

>>> App\Models\User::count();        // Should show 5
>>> App\Models\Ticket::count();      // Should show ~12-15
>>> App\Models\User::first()->tickets;
```

---

## 🧪 Test Scenarios

### Test 1: View Homepage
**Goal**: Verify public site works before login

**Steps:**
1. Open `http://localhost:8000`
2. Click through navigation links:
   - Home
   - Schedule
   - Speakers
   - Venue
   - Terms, Privacy, Contact

**Expected Results:**
- ✓ All pages load without errors
- ✓ Header shows "Login" and "Register" buttons
- ✓ Navigation menu works on mobile (click hamburger)
- ✓ "Buy Tickets" button shows on right

**Verification:**
```bash
curl http://localhost:8000        # Should get homepage HTML
```

---

### Test 2: User Registration
**Goal**: Test new user registration functionality

**Steps:**
1. Click "Register" button in top-right
2. Fill in registration form:
   - **Name**: John Developer
   - **Email**: john.dev@test.com
   - **Password**: SecurePass123!
   - **Confirm Password**: SecurePass123!
   - **Phone**: +1-555-9999
   - **Company**: Tech Startup Inc
3. Click "Register" button
4. Should redirect to login page

**Expected Results:**
- ✓ Form validates all fields
- ✓ Error messages if validation fails:
   - Email already exists
   - Passwords don't match
   - Required fields empty
- ✓ Success: User created in database
- ✓ Redirect to login page with message

**Database Verification:**
```bash
php artisan tinker

>>> App\Models\User::where('email', 'john.dev@test.com')->first();
// Should show the newly created user
```

**Error Tests:**
```
Test Case 1: Duplicate Email
- Register with existing email (alice@example.com)
- Expected: Error "Email already exists"

Test Case 2: Password Mismatch
- Password: test123
- Confirm: test456
- Expected: Error "Passwords do not match"

Test Case 3: Missing Fields
- Leave any field empty
- Expected: Error "This field is required"
```

---

### Test 3: User Login
**Goal**: Test authentication system

**Steps - Valid Credentials:**
1. Navigate to `/login`
2. Enter email: `alice@example.com`
3. Enter password: `password123`
4. Check "Remember Me" (optional)
5. Click "Login"

**Expected Results:**
- ✓ Session created (check browser cookies)
- ✓ Redirect to dashboard
- ✓ User name appears in header ("Hello, Alice")
- ✓ "My Account" dropdown visible

**Verification:**
```bash
# Check session in browser DevTools > Application > Cookies
# Should see: LARAVEL_SESSION cookie

php artisan tinker
>>> Auth::user();  // Should show current user
```

**Error Tests:**
```
Test Case 1: Wrong Password
- Email: alice@example.com
- Password: wrongpassword
- Expected: Error "Invalid credentials"

Test Case 2: Non-existent Email
- Email: notarealuser@example.com
- Password: password123
- Expected: Error "Invalid credentials"

Test Case 3: Missing Fields
- Empty email or password
- Expected: Error "This field is required"
```

---

### Test 4: Dashboard Overview
**Goal**: Verify dashboard displays correct information

**Steps:**
1. Login with alice@example.com / password123
2. Should land on dashboard

**Expected Results:**
- ✓ Welcome message: "Welcome back, Alice!"
- ✓ "Member since" date shown (e.g., "Member since Nov 20, 2025")
- ✓ 4 stat cards display:
  - 🎫 Total Tickets: 1-5 (random from seeding)
  - ✓ Active Tickets: count of non-cancelled
  - ✕ Cancelled Tickets: count of cancelled
  - 💰 Total Spent: sum in dollars (e.g., "$250.00")
- ✓ Tickets section shows purchased tickets with cards
- ✓ Profile section shows user info
- ✓ "Logout" button available

**Data Verification:**
```bash
# Verify stat calculations
php artisan tinker

>>> $user = App\Models\User::find(1);
>>> $user->tickets()->count();           // Total tickets
>>> $user->activeTickets()->count();     // Active
>>> $user->tickets()->where('status', 'cancelled')->count();  // Cancelled
>>> $user->getTotalSpentAttribute();     // Total spent
```

---

### Test 5: Buy Tickets - Purchase Form
**Goal**: Test ticket selection interface

**Steps:**
1. From dashboard, click "Buy More Tickets" button
2. Page should show 3 ticket options

**Expected Results:**
- ✓ Early Bird card shows:
  - Price: $75
  - Features listed
  - Quantity dropdown (1-10)
  - "Buy Now" button
- ✓ Regular card shows:
  - Price: $125
  - Features listed
  - Quantity dropdown
  - "Buy Now" button
- ✓ Premium card shows:
  - Price: $195
  - Features listed
  - Quantity dropdown
  - "Buy Now" button

**Layout Verification:**
```
Desktop: 3 columns displayed side-by-side
Tablet: 2 columns
Mobile: 1 column (stacked)
```

---

### Test 6: Purchase Tickets
**Goal**: Test ticket creation and purchase

**Steps - Single Ticket:**
1. Select "Premium" ticket type
2. Quantity: 1
3. Click "Buy Now"

**Expected Results:**
- ✓ Form submits to backend
- ✓ Redirect to confirmation page
- ✓ Confirmation shows:
  - ✓ Success checkmark
  - ✓ Ticket number (e.g., "TKT-123ABC456")
  - ✓ Type: Premium
  - ✓ Amount: $195.00
  - ✓ Email confirmation text
  - ✓ Buttons: "View My Tickets", "Back Home"

**Database Verification:**
```bash
php artisan tinker

# Check if ticket was created
>>> $ticket = App\Models\Ticket::latest()->first();
>>> $ticket->ticket_number;         // Should show unique number
>>> $ticket->ticket_type;           // Should be 'premium'
>>> $ticket->price;                 // Should be 195
>>> $ticket->status;                // Should be 'active'
>>> $ticket->user_id;               // Should be logged-in user ID
```

**Steps - Bulk Purchase:**
1. Select "Regular" ticket type
2. Quantity: 5
3. Click "Buy Now"

**Expected Results:**
- ✓ 5 separate tickets created
- ✓ Confirmation shows 5 tickets created
- ✓ Each ticket gets unique number
- ✓ All linked to same user

**Database Verification:**
```bash
php artisan tinker

>>> App\Models\Ticket::where('ticket_type', 'regular')
>>>   ->where('user_id', Auth::id())
>>>   ->latest()
>>>   ->limit(5)
>>>   ->get()
>>>   ->count();  // Should be 5
```

**Error Tests:**
```
Test Case 1: Invalid Quantity
- Select "Early Bird"
- Quantity: 0 or 11 or text
- Expected: Error "Quantity must be between 1 and 10"

Test Case 2: Invalid Type
- Bypass form validation
- ticket_type: invalid_type
- Expected: Error "Invalid ticket type selected"

Test Case 3: Unauthenticated Access
- Logout
- Try to access /buy-tickets form
- Expected: Redirect to login
```

---

### Test 7: View My Tickets
**Goal**: Test ticket list display and pagination

**Steps:**
1. Click "My Tickets" in navigation or dashboard
2. Review ticket list

**Expected Results:**
- ✓ All purchased tickets displayed in cards
- ✓ Each card shows:
  - Ticket type (color header)
  - Status badge (green=Active, red=Cancelled)
  - Ticket number
  - Price
  - Purchase date
  - "Details" and "Cancel" buttons
- ✓ Shows "Buy More Tickets" button at top
- ✓ Pagination at bottom (if > 10 tickets)
- ✓ Empty state message if no tickets

**Pagination Test:**
```
If user has 15 tickets:
- Page 1: Shows 10 tickets + pagination controls
- Click "Next": Shows remaining 5 tickets
- Click "Previous": Back to page 1
```

---

### Test 8: View Ticket Details
**Goal**: Test individual ticket display with QR code

**Steps:**
1. From "My Tickets" list, click "Details" on a ticket
2. Review ticket information

**Expected Results:**
- ✓ Back button to return to list
- ✓ Header with gradient background showing ticket number
- ✓ Status badge (Active/Cancelled) with color
- ✓ Details section shows:
  - Ticket #: (unique identifier)
  - Status: (Active/Cancelled/Used)
  - Type: (Early Bird/Regular/Premium)
  - Price: (formatted as currency)
  - Purchased: (date)
  - Valid Until: (date)
- ✓ QR Code displayed (if present)
- ✓ Notes section (if present)
- ✓ Action buttons:
  - Print button (if active)
  - Cancel button (if active)

**QR Code Verification:**
```bash
# Check if QR code was generated
php artisan tinker

>>> $ticket = App\Models\Ticket::find(1);
>>> $ticket->qr_code;  // Should show base64 encoded string
>>> strlen($ticket->qr_code) > 20;  // Should be true
```

---

### Test 9: Cancel Ticket
**Goal**: Test ticket cancellation

**Steps:**
1. Go to ticket details of an active ticket
2. Click "Cancel" button
3. Confirm cancellation in popup

**Expected Results:**
- ✓ Confirmation dialog appears: "Cancel this ticket?"
- ✓ Click OK to confirm
- ✓ Success message: "Ticket cancelled successfully"
- ✓ Status changes to "Cancelled" with red badge
- ✓ Cancel button disappears
- ✓ Redirect back to ticket details

**Database Verification:**
```bash
php artisan tinker

>>> $ticket = App\Models\Ticket::find(1);
>>> $ticket->status;  // Should now be 'cancelled'
>>> $ticket->updated_at;  // Should be current time

# Dashboard stats should update
>>> $user->activeTickets()->count();  // Should decrease by 1
```

**Authorization Test:**
```
Test Case 1: Cancel Another User's Ticket
- Login as Alice
- Try to cancel Bob's ticket (via URL manipulation)
- Expected: 403 Forbidden error
```

---

### Test 10: Logout
**Goal**: Test session termination

**Steps:**
1. From dashboard, click "My Account" dropdown
2. Click "Logout"

**Expected Results:**
- ✓ Session destroyed
- ✓ Redirect to homepage
- ✓ Header shows "Login" and "Register" buttons
- ✓ Cannot access `/dashboard` without login

**Verification:**
```bash
# Try to access protected route
curl http://localhost:8000/dashboard

# Should redirect to /login
```

---

### Test 11: User Profile Navigation
**Goal**: Test navigation between authenticated pages

**Steps - Dashboard Navigation:**
1. Login to dashboard
2. Click "Buy More Tickets" → Should go to purchase page
3. Complete purchase → Should show confirmation
4. From confirmation, click "View My Tickets" → Should show list
5. Click ticket details → Should show details page
6. Click back button → Should return to list

**Expected Results:**
- ✓ All navigation flows work correctly
- ✓ Links point to correct routes
- ✓ No 404 errors
- ✓ Breadcrumb navigation works

---

### Test 12: Responsive Design
**Goal**: Test mobile/tablet compatibility

**Steps - Desktop (1920x1080):**
1. View dashboard
2. View ticket list
3. View purchase page

**Expected Results:**
- ✓ 3-column layout on ticket purchase
- ✓ Cards display side-by-side
- ✓ Navigation bar shows full menu

**Steps - Tablet (768x1024):**
1. View dashboard
2. View ticket list
3. View purchase page

**Expected Results:**
- ✓ 2-column layout on purchase page
- ✓ Cards stack appropriately
- ✓ Buttons remain clickable

**Steps - Mobile (375x667):**
1. View dashboard
2. View ticket list
3. View purchase page

**Expected Results:**
- ✓ Single column layout
- ✓ Cards stack vertically
- ✓ Hamburger menu shows/hides navigation
- ✓ All buttons accessible
- ✓ No horizontal scrolling

---

### Test 13: Form Validation
**Goal**: Test all form validation rules

**Registration Form:**
```
Field Validation Tests:

Name:
✓ Empty: Show error
✓ Valid text: Accept
✓ Special chars: Accept

Email:
✓ Empty: Show error
✓ Invalid format (no @): Show error
✓ Duplicate email: Show error
✓ Valid: Accept

Password:
✓ Empty: Show error
✓ Too short: Show error
✓ Mismatch: Show error
✓ Valid 8+ chars: Accept

Phone:
✓ Empty: Accept (optional)
✓ Any format: Accept
✓ Valid format: Accept

Company:
✓ Empty: Accept (optional)
✓ Any text: Accept
```

**Login Form:**
```
Field Validation Tests:

Email:
✓ Empty: Show error
✓ Unregistered: Show error
✓ Valid: Accept

Password:
✓ Empty: Show error
✓ Wrong: Show error
✓ Correct: Accept
```

**Ticket Purchase Form:**
```
Field Validation Tests:

Ticket Type:
✓ early_bird: Accept
✓ regular: Accept
✓ premium: Accept
✓ invalid: Show error

Quantity:
✓ 0: Show error
✓ 1-10: Accept
✓ 11+: Show error
✓ text: Show error
```

---

## 📊 Performance Testing

### Load Time Tests
**Tool**: Browser DevTools > Network tab

```
Target Metrics:
- Homepage: < 2 seconds
- Dashboard: < 1.5 seconds
- Purchase page: < 1 second
- Ticket details: < 1 second

Test Steps:
1. Open DevTools (F12)
2. Go to Network tab
3. Clear cache
4. Navigate to page
5. Check "DOMContentLoaded" and "Load" times
```

### Database Query Performance
**Tool**: Laravel Debug Bar or Manual Logging

```bash
# Enable query logging
php artisan tinker

>>> DB::enableQueryLog();
>>> App\Models\User::with('tickets')->first();
>>> DB::getQueryLog();

# Check number of queries and execution time
```

---

## 🔐 Security Testing

### Test Cases

**CSRF Protection:**
```
1. Submit form without @csrf token
Expected: Error or 419 Conflict
```

**Authorization:**
```
1. Login as Alice
2. Try to view Bob's tickets (direct URL)
Expected: 403 Forbidden
```

**Password Security:**
```
1. Check password in database
Expected: Hashed, not plaintext

php artisan tinker
>>> $user = App\Models\User::first();
>>> $user->password;  // Should be hashed (60 chars)
>>> Hash::check('password123', $user->password);  // Should be true
```

**Session Hijacking:**
```
1. Login as Alice
2. Copy LARAVEL_SESSION cookie
3. Open incognito window
4. Manually set cookie
Expected: Cannot access Alice's account
```

---

## 🐛 Common Issues & Fixes

### Issue: "SQLSTATE[HY000]: General error: 1364"
```
Cause: Required field is NULL in database
Fix: Check migration file has correct defaults
     Run: php artisan migrate:refresh
```

### Issue: "Undefined method 'tickets'"
```
Cause: Migration not run
Fix: php artisan migrate
```

### Issue: "503 Service Unavailable"
```
Cause: Laravel server not running
Fix: php artisan serve
     Or check port 8000 is not in use
```

### Issue: "Logged in as wrong user"
```
Cause: Session not cleared
Fix: Clear browser cookies
     php artisan cache:clear
```

### Issue: "View not found"
```
Cause: Blade file not created
Fix: Verify file exists in resources/views/
     Check path matches route
```

---

## ✅ Sign-Off Checklist

After completing all tests, verify:

- [ ] All pages load without 404 or 500 errors
- [ ] User registration works with validation
- [ ] User login/logout works correctly
- [ ] Dashboard displays correct stats
- [ ] Ticket purchase creates records
- [ ] Ticket list shows all purchased tickets
- [ ] Ticket details display with QR code
- [ ] Can cancel active tickets
- [ ] Cannot access other users' tickets (403)
- [ ] Mobile responsive design works
- [ ] All forms validate input correctly
- [ ] Performance targets met
- [ ] No database errors in logs
- [ ] No JavaScript errors in console

---

## 🚀 Ready for Production

Once all tests pass:

```bash
# Set production configuration
.env: APP_ENV=production
.env: APP_DEBUG=false

# Run optimization
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Deploy to server
```

---

**Test Date**: _____________
**Tested By**: _____________
**Status**: ☐ PASSED ☐ FAILED

