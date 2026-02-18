<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolClass;
use App\Models\ExitPermission;

class WalasController extends Controller
{
    /**
     * Display the Walas dashboard with feature cards
     */
    public function dashboard()
    {
        // Simple dashboard with feature cards for Kelola Data Siswa and Izin Keluar
        return view('walas.dashboard');
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
            return back()->withErrors(['password' => 'Password kelas salah! Silakan periksa kembali password yang Anda masukkan.'])->withInput();
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
