<x-app-layout>
    <x-slot name="header">
        <div class="late-attendance-hero -mt-6 -mx-6 px-6 py-8 mb-6 shadow-lg">
            <div class="max-w-7xl mx-auto late-attendance-hero-inner flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="text-left">
                    <h2 class="font-bold text-3xl md:text-4xl text-white leading-tight">
                        Student Late History - {{ $student->name }}
                    </h2>
                    <p class="late-attendance-hero-subtitle mt-2 text-sm md:text-base">
                        Pantau riwayat keterlambatan dan perizinan siswa
                    </p>
                </div>
                <a href="{{ route('classes.show', $student->class_id) }}" class="flex items-center" style="background:#ffffff; border:1px solid rgba(255,255,255,0.65); color:#160B6A; border-radius:12px; padding:12px 18px; font-weight:800;">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Class
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 min-h-screen late-attendance-bg">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Student Info Card -->
            <div class="late-attendance-card mb-6">
                <div class="late-attendance-card-body">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Student Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Student Number</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $student->student_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Class</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $student->schoolClass->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Gender</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $student->gender }}</p>
                        </div>
                        @if($student->phone)
                        <div>
                            <p class="text-sm text-gray-500">Phone</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $student->phone }}</p>
                        </div>
                        @endif
                        @if($student->parent_phone)
                        <div>
                            <p class="text-sm text-gray-500">Parent Phone</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $student->parent_phone }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Late Status Card -->
            <div class="late-attendance-card mb-6">
                <div class="late-attendance-card-body">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Late Attendance Status</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 border border-gray-200 rounded-lg" style="border-color: rgba(22, 11, 106, 0.14);">
                            <p class="text-sm text-gray-500">Total Late Arrivals</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $totalLateCount }}</p>
                        </div>
                        <div class="p-4 border border-gray-200 rounded-lg" style="border-color: rgba(22, 11, 106, 0.14);">
                            <p class="text-sm text-gray-500">Status</p>
                            <p class="text-2xl font-bold">
                                @if($lateStatus == 'parent_notification')
                                    <span class="text-red-600">⚠ Parent Notification Required</span>
                                @elseif($lateStatus == 'warning')
                                    <span class="text-yellow-600">⚠ Warning</span>
                                @else
                                    <span class="text-green-600">✓ Normal</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    @if($lateStatus == 'parent_notification')
                    <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-sm text-red-800">
                            <strong>Action Required:</strong> This student has been late 5 or more times. Parent notification is recommended.
                        </p>
                    </div>
                    @elseif($lateStatus == 'warning')
                    <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <p class="text-sm text-yellow-800">
                            <strong>Warning:</strong> This student has been late 3 or more times. Close monitoring is advised.
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Exit Permissions Card -->
            <div class="late-attendance-card mb-6">
                <div class="late-attendance-card-body">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Exit Permissions</h3>
                        <a href="{{ route('exit-permissions.create') }}" class="late-attendance-link text-sm font-medium">
                            + Request Exit Permission
                        </a>
                    </div>
                    
                    @if($student->exitPermissions->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="late-attendance-table">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 text-left">Exit Date</th>
                                        <th class="px-6 py-3 text-left">Reason</th>
                                        <th class="px-6 py-3 text-left">Status</th>
                                        <th class="px-6 py-3 text-left">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($student->exitPermissions->sortByDesc('exit_date')->take(5) as $permission)
                                    <tr class="late-attendance-table-row">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $permission->exit_date->format('d M Y') }}
                                            @if($permission->exit_time)
                                                <br><span class="text-xs text-gray-500">{{ $permission->exit_time->format('H:i') }}</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($permission->reason, 40) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($permission->status === 'approved')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    ✓ Approved
                                                </span>
                                            @elseif($permission->status === 'rejected')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    ✗ Rejected
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    ⏳ Pending
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('exit-permissions.show', $permission->id) }}" class="late-attendance-link">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($student->exitPermissions->count() > 5)
                            <div class="mt-4 text-center">
                                <a href="{{ route('exit-permissions.index') }}?search={{ $student->name }}" class="late-attendance-link text-sm">
                                    View all exit permissions →
                                </a>
                            </div>
                        @endif
                    @else
                        <p class="text-gray-500 text-sm">No exit permission requests found.</p>
                    @endif
                </div>
            </div>

            <!-- Late History Table -->
            <div class="late-attendance-card">
                <div class="late-attendance-card-body">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Complete Late History</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="late-attendance-table">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left">Date</th>
                                    <th class="px-6 py-3 text-left">Arrival Time</th>
                                    <th class="px-6 py-3 text-left">Reason</th>
                                    <th class="px-6 py-3 text-left">Notes</th>
                                    <th class="px-6 py-3 text-left">Recorded By</th>
                                    <th class="px-6 py-3 text-left">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($student->lateAttendances as $attendance)
                                <tr class="late-attendance-table-row">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $attendance->late_date->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ date('H:i', strtotime($attendance->arrival_time)) }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $attendance->lateReason->reason }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $attendance->notes ?: '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $attendance->recordedBy->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($attendance->status == 'pending')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                        @elseif($attendance->status == 'approved')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Approved
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Rejected
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">No late attendance records found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
