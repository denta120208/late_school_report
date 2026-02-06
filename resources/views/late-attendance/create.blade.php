<x-app-layout>
    <x-slot name="header">
        <div class="late-attendance-hero -mt-6 -mx-6 px-6 py-8 mb-6 shadow-lg">
            <div class="max-w-7xl mx-auto late-attendance-hero-inner flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h2 class="font-bold text-3xl md:text-4xl text-white leading-tight flex items-center">
                        <svg class="w-10 h-10 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Form Pencatatan Keterlambatan
                    </h2>
                    <p class="late-attendance-hero-subtitle mt-2 text-sm md:text-base">Isi data keterlambatan siswa dengan lengkap</p>
                </div>
                <a href="{{ route('classes.show', $student->class_id) }}" class="bg-white text-gray-800 font-semibold py-2 px-4 rounded-lg shadow-md flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 min-h-screen late-attendance-bg">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <!-- Alert Box -->
            <div class="late-attendance-card mb-6">
                <div class="p-6 flex items-center">
                    <div class="bg-white rounded-2xl p-3 mr-4" style="background: rgba(22, 11, 106, 0.10);">
                        <svg class="h-8 w-8" fill="none" stroke="#160B6A" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86l-7.4 12.8A2 2 0 004.62 20h14.76a2 2 0 001.73-3.34l-7.4-12.8a2 2 0 00-3.42 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-base font-black text-gray-900">Siswa Terlambat Datang</p>
                        <p class="text-sm text-gray-500 mt-1">Pastikan semua data sudah benar sebelum submit</p>
                    </div>
                </div>
            </div>
            
            <!-- Form Card -->
            <div class="late-attendance-card">
                <div class="late-attendance-card-header">
                    <div class="flex items-center gap-3">
                        <div class="bg-white bg-opacity-20 backdrop-blur-lg rounded-2xl p-3 inline-block">
                            <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="late-attendance-card-title text-xl">Formulir Keterlambatan</div>
                            <div class="late-attendance-hero-subtitle text-sm">Isi data dengan lengkap dan akurat</div>
                        </div>
                    </div>
                </div>
                <div class="late-attendance-card-body">
                    
                    <form method="POST" action="{{ route('late-attendance.store') }}">
                        @csrf
                        
                        <input type="hidden" name="student_id" value="{{ $student->id }}">
                        <input type="hidden" name="class_id" value="{{ $student->class_id }}">
                        
                        <!-- Student Info Card -->
                        <div class="rounded-2xl p-6 mb-6" style="background: #160B6A; color: #ffffff;">
                            <div class="flex items-center">
                                <div class="rounded-2xl p-4 mr-4" style="background: rgba(255, 255, 255, 0.18);">
                                    <span class="text-3xl font-black">{{ strtoupper(substr($student->name, 0, 1)) }}</span>
                                </div>
                                <div>
                                    <p class="text-sm" style="color: rgba(255,255,255,0.80);">Nama Siswa</p>
                                    <p class="text-2xl font-bold">{{ $student->name }}</p>
                                    <p class="text-sm mt-1" style="color: rgba(255,255,255,0.80);">Kelas: <span class="font-bold">{{ $student->schoolClass->name }}</span></p>
                                </div>
                            </div>
                        </div>

                        <!-- Exit Permission Check -->
                        @php
                            $exitPermission = $student->getExitPermissionForDate(date('Y-m-d'));
                        @endphp
                        @if($exitPermission)
                            <div class="late-attendance-card mb-6" style="border-color: rgba(34, 197, 94, 0.30);">
                                <div class="p-6" style="background: rgba(34, 197, 94, 0.10);">
                                <div class="flex items-center">
                                    <div class="rounded-full p-3 mr-4" style="background: rgba(34, 197, 94, 0.16);">
                                        <svg class="w-8 h-8" fill="none" stroke="#166534" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-base font-black text-gray-900 mb-1">✓ Siswa memiliki izin keluar yang disetujui</p>
                                        <p class="text-sm text-gray-600">Tanggal: {{ $exitPermission->exit_date->format('d M Y') }}</p>
                                        <p class="text-sm text-gray-600">Alasan: {{ Str::limit($exitPermission->reason, 60) }}</p>
                                        <a href="{{ route('exit-permissions.show', $exitPermission->id) }}" class="text-sm late-attendance-link underline mt-2 inline-block">
                                            View exit permission details →
                                        </a>
                                    </div>
                                </div>
                                </div>
                            </div>
                        @endif

                        <!-- Late Date -->
                        <div class="mb-6">
                            <label for="late_date" class="block text-sm mb-2 late-attendance-label flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="#160B6A" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Tanggal Keterlambatan <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="late_date" id="late_date" value="{{ old('late_date', date('Y-m-d')) }}" required
                                class="late-attendance-input @error('late_date') border-red-500 @enderror">
                            @error('late_date')
                                <p class="text-red-500 text-sm font-semibold mt-2 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Arrival Time -->
                        <div class="mb-6">
                            <label for="arrival_time" class="block text-sm mb-2 late-attendance-label flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="#160B6A" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Jam Kedatangan <span class="text-red-500">*</span>
                            </label>
                            <input type="time" name="arrival_time" id="arrival_time" value="{{ old('arrival_time', date('H:i')) }}" required
                                class="late-attendance-input @error('arrival_time') border-red-500 @enderror">
                            @error('arrival_time')
                                <p class="text-red-500 text-sm font-semibold mt-2 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Late Reason -->
                        <div class="mb-6">
                            <label for="late_reason_id" class="block text-sm mb-2 late-attendance-label flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="#160B6A" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                </svg>
                                Alasan Keterlambatan <span class="text-red-500">*</span>
                            </label>
                            <select name="late_reason_id" id="late_reason_id" required
                                class="late-attendance-input cursor-pointer @error('late_reason_id') border-red-500 @enderror">
                                <option value="">-- Pilih Alasan Keterlambatan --</option>
                                @foreach($lateReasons as $reason)
                                    <option value="{{ $reason->id }}" {{ old('late_reason_id') == $reason->id ? 'selected' : '' }}>
                                        {{ $reason->reason }}
                                    </option>
                                @endforeach
                            </select>
                            @error('late_reason_id')
                                <p class="text-red-500 text-sm font-semibold mt-2 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Additional Notes -->
                        <div class="mb-8">
                            <label for="notes" class="block text-sm mb-2 late-attendance-label flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="#160B6A" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Catatan Tambahan <span class="text-gray-400">(Opsional)</span>
                            </label>
                            <textarea name="notes" id="notes" rows="4" placeholder="Tulis catatan tambahan jika diperlukan..."
                                class="late-attendance-input @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="text-red-500 text-sm font-semibold mt-2 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 pt-6" style="border-top: 1px solid rgba(15, 23, 42, 0.10);">
                            <button type="submit" class="late-attendance-primary-btn flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Simpan Catatan Keterlambatan</span>
                            </button>
                            <a href="{{ route('classes.show', $student->class_id) }}" class="late-attendance-secondary-btn flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
