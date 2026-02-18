<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify the role enum to add 'walas'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'teacher', 'homeroom_teacher', 'walas') NOT NULL DEFAULT 'teacher'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove 'walas' from enum
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'teacher', 'homeroom_teacher') NOT NULL DEFAULT 'teacher'");
    }
};
