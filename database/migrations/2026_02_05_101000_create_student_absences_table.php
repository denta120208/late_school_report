<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_absences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->foreignId('recorded_by')->constrained('users')->onDelete('cascade');
            $table->date('absence_date');
            $table->enum('status', ['S', 'I', 'A']);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'absence_date']);
            $table->index(['class_id', 'absence_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_absences');
    }
};
