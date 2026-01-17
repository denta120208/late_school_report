<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClassManagementController extends Controller
{
    public function index()
    {
        $classes = \App\Models\SchoolClass::withCount('students')->paginate(20);
        return view('admin.classes.index', compact('classes'));
    }

    public function create()
    {
        return view('admin.classes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'grade' => 'required|string',
            'major' => 'required|string',
            'description' => 'nullable|string',
        ]);

        \App\Models\SchoolClass::create($validated);
        return redirect()->route('admin.classes.index')->with('success', 'Class created successfully.');
    }

    public function edit($id)
    {
        $class = \App\Models\SchoolClass::findOrFail($id);
        return view('admin.classes.edit', compact('class'));
    }

    public function update(Request $request, $id)
    {
        $class = \App\Models\SchoolClass::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'grade' => 'required|string',
            'major' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $class->update($validated);
        return redirect()->route('admin.classes.index')->with('success', 'Class updated successfully.');
    }

    public function destroy($id)
    {
        $class = \App\Models\SchoolClass::findOrFail($id);
        $class->delete();
        return redirect()->route('admin.classes.index')->with('success', 'Class deleted successfully.');
    }
}
