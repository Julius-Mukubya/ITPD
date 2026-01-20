# WellPath - Drug & Alcohol Awareness Platform

## Project Overview

A comprehensive web-based platform designed to create awareness about drug and alcohol abuse among students. The system provides educational content, self-assessment tools, counseling services, community forums, and incident reporting in a safe, accessible, and stigma-free environment.

### Key Features
- 📚 Educational Content Library (Articles, Videos, Infographics)
- 📝 Interactive Quizzes for Knowledge Testing
- 🔍 Self-Assessment Tools (AUDIT & DUDIT)
- 💬 Anonymous Counseling Services
- 👥 Community Support Forum
- 🚨 Incident Reporting System
- 📊 Admin Analytics Dashboard
- 🔔 Notification System

### Target Users
- **Students**: Primary users seeking information and support
- **Counselors**: Provide guidance and support to students
- **Administrators**: Manage content, users, and platform operations

---

## Technology Stack

### Backend
- **Framework**: Laravel 11.x
- **Language**: PHP 8.2+
- **Database**: MySQL 8.0+
- **Authentication**: Laravel Breeze/Sanctum

### Frontend
- **Template Engine**: Blade
- **CSS Framework**: Tailwind CSS 3.x
- **JavaScript**: Vanilla JS / Alpine.js (optional)
- **Icons**: Heroicons / Font Awesome

### Development Tools
- **Code Editor**: Visual Studio Code
- **Version Control**: Git
- **Package Manager**: Composer, NPM
- **Server**: XAMPP / Laravel Valet / Docker

---

## System Requirements

### Minimum Requirements
- PHP 8.2 or higher
- MySQL 8.0 or higher
- Composer 2.x
- Node.js 18.x and NPM
- 2GB RAM
- 5GB Storage

### Recommended
- PHP 8.3
- MySQL 8.0+
- 4GB RAM
- 10GB Storage
- SSD for faster performance

---

## Installation & Setup Guide

### Step 1: Install Prerequisites

#### Windows (Using XAMPP)
```bash
# Download and install XAMPP from https://www.apachefriends.org/
# Download and install Composer from https://getcomposer.org/
# Download and install Node.js from https://nodejs.org/

# Verify installations
php -v
composer -v
node -v
npm -v
```

#### macOS
```bash
# Install Homebrew if not installed
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"

# Install PHP
brew install php@8.2

# Install Composer
brew install composer

# Install MySQL
brew install mysql

# Install Node.js
brew install node
```

#### Linux (Ubuntu/Debian)
```bash
# Update package list
sudo apt update

# Install PHP and extensions
sudo apt install php8.2 php8.2-cli php8.2-fpm php8.2-mysql php8.2-xml php8.2-mbstring php8.2-curl php8.2-zip php8.2-gd

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install MySQL
sudo apt install mysql-server

# Install Node.js
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install nodejs
```

---

### Step 2: Create Laravel Project

```bash
# Navigate to your projects directory
cd C:/xampp/htdocs  # Windows
cd ~/Sites          # macOS
cd ~/projects       # Linux

# Create new Laravel project
composer create-project laravel/laravel wellpath-platform

# Navigate into project
cd wellpath-platform

# Install Laravel Breeze for authentication
composer require laravel/breeze --dev

# Install Breeze with Blade templates
php artisan breeze:install blade

# Install frontend dependencies
npm install

# Build frontend assets
npm run dev
```

---

### Step 3: Configure Database

#### Create Database
```sql
-- Open MySQL command line or phpMyAdmin
CREATE DATABASE wellpath_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

#### Configure .env File
```bash
# Open .env file and update database settings
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=wellpath_db
DB_USERNAME=root
DB_PASSWORD=your_password

# Application settings
APP_NAME="WellPath"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
```

---

### Step 4: Database Design & Migrations

#### Create Migration Files
```bash
# User-related migrations
php artisan make:migration add_additional_fields_to_users_table
php artisan make:migration create_roles_table

# Content management
php artisan make:migration create_categories_table
php artisan make:migration create_educational_contents_table

