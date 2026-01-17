<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function show($id)
    {
        $student = \App\Models\Student::with(['schoolClass', 'lateAttendances' => function($query) {
            $query->with(['lateReason', 'recordedBy'])->orderBy('late_date', 'desc');
        }])->findOrFail($id);
        
        // Check if homeroom teacher is accessing their class student only
        if (auth()->user()->isHomeroomTeacher() && auth()->user()->assigned_class_id != $student->class_id) {
            abort(403, 'You can only access students from your assigned class.');
        }
        
        $totalLateCount = $student->getTotalLateCount();
        $lateStatus = $student->getLateStatus();
        
        return view('students.show', compact('student', 'totalLateCount', 'lateStatus'));
    }
}
