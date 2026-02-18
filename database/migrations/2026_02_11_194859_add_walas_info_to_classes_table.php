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
        Schema::table('classes', function (Blueprint $table) {
            $table->string('walas_name')->nullable()->after('password'); // Nama wali kelas
            $table->string('walas_whatsapp')->nullable()->after('walas_name'); // Nomor WA wali kelas
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('classes', function (Blueprint $table) {
            $table->dropColumn(['walas_name', 'walas_whatsapp']);
        });
    }
};
