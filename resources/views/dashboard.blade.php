<x-app-layout>
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-6 py-8 space-y-6">
        
        <!-- Welcome Section -->
        <div class="bg-white rounded-3xl shadow-md p-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-black text-gray-900 mb-2" style="font-family: 'Poppins', sans-serif;">Selamat Datang, Admin!</h1>
                <p class="text-sm text-gray-500 leading-relaxed" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                 Mari kita mulai mencatat siswa yang datang terlambat hari ini. <br>
Semua data tersimpan rapi dan mudah diperiksa kapan saja.
                </p>
            </div>
            <div class="hidden md:block">
                <img src="{{ asset('images/din.png') }}" alt="Illustration" class="object-contain drop-shadow-2xl" style="width: 240px; height: 240px;">
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Card 1: Telat Hari Ini -->
            <div class="card-primary rounded-2xl shadow-lg p-6 relative overflow-hidden">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="text-white text-xs font-bold uppercase tracking-wider mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 700;">TELAT HARI INI</div>
                        <div class="text-white font-black mb-1" style="font-family: 'Poppins', sans-serif; font-size: 4rem; line-height: 1;">{{ $stats['total_late_today'] }}</div>
                        <div class="text-white text-xs" style="font-family: 'Poppins', sans-serif; font-weight: 400;">Siswa terlambat</div>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-3">
                        <img src="{{ asset('images/jam.png') }}" alt="Clock" class="w-16 h-16 object-contain"  style="width: 100px; height: 100px;">
                    </div>
                </div>
            </div>

            <!-- Card 2: Telat Bulan Ini -->
            <div class="card-primary rounded-2xl shadow-lg p-6 relative overflow-hidden">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="text-white text-xs font-bold uppercase tracking-wider mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 700;">TELAT BULAN INI</div>
                        <div class="text-white font-black mb-1" style="font-family: 'Poppins', sans-serif; font-size: 4rem; line-height: 1;">{{ $stats['total_late_this_month'] }}</div>
                        <div class="text-white text-xs" style="font-family: 'Poppins', sans-serif; font-weight: 400;">Siswa terlambat</div>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-3">
                        <img src="{{ asset('images/stat.png') }}" alt="Stats" class="w-16 h-16 object-contain" style="width: 100px; height: 100px;">
                    </div>
                </div>
            </div>

            <!-- Card 3: Menunggu Approval -->
            @if(auth()->user()->isAdmin() || auth()->user()->isTeacher())
            <div class="card-primary rounded-2xl shadow-lg p-6 relative overflow-hidden">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="text-white text-xs font-bold uppercase tracking-wider mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 700;">MENUNGGU APPROVAL</div>
                        <div class="text-white font-black mb-1" style="font-family: 'Poppins', sans-serif; font-size: 4rem; line-height: 1;">{{ $stats['pending_count'] }}</div>
                        <div class="text-white text-xs" style="font-family: 'Poppins', sans-serif; font-weight: 400;">Izin keluar perlu approval</div>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-3">
                        <img src="{{ asset('images/alert.png') }}" alt="Alert" class="w-16 h-16 object-contain" style="width: 130px; height: 100px;">
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Menu Cepat -->
        <div class="bg-white rounded-2xl shadow-md overflow-hidden">
            <div class="header-primary px-6 py-4">
                <h3 class="text-white font-bold text-lg" style="font-family: 'Poppins', sans-serif; font-weight: 700;">Menu cepat</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @if(!Auth::user()->isWalas())
                    <!-- Catat Telat -->
                    <a href="{{ route('classes.index') }}" class="card-primary rounded-2xl p-6 flex flex-col items-center justify-center text-center transition-all transform hover:scale-105 shadow-lg hover:opacity-90">
                        <div class="bg-purple-500/30 rounded-full p-3 mb-3">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h4 class="text-white font-bold text-sm mb-1" style="font-family: 'Poppins', sans-serif; font-weight: 700;">Catat Telat</h4>
                        <p class="text-white/80 text-xs" style="font-family: 'Poppins', sans-serif; font-weight: 400;">Rekam keterlambatan siswa</p>
                    </a>

                    @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                    <!-- Input Kehadiran -->
                    <a href="{{ route('student-absences.create') }}" class="card-primary rounded-2xl p-6 flex flex-col items-center justify-center text-center transition-all transform hover:scale-105 shadow-lg hover:opacity-90">
                        <div class="bg-purple-500/30 rounded-full p-3 mb-3">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                        </div>
                        <h4 class="text-white font-bold text-sm mb-1" style="font-family: 'Poppins', sans-serif; font-weight: 700;">Input Kehadiran</h4>
                        <p class="text-white/80 text-xs" style="font-family: 'Poppins', sans-serif; font-weight: 400;">Catat kehadiran siswa</p>
                    </a>
                    @endif
                    @endif

                    <!-- Izin Keluar -->
                    <a href="{{ route('exit-permissions.index') }}" class="card-primary rounded-2xl p-6 flex flex-col items-center justify-center text-center transition-all transform hover:scale-105 shadow-lg hover:opacity-90">
                        <div class="bg-purple-500/30 rounded-full p-3 mb-3">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                        </div>
                        <h4 class="text-white font-bold text-sm mb-1" style="font-family: 'Poppins', sans-serif; font-weight: 700;">Izin Keluar</h4>
                        <p class="text-white/80 text-xs" style="font-family: 'Poppins', sans-serif; font-weight: 400;">Kelola izin keluar siswa</p>
                    </a>

                    @if(Auth::user()->isAdmin() || Auth::user()->isTeacher() || Auth::user()->isWalas() || Auth::user()->isHomeroomTeacher())
                    <!-- Kelola Data Siswa -->
                    <a href="{{ route('admin.students.index') }}" class="card-primary rounded-2xl p-6 flex flex-col items-center justify-center text-center transition-all transform hover:scale-105 shadow-lg hover:opacity-90">
                        <div class="bg-purple-500/30 rounded-full p-3 mb-3">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <h4 class="text-white font-bold text-sm mb-1" style="font-family: 'Poppins', sans-serif; font-weight: 700;">Kelola Data Siswa</h4>
                        <p class="text-white/80 text-xs" style="font-family: 'Poppins', sans-serif; font-weight: 400;">Manajemen data siswa</p>
                    </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Top 5 Siswa Sering Telat -->
        <div class="bg-white rounded-2xl shadow-md overflow-hidden">
            <div class="header-primary px-6 py-4">
                <h3 class="text-white font-bold text-lg" style="font-family: 'Poppins', sans-serif; font-weight: 700;">Top 5 Siswa Sering Telat</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">NAMA SISWA</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">KELAS</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">JUMLAH</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">STATUS</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">ACTION</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($stats['top_late_students'] as $student)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $student->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 uppercase">{{ $student->schoolClass->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">{{ $student->late_attendances_count }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($student->late_attendances_count >= 5)
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">Warning</span>
                                @elseif($student->late_attendances_count >= 3)
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">Warning</span>
                                @else
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600">Normal</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('students.show', $student->id) }}" class="text-gray-500 hover:text-[#231591] font-medium transition">View Details</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">No late attendance records found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Classes with Most Late Arrivals -->
        @if(auth()->user()->isAdmin() || auth()->user()->isTeacher())
        <div class="bg-white rounded-2xl shadow-md overflow-hidden">
            <div class="header-primary px-6 py-4">
                <h3 class="text-white font-bold text-lg" style="font-family: 'Poppins', sans-serif; font-weight: 700;">Classes with Most Late Arrivals</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">CLASS NAME</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">TOTAL LATE</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($stats['classes_with_most_late'] as $class)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 uppercase">{{ $class->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">{{ $class->late_attendances_count }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="px-6 py-8 text-center text-sm text-gray-500">No late attendance records found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>

</x-app-layout>