# Assessment system
php artisan make:migration create_assessments_table
php artisan make:migration create_assessment_questions_table
php artisan make:migration create_assessment_attempts_table

# Quiz system
php artisan make:migration create_quizzes_table
php artisan make:migration create_quiz_questions_table
php artisan make:migration create_quiz_options_table
php artisan make:migration create_quiz_attempts_table
php artisan make:migration create_quiz_answers_table

# Counseling system
php artisan make:migration create_counseling_sessions_table
php artisan make:migration create_counseling_messages_table

# Forum system
php artisan make:migration create_forum_categories_table
php artisan make:migration create_forum_posts_table
php artisan make:migration create_forum_comments_table

# Reporting
php artisan make:migration create_incidents_table
php artisan make:migration create_feedback_table

# Notifications
php artisan make:migration create_campaigns_table
```

#### Run Migrations
```bash
php artisan migrate
```

---

### Step 5: Create Models

```bash
# Generate models
php artisan make:model Category
php artisan make:model EducationalContent
php artisan make:model Quiz
php artisan make:model QuizQuestion
php artisan make:model QuizOption
php artisan make:model QuizAttempt
php artisan make:model QuizAnswer
php artisan make:model Assessment
php artisan make:model AssessmentAttempt
php artisan make:model CounselingSession
php artisan make:model CounselingMessage
php artisan make:model ForumCategory
php artisan make:model ForumPost
php artisan make:model ForumComment
php artisan make:model Incident
php artisan make:model Feedback
php artisan make:model Campaign
```

---

### Step 6: Create Controllers

```bash
# Public controllers
php artisan make:controller HomeController
php artisan make:controller ContentController
php artisan make:controller AboutController

# Dashboard controller
php artisan make:controller DashboardController

# Student controllers
php artisan make:controller Student/QuizController
php artisan make:controller Student/AssessmentController
php artisan make:controller Student/CounselingController
php artisan make:controller Student/ForumController
php artisan make:controller Student/ProfileController

# Admin controllers
php artisan make:controller Admin/DashboardController
php artisan make:controller Admin/ContentController
php artisan make:controller Admin/QuizController
php artisan make:controller Admin/UserController
php artisan make:controller Admin/CounselingController
php artisan make:controller Admin/IncidentController
php artisan make:controller Admin/ReportController
php artisan make:controller Admin/CategoryController

# Counselor controllers
php artisan make:controller Counselor/DashboardController
php artisan make:controller Counselor/SessionController
```

---

### Step 7: Create Middleware

```bash
# Create role-checking middleware
php artisan make:middleware CheckRole

# Create admin middleware
php artisan make:middleware IsAdmin

# Create counselor middleware
php artisan make:middleware IsCounselor

# Create student middleware
php artisan make:middleware IsStudent
```

Register middleware in `bootstrap/app.php`:
```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'role' => \App\Http\Middleware\CheckRole::class,
        'admin' => \App\Http\Middleware\IsAdmin::class,
        'counselor' => \App\Http\Middleware\IsCounselor::class,
        'student' => \App\Http\Middleware\IsStudent::class,
    ]);
})
```

---

### Step 8: Define Routes

Edit `routes/web.php`:
```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Student;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Counselor;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', function() { return view('about'); })->name('about');
Route::get('/contents', [ContentController::class, 'index'])->name('contents.index');
Route::get('/contents/{content}', [ContentController::class, 'show'])->name('contents.show');

