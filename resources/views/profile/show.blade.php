@extends('layouts.app')

@section('content')
@php use Illuminate\Support\Facades\Storage; @endphp
<div class="min-h-screen py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-medium text-black dark:text-white">
                        @if($hasFullAccess)
                            {{ $user->full_name ?? $user->name }}
                        @else
                            {{ $user->name }}
                        @endif
                    </h1>
                    @if($user->relationship_intent)
                        <p class="mt-2 text-sm text-gray-600 dark:text-neutral-400">
                            {{ $user->relationship_intent->label() }}
                        </p>
                    @endif
                </div>
                @if($isOwnProfile)
                    <a href="{{ route('profile.edit') }}"
                       class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-xl border border-transparent bg-yellow-400 text-black hover:bg-yellow-500 focus:outline-hidden focus:bg-yellow-500 transition cursor-pointer">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Profile
                    </a>
                @endif
            </div>
        </div>

        @include('components.profile-images', ['user' => $user, 'hasFullAccess' => $hasFullAccess, 'isOwnProfile' => $isOwnProfile])

        <div class="grid grid-cols-1 gap-8">
            <!-- Profile Information -->
            <div class="lg:col-span-2">
                <div class="overflow-hidden">
                    <div class="px-2 py-6">

                        @if($hasFullAccess)
                            <!-- Profile Information Grid -->
                            <div class="space-y-6">
                                <!-- Personal Details -->
                                <div class="pl-4">
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-neutral-400 mb-3">Personal Details</h4>
                                    <div class="grid grid-cols-1 gap-4">
                                        <div class="flex justify-between py-3 border-t border-gray-200 dark:border-neutral-700">
                                            <span class="font-medium text-black dark:text-white">Full Name:</span>
                                            <span class="text-black dark:text-white">{{ $user->full_name ?? $user->name }}</span>
                                        </div>
                                        <div class="flex justify-between py-3 border-t border-gray-200 dark:border-neutral-700">
                                            <span class="font-medium text-black dark:text-white">Age:</span>
                                            <span class="text-black dark:text-white">{{ $user->age ?? 'Not specified' }}</span>
                                        </div>
                                        <div class="flex justify-between py-3 border-t border-gray-200 dark:border-neutral-700">
                                            <span class="font-medium text-black dark:text-white">Gender:</span>
                                            <span class="text-black dark:text-white">{{ $user->gender?->label() ?? 'Not specified' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Information -->
                                <div class="pl-4">
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-neutral-400 mb-3">Contact Information</h4>
                                    <div class="grid grid-cols-1 gap-4">
                                        <div class="flex justify-between py-3 border-t border-gray-200 dark:border-neutral-700">
                                            <span class="font-medium text-black dark:text-white">WhatsApp:</span>
                                            <span class="text-black dark:text-white">{{ $user->whatsapp_number }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Preferences -->
                                <div class="pl-4">
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-neutral-400 mb-3">Preferences</h4>
                                    <div class="grid grid-cols-1 gap-4">
                                        <div class="flex justify-between py-3 border-t border-gray-200 dark:border-neutral-700">
                                            <span class="font-medium text-black dark:text-white">Sexual Preference:</span>
                                            <span class="text-black dark:text-white">{{ $user->sexual_preference?->label() ?? 'Not specified' }}</span>
                                        </div>
                                        <div class="flex justify-between py-3 border-t border-gray-200 dark:border-neutral-700">
                                            <span class="font-medium text-black dark:text-white">Looking for:</span>
                                            <span class="text-black dark:text-white">{{ $user->relationship_intent?->label() ?? 'Not specified' }}</span>
                                        </div>
                                    </div>
                                </div>

                                @if($isOwnProfile)
                                    <!-- Account Status -->
                                    <div class="pl-4">
                                        <h4 class="text-sm font-medium text-gray-500 dark:text-neutral-400 mb-3">Account Status</h4>
                                        <div class="py-3 border-t border-gray-200 dark:border-neutral-700">
                                            <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium {{ $user->status->value === 'active' ? 'bg-yellow-400 text-black' : 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400' }}">
                                                <span class="size-1.5 inline-block rounded-full {{ $user->status->value === 'active' ? 'bg-black' : 'bg-red-800 dark:bg-red-400' }}"></span>
                                                {{ $user->status->label() }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @else
                            <!-- Limited Access View -->
                            <div class="text-center py-12">
                                <svg class="mx-auto h-16 w-16 text-gray-400 dark:text-neutral-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                <h3 class="mt-6 text-lg font-medium text-black dark:text-white">Limited Profile Access</h3>
                                <p class="mt-2 text-sm text-gray-600 dark:text-neutral-400 max-w-sm mx-auto">
                                    Connect with {{ explode(' ', $user->full_name ?? $user->name)[0] }} to see their full profile information.
                                </p>

                                @if(!$isOwnProfile)
                                    <div class="mt-8">
                                        <button type="button"
                                                class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-xl border border-transparent bg-yellow-400 text-black hover:bg-yellow-500 focus:outline-hidden focus:bg-yellow-500 transition cursor-pointer">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                            Send Connection Request
                                        </button>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
@if($hasFullAccess && $user->profileImages->count() > 0)
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="max-w-4xl max-h-screen p-4">
            <div class="bg-white rounded-lg overflow-hidden">
                <div class="flex justify-between items-center p-4 border-b">
                    <h3 class="text-lg font-medium">{{ $user->full_name ?? $user->name }}'s Photos</h3>
                    <button onclick="closeImageModal()" class="text-gray-400 hover:text-gray-600 cursor-pointer">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="p-4">
                    <div class="relative">
                        <img id="modalImage" class="w-full h-auto max-h-96 object-contain rounded-lg" src="" alt="Profile photo">

                        @if($user->profileImages->count() > 1)
                            <!-- Navigation arrows -->
                            <button onclick="previousImage()" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75 cursor-pointer">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>
                            <button onclick="nextImage()" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75 cursor-pointer">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        @endif
                    </div>

                    @if($user->profileImages->count() > 1)
                        <!-- Image counter -->
                        <div class="text-center mt-4">
                            <span id="imageCounter" class="text-sm text-gray-500">1 of {{ $user->profileImages->count() }}</span>
                        </div>

                        <!-- Thumbnails -->
                        <div class="flex justify-center mt-4 space-x-2">
                            @foreach($user->profileImages as $image)
                                <img class="h-12 w-12 rounded object-cover border-2 border-transparent cursor-pointer thumbnail"
                                     src="{{ Storage::url($image->image_path) }}"
                                     alt="Thumbnail {{ $loop->index + 1 }}"
                                     onclick="showImage({{ $loop->index }})"
                                     data-index="{{ $loop->index }}">
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif

@endsection
