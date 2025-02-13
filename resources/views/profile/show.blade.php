<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Your Profile') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <!-- Header Section with Gradient Background -->
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-6">
                    <div class="flex items-center">
                        @if(Auth::user()->profile_photo_path)
                            <img class="h-20 w-20 rounded-full border-4 border-white mr-4 object-cover"
                                src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }} Profile Photo">
                        @else
                            <img class="h-20 w-20 rounded-full border-4 border-white mr-4 object-cover"
                                src="{{ asset('default-profile-photo.png') }}"
                                alt="{{ Auth::user()->name }} Profile Photo">
                        @endif
                        <div>
                            <h3 class="text-white text-3xl font-bold">{{ Auth::user()->name }}</h3>
                            <p class="text-white text-lg">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>
                <!-- Details Section -->
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <span class="block text-sm font-medium text-gray-500">Role</span>
                            <span class="mt-1 block text-xl text-gray-800">{{ Auth::user()->role ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="block text-sm font-medium text-gray-500">Member Since</span>
                            <span
                                class="mt-1 block text-xl text-gray-800">{{ Auth::user()->created_at->format('F d, Y') }}</span>
                        </div>
                        <!-- Additional details can be added here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
