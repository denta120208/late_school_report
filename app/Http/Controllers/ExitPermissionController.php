<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ExitPermission;
use App\Models\Student;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Services\WhatsAppService;

class ExitPermissionController extends Controller
{
    // Display all exit permissions (with filters)
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // For shared Walas account (homeroom_teacher or walas without assigned_class_id), show class selection interface
        if (in_array($user->role, ['homeroom_teacher', 'walas']) && !$user->assigned_class_id) {
            return $this->showWalasClassSelection();
        }
        
        $query = ExitPermission::with(['student', 'schoolClass', 'submittedBy', 'walasApprovedBy', 'adminApprovedBy']);

        // Role-based filtering - Skip for shared Walas account
        if (in_array($user->role, ['homeroom_teacher', 'walas']) && $user->assigned_class_id) {
            $query->where('class_id', $user->assigned_class_id);
        }

        // Apply filters
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('exit_date', $request->date);
        }

        if ($request->filled('search')) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $exitPermissions = $query->latest()->paginate(15);
        $classes = SchoolClass::all();

        // Load classes with pending exit permissions count
        if (in_array($user->role, ['homeroom_teacher', 'walas']) && $user->assigned_class_id) {
            $classesWithCount = SchoolClass::where('id', $user->assigned_class_id)->get();
        } else {
            $classesWithCount = SchoolClass::active()->get();
        }
        
        // Load pending exit permissions count for each class
        $classesWithCount->load(['exitPermissions' => function($query) use ($user) {
            // For homeroom teacher or walas, show pending walas approvals
            if (in_array($user->role, ['homeroom_teacher', 'walas'])) {
                $query->where('walas_status', 'pending');
            } else {
                // For admin/teacher, show all pending
                $query->where('status', 'pending');
            }
        }]);

        return view('exit-permissions.index', compact('exitPermissions', 'classes', 'classesWithCount'));
    }
    
    /**
     * Show class selection interface for shared Walas account
     */
    private function showWalasClassSelection()
    {
        // Get ALL classes, not just those with pending requests
        $classesWithRequests = SchoolClass::active()->withCount(['exitPermissions' => function ($query) {
            $query->where('walas_status', 'pending');
        }])->get();

        return view('exit-permissions.walas-class-selection', compact('classesWithRequests'));
    }

    // Show form to create new exit permission
    public function create()
    {
        $user = Auth::user();
        
        if (in_array($user->role, ['homeroom_teacher', 'walas']) && $user->assigned_class_id) {
            $classes = SchoolClass::where('id', $user->assigned_class_id)->get();
            $students = Student::where('class_id', $user->assigned_class_id)->active()->get();
        } else {
            $classes = SchoolClass::all();
            $students = Student::active()->get();
        }

        return view('exit-permissions.create', compact('classes', 'students'));
    }

    // Store new exit permission
    public function store(Request $request)
    {
        // Base validation rules
        $rules = [
            'student_id' => 'required|exists:students,id',
            'permission_type' => 'required|in:sick,leave_early,permission_out',
            'exit_date' => 'required|date',
            'exit_time' => 'nullable|date_format:H:i',
            'time_out' => 'required|date_format:H:i',
            'reason' => 'required|string|max:1000',
            'additional_notes' => 'nullable|string|max:1000',
        ];

        // Conditional validation for time_in based on permission_type
        if ($request->permission_type === 'permission_out') {
            $rules['time_in'] = 'required|date_format:H:i|after:time_out';
        } else {
            $rules['time_in'] = 'nullable|date_format:H:i|after:time_out';
        }

        $validated = $request->validate($rules);

        $student = Student::findOrFail($validated['student_id']);

        $exitPermission = ExitPermission::create([
            'student_id' => $validated['student_id'],
            'class_id' => $student->class_id,
            'submitted_by' => Auth::id(),
            'permission_type' => $validated['permission_type'],
            'exit_date' => $validated['exit_date'],
            'exit_time' => $validated['exit_time'] ?? null,
            'time_out' => $validated['time_out'],
            'time_in' => $validated['time_in'] ?? null,
            'reason' => $validated['reason'],
            'additional_notes' => $validated['additional_notes'] ?? null,
        ]);

        // Kirim notifikasi WhatsApp ke wali kelas
        try {
            $whatsappService = new WhatsAppService();
            $whatsappSent = $whatsappService->sendExitPermissionNotificationToWalas($exitPermission);
            
            if ($whatsappSent) {
                return redirect()->route('exit-permissions.index')
                    ->with('success', 'Izin keluar berhasil diajukan dan notifikasi WhatsApp telah dikirim ke wali kelas!');
            } else {
                return redirect()->route('exit-permissions.index')
                    ->with('success', 'Izin keluar berhasil diajukan! (Notifikasi WhatsApp gagal dikirim, silakan hubungi wali kelas secara manual)');
            }
        } catch (\Exception $e) {
            \Log::error('Error sending WhatsApp notification: ' . $e->getMessage());
            return redirect()->route('exit-permissions.index')
                ->with('success', 'Izin keluar berhasil diajukan! (Notifikasi WhatsApp gagal dikirim)');
        }
    }

    // Show single exit permission details
    public function show(ExitPermission $exitPermission)
    {
        $user = Auth::user();

        // Check if homeroom teacher/walas can only see their class (skip for shared Walas)
        if (in_array($user->role, ['homeroom_teacher', 'walas']) && $user->assigned_class_id && $exitPermission->class_id !== $user->assigned_class_id) {
            abort(403, 'Unauthorized access');
        }
        
        // For shared Walas account, allow access since they should come from verified class context

        $exitPermission->load(['student', 'schoolClass', 'submittedBy', 'walasApprovedBy', 'adminApprovedBy']);

        return view('exit-permissions.show', compact('exitPermission'));
    }

    // Walas approval/rejection
    public function walasApprove(Request $request, ExitPermission $exitPermission)
    {
        $user = Auth::user();

        // Check if user is homeroom teacher or walas
        if (!in_array($user->role, ['homeroom_teacher', 'walas'])) {
            abort(403, 'Unauthorized access');
        }

        // For shared Walas account, verify access is from the class requests page
        // (This method should only be called from within the class context)

        $validated = $request->validate([
            'action' => 'required|in:approve,reject',
            'walas_notes' => 'nullable|string|max:500',
        ]);

        $exitPermission->update([
            'walas_status' => $validated['action'] === 'approve' ? 'approved' : 'rejected',
            'walas_approved_by' => $user->id,
            'walas_approved_at' => now(),
            'walas_notes' => $validated['walas_notes'] ?? null,
        ]);

        $exitPermission->updateOverallStatus();

        return redirect()->back()->with('success', 'Exit permission ' . $validated['action'] . 'd successfully!');
    }

    // Admin approval/rejection
    public function adminApprove(Request $request, ExitPermission $exitPermission)
    {
        $user = Auth::user();

        // Check if user is admin or teacher
        if (!in_array($user->role, ['admin', 'teacher'])) {
            abort(403, 'Unauthorized access');
        }

        // Enforce sequential approval: Admin can only approve after Homeroom Teacher approval
        if ($exitPermission->walas_status !== 'approved') {
            return redirect()->back()->with('error', 'Admin approval can only be processed after Homeroom Teacher approval!');
        }

        $validated = $request->validate([
            'action' => 'required|in:approve,reject',
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $exitPermission->update([
            'admin_status' => $validated['action'] === 'approve' ? 'approved' : 'rejected',
            'admin_approved_by' => $user->id,
            'admin_approved_at' => now(),
            'admin_notes' => $validated['admin_notes'] ?? null,
        ]);

        $exitPermission->updateOverallStatus();

        return redirect()->back()->with('success', 'Exit permission ' . $validated['action'] . 'd successfully!');
    }

    // Get students by class (AJAX)
    public function getStudentsByClass(Request $request)
    {
        $students = Student::where('class_id', $request->class_id)
            ->active()
            ->orderBy('name')
            ->get(['id', 'name', 'student_number']);

        return response()->json($students);
    }

    // Show list of classes with pending exit permissions count
    public function classList()
    {
        $user = Auth::user();
        
        // Get classes based on role
        if (in_array($user->role, ['homeroom_teacher', 'walas']) && $user->assigned_class_id) {
            $classes = SchoolClass::where('id', $user->assigned_class_id)->get();
        } else {
            $classes = SchoolClass::active()->get();
        }
        
        // Load pending exit permissions count for each class
        $classes->load(['exitPermissions' => function($query) use ($user) {
            // For homeroom teacher or walas, show pending walas approvals
            if (in_array($user->role, ['homeroom_teacher', 'walas'])) {
                $query->where('walas_status', 'pending');
            } else {
                // For admin/teacher, show all pending
                $query->where('status', 'pending');
            }
        }]);
        
        return view('exit-permissions.classes', compact('classes'));
    }

    // Show exit permissions for specific class
    public function showClassExitPermissions($classId)
    {
        $user = Auth::user();
        $class = SchoolClass::findOrFail($classId);
        
        // Check authorization for homeroom teacher/walas (skip for shared Walas)
        if (in_array($user->role, ['homeroom_teacher', 'walas']) && $user->assigned_class_id && $class->id !== $user->assigned_class_id) {
            abort(403, 'You can only access exit permissions for your assigned class.');
        }
        
        // For shared Walas account, allow access since they should come from verified password context
        
        // Get exit permissions for this class
        $query = ExitPermission::where('class_id', $class->id)
            ->with(['student', 'submittedBy', 'walasApprovedBy', 'adminApprovedBy']);
        
        // Filter based on role
        if (in_array($user->role, ['homeroom_teacher', 'walas'])) {
            // Show pending walas approvals for homeroom teacher or walas
            $query->where('walas_status', 'pending');
        }
        
        $exitPermissions = $query->latest()->get();
        
        return view('exit-permissions.class-show', compact('class', 'exitPermissions'));
    }
}
