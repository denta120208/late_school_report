<x-app-layout>
    <x-slot name="header">
        <div class="late-attendance-hero -mt-6 -mx-6 px-6 py-8 mb-6 shadow-lg">
            <div class="max-w-7xl mx-auto late-attendance-hero-inner">
                <h2 class="font-bold text-3xl md:text-4xl text-white leading-tight">
                    {{ __('Profile') }}
                </h2>
                <p class="late-attendance-hero-subtitle mt-2 text-sm md:text-base">
                    Kelola informasi akun dan keamanan anda
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 min-h-screen late-attendance-bg">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 late-attendance-card">
                <div class="max-w-xl text-gray-900">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 late-attendance-card">
                <div class="max-w-xl text-gray-900">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 late-attendance-card">
                <div class="max-w-xl text-gray-900">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
