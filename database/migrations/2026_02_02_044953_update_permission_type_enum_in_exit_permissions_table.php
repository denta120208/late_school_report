<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('exit_permissions', function (Blueprint $table) {
            $table->dropColumn('permission_type');
        });
        
        Schema::table('exit_permissions', function (Blueprint $table) {
            $table->enum('permission_type', ['sick', 'leave_early', 'permission_out'])->after('submitted_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exit_permissions', function (Blueprint $table) {
            $table->dropColumn('permission_type');
        });
        
        Schema::table('exit_permissions', function (Blueprint $table) {
            $table->enum('permission_type', ['sick', 'leave_early'])->after('submitted_by');
        });
    }
};
