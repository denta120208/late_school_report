<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestExitPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample exit permission requests for testing
        $classes = \App\Models\SchoolClass::all();
        $students = \App\Models\Student::all();
        $submittedBy = \App\Models\User::where('role', 'teacher')->first();

        if ($classes->count() > 0 && $students->count() > 0 && $submittedBy) {
            foreach ($classes->take(3) as $class) {
                $classStudents = $students->where('class_id', $class->id);
                
                if ($classStudents->count() > 0) {
                    \App\Models\ExitPermission::create([
                        'student_id' => $classStudents->first()->id,
                        'class_id' => $class->id,
                        'submitted_by' => $submittedBy->id,
                        'permission_type' => 'sick',
                        'exit_date' => now()->format('Y-m-d'),
                        'time_out' => '10:30',
                        'time_in' => null,
                        'reason' => 'Sakit demam tinggi, perlu istirahat di rumah',
                        'additional_notes' => 'Mohon izin untuk pulang lebih awal',
                        'walas_status' => 'pending',
                        'admin_status' => 'pending',
                        'status' => 'pending',
                    ]);
                }
            }
        }
    }
}
