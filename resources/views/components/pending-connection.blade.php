<div class="relative">
    <div class="aspect-4/4 overflow-hidden rounded-2xl">
        @if($connectionUser->getMainProfileImagePath())
            <img class="size-full object-cover rounded-2xl" src="{{ Storage::url($connectionUser->getMainProfileImagePath()) }}" alt="{{ $connectionUser->name }}">
        @else
            <div class="size-full bg-gray-300 rounded-2xl flex items-center justify-center dark:bg-neutral-700">
                <svg class="w-16 h-16 text-gray-500 dark:text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
        @endif
    </div>

    <div class="pt-4">
        <h3 class="font-medium md:text-lg text-black dark:text-white">
            {{ $connectionUser->name }}
        </h3>

        <p class="mt-2 text-sm text-black dark:text-white">
        </p>
    </div>

    <a class="after:absolute after:inset-0 after:z-1" href="{{ route('users.show', $connectionUser->slug) }}"></a>
</div>

<div class="mb-2 mt-4 text-sm">
    <!-- List -->
    <div class="flex flex-col">
        <!-- Item -->
        <div class="py-3 border-t border-gray-200 dark:border-neutral-700">
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <span class="font-medium text-black dark:text-white">Looking for</span>
                </div>
                <div class="text-end">
                    <span class="text-black dark:text-white">
                        {{ $connectionUser->relationship_intent->label() }}
                    </span>
                </div>
            </div>
        </div>
        <!-- End Item -->

        <!-- Item -->
        <div class="py-3 border-t border-gray-200 dark:border-neutral-700">
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <span class="font-medium text-black dark:text-white">Age</span>
                </div>
                <div class="text-end">
                    <span class="text-black dark:text-white">
                        {{ $connectionUser->age }}
                    </span>
                </div>
            </div>
        </div>
        <!-- End Item -->
    </div>
    <!-- End List -->
</div>
