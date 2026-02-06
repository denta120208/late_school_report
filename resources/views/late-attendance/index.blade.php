<x-app-layout>
    <x-slot name="header">
        <div class="late-attendance-hero -mt-6 -mx-6 px-6 py-8 mb-6 shadow-lg">
            <div class="max-w-7xl mx-auto late-attendance-hero-inner">
                <h2 class="font-bold text-3xl md:text-4xl text-white leading-tight">
                    Laporan Keterlambatan Kehadiran
                </h2>
                <p class="late-attendance-hero-subtitle mt-2 text-sm md:text-base">
                    Pantau dan kelola catatan keterlambatan siswa
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 min-h-screen late-attendance-bg">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 walas-alert walas-alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Filters -->
            <div class="late-attendance-card mb-6">
                <div class="late-attendance-card-body">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Filters</h3>
                    <form method="GET" action="{{ route('late-attendance.index') }}" class="late-attendance-filters-grid">
                        <!-- Search -->
                        <div>
                            <label for="search" class="block text-sm mb-2 late-attendance-label">Siswa</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                placeholder="Student name..." 
                                class="late-attendance-input text-sm">
                        </div>

                        <!-- Class Filter -->
                        <div>
                            <label for="class_id" class="block text-sm mb-2 late-attendance-label">Kelas</label>
                            <select name="class_id" id="class_id" class="late-attendance-input text-sm">
                                <option value="">All Classes</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date Filter -->
                        <div>
                            <label for="date" class="block text-sm mb-2 late-attendance-label">Tanggal</label>
                            <input type="date" name="date" id="date" value="{{ request('date') }}" 
                                class="late-attendance-input text-sm">
                        </div>

                        <!-- Buttons -->
                        <div class="late-attendance-filter-actions">
                            <button type="submit" class="late-attendance-primary-btn">
                                Apply Filters
                            </button>
                            <a href="{{ route('late-attendance.index') }}" class="late-attendance-secondary-btn">
                                Clear Filters
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Results Table -->
            <div class="late-attendance-card">
                <div class="late-attendance-card-header">
                    <div class="flex items-center justify-between late-attendance-toolbar">
                        <h3 class="late-attendance-card-title text-base md:text-lg">
                            CATATAN KEHADIRAN TERLAMBAT
                        </h3>
                    </div>
                </div>

                <div class="late-attendance-card-body">
                    
                    <div class="overflow-x-auto">
                        <table class="late-attendance-table">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Class</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Arrival Time</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reason</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Recorded By</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($lateAttendances as $attendance)
                                <tr class="late-attendance-table-row">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $attendance->late_date->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <a href="{{ route('students.show', $attendance->student_id) }}" class="late-attendance-link">
                                            {{ $attendance->student->name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $attendance->schoolClass->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ date('H:i', strtotime($attendance->arrival_time)) }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $attendance->lateReason->reason }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $attendance->recordedBy->name ?? 'N/A' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">No late attendance records found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $lateAttendances->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-refresh halaman setiap 30 detik untuk update data real-time
        setInterval(function() {
            // Hanya refresh jika tidak ada form yang sedang di-submit atau input yang aktif
            if (!document.querySelector('form:target') && document.activeElement.tagName !== 'INPUT' && document.activeElement.tagName !== 'SELECT') {
                // Simpan scroll position
                const scrollPosition = window.scrollY;
                
                // Refresh halaman
                window.location.reload();
                
                // Restore scroll position setelah reload
                setTimeout(() => {
                    window.scrollTo(0, scrollPosition);
                }, 100);
            }
        }, 30000); // 30 detik

        // Tambahkan visual indicator untuk auto-refresh
        let countdown = 30;
        const updateCountdown = () => {
            const indicator = document.getElementById('refresh-indicator');
            if (indicator) {
                indicator.textContent = `Auto-refresh dalam ${countdown}s`;
                countdown--;
                if (countdown < 0) countdown = 30;
            }
        };

        // Buat indicator elemen
        document.addEventListener('DOMContentLoaded', function() {
            const header = document.querySelector('.late-attendance-toolbar');
            if (header) {
                const indicator = document.createElement('div');
                indicator.id = 'refresh-indicator';
                indicator.className = 'text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded';
                indicator.textContent = 'Auto-refresh dalam 30s';
                header.appendChild(indicator);
                
                // Update countdown setiap detik
                setInterval(updateCountdown, 1000);
            }
        });

        // Pause auto-refresh ketika user sedang mengisi form
        let pauseRefresh = false;
        document.addEventListener('focusin', function(e) {
            if (e.target.tagName === 'INPUT' || e.target.tagName === 'SELECT') {
                pauseRefresh = true;
            }
        });

        document.addEventListener('focusout', function(e) {
            setTimeout(() => {
                pauseRefresh = false;
            }, 1000);
        });
    </script>
</x-app-layout>
