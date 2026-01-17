<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-blue-600 to-cyan-600 -mt-6 -mx-6 px-6 py-8 mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="font-bold text-3xl text-white leading-tight drop-shadow-lg flex items-center">
                        <svg class="w-10 h-10 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        Kirim Notifikasi Telegram
                    </h2>
                    <p class="text-blue-100 mt-2">Review dan kirim laporan keterlambatan ke grup Telegram</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-blue-50 via-cyan-50 to-teal-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Success/Error Messages -->
            @if(session('success'))
            <div class="mb-6 bg-gradient-to-r from-green-500 to-emerald-500 text-white px-6 py-4 rounded-2xl shadow-xl flex items-center">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="font-bold">{{ session('success') }}</span>
            </div>
            @endif

            @if(session('error'))
            <div class="mb-6 bg-gradient-to-r from-red-500 to-pink-500 text-white px-6 py-4 rounded-2xl shadow-xl flex items-center">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="font-bold">{{ session('error') }}</span>
            </div>
            @endif

            <!-- Info Card -->
            <div class="bg-gradient-to-r from-blue-500 to-cyan-500 rounded-3xl shadow-2xl p-8 mb-8 text-white">
                <div class="flex items-start justify-between">
                    <div class="flex items-start">
                        <div class="bg-white bg-opacity-20 rounded-full p-4 mr-6">
                            <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold mb-3">📱 Cara Menggunakan</h3>
                            <div class="space-y-2 text-blue-50">
                                <p class="flex items-center"><span class="bg-white bg-opacity-20 rounded-full w-6 h-6 flex items-center justify-center mr-3 text-sm font-bold">1</span>Centang siswa yang ingin dikirim notifikasinya</p>
                                <p class="flex items-center"><span class="bg-white bg-opacity-20 rounded-full w-6 h-6 flex items-center justify-center mr-3 text-sm font-bold">2</span>Klik tombol "Kirim ke Telegram" di bawah</p>
                                <p class="flex items-center"><span class="bg-white bg-opacity-20 rounded-full w-6 h-6 flex items-center justify-center mr-3 text-sm font-bold">3</span>Notifikasi otomatis terkirim ke grup Telegram</p>
                            </div>
                        </div>
                    </div>

                    @if(isset($sentCount) && $sentCount > 0)
                    <div class="text-center">
                        <div class="bg-white bg-opacity-20 rounded-2xl p-4 mb-3">
                            <div class="text-3xl font-black">{{ $sentCount }}</div>
                            <div class="text-xs text-blue-100">Sudah Dikirim</div>
                        </div>
                        <form method="POST" action="{{ route('telegram.reset') }}" class="inline">
                            @csrf
                            <button type="submit" onclick="return confirm('Reset semua status pengiriman hari ini?')" 
                                class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-xl text-sm shadow-lg transition-all duration-300">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Reset & Kirim Ulang
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>

            <form method="POST" action="{{ route('telegram.send') }}" id="telegramForm">
                @csrf

                <!-- Main Card -->
                <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border-2 border-blue-100">
                    <div class="bg-gradient-to-r from-blue-500 to-cyan-500 p-6">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-2xl font-bold text-white flex items-center">
                                    <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Daftar Keterlambatan Hari Ini
                                </h3>
                                <p class="text-blue-100 mt-1">{{ now()->format('l, d F Y') }}</p>
                            </div>
                            <div class="text-right">
                                <div class="text-4xl font-black text-white">{{ $lateAttendances->count() }}</div>
                                <div class="text-blue-100 text-sm">Siswa Terlambat</div>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        @if($lateAttendances->isEmpty())
                        <div class="text-center py-20">
                            <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            @if(isset($sentCount) && $sentCount > 0)
                                <p class="text-gray-500 text-xl font-bold">✅ Semua Data Sudah Dikirim ke Telegram!</p>
                                <p class="text-gray-400 mt-2">{{ $sentCount }} siswa sudah dinotifikasi</p>
                                <form method="POST" action="{{ route('telegram.reset') }}" class="inline mt-4">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Reset untuk kirim ulang?')" 
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-6 rounded-xl shadow-lg transition-all duration-300">
                                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                        Reset & Kirim Ulang
                                    </button>
                                </form>
                            @else
                                <p class="text-gray-500 text-xl font-bold">🎉 Tidak Ada Siswa yang Telat Hari Ini!</p>
                                <p class="text-gray-400 mt-2">Semua siswa datang tepat waktu</p>
                            @endif
                        </div>
                        @else
                        <!-- Select All Checkbox -->
                        <div class="mb-4 p-4 bg-gradient-to-r from-gray-50 to-blue-50 rounded-2xl border-2 border-blue-200">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" id="selectAll" class="w-6 h-6 text-blue-600 rounded-lg border-2 border-gray-300 focus:ring-blue-500">
                                <span class="ml-3 text-lg font-bold text-gray-800">Pilih Semua ({{ $lateAttendances->count() }} siswa)</span>
                            </label>
                        </div>

                        <!-- List of Students -->
                        <div class="space-y-3">
                            @foreach($lateAttendances as $attendance)
                            <div class="bg-gradient-to-r from-white to-gray-50 rounded-2xl p-6 shadow-lg border-2 border-gray-100 hover:border-blue-300 transition-all duration-300">
                                <div class="flex items-center">
                                    <!-- Checkbox -->
                                    <input type="checkbox" name="attendance_ids[]" value="{{ $attendance->id }}" 
                                        class="attendance-checkbox w-6 h-6 text-blue-600 rounded-lg border-2 border-gray-300 focus:ring-blue-500 mr-4">
                                    
                                    <!-- Avatar -->
                                    <div class="bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl p-4 w-16 h-16 flex items-center justify-center shadow-lg mr-4">
                                        <span class="text-2xl font-black text-white">{{ strtoupper(substr($attendance->student->name, 0, 1)) }}</span>
                                    </div>

                                    <!-- Student Info -->
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-3 mb-1">
                                            <h4 class="text-xl font-bold text-gray-900">{{ $attendance->student->name }}</h4>
                                            @if($attendance->student->lateAttendances->count() >= 5)
                                                <span class="px-3 py-1 bg-red-500 text-white text-xs font-bold rounded-full animate-pulse">
                                                    🚨 {{ $attendance->student->lateAttendances->count() }}x
                                                </span>
                                            @elseif($attendance->student->lateAttendances->count() >= 3)
                                                <span class="px-3 py-1 bg-yellow-500 text-white text-xs font-bold rounded-full">
                                                    ⚠️ {{ $attendance->student->lateAttendances->count() }}x
                                                </span>
                                            @endif
                                        </div>
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-sm text-gray-600">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                </svg>
                                                {{ $attendance->schoolClass->name }}
                                            </span>
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ date('H:i', strtotime($attendance->arrival_time)) }}
                                            </span>
                                            <span class="flex items-center col-span-2">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                                </svg>
                                                {{ $attendance->lateReason->reason }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    <!-- Footer Actions -->
                    @if(!$lateAttendances->isEmpty())
                    <div class="bg-gradient-to-r from-gray-50 to-blue-50 p-6 border-t-4 border-blue-200">
                        <div class="flex items-center justify-between">
                            <div class="text-gray-700">
                                <p class="text-sm">Siswa dipilih: <span id="selectedCount" class="font-bold text-blue-600 text-lg">0</span></p>
                            </div>
                            <div class="flex items-center space-x-3">
                                <button type="submit" class="group relative bg-gradient-to-r from-blue-500 via-cyan-500 to-teal-500 hover:from-blue-600 hover:via-cyan-600 hover:to-teal-600 text-white font-black py-4 px-10 rounded-2xl text-xl shadow-2xl transform hover:scale-105 transition-all duration-300 flex items-center disabled:opacity-50 disabled:cursor-not-allowed" id="sendButton" disabled>
                                    <svg class="w-7 h-7 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                    <span>Kirim ke Telegram</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </form>

        </div>
    </div>

    <script>
        // Select All functionality
        document.getElementById('selectAll')?.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.attendance-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateSelectedCount();
        });

        // Update count on individual checkbox change
        document.querySelectorAll('.attendance-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectedCount);
        });

        function updateSelectedCount() {
            const checkedBoxes = document.querySelectorAll('.attendance-checkbox:checked');
            const count = checkedBoxes.length;
            document.getElementById('selectedCount').textContent = count;
            document.getElementById('sendButton').disabled = count === 0;
        }

        // Initialize count
        updateSelectedCount();
    </script>
</x-app-layout>
