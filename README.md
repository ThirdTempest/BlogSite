# 🛡️ BlogSite System — A Site with Good Security

[![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![Database](https://img.shields.io/badge/Database-SQLite-003B57?style=for-the-badge&logo=sqlite&logoColor=white)](https://www.sqlite.org/)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com/)
[![Tests](https://img.shields.io/badge/Tests-18%20Passed-success?style=for-the-badge&logo=phpunit&logoColor=white)](https://phpunit.de/)

> **Prelim Coursework Project**  
> A secure authentication, authorization, and user management web application built with **pure Laravel**, featuring **Two-Factor Email OTP verification**, **strict password enforcement**, **role-based access control**, and **Google SMTP integration**.

---

## 👥 Project Team & Authors

- **Rob Malik Abrenica**
- **Nathaniel Pescadero**
- **Raphael Simone Llanita**
- **Kent John Gadornez**
- **Jayshan**

---

## ✨ Key Features

- 🎨 **Modern Frosted Glass UI**: Custom cloud sky backdrop with glassmorphic cards and interactive inputs powered by Tailwind CSS (via CDN — zero npm build required).
- 🔒 **Strict Password Security Policy**: Enforces high-security passwords ($\ge 10$ characters, uppercase, lowercase, numbers, and symbols) with a real-time visual requirement checklist.
- 📩 **Two-Factor Authentication (2FA Email OTP)**: Dispatches a 6-digit verification code to the user's Gmail upon registration and login with a live 10-minute countdown timer.
- ⚡ **Super Admin Direct Login**: Accounts with the `admin` role bypass OTP prompts for seamless administrative access.
- 👥 **Role-Based Authorization (Admin vs User)**: Custom `AdminMiddleware` and `EnsureEmailOtpVerified` middleware guarding routes.
- 🛠️ **Full User Management CRUD**: Allows Super Admins to search, filter, paginate, create, edit, and delete users, with safety safeguards preventing self-deletion or deletion of the last admin.
- ✉️ **Automated Transactional Emails**:
  - **Email OTP Verification**: Responsive HTML email with 6-digit code.
  - **Welcome Email**: Automatically sent with login credentials when an Admin creates a new user.
  - **Password Reset Email**: Secure 60-minute token-based reset link with email confirmation.

---

## 📋 Prerequisites

Make sure you have the following installed on your machine:
- **PHP >= 8.1** (with extensions enabled in `php.ini`: `pdo_sqlite`, `sqlite3`, `openssl`, `mbstring`, `curl`)
- **Composer** (PHP Dependency Manager)
- **Git**
- **Google Account** (with **2-Step Verification** and an **App Password** for SMTP email delivery)

---

## 🚀 Step-by-Step Installation & Setup

### 1. Clone the Repository
```bash
git clone https://github.com/ThirdTempest/BlogSite.git
cd BlogSite
```

### 2. Install Composer Dependencies
```bash
composer install
```

### 3. Setup Environment File
Duplicate `.env.example` to create your `.env` file:

**Windows (PowerShell / Command Prompt):**
```powershell
copy .env.example .env
```

**macOS / Linux:**
```bash
cp .env.example .env
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Create SQLite Database File
Ensure the SQLite database file exists in the `database/` folder:

**Windows (PowerShell):**
```powershell
if (!(Test-Path "database\database.sqlite")) { New-Item "database\database.sqlite" -ItemType File }
```

**macOS / Linux:**
```bash
touch database/database.sqlite
```

Verify in your `.env` that:
```env
DB_CONNECTION=sqlite
```

---

### 6. Configure Google SMTP Credentials

To enable live email OTP and password reset functionality, update the mail configuration in your `.env` file:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_real_email@gmail.com
MAIL_PASSWORD=your_16_character_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your_real_email@gmail.com"
MAIL_FROM_NAME="BlogSite System"
```

> [!IMPORTANT]
> **How to get a Google App Password:**
> 1. Go to your [Google Account Security Settings](https://myaccount.google.com/security).
> 2. Ensure **2-Step Verification** is turned **ON**.
> 3. Search for **App passwords**.
> 4. Create an app named **BlogSite** and copy the generated **16-letter password** (without spaces) into `MAIL_PASSWORD`.

---

### 7. Run Database Migrations & Seed Default Admin

Run the database migrations and seed the initial Super Admin account:

```bash
php artisan migrate:fresh --seed
```

---

### 8. Start the Local Development Server

```bash
php artisan serve
```

Open your browser and navigate to:
```
http://127.0.0.1:8000
```

---

## 🔑 Default Accounts

| Role | Email | Password | Access & Behavior |
| :--- | :--- | :--- | :--- |
| **Super Admin** | `admin@blogsite.com` | `Admin@12345!` | Full Admin & User Management access. Bypasses OTP. |
| **New User** | Registered via `/register` | User-defined (Strict Policy) | Requires 6-Digit Email OTP verification before accessing Dashboard. |

---

## 💡 How to Create / Reset Admin Accounts via Tinker

If you ever need to create or reset an admin account manually:

```bash
php artisan tinker
```

```php
App\Models\User::updateOrCreate(
    ['email' => 'admin@blogsite.com'],
    [
        'name' => 'Super Admin',
        'password' => Hash::make('Admin@12345!'),
        'role' => 'admin',
        'email_verified_at' => now(),
    ]
);
```

Or as a one-liner command:
```bash
php artisan tinker --execute="App\Models\User::updateOrCreate(['email' => 'admin@blogsite.com'], ['name' => 'Super Admin', 'password' => Hash::make('Admin@12345!'), 'role' => 'admin', 'email_verified_at' => now()]); echo PHP_EOL . 'Admin created!' . PHP_EOL;"
```

---

## 🧪 Running Automated Tests

The application includes a complete suite of **18 automated Feature & Unit tests** testing registration, strict password validation, login, OTP verification, password resets, authorization, and CRUD operations.

Run all tests using:
```bash
php artisan test
```

Expected output:
```
PASS  Tests\Unit\ExampleTest
PASS  Tests\Feature\AuthAndUserTest (16 tests)
PASS  Tests\Feature\ExampleTest
Tests:  18 passed (52 assertions)
```

---

## 📁 Project Structure Overview

```
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   │   ├── ForgotPasswordController.php   # Reset link request handler
│   │   │   │   ├── LoginController.php            # Login & OTP dispatch / Admin bypass
│   │   │   │   ├── OtpVerificationController.php  # 6-Digit OTP verification logic
│   │   │   │   ├── RegisterController.php         # User registration & password checks
│   │   │   │   └── ResetPasswordController.php    # Token verification & password update
│   │   │   ├── DashboardController.php            # Welcome dashboard
│   │   │   └── UserController.php                 # User Management CRUD
│   │   └── Middleware/
│   │       ├── AdminMiddleware.php                # Restricts routes to role === 'admin'
│   │       └── EnsureEmailOtpVerified.php         # Guards routes until OTP is verified
│   ├── Mail/
│   │   ├── ResetPasswordMail.php                  # Password reset notification mailable
│   │   ├── SendOtpMail.php                        # 6-digit OTP delivery mailable
│   │   └── UserCreatedWelcomeMail.php             # Admin new user welcome mailable
│   └── Models/
│       └── User.php                               # User model with role & OTP helpers
├── database/
│   ├── migrations/                                # Database table definitions
│   └── seeders/DatabaseSeeder.php                 # Default Super Admin seeder
├── public/
│   ├── background.png                             # Custom sky background asset
│   └── bloglogo.png                               # BlogSite logo asset
├── resources/views/
│   ├── auth/                                      # Login, Register, OTP, & Password views
│   ├── emails/                                    # HTML Email templates
│   ├── layouts/                                   # App & Auth master Blade layouts
│   ├── users/                                     # User management CRUD views
│   └── dashboard.blade.php                        # Authenticated welcome dashboard
├── routes/web.php                                 # Application route definitions
└── tests/Feature/AuthAndUserTest.php              # Automated test suite
```

---

## 📄 License

This project was developed for educational and coursework purposes under the MIT License.
