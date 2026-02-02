<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Class Password Required: ') }} {{ $class->name }}
            </h2>
            <a href="{{ route('walas.dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Password Form -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-6">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-bold text-yellow-800">🔐 Class Password Required</h3>
                                <p class="text-yellow-700 mt-1">
                                    This class requires password authentication to access exit permission requests.
                                </p>
                            </div>
                        </div>

                        <!-- Show validation errors -->
                        @if ($errors->any())
                            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('walas.verify-password.store', $class->id) }}">
                            @csrf
                            
                            <div class="mb-4">
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Class Password
                                </label>
                                <input type="password" 
                                       id="password" 
                                       name="password" 
                                       class="mt-1 block w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-purple-500 focus:ring-2 focus:ring-purple-200 text-lg"
                                       placeholder="Enter class password"
                                       required 
                                       autofocus>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <button type="submit" 
                                        class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-xl transition duration-200">
                                    🔓 Access Class
                                </button>
                                
                                <a href="{{ route('walas.dashboard') }}" 
                                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-xl transition duration-200">
                                    Cancel
                                </a>
                            </div>
                        </form>
                        
                        <div class="mt-4 text-xs text-gray-600">
                            <p class="font-semibold">Important Security Notes:</p>
                            <ul class="list-disc list-inside mt-1 space-y-1">
                                <li>Password is required for every class access</li>
                                <li>No session persistence - password required on page reload</li>
                                <li>Access is granted only for this specific navigation</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>