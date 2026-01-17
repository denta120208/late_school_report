<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-purple-600 to-blue-600 -mt-6 -mx-6 px-6 py-8 mb-6">
            <h2 class="font-bold text-3xl text-white leading-tight drop-shadow-lg">
                👋 Selamat Datang, {{ auth()->user()->name }}!
            </h2>
            <p class="text-purple-100 mt-2">{{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}</p>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-gray-50 to-blue-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Card 1: Late Today -->
                <div class="bg-gradient-to-br from-red-500 to-pink-600 rounded-2xl shadow-2xl overflow-hidden transform hover:scale-105 transition duration-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-red-100 text-sm font-medium uppercase tracking-wide">Telat Hari Ini</div>
                                <div class="mt-3 text-5xl font-black text-white drop-shadow-lg">{{ $stats['total_late_today'] }}</div>
                                <div class="mt-2 text-red-100 text-xs">siswa terlambat</div>
                            </div>
                            <div class="bg-white bg-opacity-20 rounded-full p-4">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Late This Month -->
                <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl shadow-2xl overflow-hidden transform hover:scale-105 transition duration-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-blue-100 text-sm font-medium uppercase tracking-wide">Telat Bulan Ini</div>
                                <div class="mt-3 text-5xl font-black text-white drop-shadow-lg">{{ $stats['total_late_this_month'] }}</div>
                                <div class="mt-2 text-blue-100 text-xs">total keterlambatan</div>
                            </div>
                            <div class="bg-white bg-opacity-20 rounded-full p-4">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                @if(auth()->user()->isAdmin() || auth()->user()->isTeacher())
                <!-- Card 3: Pending -->
                <div class="bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl shadow-2xl overflow-hidden transform hover:scale-105 transition duration-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-yellow-100 text-sm font-medium uppercase tracking-wide">Menunggu Approval</div>
                                <div class="mt-3 text-5xl font-black text-white drop-shadow-lg">{{ $stats['pending_count'] }}</div>
                                <div class="mt-2 text-yellow-100 text-xs">perlu ditinjau</div>
                            </div>
                            <div class="bg-white bg-opacity-20 rounded-full p-4">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden mb-8 border-2 border-purple-100">
                <div class="bg-gradient-to-r from-purple-600 to-blue-600 p-6">
                    <h3 class="text-2xl font-bold text-white flex items-center">
                        <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Menu Cepat
                    </h3>
                </div>
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Button 1: Catat Telat -->
                        <a href="{{ route('classes.index') }}" class="group relative bg-gradient-to-br from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white font-bold py-8 px-6 rounded-2xl text-center transform hover:scale-110 hover:rotate-1 transition duration-300 shadow-xl hover:shadow-2xl">
                            <div class="text-6xl mb-3">📝</div>
                            <div class="text-xl font-bold">Catat Siswa Telat</div>
                            <div class="text-sm text-red-100 mt-2">Rekam keterlambatan siswa</div>
                            <div class="absolute top-2 right-2 bg-white bg-opacity-20 rounded-full p-2 opacity-0 group-hover:opacity-100 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </div>
                        </a>

                        <!-- Button 2: Lihat Laporan -->
                        <a href="{{ route('late-attendance.index') }}" class="group relative bg-gradient-to-br from-green-500 to-teal-600 hover:from-green-600 hover:to-teal-700 text-white font-bold py-8 px-6 rounded-2xl text-center transform hover:scale-110 hover:rotate-1 transition duration-300 shadow-xl hover:shadow-2xl">
                            <div class="text-6xl mb-3">📊</div>
                            <div class="text-xl font-bold">Laporan Keterlambatan</div>
                            <div class="text-sm text-green-100 mt-2">Lihat data & statistik</div>
                            <div class="absolute top-2 right-2 bg-white bg-opacity-20 rounded-full p-2 opacity-0 group-hover:opacity-100 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </div>
                        </a>

                        @if(auth()->user()->isAdmin())
                        <!-- Button 3: Kelola Data -->
                        <a href="{{ route('admin.students.index') }}" class="group relative bg-gradient-to-br from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700 text-white font-bold py-8 px-6 rounded-2xl text-center transform hover:scale-110 hover:rotate-1 transition duration-300 shadow-xl hover:shadow-2xl">
                            <div class="text-6xl mb-3">👥</div>
                            <div class="text-xl font-bold">Kelola Data Siswa</div>
                            <div class="text-sm text-purple-100 mt-2">Admin panel</div>
                            <div class="absolute top-2 right-2 bg-white bg-opacity-20 rounded-full p-2 opacity-0 group-hover:opacity-100 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </div>
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Top Late Students -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden mb-8 border-2 border-red-100">
                <div class="bg-gradient-to-r from-red-500 to-pink-500 p-6">
                    <h3 class="text-2xl font-bold text-white flex items-center">
                        <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        Top 5 Siswa Sering Telat
                    </h3>
                    <p class="text-red-100 mt-1">Perlu perhatian khusus</p>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Class</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Late</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($stats['top_late_students'] as $student)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $student->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student->schoolClass->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $student->late_attendances_count }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($student->late_attendances_count >= 5)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Parent Notification
                                            </span>
                                        @elseif($student->late_attendances_count >= 3)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Warning
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Normal
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('students.show', $student->id) }}" class="text-blue-600 hover:text-blue-900">View Details</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No late attendance records found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @if(auth()->user()->isAdmin() || auth()->user()->isTeacher())
            <!-- Classes with Most Late Arrivals -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Classes with Most Late Arrivals</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Class Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Late</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($stats['classes_with_most_late'] as $class)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $class->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $class->late_attendances_count }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500">No late attendance records found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
