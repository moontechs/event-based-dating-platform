@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
            Complete Your Profile
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            Please fill in the required information to get started
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow-sm border border-gray-200 rounded-lg sm:px-10">
            <form method="POST" action="{{ route('profile.setup.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Photo Upload -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Profile Photo *
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="photo" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                    <span>Upload a photo</span>
                                    <input id="photo" name="photo" type="file" class="sr-only" accept="image/*" required>
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

                <!-- Relationship Intent -->
                <div>
                    <label for="relationship_intent" class="block text-sm font-medium text-gray-700 mb-2">
                        Relationship Intent *
                    </label>
                    <select id="relationship_intent" name="relationship_intent" required
                            class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                        <option value="">Select your intent</option>
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

                <!-- Terms Acceptance -->
                <div class="flex items-center">
                    <input id="terms_accepted" name="terms_accepted" type="checkbox" required
                           {{ old('terms_accepted', $user->terms_accepted) ? 'checked' : '' }}
                           class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                    <label for="terms_accepted" class="text-sm text-gray-500 ms-3">
                        I accept the <a href="#" class="text-blue-600 decoration-2 hover:underline font-medium cursor-pointer">Terms of Service</a> *
                    </label>
                </div>
                @error('terms_accepted')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror

                <div>
                    <button type="submit"
                            class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none cursor-pointer">
                        Complete Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
