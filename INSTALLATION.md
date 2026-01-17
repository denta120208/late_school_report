# School Late Attendance Management System - Installation Guide

## Overview
A Laravel-based web application to digitally record and manage students who arrive late at school, replacing the manual paper-based system.

## Requirements
- PHP 8.2 or higher
- Composer
- MySQL database
- Node.js and NPM

## Installation Steps

### 1. Clone and Setup
```bash
# If not already done, navigate to your project directory
cd /path/to/project

# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 2. Environment Configuration
```bash
# Copy the environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 3. Database Configuration
Edit your `.env` file and configure your database:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=telat
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 4. Run Migrations and Seeders
```bash
# Run migrations and seed the database
php artisan migrate:fresh --seed
```

This will create:
- **Admin User**: admin@school.com (password: password)
- **Teacher User**: teacher@school.com (password: password)
- **Homeroom Teacher (PPLG)**: homeroom.pplg@school.com (password: password)
- **Homeroom Teacher (DKV)**: homeroom.dkv@school.com (password: password)
- 6 Classes (Grade 10-12 for PPLG and DKV)
- 17 Sample Students
- 5 Late Reasons

### 5. Build Frontend Assets
```bash
# Build assets for production
npm run build

# OR for development with hot reload
npm run dev
```

### 6. Start the Application
```bash
# Start the development server
php artisan serve
```

Visit: http://localhost:8000

## Default Login Credentials

### Admin Account
- **Email**: admin@school.com
- **Password**: password
- **Permissions**: Full access to all features including admin panel

### Teacher Account
- **Email**: teacher@school.com
- **Password**: password
- **Permissions**: Can record late attendance for all classes, view all reports

### Homeroom Teacher (PPLG)
- **Email**: homeroom.pplg@school.com
- **Password**: password
- **Permissions**: Can only view and manage Grade 10 PPLG class

### Homeroom Teacher (DKV)
- **Email**: homeroom.dkv@school.com
- **Password**: password
- **Permissions**: Can only view and manage Grade 10 DKV class

## Features Overview

### 1. Dashboard
- View today's late count
- View monthly statistics
- See top 5 students with most late arrivals
- See classes with highest lateness frequency
- Quick action buttons

### 2. Record Late Attendance
- **Step 1**: Select a class from the list
- **Step 2**: View all students in the class
- **Step 3**: Click "Record Late" for a student
- **Step 4**: Fill in the late attendance form:
  - Date (auto-filled to today)
  - Arrival time (auto-filled to current time)
  - Late reason (dropdown)
  - Additional notes (optional)
- **Step 5**: Submit the form

### 3. Reports & Monitoring
- View all late attendance records
- Filter by:
  - Student name (search)
  - Class
  - Date
  - Month/Year
  - Status (Pending/Approved/Rejected)
- Pagination for large datasets

### 4. Student Late History
- View individual student details
- See total late count
- Status indicators:
  - **Normal**: Less than 3 late arrivals
  - **Warning**: 3-4 late arrivals (yellow indicator)
  - **Parent Notification**: 5+ late arrivals (red indicator)
- Complete history of all late records

### 5. Admin Panel (Admin Only)
- **Manage Students**: Create, edit, delete students
- **Manage Classes**: Create, edit, delete classes
- **Manage Users**: Create, edit, delete users with roles
- **Manage Late Reasons**: Create, edit, delete late reasons

## User Roles & Permissions

### Admin
- Manage all classes, students, users, and late reasons
- View all reports across all classes
- Approve/reject late attendance records
- Full system access

### Teacher / Duty Officer
- Record late attendance for any class
- View reports for all classes
- Approve/reject late attendance records
- Cannot access admin panel

### Homeroom Teacher
- Record late attendance only for their assigned class
- View reports only for their assigned class
- View student histories only from their class
- Cannot access admin panel

## System Architecture

### Database Tables
1. **users** - User accounts with roles
2. **classes** - School classes (Grade 10-12, PPLG/DKV)
3. **students** - Student records
4. **late_reasons** - Configurable late reasons
5. **late_attendances** - Late attendance records with relationships

### Key Features
- Role-based access control (RBAC)
- Automatic date/time filling
- Status management (Pending/Approved/Rejected)
- Warning system (3+ = warning, 5+ = parent notification)
- Clean, mobile-friendly UI with Tailwind CSS
- Proper validation and error handling

## Technology Stack
- **Backend**: Laravel 11
- **Frontend**: Blade Templates
- **Styling**: Tailwind CSS
- **Authentication**: Laravel Breeze
- **Database**: MySQL

## Troubleshooting

### Issue: Routes not found
```bash
php artisan route:clear
php artisan config:clear
php artisan cache:clear
```

### Issue: CSS not loading
```bash
npm run build
# OR
npm run dev
```

### Issue: Database connection error
- Check your `.env` file database credentials
- Make sure MySQL is running
- Verify database name exists

### Issue: Permission denied errors
```bash
# On Linux/Mac
chmod -R 775 storage bootstrap/cache
```

## Support & Documentation
For more information about Laravel, visit: https://laravel.com/docs

## License
This project is open-sourced software licensed under the MIT license.
