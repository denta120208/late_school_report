<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teacher_absences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recorded_by')->constrained('users')->onDelete('cascade');
            $table->date('absence_date');
            $table->string('teacher_name');
            $table->string('reason')->nullable();
            $table->timestamps();

            $table->index(['absence_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_absences');
    }
};