require __DIR__.'/auth.php';

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Student routes
    Route::middleware('student')->prefix('student')->name('student.')->group(function () {
        Route::resource('quizzes', Student\QuizController::class);
        Route::post('quizzes/{quiz}/start', [Student\QuizController::class, 'start'])->name('quizzes.start');
        Route::resource('assessments', Student\AssessmentController::class);
        Route::resource('counseling', Student\CounselingController::class);
        Route::resource('forum', Student\ForumController::class);
    });
    
    // Admin routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::resource('contents', Admin\ContentController::class);
        Route::resource('quizzes', Admin\QuizController::class);
        Route::resource('users', Admin\UserController::class);
        Route::resource('incidents', Admin\IncidentController::class);
        Route::get('reports', [Admin\ReportController::class, 'index'])->name('reports.index');
    });
    
    // Counselor routes
    Route::middleware('counselor')->prefix('counselor')->name('counselor.')->group(function () {
        Route::get('dashboard', [Counselor\DashboardController::class, 'index'])->name('dashboard');
        Route::resource('sessions', Counselor\SessionController::class);
    });
});
```

---

### Step 9: Setup Views Structure

```bash
# Create directory structure
mkdir -p resources/views/layouts
mkdir -p resources/views/components
mkdir -p resources/views/dashboard/partials/student
mkdir -p resources/views/dashboard/partials/admin
mkdir -p resources/views/dashboard/partials/counselor
mkdir -p resources/views/content
mkdir -p resources/views/student/quizzes
mkdir -p resources/views/student/assessments
mkdir -p resources/views/student/counseling
mkdir -p resources/views/student/forum
mkdir -p resources/views/admin/contents
mkdir -p resources/views/admin/quizzes
mkdir -p resources/views/admin/users
mkdir -p resources/views/counselor/sessions
```

---

### Step 10: Install Additional Packages

```bash
# For image handling
composer require intervention/image

# For PDF generation (reports)
composer require barryvdh/laravel-dompdf

# For database seeding (optional)
composer require fakerphp/faker --dev
```

---

### Step 11: Create Seeders

```bash
# Create seeders for initial data
php artisan make:seeder RoleSeeder
php artisan make:seeder UserSeeder
php artisan make:seeder CategorySeeder
php artisan make:seeder ContentSeeder
php artisan make:seeder QuizSeeder

# Run seeders
php artisan db:seed
```

---

### Step 12: Configure File Storage

```bash
# Create symbolic link for public storage
php artisan storage:link

# This creates: public/storage -> storage/app/public
```

Update `.env`:
```bash
FILESYSTEM_DISK=public
```

---

### Step 13: Setup Tailwind CSS

Create `tailwind.config.js`:
```javascript
/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        primary: '#3B82F6',
        secondary: '#10B981',
        accent: '#8B5CF6',
        warning: '#F59E0B',
        danger: '#EF4444',
      },
    },
  },
  plugins: [],
}
```

Update `resources/css/app.css`:
```css
@tailwind base;
@tailwind components;
@tailwind utilities;

/* Custom styles */
@layer components {
    .btn-primary {
        @apply bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition;
    }
    
    .btn-secondary {
        @apply bg-white text-primary border border-primary px-4 py-2 rounded-lg hover:bg-primary hover:text-white transition;
    }
    
    .card {
        @apply bg-white rounded-lg shadow-md p-6;
    }
}
```

---

### Step 14: Run Development Server

```bash
# Terminal 1: Run Laravel development server
php artisan serve

# Terminal 2: Run Vite for asset compilation
npm run dev

# Your application is now available at:
# http://localhost:8000
```

---

## Development Workflow

### Phase 1: Foundation (Week 1-2)
- ✅ Setup project structure
- ✅ Configure database
- ✅ Create migrations and models
- ✅ Setup authentication
- ✅ Create basic layout and navigation

### Phase 2: Core Features (Week 3-4)
- ✅ Educational content management
- ✅ Quiz system (creation, taking, scoring)
- ✅ Self-assessment tools (AUDIT/DUDIT)
- ✅ User dashboard (all roles)

### Phase 3: Advanced Features (Week 5-6)
- ✅ Counseling session system
- ✅ Real-time chat
- ✅ Forum/community features
- ✅ Incident reporting
- ✅ Notification system

### Phase 4: Admin Features (Week 7)
- ✅ User management
- ✅ Content moderation
- ✅ Analytics and reports
- ✅ Campaign management

### Phase 5: Testing & Deployment (Week 8)
- ✅ Unit testing
- ✅ Integration testing
- ✅ User acceptance testing
- ✅ Bug fixes and optimization
- ✅ Documentation
- ✅ Deployment

---

## Testing Guide

### Setup Testing Environment
```bash
# Create testing database
CREATE DATABASE wellpath_test;

