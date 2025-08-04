@extends('layouts.app')

@section('content')
@php use Illuminate\Support\Facades\Storage; @endphp
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm border border-gray-200 rounded-lg overflow-hidden">
            <!-- Header -->
            <div class="px-6 py-8 bg-gradient-to-r from-blue-50 to-indigo-50">
                <div class="flex items-center space-x-6">
                    <!-- Profile Photo -->
                    <div class="flex-shrink-0">
                        @if($user->photo_path)
                            <img class="h-24 w-24 rounded-full object-cover border-4 border-white shadow-lg"
                                 src="{{ Storage::url($user->photo_path) }}"
                                 alt="{{ $user->full_name ?? $user->name }}">
                        @else
                            <div class="h-24 w-24 rounded-full bg-gray-300 flex items-center justify-center border-4 border-white shadow-lg">
                                <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Profile Info -->
                    <div class="flex-1 min-w-0">
                        <h1 class="text-2xl font-bold text-gray-900">
                            @if($hasFullAccess)
                                {{ $user->full_name ?? $user->name }}
                            @else
                                {{ explode(' ', $user->full_name ?? $user->name)[0] }}
                            @endif
                        </h1>
                        @if($user->relationship_intent)
                            <p class="text-sm text-gray-600 mt-1">
                                {{ $user->relationship_intent->label() }}
                            </p>
                        @endif
                        @if($isOwnProfile)
                            <div class="mt-4">
                                <a href="{{ route('profile.edit') }}"
                                   class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 py-2 px-3 cursor-pointer">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit Profile
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Profile Details -->
            <div class="px-6 py-6">
                @if($hasFullAccess)
                    <!-- Full Profile Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Full Name Card -->
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0">
                                    <svg class="size-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Full Name</h3>
                                    <p class="text-sm text-gray-900 font-medium">{{ $user->full_name ?? $user->name }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Email Card -->
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0">
                                    <svg class="size-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                        <polyline points="22,6 12,13 2,6"></polyline>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Email</h3>
                                    <p class="text-sm text-gray-900 font-medium">{{ $user->email }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- WhatsApp Card -->
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0">
                                    <svg class="size-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">WhatsApp Number</h3>
                                    <p class="text-sm text-gray-900 font-medium">{{ $user->whatsapp_number ?? 'Not provided' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Age Card -->
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0">
                                    <svg class="size-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12,6 12,12 16,14"></polyline>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Age</h3>
                                    <p class="text-sm text-gray-900 font-medium">{{ $user->age ?? 'Not specified' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Gender Card -->
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0">
                                    <svg class="size-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="4"></circle>
                                        <path d="M16 8v5a3 3 0 0 0 6 0v-5a4 4 0 1 0-8 8 3 3 0 0 0 0-6 4 4 0 1 0-8-8v5a3 3 0 0 0 6 0V8"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Gender</h3>
                                    <p class="text-sm text-gray-900 font-medium">
                                        {{ $user->gender?->label() ?? 'Not specified' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Sexual Preference Card -->
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0">
                                    <svg class="size-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Sexual Preference</h3>
                                    <p class="text-sm text-gray-900 font-medium">
                                        {{ $user->sexual_preference?->label() ?? 'Not specified' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- What are you looking for Card -->
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0">
                                    <svg class="size-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">What are you looking for?</h3>
                                    <p class="text-sm text-gray-900 font-medium">
                                        {{ $user->relationship_intent?->label() ?? 'Not specified' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        @if($isOwnProfile)
                            <!-- Account Status Card -->
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0">
                                        <svg class="size-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M9 12l2 2 4-4"></path>
                                            <path d="M21 12c.552 0 1-.448 1-1V5c0-.552-.448-1-1-1H3c-.552 0-1 .448-1 1v6c0 .552.448 1 1 1h18z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-500">Account Status</h3>
                                        <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium {{ $user->status->value === 'active' ? 'bg-teal-100 text-teal-800' : 'bg-red-100 text-red-800' }}">
                                            <span class="size-1.5 inline-block rounded-full {{ $user->status->value === 'active' ? 'bg-teal-800' : 'bg-red-800' }}"></span>
                                            {{ $user->status->label() }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @else
                    <!-- Public Profile Information -->
                    <div class="text-center py-8">
                        <div class="max-w-md mx-auto">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <h3 class="mt-4 text-sm font-medium text-gray-900">Limited Profile Access</h3>
                            <p class="mt-2 text-sm text-gray-500">
                                Connect with {{ explode(' ', $user->full_name ?? $user->name)[0] }} to see their full profile information.
                                You can see their basic information and relationship intent.
                            </p>

                            @if(!$isOwnProfile)
                                <div class="mt-6">
                                    <button type="button"
                                            class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 py-2 px-4 cursor-pointer">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        Send Connection Request
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
