<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Walas Dashboard - Class Management') }}
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

            <!-- Security Notice -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-6">
                <div class="flex items-center mb-2">
                    <svg class="w-6 h-6 text-yellow-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <h3 class="text-lg font-bold text-yellow-800">🔐 Strict Access Control</h3>
                </div>
                <p class="text-yellow-700">
                    Each class requires password verification for every access. No session persistence - maximum security for shared accounts.
                </p>
            </div>

            <!-- Classes with Pending Requests -->
            <div class="bg-white rounded-lg shadow-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-6">
                        📋 Classes with Pending Exit Permission Requests
                    </h3>
                    
                    @if($classesWithRequests->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($classesWithRequests as $class)
                                <div class="bg-gray-50 rounded-lg p-6 border-l-4 border-yellow-400">
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <h4 class="text-lg font-bold text-gray-800">{{ $class->name }}</h4>
                                            <p class="text-sm text-gray-600">{{ $class->grade }} - {{ $class->major }}</p>
                                        </div>
                                        <span class="bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                            {{ $class->exit_permissions_count }} Pending
                                        </span>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <span class="inline-flex items-center text-blue-600 text-sm font-medium">
                                            🔐 Password Required
                                        </span>
                                    </div>
                                    
                                    <div class="flex gap-2">
                                        <a href="{{ route('walas.verify-password', $class->id) }}" 
                                           class="flex-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center">
                                            🔐 Access Class
                                        </a>
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
</x-app-layout>