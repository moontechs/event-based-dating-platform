<div>
    <div class="relative">
        <div class="aspect-4/4 overflow-hidden rounded-2xl">
            <img class="size-full object-cover rounded-2xl"
                 src="{{ Storage::url($this->user->getMainProfileImagePath()) }}"
                 alt="{{ $this->user->full_name }}"
            >
        </div>

        <div class="pt-4">
            <h3 class="font-medium md:text-lg text-black dark:text-white">
            </h3>

            <p class="mt-2 text-sm text-black dark:text-white">
            </p>
        </div>
    </div>

    <div class="grid md:grid grid-cols-3 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-8 lg:gap-12">
        @if($this->hasFullAccess && $this->user->profileImages->count() > 1)
            @foreach($this->user->profileImages->where('is_main', false)->take(6) as $image)
                <div class="group flex flex-col">
                    <div class="relative">
                        <div class="aspect-4/4 overflow-hidden rounded-2xl">
                            <img class="size-full object-cover rounded-2xl" loading="lazy"
                                 src="{{ Storage::url($image->image_path) }}"
                                 alt="{{ $this->user->full_name }}">
                        </div>
                        <div class="pt-4">
                            <h3 class="font-medium md:text-lg text-black dark:text-white"></h3>
                            <p class="mt-2 text-sm text-black dark:text-white"></p>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
