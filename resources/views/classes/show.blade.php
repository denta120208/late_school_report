<x-app-layout>
    <x-slot name="header">
        <div class="class-show-header -mt-6 -mx-6">
            <div class="max-w-7xl mx-auto class-show-header-inner">
                <div class="class-show-title">
                    <svg class="w-7 h-7 mt-1" fill="none" stroke="#0f172a" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <div>
                        <h2>{{ $class->name }}</h2>
                        <div class="class-show-subtitle">{{ $class->description }}</div>
                    </div>
                </div>

                <a href="{{ route('classes.index') }}" class="class-show-back-btn">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10 class-show-bg">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 walas-alert walas-alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Quick Access Card -->
            <div class="late-attendance-card mb-6">
                <div class="late-attendance-card-body flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="flex items-center gap-3">
                        
                        <div>
                        </div>
                    </div>
                    <a href="{{ route('late-attendance.multi-create') }}" class="late-attendance-primary-btn flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Cari Siswa!
                    </a>
                </div>
            </div>

            <div class="class-show-card">
                <div class="class-show-card-header">
                    <div>
                        <div class="class-show-card-header-title">PILIH SISWA YANG TELAT</div>
                        <div class="class-show-card-header-subtitle">Centang siswa yang terlambat, lalu klik “Submit Selection”</div>
                    </div>
                    <div id="bulkActionButtons" class="hidden">
                        <button type="button" onclick="submitBulkSelection()" class="class-show-submit-btn">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Submit Selection (<span id="selectedCount">0</span>)
                        </button>
                    </div>
                </div>
                <div class="p-6">
                    <form id="bulkSelectionForm" action="{{ route('late-attendance.bulk-review') }}" method="POST">
                        @csrf
                        <input type="hidden" name="class_id" value="{{ $class->id }}">
                        <input type="hidden" name="existing_form_data" id="existingFormDataInput" value="">
                        
                        <div class="space-y-3">
                            @forelse($class->students as $student)
                            <div class="class-show-student-row transition-all duration-300" data-student-card>
                                <div class="flex items-center justify-between gap-4">
                                    <div class="flex items-center gap-4 flex-1">
                                        <input type="checkbox" name="student_ids[]" value="{{ $student->id }}"
                                            class="class-show-checkbox student-checkbox"
                                            onchange="updateBulkActions()">

                                        <div class="class-show-avatar">
                                            {{ strtoupper(substr($student->name, 0, 1)) }}
                                        </div>

                                        <div class="min-w-0">
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <div class="class-show-student-name truncate">{{ $student->name }}</div>
                                                @if($student->hasApprovedExitPermission(now()->format('Y-m-d')))
                                                    <span class="px-2 py-1 bg-green-500 text-white text-xs font-bold rounded-full" title="Has approved exit permission today">
                                                        ✓ Izin Keluar
                                                    </span>
                                                @endif
                                                @if($student->lateAttendances->count() >= 5)
                                                    <span class="px-2 py-1 bg-red-500 text-white text-xs font-bold rounded-full">
                                                        {{ $student->lateAttendances->count() }}x
                                                    </span>
                                                @elseif($student->lateAttendances->count() >= 3)
                                                    <span class="px-2 py-1 bg-yellow-500 text-white text-xs font-bold rounded-full">
                                                        {{ $student->lateAttendances->count() }}x
                                                    </span>
                                                @elseif($student->lateAttendances->count() > 0)
                                                    <span class="px-2 py-1 bg-blue-500 text-white text-xs font-bold rounded-full">
                                                        {{ $student->lateAttendances->count() }}x
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="class-show-student-meta">
                                                <span class="flex items-center gap-2">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                                    </svg>
                                                    {{ $student->student_number }}
                                                </span>
                                                <span class="flex items-center gap-2">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                    </svg>
                                                    {{ $student->gender }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('late-attendance.create', $student->id) }}" class="class-show-action-primary">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Catat Telat
                                        </a>
                                        <a href="{{ route('students.show', $student->id) }}" class="class-show-action-secondary">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            Riwayat
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-20">
                                <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <p class="text-gray-500 text-xl">Tidak ada siswa di kelas ini</p>
                            </div>
                            @endforelse
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Restore selected checkboxes from sessionStorage when page loads
        document.addEventListener('DOMContentLoaded', function() {
            const savedSelections = JSON.parse(sessionStorage.getItem('selectedStudents') || '[]');
            
            savedSelections.forEach(studentId => {
                const checkbox = document.querySelector(`.student-checkbox[value="${studentId}"]`);
                if (checkbox) {
                    checkbox.checked = true;
                }
            });
            
            updateBulkActions();
        });

        function updateBulkActions() {
            const checkboxes = document.querySelectorAll('.student-checkbox:checked');
            const count = checkboxes.length;
            const bulkButtons = document.getElementById('bulkActionButtons');
            const selectedCount = document.getElementById('selectedCount');
            
            // Save selected student IDs to sessionStorage
            const selectedIds = Array.from(checkboxes).map(cb => cb.value);
            sessionStorage.setItem('selectedStudents', JSON.stringify(selectedIds));
            
            if (count > 0) {
                bulkButtons.classList.remove('hidden');
                selectedCount.textContent = count;
            } else {
                bulkButtons.classList.add('hidden');
            }
        }

        function submitBulkSelection() {
            const checkboxes = document.querySelectorAll('.student-checkbox:checked');
            if (checkboxes.length === 0) {
                alert('Silakan pilih minimal satu siswa');
                return;
            }
            
            // Get existing form data from sessionStorage (if user is adding more students)
            const existingFormData = sessionStorage.getItem('bulkLateFormData');
            if (existingFormData) {
                document.getElementById('existingFormDataInput').value = existingFormData;
                // Clear bulkLateFormData after sending it
                sessionStorage.removeItem('bulkLateFormData');
            }
            
            // Clear selectedStudents will happen after form is submitted and we're in bulk-review page
            sessionStorage.removeItem('selectedStudents');
            document.getElementById('bulkSelectionForm').submit();
        }
    </script>
</x-app-layout>
