<x-app-layout>
    <x-slot name="header">
        <div class="exit-permissions-card-header exit-permissions-page-hero -mt-6 -mx-6 px-6 py-8 mb-6 shadow-md">
            <div class="max-w-7xl mx-auto flex justify-between items-center exit-permissions-page-hero-inner">
                <div>
                    <h2 class="font-bold text-3xl md:text-4xl text-white leading-tight flex items-center exit-permissions-page-title">
                        <svg class="w-10 h-10 md:w-12 md:h-12 mr-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Detail Izin Keluar
                    </h2>
                    <p class="exit-permissions-subtitle mt-1 text-sm md:text-base">Informasi lengkap permohonan izin keluar siswa</p>
                </div>
                <a href="{{ route('exit-permissions.index') }}" class="exit-permissions-header-btn font-semibold py-3 px-6 md:px-8 bg-white bg-opacity-20 hover:bg-opacity-30 border border-white border-opacity-30 text-white !rounded-md transition duration-300 flex items-center shadow-md hover:shadow-lg">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 min-h-screen exit-permissions-bg">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 bg-green-500 text-white px-6 py-4 !rounded-md shadow-md flex items-center border-l-4 border-green-700">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Error Message -->
            @if(session('error'))
                <div class="mb-6 bg-red-500 text-white px-6 py-4 !rounded-md shadow-md flex items-center border-l-4 border-red-700">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-bold">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Main Details Card -->
            <div class="exit-permissions-card mb-6 !rounded-md overflow-hidden border border-gray-200 shadow-sm">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-custom-blue mb-6 flex items-center border-b pb-3 border-gray-100">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Informasi Permohonan
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Nama Siswa</label>
                            <div class="p-3 bg-gray-50 border border-gray-300 !rounded-md text-gray-800 font-medium">
                                {{ $exitPermission->student->name }}
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">NIS</label>
                            <div class="p-3 bg-gray-50 border border-gray-300 !rounded-md text-gray-800 font-medium">
                                {{ $exitPermission->student->student_number }}
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Kelas</label>
                            <div class="p-3 bg-gray-50 border border-gray-300 !rounded-md text-gray-800 font-medium">
                                {{ $exitPermission->schoolClass->name }}
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Tanggal Keluar</label>
                            <div class="p-3 bg-gray-50 border border-gray-300 !rounded-md text-gray-800 font-medium">
                                {{ $exitPermission->exit_date->format('d F Y') }}
                            </div>
                        </div>
                        
                        <div class="md:col-span-2">
                             <label class="block text-sm font-semibold text-gray-600 mb-1">Jenis Izin</label>
                             <div class="p-3 bg-gray-50 border border-gray-300 !rounded-md text-gray-800 font-medium">
                                @if($exitPermission->permission_type === 'sick')
                                     Sakit
                                @elseif($exitPermission->permission_type === 'leave_early')
                                     Izin Pulang Awal
                                @elseif($exitPermission->permission_type === 'permission_out')
                                     Izin Keluar
                                @else
                                    {{ $exitPermission->permission_type }}
                                @endif
                             </div>
                        </div>
                        
                        @if($exitPermission->time_out)
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Jam Keluar</label>
                            <div class="p-3 bg-gray-50 border border-gray-300 !rounded-md text-gray-800 font-medium">
                                {{ $exitPermission->time_out }}
                            </div>
                        </div>
                        @endif
                        
                        @if($exitPermission->time_in)
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Jam Kembali</label>
                            <div class="p-3 bg-gray-50 border border-gray-300 !rounded-md text-gray-800 font-medium">
                                {{ $exitPermission->time_in }}
                            </div>
                        </div>
                        @endif
                        
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Status Keseluruhan</label>
                            <div class="mt-1">
                                @if($exitPermission->status === 'approved')
                                    <span class="inline-flex items-center px-3 py-1 !rounded-md text-sm font-bold bg-green-100 text-green-800 border border-green-200">
                                        ✓ Fully Approved
                                    </span>
                                @elseif($exitPermission->status === 'rejected')
                                    <span class="inline-flex items-center px-3 py-1 !rounded-md text-sm font-bold bg-red-100 text-red-800 border border-red-200">
                                        ✗ Ditolak
                                    </span>
                                @elseif($exitPermission->walas_status === 'pending')
                                    <span class="inline-flex items-center px-3 py-1 !rounded-md text-sm font-bold bg-yellow-100 text-yellow-800 border border-yellow-200">
                                        ⏳ Waiting for Homeroom Teacher Approval
                                    </span>
                                @elseif($exitPermission->walas_status === 'approved' && $exitPermission->admin_status === 'pending')
                                    <span class="inline-flex items-center px-3 py-1 !rounded-md text-sm font-bold bg-blue-100 text-blue-800 border border-blue-200">
                                        ⏳ Approved by Homeroom Teacher - Waiting for Admin Approval
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 !rounded-md text-sm font-bold bg-gray-100 text-gray-800 border border-gray-200">
                                        ⏳ Menunggu Persetujuan
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Reason Section -->
                    <div class="mt-6">
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Alasan Keluar</label>
                        <div class="p-3 bg-gray-50 border border-gray-300 !rounded-md text-gray-800 italic">
                            {{ $exitPermission->reason }}
                        </div>
                    </div>

                    @if($exitPermission->additional_notes)
                    <div class="mt-4">
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Catatan Tambahan</label>
                        <div class="p-3 bg-gray-50 border border-gray-300 !rounded-md text-gray-800">
                            {{ $exitPermission->additional_notes }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Homeroom Teacher Approval Card -->
            <div class="exit-permissions-card mb-6 !rounded-md overflow-hidden border border-gray-200 shadow-sm">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-custom-blue mb-6 flex items-center border-b pb-3 border-gray-100">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Persetujuan Wali Kelas
                    </h3>
                    
                    <div class="flex items-center justify-between mb-4 bg-gray-50 p-4 border border-gray-200 !rounded-md gap-4">
                        <p class="text-gray-700 font-semibold">Status:</p>
                        <div>
                            @if($exitPermission->walas_status === 'approved')
                                <span class="inline-flex items-center px-3 py-1 !rounded-md text-sm font-bold bg-green-100 text-green-800 border border-green-200">
                                    ✓ Disetujui
                                </span>
                            @elseif($exitPermission->walas_status === 'rejected')
                                <span class="inline-flex items-center px-3 py-1 !rounded-md text-sm font-bold bg-red-100 text-red-800 border border-red-200">
                                    ✗ Ditolak
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 !rounded-md text-sm font-bold bg-yellow-100 text-yellow-800 border border-yellow-200">
                                    ⏳ Menunggu
                                </span>
                            @endif
                        </div>
                    </div>

                    @if($exitPermission->walas_approved_by)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Disetujui Oleh</label>
                            <div class="p-3 bg-gray-50 border border-gray-300 !rounded-md text-gray-800">
                                {{ $exitPermission->walasApprovedBy->name }}
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Waktu Persetujuan</label>
                            <div class="p-3 bg-gray-50 border border-gray-300 !rounded-md text-gray-800">
                                {{ $exitPermission->walas_approved_at->format('d M Y, H:i') }}
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($exitPermission->walas_notes)
                    <div class="mt-4">
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Catatan Wali Kelas</label>
                        <div class="p-3 bg-gray-50 border border-gray-300 !rounded-md text-gray-800">
                            {{ $exitPermission->walas_notes }}
                        </div>
                    </div>
                    @endif

                    @if((auth()->user()->role === 'homeroom_teacher' || auth()->user()->role === 'walas') && $exitPermission->walas_status === 'pending')
                        <form method="POST" action="{{ route('exit-permissions.walas-approve', $exitPermission->id) }}" class="mt-6 pt-6 border-t border-gray-100" onsubmit="return confirm('Apakah Anda yakin ingin mengirim keputusan ini?')">
                            @csrf

                            <div class="mb-4">
                                <label for="walas_notes" class="block text-sm font-semibold text-gray-600 mb-2">Catatan (Opsional)</label>
                                <textarea id="walas_notes" name="walas_notes" rows="3" class="w-full bg-white border border-gray-300 !rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                            </div>

                            <div class="flex gap-4 mt-4">
                                <button type="submit" name="action" value="approve" 
                                        class="flex-1 font-bold py-3 px-6 rounded-md shadow hover:shadow-lg transition-all duration-200 flex items-center justify-center text-white"
                                        style="background-color: #16a34a !important; color: #ffffff !important; opacity: 1 !important; visibility: visible !important; display: flex !important;">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Setujui
                                </button>
                                <button type="submit" name="action" value="reject" 
                                        class="flex-1 font-bold py-3 px-6 rounded-md shadow hover:shadow-lg transition-all duration-200 flex items-center justify-center text-white"
                                        style="background-color: #dc2626 !important; color: #ffffff !important; opacity: 1 !important; visibility: visible !important; display: flex !important;">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Tolak
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Admin Approval Card -->
            <div class="exit-permissions-card !rounded-md overflow-hidden border border-gray-200 shadow-sm">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-custom-blue mb-6 flex items-center border-b pb-3 border-gray-100">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        Persetujuan Admin
                    </h3>
                    
                    <div class="flex items-center justify-between mb-4 bg-gray-50 p-4 border border-gray-200 !rounded-md gap-4">
                        <p class="text-gray-700 font-semibold">Status:</p>
                        <div>
                            @if($exitPermission->admin_status === 'approved')
                                <span class="inline-flex items-center px-3 py-1 !rounded-md text-sm font-bold bg-green-100 text-green-800 border border-green-200">
                                    ✓ Disetujui
                                </span>
                            @elseif($exitPermission->admin_status === 'rejected')
                                <span class="inline-flex items-center px-3 py-1 !rounded-md text-sm font-bold bg-red-100 text-red-800 border border-red-200">
                                    ✗ Ditolak
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 !rounded-md text-sm font-bold bg-yellow-100 text-yellow-800 border border-yellow-200">
                                    ⏳ Menunggu
                                </span>
                            @endif
                        </div>
                    </div>

                    @if($exitPermission->admin_approved_by)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Disetujui Oleh</label>
                            <div class="p-3 bg-gray-50 border border-gray-300 !rounded-md text-gray-800">
                                {{ $exitPermission->adminApprovedBy->name }}
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Waktu Persetujuan</label>
                            <div class="p-3 bg-gray-50 border border-gray-300 !rounded-md text-gray-800">
                                {{ $exitPermission->admin_approved_at->format('d M Y, H:i') }}
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($exitPermission->admin_notes)
                    <div class="mt-4">
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Catatan Admin</label>
                        <div class="p-3 bg-gray-50 border border-gray-300 !rounded-md text-gray-800">
                            {{ $exitPermission->admin_notes }}
                        </div>
                    </div>
                    @endif

                    @if(auth()->user()->isAdmin() && $exitPermission->admin_status === 'pending')
                        @if($exitPermission->walas_status === 'approved')
                            {{-- Admin can approve after homeroom teacher approval --}}
                            <form method="POST" action="{{ route('exit-permissions.admin-approve', $exitPermission->id) }}" class="mt-6 pt-6 border-t border-gray-100" onsubmit="return confirm('Apakah Anda yakin ingin mengirim keputusan ini?')">
                                @csrf

                                <div class="mb-4">
                                    <label for="admin_notes" class="block text-sm font-semibold text-gray-600 mb-2">Catatan (Opsional)</label>
                                    <textarea id="admin_notes" name="admin_notes" rows="3" class="w-full bg-white border border-gray-300 !rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                                </div>

                                <div class="flex gap-4 mt-4">
                                    <button type="submit" name="action" value="approve" 
                                            class="flex-1 font-bold py-3 px-6 rounded-md shadow hover:shadow-lg transition-all duration-200 flex items-center justify-center text-white"
                                            style="background-color: #16a34a !important; color: #ffffff !important; opacity: 1 !important; visibility: visible !important; display: flex !important;">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Setujui
                                    </button>
                                    <button type="submit" name="action" value="reject" 
                                            class="flex-1 font-bold py-3 px-6 rounded-md shadow hover:shadow-lg transition-all duration-200 flex items-center justify-center text-white"
                                            style="background-color: #dc2626 !important; color: #ffffff !important; opacity: 1 !important; visibility: visible !important; display: flex !important;">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Tolak
                                    </button>
                                </div>
                            </form>
                        @else
                            {{-- Admin approval disabled until homeroom teacher approves --}}
                            <div class="mt-6 p-4 bg-gray-50 !rounded-md border border-gray-200">
                                <div class="flex items-center mb-3">
                                    <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                    <p class="text-gray-600 font-semibold">Admin Approval Pending</p>
                                </div>
                                <p class="text-gray-500 text-sm mb-4">Admin approval is currently disabled. This request must be approved by the Homeroom Teacher first before Admin can review it.</p>
                                
                                <div class="flex gap-4">
                                    <button disabled class="flex-1 bg-gray-200 text-gray-400 font-bold py-3 px-6 !rounded-md cursor-not-allowed flex items-center justify-center border border-gray-300">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Setujui (Disabled)
                                    </button>
                                    <button disabled class="flex-1 bg-gray-200 text-gray-400 font-bold py-3 px-6 !rounded-md cursor-not-allowed flex items-center justify-center border border-gray-300">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Tolak (Disabled)
                                    </button>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
