<x-app-layout>
    <x-slot name="header">
        <div class="exit-create-page-header -mt-6 -mx-6 px-6 py-8 mb-6">
            <div class="flex justify-between items-center exit-create-page-header-inner">
                <div>
                    <h2 class="font-bold text-3xl text-white leading-tight drop-shadow-lg flex items-center">
                        <svg class="w-10 h-10 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Ajukan Izin Keluar
                    </h2>
                    <p class="exit-create-page-header-subtitle mt-2">Isi form untuk mengajukan izin keluar siswa ini</p>
                </div>
                <a href="{{ route('exit-permissions.index') }}" class="exit-create-back-btn font-bold py-3 px-6 rounded-xl transition duration-300 flex items-center backdrop-blur-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 exit-create-page-bg">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="exit-create-form-card">
                <div class="exit-create-form-header">
                    <img class="exit-create-form-header-img" src="{{ asset('build/assets/form.png') }}" alt="Form">
                    <h3 class="exit-create-form-header-title">FORM IZIN KELUAR</h3>
                    <p class="exit-create-form-header-subtitle">Lengkapi semua yang dibutuhkan</p>
                </div>
                <div class="exit-create-form-body">
                    <form method="POST" action="{{ route('exit-permissions.store') }}" id="exitPermissionForm">
                        @csrf

                        <!-- Class Selection (if admin/teacher) -->
                        @if(auth()->user()->role !== 'homeroom_teacher')
                        <div class="mb-6">
                            <label for="class_id" class="block text-gray-800 text-sm font-bold mb-2 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                Kelas
                            </label>
                            <select id="class_id" name="class_id" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-200 transition duration-300" required>
                                <option value="">Pilih Kelas</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                            @error('class_id')
                                <p class="text-red-500 text-sm font-semibold mt-2 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        @endif

                        <!-- Student Selection -->
                        <div class="mb-6">
                            <label for="student_id" class="block text-gray-800 text-sm font-bold mb-2 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Nama Siswa <span class="text-red-500">*</span>
                            </label>
                            <select id="student_id" name="student_id" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-300" required>
                                <option value="">Pilih Siswa</option>
                                @if(auth()->user()->role === 'homeroom_teacher')
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->student_number }})</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('student_id')
                                <p class="text-red-500 text-sm font-semibold mt-2 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Permission Type -->
                        <div class="mb-6">
                            <label for="permission_type" class="block text-gray-800 text-sm font-bold mb-2 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Jenis Izin <span class="text-red-500">*</span>
                            </label>
                            <select id="permission_type" name="permission_type" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-300" required>
                                <option value="">Pilih Jenis Izin</option>
                                <option value="sick" {{ old('permission_type') == 'sick' ? 'selected' : '' }}>Sakit</option>
                                <option value="leave_early" {{ old('permission_type') == 'leave_early' ? 'selected' : '' }}>Izin Pulang Awal</option>
                                <option value="permission_out" {{ old('permission_type') == 'permission_out' ? 'selected' : '' }}>Izin Keluar</option>
                            </select>
                            @error('permission_type')
                                <p class="text-red-500 text-sm font-semibold mt-2 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Exit Date -->
                        <div class="mb-6">
                            <label for="exit_date" class="block text-gray-800 text-sm font-bold mb-2 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Tanggal Keluar <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="exit_date" name="exit_date" value="{{ old('exit_date', date('Y-m-d')) }}" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-red-500 focus:ring-2 focus:ring-red-200 transition duration-300" required>
                            @error('exit_date')
                                <p class="text-red-500 text-sm font-semibold mt-2 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Time Out -->
                        <div class="mb-6">
                            <label for="time_out" class="block text-gray-800 text-sm font-bold mb-2 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Jam Keluar <span class="text-red-500">*</span>
                            </label>
                            <input type="time" id="time_out" name="time_out" value="{{ old('time_out', now()->format('H:i')) }}" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition duration-300" required step="60">
                            @error('time_out')
                                <p class="text-red-500 text-sm font-semibold mt-2 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Time In -->
                        <div class="mb-6" id="time_in_section">
                            <label for="time_in" class="block text-gray-800 text-sm font-bold mb-2 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Jam Kembali <span class="text-gray-400">(Opsional - tergantung jenis izin)</span>
                            </label>
                            <input type="time" id="time_in" name="time_in" value="{{ old('time_in') }}" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition duration-300" step="60">
                            @error('time_in')
                                <p class="text-red-500 text-sm font-semibold mt-2 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Reason -->
                        <div class="mb-6">
                            <label for="reason" class="block text-gray-800 text-sm font-bold mb-2 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                </svg>
                                Alasan Keluar <span class="text-red-500">*</span>
                            </label>
                            <textarea id="reason" name="reason" rows="4" placeholder="Jelaskan alasan izin keluar..." class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 transition duration-300" required>{{ old('reason') }}</textarea>
                            @error('reason')
                                <p class="text-red-500 text-sm font-semibold mt-2 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Additional Notes -->
                        <div class="mb-8">
                            <label for="additional_notes" class="block text-gray-800 text-sm font-bold mb-2 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Catatan Tambahan <span class="text-gray-400">(Opsional)</span>
                            </label>
                            <textarea id="additional_notes" name="additional_notes" rows="3" placeholder="Tambahkan catatan jika diperlukan..." class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition duration-300">{{ old('additional_notes') }}</textarea>
                            @error('additional_notes')
                                <p class="text-red-500 text-sm font-semibold mt-2 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-between pt-6 border-t-4 border-gray-200 exit-create-form-actions">
                            <a href="{{ route('exit-permissions.index') }}" class="text-gray-600 hover:text-gray-900 font-bold text-lg flex items-center group">
                                <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Batal
                            </a>
                            <button type="submit" class="exit-create-submit-btn flex items-center">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Ajukan Izin</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Permission type handling - show/hide Time In field based on permission type
        document.getElementById('permission_type').addEventListener('change', function() {
            const permissionType = this.value;
            const timeInSection = document.getElementById('time_in_section');
            const timeInInput = document.getElementById('time_in');
            const timeInLabel = timeInSection.querySelector('label span');
            
            if (permissionType === 'sick') {
                // For sick leave, Time In is not needed (staying home)
                timeInSection.style.display = 'none';
                timeInInput.required = false;
                timeInInput.value = ''; // Clear the value
            } else if (permissionType === 'leave_early') {
                // For leave early, Time In is not needed (going home)
                timeInSection.style.display = 'none';
                timeInInput.required = false;
                timeInInput.value = ''; // Clear the value
            } else if (permissionType === 'permission_out') {
                // For permission out, Time In is required (must return to class)
                timeInSection.style.display = 'block';
                timeInInput.required = true;
                timeInLabel.innerHTML = '<span class="text-red-500">* (Wajib diisi - waktu kembali ke kelas)</span>';
            } else {
                // Default state
                timeInSection.style.display = 'block';
                timeInInput.required = false;
                timeInLabel.textContent = '(Opsional - tergantung jenis izin)';
            }
        });

        // Trigger on page load if there's an old value
        document.addEventListener('DOMContentLoaded', function() {
            const permissionTypeSelect = document.getElementById('permission_type');
            if (permissionTypeSelect.value) {
                permissionTypeSelect.dispatchEvent(new Event('change'));
            }
        });


        @if(auth()->user()->role !== 'homeroom_teacher')
        // AJAX to load students when class is selected
        document.getElementById('class_id').addEventListener('change', function() {
            const classId = this.value;
            const studentSelect = document.getElementById('student_id');
            
            // Clear current options
            studentSelect.innerHTML = '<option value="">Select Student</option>';
            
            if (classId) {
                fetch(`{{ route('exit-permissions.students-by-class') }}?class_id=${classId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(student => {
                            const option = document.createElement('option');
                            option.value = student.id;
                            option.textContent = `${student.name} (${student.student_number})`;
                            studentSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error loading students:', error));
            }
        });
        @endif
    </script>
</x-app-layout>
