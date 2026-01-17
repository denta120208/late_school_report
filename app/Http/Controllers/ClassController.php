<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isHomeroomTeacher()) {
            // Homeroom teacher sees only their assigned class
            $classes = \App\Models\SchoolClass::where('id', $user->assigned_class_id)
                ->active()
                ->get();
        } else {
            // Admin and teachers see all classes
            $classes = \App\Models\SchoolClass::active()->get();
        }
        
        return view('classes.index', compact('classes'));
    }
    
    public function show($id)
    {
        $class = \App\Models\SchoolClass::with(['students' => function($query) {
            $query->active()->orderBy('name');
        }])->findOrFail($id);
        
        // Check if homeroom teacher is accessing their own class only
        if (auth()->user()->isHomeroomTeacher() && auth()->user()->assigned_class_id != $id) {
            abort(403, 'You can only access your assigned class.');
        }
        
        return view('classes.show', compact('class'));
    }
}
