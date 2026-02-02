<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolClass;
use App\Models\ExitPermission;

class WalasController extends Controller
{
    /**
     * Display the Walas dashboard with all classes that have pending requests
     */
    public function dashboard()
    {
        // For shared Walas account, show ALL classes that have pending exit permission requests
        // regardless of assigned_class_id since it's a shared account
        $classesWithRequests = SchoolClass::whereHas('exitPermissions', function ($query) {
            $query->where('walas_status', 'pending');
        })->withCount(['exitPermissions' => function ($query) {
            $query->where('walas_status', 'pending');
        }])->with(['exitPermissions' => function ($query) {
            $query->where('walas_status', 'pending')->latest()->take(3);
        }])->get();

        return view('walas.dashboard', compact('classesWithRequests'));
    }

    /**
     * Verify class password and show exit permission requests
     */
    public function verifyPasswordAndShowRequests(Request $request, SchoolClass $class)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        // Check if the provided password matches the class password
        if ($request->password !== $class->password) {
            return back()->withErrors(['password' => 'Invalid class password.']);
        }

        // Get all pending exit permission requests for this class
        $exitPermissions = ExitPermission::where('class_id', $class->id)
            ->where('walas_status', 'pending')
            ->with(['student', 'submittedBy'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('exit-permissions.class-show', compact('class', 'exitPermissions'));
    }

    /**
     * Show password form for class access
     */
    public function showPasswordForm(SchoolClass $class)
    {
        return view('walas.verify-password', compact('class'));
    }
}
