<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-red-600 to-pink-600 -mt-6 -mx-6 px-6 py-8 mb-6">
            <h2 class="font-bold text-3xl text-white leading-tight drop-shadow-lg flex items-center">
                <svg class="w-10 h-10 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Catat Siswa yang Telat
            </h2>
            <p class="text-red-100 mt-2">Pilih kelas untuk melihat daftar siswa</p>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-red-50 via-pink-50 to-orange-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Quick Action Buttons -->
            <div class="mb-8 flex justify-between items-center">
                <div>
                    <h3 class="text-2xl font-bold text-gray-800">📝 Pencatatan Keterlambatan</h3>
                    <p class="text-gray-600 mt-1">Pilih metode pencatatan yang sesuai</p>
                </div>
                <a href="{{ route('late-attendance.multi-create') }}" class="group relative bg-gradient-to-r from-purple-500 via-pink-500 to-red-500 hover:from-purple-600 hover:via-pink-600 hover:to-red-600 text-white font-black py-4 px-8 rounded-2xl text-lg shadow-2xl transform hover:scale-105 transition-all duration-300 flex items-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span>Catat Multi-Siswa</span>
                    <div class="absolute top-0 left-0 right-0 bottom-0 bg-white opacity-0 group-hover:opacity-20 rounded-2xl transition-opacity duration-300"></div>
                </a>
            </div>

            <!-- Info Card -->
            <div class="bg-gradient-to-r from-blue-500 to-cyan-500 rounded-3xl shadow-2xl p-8 mb-8 text-white">
                <div class="flex items-start">
                    <div class="bg-white bg-opacity-20 rounded-full p-4 mr-6">
                        <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-2xl font-bold mb-3">📋 Dua Cara Mencatat Keterlambatan</h3>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="bg-white bg-opacity-10 rounded-xl p-4 backdrop-blur-sm">
                                <h4 class="font-bold text-lg mb-2 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    Multi-Siswa (Cepat)
                                </h4>
                                <p class="text-blue-100 text-sm">✅ Catat banyak siswa sekaligus<br>✅ Hemat waktu untuk pencatatan massal<br>✅ Klik tombol "Catat Multi-Siswa" di atas</p>
                            </div>
                            <div class="bg-white bg-opacity-10 rounded-xl p-4 backdrop-blur-sm">
                                <h4 class="font-bold text-lg mb-2 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Per-Siswa Individual
                                </h4>
                                <p class="text-blue-100 text-sm">✅ Catat satu per satu siswa<br>✅ Detail per kelas<br>✅ Pilih kelas di bawah → klik "Catat Telat"</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Classes Grid -->
            <div class="mb-4">
                <h3 class="text-3xl font-bold text-gray-800 mb-2">🏫 Daftar Kelas</h3>
                <p class="text-gray-600">Klik kartu kelas untuk melihat daftar siswa</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($classes as $class)
                <a href="{{ route('classes.show', $class->id) }}" class="group relative block bg-white rounded-3xl shadow-xl hover:shadow-2xl transform hover:scale-105 hover:-rotate-1 transition-all duration-300 overflow-hidden border-4 border-transparent hover:border-red-400">
                    <!-- Gradient Background -->
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-400 via-pink-400 to-red-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    
                    <!-- Content -->
                    <div class="relative p-8">
                        <!-- Class Icon -->
                        <div class="bg-gradient-to-br from-red-500 to-pink-600 rounded-2xl p-4 w-20 h-20 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        
                        <!-- Class Name -->
                        <h5 class="mb-3 text-3xl font-black text-gray-900 group-hover:text-white transition-colors duration-300">
                            {{ $class->name }}
                        </h5>
                        
                        <!-- Description -->
                        <p class="font-medium text-gray-600 group-hover:text-white transition-colors duration-300 mb-4">
                            {{ $class->description }}
                        </p>
                        
                        <!-- Student Count Badge -->
                        <div class="flex items-center justify-between">
                            <div class="bg-gradient-to-r from-blue-500 to-cyan-500 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                {{ $class->students->count() }} Siswa
                            </div>
                            
                            <!-- Arrow Icon -->
                            <div class="bg-white bg-opacity-0 group-hover:bg-opacity-20 rounded-full p-2 transition-all duration-300">
                                <svg class="w-6 h-6 text-gray-400 group-hover:text-white transform group-hover:translate-x-2 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Shine Effect -->
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-0 group-hover:opacity-20 transform -skew-x-12 group-hover:translate-x-full transition-all duration-1000"></div>
                </a>
                @endforeach
            </div>

            @if($classes->isEmpty())
            <div class="text-center py-20 bg-white rounded-3xl shadow-xl">
                <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
                <p class="text-gray-500 text-xl">Tidak ada kelas yang tersedia</p>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
