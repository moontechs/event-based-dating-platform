@php use Illuminate\Support\Facades\Storage; @endphp
<div class="min-h-screen py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <form wire:submit="save">
            <!-- Profile Photos Section -->
            <div class="lg:col-span-2">
                <div class="overflow-hidden">
                    <div class="px-6 py-6">
                        @livewire('profile-image-upload', ['user' => auth()->user()])
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                <!-- Profile Information Form -->
                <div class="lg:col-span-1">
                    <div class="overflow-hidden">
                        <div class="px-6 py-6">
                            <h3 class="text-lg font-medium text-black dark:text-white mb-4">
                                Profile Information
                            </h3>

                            <div class="space-y-6">
                                <!-- Full Name -->
                                <div>
                                    <label for="full_name" class="block text-sm font-medium text-black dark:text-white mb-2">
                                        Full Name *
                                    </label>
                                    <input id="full_name" wire:model="full_name" type="text" autocomplete="name" required autofocus
                                           class="py-3 px-4 block w-full border-gray-200 rounded-xl text-sm focus:border-yellow-400 focus:ring-yellow-400 dark:bg-neutral-800 dark:border-neutral-600 dark:text-white dark:focus:border-yellow-400">
                                    @error('full_name')
                                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email (Read-only) -->
                                <div>
                                    <label for="email" class="block text-sm font-medium text-black dark:text-white mb-2">
                                        Email Address
                                    </label>
                                    <input id="email" type="email" value="{{ $email }}" readonly
                                           class="py-3 px-4 block w-full border-gray-200 rounded-xl text-sm bg-gray-50 text-gray-500 cursor-not-allowed dark:bg-neutral-700 dark:border-neutral-600 dark:text-neutral-400">
                                    <p class="text-xs text-gray-500 dark:text-neutral-400 mt-2">Email cannot be changed after registration</p>
                                </div>

                                <!-- WhatsApp Number -->
                                <div>
                                    <label for="whatsapp_number" class="block text-sm font-medium text-black dark:text-white mb-2">
                                        WhatsApp Number *
                                    </label>
                                    <input id="whatsapp_number" wire:model="whatsapp_number" type="tel" required
                                           placeholder="+1234567890"
                                           class="py-3 px-4 block w-full border-gray-200 rounded-xl text-sm focus:border-yellow-400 focus:ring-yellow-400 dark:bg-neutral-800 dark:border-neutral-600 dark:text-white dark:focus:border-yellow-400">
                                    <p class="text-xs text-gray-500 dark:text-neutral-400 mt-2">For display purposes only</p>
                                    @error('whatsapp_number')
                                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Age -->
                                <div>
                                    <label for="age" class="block text-sm font-medium text-black dark:text-white mb-2">
                                        Age *
                                    </label>
                                    <input id="age" wire:model="age" type="number" min="18" max="100" required
                                           class="py-3 px-4 block w-full border-gray-200 rounded-xl text-sm focus:border-yellow-400 focus:ring-yellow-400 dark:bg-neutral-800 dark:border-neutral-600 dark:text-white dark:focus:border-yellow-400">
                                    @error('age')
                                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Gender -->
                                <div>
                                    <label for="gender" class="block text-sm font-medium text-black dark:text-white mb-2">
                                        Gender *
                                    </label>
                                    <select id="gender" wire:model="gender" required
                                            class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-xl text-sm focus:border-yellow-400 focus:ring-yellow-400 dark:bg-neutral-800 dark:border-neutral-600 dark:text-white dark:focus:border-yellow-400">
                                        <option value="">Select your gender</option>
                                        @foreach($genders as $genderOption)
                                            <option value="{{ $genderOption->value }}">
                                                {{ $genderOption->label() }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('gender')
                                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Sexual Preference -->
                                <div>
                                    <label for="sexual_preference" class="block text-sm font-medium text-black dark:text-white mb-2">
                                        Sexual Preference *
                                    </label>
                                    <select id="sexual_preference" wire:model="sexual_preference" required
                                            class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-xl text-sm focus:border-yellow-400 focus:ring-yellow-400 dark:bg-neutral-800 dark:border-neutral-600 dark:text-white dark:focus:border-yellow-400">
                                        <option value="">Select your preference</option>
                                        @foreach($sexualPreferences as $preference)
                                            <option value="{{ $preference->value }}">
                                                {{ $preference->label() }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('sexual_preference')
                                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Relationship Intent -->
                                <div>
                                    <label for="relationship_intent" class="block text-sm font-medium text-black dark:text-white mb-2">
                                        What are you looking for? *
                                    </label>
                                    <select id="relationship_intent" wire:model="relationship_intent" required
                                            class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-xl text-sm focus:border-yellow-400 focus:ring-yellow-400 dark:bg-neutral-800 dark:border-neutral-600 dark:text-white dark:focus:border-yellow-400">
                                        <option value="">Select what you're looking for</option>
                                        @foreach($relationshipIntents as $intent)
                                            <option value="{{ $intent->value }}">
                                                {{ $intent->label() }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('relationship_intent')
                                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Success Message -->
                                @if(session()->has('success'))
                                    <div class="bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-xl">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <!-- Action Buttons -->
                                <div class="flex items-center justify-end gap-x-3 pt-6 border-t border-gray-200 dark:border-neutral-700">
                                    <button type="submit"
                                            class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-xl border border-transparent bg-yellow-400 text-black hover:bg-yellow-500 focus:outline-hidden focus:bg-yellow-500 transition cursor-pointer">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Save Changes
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
