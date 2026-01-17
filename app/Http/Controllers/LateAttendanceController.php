<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LateAttendanceController extends Controller
{
    public function create($studentId)
    {
        $student = \App\Models\Student::with('schoolClass')->findOrFail($studentId);
        
        // Check if homeroom teacher is accessing their class student only
        if (auth()->user()->isHomeroomTeacher() && auth()->user()->assigned_class_id != $student->class_id) {
            abort(403, 'You can only record attendance for students from your assigned class.');
        }
        
        $lateReasons = \App\Models\LateReason::active()->get();
        
        return view('late-attendance.create', compact('student', 'lateReasons'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'class_id' => 'required|exists:classes,id',
            'late_reason_id' => 'required|exists:late_reasons,id',
            'late_date' => 'required|date',
            'arrival_time' => 'required',
            'notes' => 'nullable|string',
        ]);
        
        $validated['recorded_by'] = auth()->id();
        $validated['status'] = 'pending';
        
        \App\Models\LateAttendance::create($validated);
        
        return redirect()->route('classes.show', $validated['class_id'])
            ->with('success', 'Late attendance recorded successfully.');
    }
    
    public function index(Request $request)
    {
        $query = \App\Models\LateAttendance::with(['student', 'schoolClass', 'lateReason', 'recordedBy']);
        
        // Filter by role
        if (auth()->user()->isHomeroomTeacher()) {
            $query->where('class_id', auth()->user()->assigned_class_id);
        }
        
        // Apply filters
        if ($request->filled('search')) {
            $query->whereHas('student', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }
        
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }
        
        if ($request->filled('date')) {
            $query->whereDate('late_date', $request->date);
        }
        
        if ($request->filled('month') && $request->filled('year')) {
            $query->whereMonth('late_date', $request->month)
                  ->whereYear('late_date', $request->year);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $lateAttendances = $query->orderBy('late_date', 'desc')->paginate(20);
        
        $classes = auth()->user()->isHomeroomTeacher() 
            ? \App\Models\SchoolClass::where('id', auth()->user()->assigned_class_id)->get()
            : \App\Models\SchoolClass::active()->get();
        
        return view('late-attendance.index', compact('lateAttendances', 'classes'));
    }
    
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);
        
        $attendance = \App\Models\LateAttendance::findOrFail($id);
        $attendance->update($validated);
        
        return back()->with('success', 'Status updated successfully.');
    }
}
