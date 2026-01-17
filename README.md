# 🎯 School Late Attendance Management System

A complete Laravel-based web application to digitally record and manage students who arrive late at school, replacing the manual paper-based system used by teachers.

## ✅ Project Status: **COMPLETED**

This system is fully implemented with all features from the requirements below.

## 🚀 Quick Start

See [INSTALLATION.md](INSTALLATION.md) for complete setup instructions.

```bash
# Install dependencies
composer install
npm install

# Setup database
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed

# Build and run
npm run build
php artisan serve
```

**Default Admin Login:**
- Email: admin@school.com
- Password: password

---

## 📋 Original Requirements

Build a Laravel-based web application to digitally record and manage students who arrive late at school, replacing the current manual paper-based system used by teachers.

The system should be simple, fast, user-friendly, and suitable for daily use by school staff.

🧩 Core Features Prompt
1️⃣ Authentication & User Roles

Create an authentication system with role-based access control.

Roles:

Admin

Manage classes

Manage students

Manage teachers/users

Manage late reasons

Teacher / Duty Officer

Record student lateness

Homeroom Teacher

View lateness reports for their assigned class only

2️⃣ Class Selection Page

Create a page that displays a list of available classes, for example:

Grade 10 PPLG

Grade 11 PPLG

Grade 12 PPLG

Grade 10 DKV

Grade 11 DKV

Grade 12 DKV

Teachers can click a class to view the list of students in that class.

3️⃣ Student List & Selection

On the selected class page:

Display all students belonging to the class

Each student should have a checkbox

Allow teachers to select one student at a time

Provide a “Continue / Submit” button to proceed

4️⃣ Late Attendance Input Form

After selecting a student, show a form with the following fields:

Student Name (auto-filled, read-only)

Class Name (auto-filled)

Late Reason (dropdown)

Arrival Time (time picker)

Date of Late Arrival (date picker, default: today)

Additional Notes (optional)

Submit button

Late Reason Options:

Woke up late

Transportation issue

Heavy rain

Discipline issue

Other

5️⃣ Data Storage & Relationships

Design database tables with the following relationships:

One class has many students

One student can have many late attendance records

Late attendance records store:

student_id

class_id

reason_id

arrival_time

late_date

notes

status

📊 Reporting & Monitoring Features
6️⃣ Late Attendance Recap Page

Create a table view showing:

Student Name

Class

Date

Arrival Time

Late Reason

Status

Include features:

Search by student name

Filter by class

Filter by date/month

7️⃣ Student Late History Page

Create a detailed student profile page displaying:

Total number of late arrivals

Complete lateness history

Status indicators:

Warning after 3 late arrivals

Parent notification after 5 late arrivals

📈 Statistics & Insights
8️⃣ Dashboard Statistics

Display simple analytics:

Top 5 students with the most late arrivals

Classes with the highest lateness frequency

Monthly late attendance summary

🧾 Export & Documentation
9️⃣ PDF Export Feature

Allow users to:

Export lateness reports per class

Export lateness reports per student

Download reports as PDF files for school documentation

⚙️ System Configuration
🔟 Late Reason Management

Allow Admin users to:

Add new late reasons

Edit existing reasons

Delete unused reasons

1️⃣1️⃣ Late Attendance Status Management

Each lateness record should have a status:

Pending

Approved

Rejected

Admins or authorized staff can update the status.

🧠 Smart Features (Optional)
1️⃣2️⃣ Automatic Date & Time

Automatically fill current date and time

Allow manual editing if needed

1️⃣3️⃣ QR Code Class Access (Optional)

Generate a QR code for each class

Scanning the QR code opens the student list of that class

🛠️ Technology Stack

Backend: Laravel (latest version)

Database: MySQL

Frontend: Blade Templates

Styling: Tailwind CSS or Bootstrap

Authentication: Laravel built-in auth system

🎯 Design Principles

Simple and clean UI

Optimized for fast daily input

Mobile-friendly layout

Clear validation messages

📌 Final Notes

The application should follow Laravel MVC architecture, use proper validation, and ensure data security and role-based access.