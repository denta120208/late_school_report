<x-app-layout>
    <x-slot name="header">
        <div class="walas-selection-hero -mt-6 -mx-6 px-6 py-8">
            <div class="max-w-7xl mx-auto walas-selection-hero-inner">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 class="font-bold text-3xl md:text-4xl text-white leading-tight">
                            Pilih Kelas (Walas)
                        </h2>
                        <p class="walas-selection-subtitle mt-2 text-sm md:text-base">
                            Masukkan password untuk mengakses permohonan izin keluar per kelas
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8 min-h-screen exit-permissions-bg walas-selection-page">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-6 walas-alert walas-alert-success">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 walas-alert walas-alert-error">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Info Banner -->
            <div class="walas-info-card mb-6">
                <div class="flex items-start">
                    <svg class="w-5 h-5 mr-3" style="color:#160B6A" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <h3 class="walas-info-title">Akses Kelas Walas (Shared Account)</h3>
                        <p class="walas-info-text text-sm mt-1">
                            Pilih kelas di bawah untuk melihat dan mengelola permohonan izin keluar. Setiap kelas memiliki password unik.
                        </p>
                    </div>
                </div>
            </div>



            <!-- All Classes -->
            <div class="walas-section-card">
                <div class="walas-section-header">
                    📚 Daftar Kelas
                </div>
                <div class="walas-section-body">
                    
                    @if($classesWithRequests->count() > 0)
                        <div class="walas-grid">
                            @foreach($classesWithRequests as $class)
                                <div class="walas-class-card">
                                    <div class="walas-class-card-body">
                                    
                                    <!-- Class Header -->
                                    <div class="flex justify-between items-start mb-4 gap-3">
                                        <div>
                                            <h4 class="walas-class-title">{{ $class->name }}</h4>
                                            <p class="walas-class-meta text-sm mt-1">{{ $class->grade }} - {{ $class->major }}</p>
                                            @if($class->description)
                                                <p class="walas-class-desc text-xs mt-2">{{ $class->description }}</p>
                                            @endif
                                        </div>
                                        @if($class->exit_permissions_count > 0)
                                            <span class="walas-badge walas-badge-pending">
                                                {{ $class->exit_permissions_count }} Pending
                                            </span>
                                        @else
                                            <span class="walas-badge walas-badge-empty">
                                                No Requests
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <!-- Security Status -->
                                    <div class="mb-4">
                                        <div class="flex items-center walas-security-text">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                            </svg>
                                            🔐 Password Diperlukan
                                        </div>
                                    </div>
                                    
                                    <!-- Action Buttons -->
                                    <div class="flex gap-2">
                                        <button onclick="showPasswordModal({{ $class->id }}, '{{ $class->name }}')" 
                                                class="flex-1 walas-primary-btn text-sm">
                                            🔐 Access Class
                                        </button>
                                    </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="walas-empty">
                            <div style="font-size:56px; margin-bottom:12px; opacity:0.55">📭</div>
                            <h4 class="text-xl font-bold" style="color: rgba(17,24,39,0.72); margin-bottom:6px;">No Pending Requests</h4>
                            <p style="color: rgba(17,24,39,0.55)">All exit permission requests have been processed.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Password Modal -->
    <div id="passwordModal" class="walas-modal-overlay hidden">
        <div class="walas-modal-wrap">
            <div class="walas-modal">
                <div class="walas-modal-header">
                    <h3 class="walas-modal-title">🔐 Class Password Required</h3>
                    <button onclick="hidePasswordModal()" class="walas-modal-close" type="button">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="walas-modal-body">
                    <div class="walas-modal-hint">
                        Enter the password for <span id="modalClassName"></span>
                    </div>

                    <form id="unlockForm" method="POST">
                        @csrf
                        <div style="margin-top:14px">
                            <label for="password" class="walas-modal-label">Class Password</label>
                            <input type="password"
                                   id="password"
                                   name="password"
                                   class="walas-modal-input"
                                   placeholder="Enter class password"
                                   required
                                   autofocus>
                            <p class="walas-modal-footnote">Only authorized homeroom teachers should have access to this password.</p>
                        </div>

                        <div class="walas-modal-actions">
                            <button type="button" onclick="hidePasswordModal()" class="walas-modal-cancel">Cancel</button>
                            <button type="submit" class="walas-modal-submit">🔐 Access Class</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showPasswordModal(classId, className) {
            document.getElementById('modalClassName').textContent = className;
            document.getElementById('unlockForm').action = `/walas/classes/${classId}/verify-password`;
            document.getElementById('passwordModal').classList.remove('hidden');
            document.getElementById('password').focus();
        }

        function hidePasswordModal() {
            document.getElementById('passwordModal').classList.add('hidden');
            document.getElementById('password').value = '';
        }

        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                hidePasswordModal();
            }
        });

        // Close modal when clicking outside
        document.getElementById('passwordModal').addEventListener('click', function(e) {
            if (e.target === this) {
                hidePasswordModal();
            }
        });
    </script>
</x-app-layout>