# Update phpunit.xml
<env name="DB_CONNECTION" value="mysql"/>
<env name="DB_DATABASE" value="wellpath_test"/>
```

### Run Tests
```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=QuizTest

# Generate coverage report
php artisan test --coverage
```

### Create Tests
```bash
# Create feature test
php artisan make:test QuizTest

# Create unit test
php artisan make:test QuizTest --unit
```

---

## Deployment Guide

### Prepare for Production

1. **Update .env for production**
```bash
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Use strong app key
php artisan key:generate
```

2. **Optimize application**
```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Build production assets
npm run build
```

3. **Set proper permissions**
```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

### Deployment Options

#### Option 1: Shared Hosting (cPanel)
1. Upload files via FTP
2. Import database via phpMyAdmin
3. Update .env with host credentials
4. Point domain to /public directory

#### Option 2: VPS (DigitalOcean, AWS, etc.)
```bash
# Install dependencies
sudo apt install nginx php8.2-fpm mysql-server

# Setup nginx configuration
# Clone repository
# Run composer install --no-dev
# Run migrations
# Setup supervisor for queue workers
```

#### Option 3: Platform as a Service (Laravel Forge, Ploi)
- Connect your server
- Deploy repository
- Automatic deployment on push

---

## Troubleshooting

### Common Issues

**Issue: "Specified key was too long"**
```php
// In AppServiceProvider.php
use Illuminate\Support\Facades\Schema;

public function boot()
{
    Schema::defaultStringLength(191);
}
```

**Issue: Permission denied on storage**
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

**Issue: Class not found**
```bash
composer dump-autoload
php artisan clear-compiled
```

**Issue: Mix/Vite manifest not found**
```bash
npm install
npm run build
```

---

## Security Best Practices

1. **Never commit .env file**
2. **Use CSRF protection** (Laravel default)
3. **Validate all user inputs**
4. **Hash passwords** (use bcrypt)
5. **Use prepared statements** (Eloquent default)
6. **Implement rate limiting**
7. **Keep dependencies updated**
```bash
composer update
npm update
```

---

## Maintenance Tasks

### Regular Maintenance
```bash
# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Database backup
mysqldump -u username -p wellpath_db > backup.sql

# Check logs
tail -f storage/logs/laravel.log
```

---

## Resources & Documentation

### Official Documentation
- [Laravel Documentation](https://laravel.com/docs)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [PHP Documentation](https://www.php.net/docs.php)
- [MySQL Documentation](https://dev.mysql.com/doc/)

### Helpful Tools
- [Laravel Debugbar](https://github.com/barryvdh/laravel-debugbar)
- [Laravel Telescope](https://laravel.com/docs/telescope)
- [Postman](https://www.postman.com/) - API testing
- [TablePlus](https://tableplus.com/) - Database management

### Learning Resources
- [Laracasts](https://laracasts.com/)
- [Laravel Bootcamp](https://bootcamp.laravel.com/)
- [Laravel News](https://laravel-news.com/)

---

## Project Team

- **Kyomuhangi Betty** - 23/U/10574/EVE - +256762932061
- **Nakazibwe Jacqueline** - 23/U/13646/EVE - +256762418037
- **Kayom Janet** - 23/U/09506/EVE - +256778367626
- **Kamya Martin** - 23/U/0506 - +256707738070
- **Mukubya Julius** - 23/U/11887/PS - +256786396304

**Supervisor**: [Supervisor Name]  
**Institution**: Makerere University Business School  
**Project Duration**: March 2025 - May 2025

---

## License

This project is developed for educational purposes as part of the Bachelor of Business Computing degree requirements at Makerere University Business School.

---

## Support

For issues, questions, or contributions, contact the project team members listed above.

**Last Updated**: November 2024  
**Version**: 1.0.0