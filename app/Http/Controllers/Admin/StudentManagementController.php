<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentManagementController extends Controller
{
    public function index()
    {
        $students = \App\Models\Student::with('schoolClass')->paginate(20);
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        $classes = \App\Models\SchoolClass::active()->get();
        return view('admin.students.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'student_number' => 'required|string|unique:students,student_number',
            'class_id' => 'required|exists:classes,id',
            'gender' => 'nullable|string',
            'phone' => 'nullable|string',
            'parent_phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        \App\Models\Student::create($validated);
        return redirect()->route('admin.students.index')->with('success', 'Student created successfully.');
    }

    public function edit($id)
    {
        $student = \App\Models\Student::findOrFail($id);
        $classes = \App\Models\SchoolClass::active()->get();
        return view('admin.students.edit', compact('student', 'classes'));
    }

    public function update(Request $request, $id)
    {
        $student = \App\Models\Student::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'student_number' => 'required|string|unique:students,student_number,' . $id,
            'class_id' => 'required|exists:classes,id',
            'gender' => 'nullable|string',
            'phone' => 'nullable|string',
            'parent_phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $student->update($validated);
        return redirect()->route('admin.students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy($id)
    {
        $student = \App\Models\Student::findOrFail($id);
        $student->delete();
        return redirect()->route('admin.students.index')->with('success', 'Student deleted successfully.');
    }
}
