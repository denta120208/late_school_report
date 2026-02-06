<x-app-layout>
    <x-slot name="header">
        <div class="late-attendance-hero -mt-6 -mx-6 px-6 py-8 mb-6 shadow-lg">
            <div class="max-w-7xl mx-auto late-attendance-hero-inner flex items-center justify-between gap-4 flex-wrap">
                <div style="flex: 1 1 520px; min-width: 260px;">
                    <h2 class="font-bold text-3xl text-white leading-tight drop-shadow-lg flex items-center">
                        <svg class="w-10 h-10 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        {{ $class->name }}
                    </h2>
                    <p class="late-attendance-hero-subtitle mt-2 text-sm">{{ $class->description }} • {{ $exitPermissions->count() }} Permohonan Izin Keluar</p>
                </div>
                <a href="{{ route('exit-permissions.index') }}" class="late-attendance-secondary-btn-nohover flex items-center justify-center" style="flex: 0 0 auto;">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 late-attendance-bg">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
            <div class="mb-6 bg-gradient-to-r from-green-500 to-emerald-500 text-white px-6 py-4 rounded-2xl shadow-xl flex items-center">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="font-bold">{{ session('success') }}</span>
            </div>
            @endif

            <div class="late-attendance-card">
                <div class="late-attendance-card-header">
                    <h3 class="text-2xl late-attendance-card-title flex items-center">
                        <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Daftar Permohonan Izin Keluar
                    </h3>
                    <p class="late-attendance-hero-subtitle mt-1">
                        @if(auth()->user()->isHomeroomTeacher())
                            Permohonan yang perlu persetujuan Anda
                        @else
                            Semua permohonan izin keluar dari kelas ini
                        @endif
                    </p>
                </div>
                
                <div class="late-attendance-card-body">
                    @if($exitPermissions->count() > 0)
                        <div class="space-y-4">
                            @foreach($exitPermissions as $permission)
                            <div class="group bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-200" style="border: 1px solid rgba(22, 11, 106, 0.12);">
                                <div class="flex items-start justify-between">
                                    <!-- Student Info -->
                                    <div class="flex items-start space-x-6 flex-1">
                                        <!-- Avatar -->
                                        <div class="rounded-2xl p-4 w-16 h-16 flex items-center justify-center shadow-lg" style="background:#160B6A;">
                                            <span class="text-2xl font-black text-white">{{ strtoupper(substr($permission->student->name, 0, 1)) }}</span>
                                        </div>
                                        
                                        <!-- Details -->
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-3 mb-2">
                                                <h4 class="text-xl font-bold text-gray-900">{{ $permission->student->name }}</h4>
                                                <span class="px-3 py-1 text-xs font-bold rounded-full" style="background: rgba(22, 11, 106, 0.08); color:#160B6A;">
                                                    {{ $permission->student->student_number }}
                                                </span>
                                            </div>
                                            
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                                                <div class="flex items-center text-sm text-gray-600">
                                                    <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                    <span class="font-semibold">{{ $permission->exit_date->format('d M Y') }}</span>
                                                    @if($permission->exit_time)
                                                        <span class="ml-2 text-orange-600">• {{ $permission->exit_time->format('H:i') }}</span>
                                                    @endif
                                                </div>
                                                
                                                <div class="flex items-center text-sm text-gray-600">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:#160B6A;">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                    </svg>
                                                    <span>Diajukan oleh: <span class="font-semibold">{{ $permission->submittedBy->name }}</span></span>
                                                </div>
                                            </div>
                                            
                                            <div class="rounded-xl p-3 mb-3" style="background: rgba(22, 11, 106, 0.04); border: 1px solid rgba(22, 11, 106, 0.12);">
                                                <p class="text-sm font-semibold mb-1 flex items-center" style="color:#160B6A;">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                                    </svg>
                                                    Alasan:
                                                </p>
                                                <p class="text-gray-900 text-sm">{{ $permission->reason }}</p>
                                            </div>
                                            
                                            <!-- Status Badges -->
                                            <div class="flex items-center space-x-2">
                                                <!-- Walas Status -->
                                                <div class="flex items-center space-x-1">
                                                    <span class="text-xs text-gray-600">Walas:</span>
                                                    @if($permission->walas_status === 'approved')
                                                        <span class="px-2 py-1 text-xs font-bold rounded-full bg-green-500 text-white">
                                                            ✓ Approved
                                                        </span>
                                                    @elseif($permission->walas_status === 'rejected')
                                                        <span class="px-2 py-1 text-xs font-bold rounded-full bg-red-500 text-white">
                                                            ✗ Rejected
                                                        </span>
                                                    @else
                                                        <span class="px-2 py-1 text-xs font-bold rounded-full bg-yellow-500 text-white">
                                                            ⏳ Pending
                                                        </span>
                                                    @endif
                                                </div>
                                                
                                                <!-- Admin Status -->
                                                <div class="flex items-center space-x-1">
                                                    <span class="text-xs text-gray-600">Admin:</span>
                                                    @if($permission->admin_status === 'approved')
                                                        <span class="px-2 py-1 text-xs font-bold rounded-full bg-green-500 text-white">
                                                            ✓ Approved
                                                        </span>
                                                    @elseif($permission->admin_status === 'rejected')
                                                        <span class="px-2 py-1 text-xs font-bold rounded-full bg-red-500 text-white">
                                                            ✗ Rejected
                                                        </span>
                                                    @else
                                                        <span class="px-2 py-1 text-xs font-bold rounded-full bg-yellow-500 text-white">
                                                            ⏳ Pending
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Action Section -->
                                    <div class="ml-4 min-w-max">
                                        <!-- View Detail Button - Always show for all users -->
                                        <a href="{{ route('exit-permissions.show', $permission->id) }}" 
                                           class="late-attendance-primary-btn flex items-center justify-center transition duration-200">
                                            @if(auth()->user()->role === 'homeroom_teacher' && $permission->walas_status === 'pending')
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Review & Approve
                                            @else
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                Lihat Detail
                                            @endif
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-20">
                            <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                            <p class="text-gray-500 text-xl font-semibold">
                                @if(auth()->user()->isHomeroomTeacher())
                                    Tidak ada permohonan izin keluar yang perlu disetujui
                                @else
                                    Tidak ada permohonan izin keluar pending di kelas ini
                                @endif
                            </p>
                            <p class="text-gray-400 mt-2">Semua permohonan sudah diproses atau belum ada pengajuan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
