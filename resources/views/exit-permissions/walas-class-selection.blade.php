<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Exit Permissions - Class Selection') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Info Banner -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-blue-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <h3 class="font-semibold text-blue-800">Shared Walas Account - Class Access Control</h3>
                        <p class="text-blue-600 text-sm mt-1">
                            Select a class below to view and manage exit permission requests. Each class requires its unique password for access.
                        </p>
                    </div>
                </div>
            </div>


            <!-- All Classes -->
            <div class="bg-white rounded-lg shadow-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-6">
                        📚 All Classes - Select to Manage Exit Permissions
                    </h3>
                    
                    @if($classesWithRequests->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($classesWithRequests as $class)
                                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow border-gray-200 bg-gray-50">
                                    
                                    <!-- Class Header -->
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <h4 class="text-lg font-bold text-gray-800">{{ $class->name }}</h4>
                                            <p class="text-sm text-gray-600">{{ $class->grade }} - {{ $class->major }}</p>
                                            @if($class->description)
                                                <p class="text-xs text-gray-500 mt-1">{{ $class->description }}</p>
                                            @endif
                                        </div>
                                        @if($class->exit_permissions_count > 0)
                                            <span class="bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                                {{ $class->exit_permissions_count }} Pending
                                            </span>
                                        @else
                                            <span class="bg-gray-300 text-gray-600 text-xs font-bold px-2 py-1 rounded-full">
                                                No Requests
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <!-- Security Status -->
                                    <div class="mb-4">
                                        <div class="flex items-center text-blue-600 text-sm font-medium">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                            </svg>
                                            🔐 Password Required
                                        </div>
                                    </div>
                                    
                                    <!-- Action Buttons -->
                                    <div class="flex gap-2">
                                        <button onclick="showPasswordModal({{ $class->id }}, '{{ $class->name }}')" 
                                                class="flex-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                                            🔐 Access Class
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-gray-400 text-6xl mb-4">📭</div>
                            <h4 class="text-xl font-bold text-gray-600 mb-2">No Pending Requests</h4>
                            <p class="text-gray-500">All exit permission requests have been processed.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Password Modal -->
    <div id="passwordModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-800">🔐 Class Password Required</h3>
                    <button onclick="hidePasswordModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Security Warning -->
                <div class="mb-4 p-3 bg-yellow-50 border border-yellow-200 rounded">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-yellow-700 text-sm font-medium">Enter the password for <span id="modalClassName"></span></span>
                    </div>
                </div>

                <form id="unlockForm" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Class Password
                        </label>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Enter class password"
                               required
                               autofocus>
                        <p class="text-xs text-gray-500 mt-1">Only authorized homeroom teachers should have access to this password.</p>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" 
                                onclick="hidePasswordModal()"
                                class="px-4 py-2 text-gray-600 hover:text-gray-800 font-medium">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                            🔐 Access Class
                        </button>
                    </div>
                </form>
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