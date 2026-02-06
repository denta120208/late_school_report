<x-app-layout>
    <x-slot name="header">
        <div class="late-attendance-hero -mt-6 -mx-6 px-6 py-8 mb-6 shadow-lg">
            <div class="max-w-7xl mx-auto late-attendance-hero-inner flex items-center justify-between gap-4 flex-wrap">
                <div style="flex: 1 1 520px; min-width: 260px;">
                    <h2 class="font-bold text-3xl text-white leading-tight drop-shadow-lg flex items-center">
                        <svg class="w-10 h-10 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Catat Keterlambatan Siswa
                    </h2>
                    <p class="late-attendance-hero-subtitle mt-2 text-sm">Isi data keterlambatan untuk setiap siswa yang dipilih</p>
                </div>
                <div class="flex items-center gap-3 flex-wrap" style="flex: 0 0 auto; justify-content: flex-end; margin-left: auto;">
                    <button type="button" onclick="addMoreStudents()" class="late-attendance-primary-btn flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Tambah Siswa Lain
                    </button>
                    <a href="{{ route('classes.index') }}" class="late-attendance-secondary-btn-nohover flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8 min-h-screen late-attendance-bg">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Info Alert -->
            <div class="late-attendance-card mb-6">
                <div class="late-attendance-card-body">
                    <div class="flex items-center">
                        <div class="rounded-full p-4 mr-4" style="background: rgba(22, 11, 106, 0.10);">
                            <svg class="h-8 w-8" fill="#160B6A" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        </div>
                        <div>
                            <p class="text-xl font-bold" style="color:#160B6A;">Isi Data Individual</p>
                            <p class="text-slate-600 mt-1">Setiap siswa memiliki form sendiri. Isi waktu kedatangan dan alasan untuk masing-masing siswa.</p>
                        </div>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('late-attendance.bulk-store') }}" id="bulkLateForm">
                @csrf

                <!-- Class Info Header -->
                <div class="late-attendance-card mb-6">
                    <div class="late-attendance-card-body">
                        <div class="flex items-center justify-between gap-4 flex-wrap">
                            <div class="flex items-center gap-4">
                                <div class="rounded-2xl p-4" style="background: rgba(22, 11, 106, 0.10);">
                                    <svg class="w-8 h-8" fill="none" stroke="#160B6A" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Kelas</p>
                                    <p class="text-2xl font-bold text-gray-900">
                                        @if($classes->count() == 1)
                                            {{ $classes->first()->name }}
                                        @else
                                            {{ $classes->count() }} Kelas Berbeda
                                        @endif
                                    </p>
                                    @if($classes->count() > 1)
                                        <p class="text-sm text-gray-500 mt-1">{{ $classes->pluck('name')->join(', ') }}</p>
                                    @endif
                                </div>
                            </div>
                            <span class="px-6 py-3 rounded-xl font-bold text-lg" style="background:#160B6A; color:#fff; white-space:nowrap;">
                                {{ count($students) }} Siswa Terpilih
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Individual Student Forms -->
                <div class="space-y-6" id="studentFormsContainer">
                    @foreach($students as $index => $student)
                    @php
                        // Check if this student has existing form data
                        $existingData = null;
                        if (!empty($existingFormData)) {
                            foreach ($existingFormData as $formData) {
                                if (isset($formData['student_id']) && $formData['student_id'] == $student->id) {
                                    $existingData = $formData;
                                    break;
                                }
                            }
                        }
                    @endphp
                    <div class="late-attendance-card student-form-card" data-student-id="{{ $student->id }}">
                        <div class="late-attendance-card-header p-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="bg-white bg-opacity-20 rounded-2xl p-3 backdrop-blur-lg">
                                        <div class="rounded-xl p-3 w-14 h-14 flex items-center justify-center" style="background: rgba(255,255,255,0.22);">
                                            <span class="text-2xl font-black text-white">{{ strtoupper(substr($student->name, 0, 1)) }}</span>
                                        </div>
                                    </div>
                                    <div class="text-white">
                                        <p class="text-sm" style="color: rgba(255,255,255,0.85);">Siswa #{{ $index + 1 }}</p>
                                        <h3 class="text-2xl font-bold">{{ $student->name }}</h3>
                                        <p style="color: rgba(255,255,255,0.85);">{{ $student->student_number }} • {{ $student->schoolClass->name }}</p>
                                    </div>
                                </div>
                                <button type="button" onclick="removeStudentForm({{ $student->id }})" class="bg-white bg-opacity-20 text-white font-bold py-2 px-4 rounded-xl transition duration-300 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Hapus
                                </button>
                            </div>
                        </div>

                        <div class="p-8 bg-white">
                            <input type="hidden" name="students[{{ $index }}][student_id]" value="{{ $student->id }}">
                            <input type="hidden" name="students[{{ $index }}][class_id]" value="{{ $student->class_id }}">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Late Date -->
                                <div>
                                    <label class="block text-sm mb-2 late-attendance-label flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="#160B6A" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Tanggal Telat <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="students[{{ $index }}][late_date]" value="{{ old('students.'.$index.'.late_date', $existingData['late_date'] ?? date('Y-m-d')) }}" required
                                        class="late-attendance-input">
                                </div>

                                <!-- Arrival Time -->
                                <div>
                                    <label class="block text-sm mb-2 late-attendance-label flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="#160B6A" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Jam Kedatangan <span class="text-red-500">*</span>
                                    </label>
                                    <input type="time" name="students[{{ $index }}][arrival_time]" value="{{ old('students.'.$index.'.arrival_time', $existingData['arrival_time'] ?? '') }}" required
                                        class="late-attendance-input">
                                </div>

                                <!-- Late Reason -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm mb-2 late-attendance-label flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="#160B6A" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                        </svg>
                                        Alasan Telat <span class="text-red-500">*</span>
                                    </label>
                                    <select name="students[{{ $index }}][late_reason_id]" required
                                        class="late-attendance-input cursor-pointer">
                                        <option value="">-- Pilih Alasan --</option>
                                        @foreach($lateReasons as $reason)
                                            <option value="{{ $reason->id }}" {{ (old('students.'.$index.'.late_reason_id', $existingData['late_reason_id'] ?? '') == $reason->id) ? 'selected' : '' }}>
                                                {{ $reason->reason }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Notes -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm mb-2 late-attendance-label flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="#160B6A" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Catatan Tambahan <span class="text-gray-400">(Opsional)</span>
                                    </label>
                                    <textarea name="students[{{ $index }}][notes]" rows="2" placeholder="Tambahkan catatan jika ada..."
                                        class="late-attendance-input">{{ old('students.'.$index.'.notes', $existingData['notes'] ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Submit Button -->
                <div class="mt-8 late-attendance-card">
                    <div class="late-attendance-card-body">
                    <div class="flex items-center justify-between gap-4 flex-wrap">
                        <div>
                            <p class="text-gray-600">Total siswa yang akan dicatat:</p>
                            <p class="text-3xl font-bold text-gray-900" id="totalStudents">{{ count($students) }}</p>
                        </div>
                        <div class="flex items-center gap-3 flex-wrap" style="flex: 0 0 auto; justify-content: flex-end; margin-left: auto;">
                            <button type="button" onclick="addMoreStudents()" class="late-attendance-secondary-btn flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Tambah Siswa Lagi
                            </button>
                            <a href="{{ route('classes.index') }}" class="late-attendance-secondary-btn-nohover flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Batal
                            </a>
                            <button type="submit" class="late-attendance-primary-btn flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Simpan Semua</span>
                            </button>
                        </div>
                    </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // On page load, clear bulkLateFormData if we just loaded fresh data
        document.addEventListener('DOMContentLoaded', function() {
            // Check if this is a fresh load (not from "add more students")
            // If existingFormData was passed from controller, we already restored it
            // So we can clear the sessionStorage for bulkLateFormData
            const urlParams = new URLSearchParams(window.location.search);
            // Keep selectedStudents for checkbox persistence, but we've already processed bulkLateFormData
        });

        function removeStudentForm(studentId) {
            const card = document.querySelector(`.student-form-card[data-student-id="${studentId}"]`);
            if (card) {
                card.remove();
                
                // Remove from sessionStorage
                const savedSelections = JSON.parse(sessionStorage.getItem('selectedStudents') || '[]');
                const updatedSelections = savedSelections.filter(id => id != studentId);
                sessionStorage.setItem('selectedStudents', JSON.stringify(updatedSelections));
                
                // Update count
                const remaining = document.querySelectorAll('.student-form-card').length;
                document.getElementById('totalStudents').textContent = remaining;
                
                if (remaining === 0) {
                    alert('Tidak ada siswa tersisa. Kembali ke halaman kelas.');
                    sessionStorage.removeItem('selectedStudents');
                    window.location.href = "{{ route('classes.index') }}";
                }
            }
        }

        function addMoreStudents() {
            // Save current form data to sessionStorage before going back
            const studentForms = document.querySelectorAll('.student-form-card');
            const formData = [];
            const studentIds = [];
            
            studentForms.forEach((card, index) => {
                const studentId = card.getAttribute('data-student-id');
                const lateDate = card.querySelector(`input[name="students[${index}][late_date]"]`)?.value || '';
                const arrivalTime = card.querySelector(`input[name="students[${index}][arrival_time]"]`)?.value || '';
                const lateReasonId = card.querySelector(`select[name="students[${index}][late_reason_id]"]`)?.value || '';
                const notes = card.querySelector(`textarea[name="students[${index}][notes]"]`)?.value || '';
                const classId = card.querySelector(`input[name="students[${index}][class_id]"]`)?.value || '';
                
                formData.push({
                    student_id: studentId,
                    class_id: classId,
                    late_date: lateDate,
                    arrival_time: arrivalTime,
                    late_reason_id: lateReasonId,
                    notes: notes
                });
                
                // Collect all current student IDs
                studentIds.push(studentId);
            });
            
            // Save form data to sessionStorage
            sessionStorage.setItem('bulkLateFormData', JSON.stringify(formData));
            
            // Save current student IDs to sessionStorage so they stay selected
            sessionStorage.setItem('selectedStudents', JSON.stringify(studentIds));
            
            // Keep the current selections in sessionStorage and go back
            window.location.href = "{{ route('classes.index') }}";
        }

        // Confirm before submit
        document.getElementById('bulkLateForm').addEventListener('submit', function(e) {
            const studentCount = document.querySelectorAll('.student-form-card').length;
            if (!confirm(`Apakah Anda yakin ingin menyimpan data keterlambatan untuk ${studentCount} siswa? Notifikasi Telegram akan dikirim otomatis.`)) {
                e.preventDefault();
            } else {
                // Clear all sessionStorage after successful submission
                sessionStorage.removeItem('selectedStudents');
                sessionStorage.removeItem('bulkLateFormData');
            }
        });
    </script>
</x-app-layout>
