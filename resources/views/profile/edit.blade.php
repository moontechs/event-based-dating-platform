@extends('layouts.app')

@section('content')
@php use Illuminate\Support\Facades\Storage; @endphp
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm border border-gray-200 rounded-lg">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h1 class="text-xl font-semibold text-gray-900">Edit Profile</h1>
                    <a href="{{ route('profile.show') }}"
                       class="text-sm text-gray-500 hover:text-gray-700 cursor-pointer">
                        ← Back to Profile
                    </a>
                </div>
            </div>

            <!-- Form -->
            <div class="px-6 py-6">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Current Photo & Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Profile Photo
                        </label>

                        <!-- Current Photo Display -->
                        @if($user->photo_path)
                            <div class="mb-6 flex flex-col items-center">
                                <img class="h-32 w-32 rounded-full object-cover border-4 border-gray-300 shadow-lg"
                                     src="{{ Storage::url($user->photo_path) }}"
                                     alt="Current profile photo">
                                <div class="mt-3">
                                    <span class="text-sm text-gray-600">Current photo</span>
                                </div>
                            </div>
                        @endif

                        <!-- Photo Upload -->
                        <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="photo" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>{{ $user->photo_path ? 'Change photo' : 'Upload a photo' }}</span>
                                        <input id="photo" name="photo" type="file" class="sr-only" accept="image/*">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                            </div>
                        </div>
                        @error('photo')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Full Name -->
                    <div>
                        <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Full Name *
                        </label>
                        <input id="full_name" name="full_name" type="text" autocomplete="name" required
                               value="{{ old('full_name', $user->full_name) }}"
                               class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                        @error('full_name')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email (Read-only) -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Address
                        </label>
                        <input id="email" name="email" type="email" value="{{ $user->email }}" readonly
                               class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm bg-gray-50 text-gray-500 cursor-not-allowed disabled:opacity-50 disabled:pointer-events-none">
                        <p class="text-xs text-gray-500 mt-2">Email cannot be changed after registration</p>
                    </div>

                    <!-- WhatsApp Number -->
                    <div>
                        <label for="whatsapp_number" class="block text-sm font-medium text-gray-700 mb-2">
                            WhatsApp Number *
                        </label>
                        <input id="whatsapp_number" name="whatsapp_number" type="tel" required
                               value="{{ old('whatsapp_number', $user->whatsapp_number) }}"
                               placeholder="+1234567890"
                               class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                        <p class="text-xs text-gray-500 mt-2">For display purposes only</p>
                        @error('whatsapp_number')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Age -->
                    <div>
                        <label for="age" class="block text-sm font-medium text-gray-700 mb-2">
                            Age *
                        </label>
                        <input id="age" name="age" type="number" min="18" max="100" required
                               value="{{ old('age', $user->age) }}"
                               class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                        @error('age')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Gender -->
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">
                            Gender *
                        </label>
                        <select id="gender" name="gender" required
                                class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                            <option value="">Select your gender</option>
                            @foreach($genders as $gender)
                                <option value="{{ $gender->value }}"
                                        {{ old('gender', $user->gender?->value) === $gender->value ? 'selected' : '' }}>
                                    {{ $gender->label() }}
                                </option>
                            @endforeach
                        </select>
                        @error('gender')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sexual Preference -->
                    <div>
                        <label for="sexual_preference" class="block text-sm font-medium text-gray-700 mb-2">
                            Sexual Preference *
                        </label>
                        <select id="sexual_preference" name="sexual_preference" required
                                class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                            <option value="">Select your preference</option>
                            @foreach($sexualPreferences as $preference)
                                <option value="{{ $preference->value }}"
                                        {{ old('sexual_preference', $user->sexual_preference?->value) === $preference->value ? 'selected' : '' }}>
                                    {{ $preference->label() }}
                                </option>
                            @endforeach
                        </select>
                        @error('sexual_preference')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- What are you looking for -->
                    <div>
                        <label for="relationship_intent" class="block text-sm font-medium text-gray-700 mb-2">
                            What are you looking for? *
                        </label>
                        <select id="relationship_intent" name="relationship_intent" required
                                class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                            <option value="">Select what you're looking for</option>
                            @foreach($relationshipIntents as $intent)
                                <option value="{{ $intent->value }}"
                                        {{ old('relationship_intent', $user->relationship_intent?->value) === $intent->value ? 'selected' : '' }}>
                                    {{ $intent->label() }}
                                </option>
                            @endforeach
                        </select>
                        @error('relationship_intent')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end gap-x-2 pt-4 border-t border-gray-200">
                        <a href="{{ route('profile.show') }}"
                           class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-300 bg-white text-gray-800 hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none cursor-pointer">
                            Cancel
                        </a>
                        <button type="submit"
                                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none cursor-pointer">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
