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
            $table->enum('permission_type', ['sick', 'leave_early'])->after('submitted_by');
            $table->time('time_out')->after('exit_time');
            $table->time('time_in')->nullable()->after('time_out');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exit_permissions', function (Blueprint $table) {
            $table->dropColumn(['permission_type', 'time_out', 'time_in']);
        });
    }
};
