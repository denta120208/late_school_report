<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\LateAttendanceController;
use App\Http\Controllers\Admin\ClassManagementController;
use App\Http\Controllers\Admin\StudentManagementController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\LateReasonManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Classes (All authenticated users)
    Route::get('/classes', [ClassController::class, 'index'])->name('classes.index');
    Route::get('/classes/{id}', [ClassController::class, 'show'])->name('classes.show');
    
    // Students
    Route::get('/students/{id}', [StudentController::class, 'show'])->name('students.show');
    
    // Late Attendance
    Route::get('/late-attendance', [LateAttendanceController::class, 'index'])->name('late-attendance.index');
    Route::get('/late-attendance/create/{studentId}', [LateAttendanceController::class, 'create'])->name('late-attendance.create');
    Route::post('/late-attendance', [LateAttendanceController::class, 'store'])->name('late-attendance.store');
    
    // Admin and Teacher can update status
    Route::middleware(['role:admin,teacher'])->group(function () {
        Route::patch('/late-attendance/{id}/status', [LateAttendanceController::class, 'updateStatus'])->name('late-attendance.update-status');
    });
    
    // Telegram Notification Routes
    Route::get('/telegram/review', [App\Http\Controllers\TelegramNotificationController::class, 'review'])->name('telegram.review');
    Route::post('/telegram/send', [App\Http\Controllers\TelegramNotificationController::class, 'send'])->name('telegram.send');
    Route::post('/telegram/reset', [App\Http\Controllers\TelegramNotificationController::class, 'reset'])->name('telegram.reset');
    Route::get('/telegram/test', [App\Http\Controllers\TelegramNotificationController::class, 'test'])->name('telegram.test');
    
    // Admin only routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        // Class Management
        Route::resource('classes', ClassManagementController::class);
        
        // Student Management
        Route::resource('students', StudentManagementController::class);
        
        // User Management
        Route::resource('users', UserManagementController::class);
        
        // Late Reason Management
        Route::resource('late-reasons', LateReasonManagementController::class);
    });
});

require __DIR__.'/auth.php';
