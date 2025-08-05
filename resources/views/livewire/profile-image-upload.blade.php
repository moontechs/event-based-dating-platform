@php use Illuminate\Support\Facades\Storage; @endphp
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-lg font-medium text-black dark:text-white">
                Profile Photos
            </h3>
            <p class="text-sm text-gray-600 dark:text-neutral-400">
                Upload {{ config('profile.images.count.min') }} - {{ config('profile.images.count.max') }} photos to showcase yourself ({{ $this->totalImages }}/{{ config('profile.images.count.max') }} uploaded).
            </p>
        </div>
    </div>

    <!-- Success Message -->
    @if(session()->has('image-success'))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 dark:bg-green-900/20 dark:border-green-800">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800 dark:text-green-200">
                        {{ session('image-success') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Validation Messages -->
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 dark:bg-red-900/20 dark:border-red-800">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800 dark:text-red-200">
                        Please fix the following errors:
                    </h3>
                    <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Existing Images Grid -->
    @if($this->user->profileImages->count() > 0)
        <div class="grid md:grid grid-cols-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 gap-8 lg:gap-12">
            @foreach($this->user->profileImages as $image)
                @if(!in_array($image->id, $deletedImages))
                    <div class="group flex flex-col">
                        <div class="relative">
                            <div class="aspect-4/4 overflow-hidden rounded-2xl">
                                <img class="size-full object-cover rounded-2xl" loading="lazy"
                                     src="{{ Storage::url($image->image_path) }}"
                                     alt="{{ $this->user->full_name }}">

                                <!-- Main Badge -->
                                <div class="absolute top-2 left-2 @if($this->mainImageId != $image->id) hidden @endif">
                                        <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-yellow-400 text-black">
                                            <span class="size-1.5 inline-block rounded-full bg-black"></span>
                                            Main
                                        </span>
                                </div>

                                <!-- Action Buttons -->
                                <div class="absolute inset-0 bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                                    <div class="flex gap-2">
                                        @if(!$image->is_main && $this->mainImageId != $image->id)
                                            <button type="button" wire:click="setMainImage({{ $image->id }})"
                                                    class="size-8 flex justify-center items-center bg-yellow-400 text-black rounded-full hover:bg-yellow-500 focus:outline-hidden focus:bg-yellow-500 transition cursor-pointer"
                                                    title="Set as main">
                                                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </button>
                                        @endif
                                        <button type="button" wire:click="removeExistingImage({{ $image->id }})"
                                                class="size-8 flex justify-center items-center bg-red-500 text-white rounded-full hover:bg-red-600 focus:outline-hidden focus:bg-red-600 transition cursor-pointer"
                                                title="Remove photo">
                                            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-4">
                                <h3 class="font-medium md:text-lg text-black dark:text-white"></h3>
                                <p class="mt-2 text-sm text-black dark:text-white"></p>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif

    <!-- New Images Preview -->
    @if(count($this->tempImages) > 0)
        <div>
            <h4 class="text-sm font-medium text-gray-700 dark:text-neutral-300 mb-3">New Photos Preview</h4>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($this->tempImages as $index => $tempImage)
                    <div class="group flex flex-col">
                        <div class="relative">
                            <div class="aspect-4/4 overflow-hidden rounded-2xl">
                                <img class="size-full object-cover rounded-2xl" loading="lazy"
                                     src="{{ $tempImage['preview'] }}"
                                     alt="New photo preview">

                                <!-- New Badge -->
                                <div class="absolute top-2 left-2">
                                    <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-blue-500 text-white">
                                        <span class="size-1.5 inline-block rounded-full bg-white"></span>
                                        New
                                    </span>
                                </div>

                                <!-- Action Buttons -->
                                <!-- Remove Button -->
                                <div class="absolute inset-0 bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                                    <button type="button" wire:click="removeNewImage({{ $index }})"
                                            class="size-8 flex justify-center items-center bg-red-500 text-white rounded-full hover:bg-red-600 focus:outline-hidden focus:bg-red-600 transition cursor-pointer"
                                            title="Remove photo">
                                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="pt-4">
                                <h3 class="font-medium md:text-lg text-black dark:text-white"></h3>
                                <p class="mt-2 text-sm text-black dark:text-white"></p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Add New Photos -->
    @if($this->canAddMore)
        <div class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="group relative">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <button type="button"
                            onclick="this.closest('.group').querySelector('input[type=file]').click()"
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium text-nowrap rounded-xl border border-transparent bg-yellow-400 text-black hover:bg-yellow-500 focus:outline-hidden focus:bg-yellow-500 transition disabled:opacity-50 disabled:pointer-events-none cursor-pointer"
                        >
                            Click to upload photos
                        </button>
                        <p class="text-xs text-gray-400 dark:text-neutral-500">PNG, JPG up to 10MB</p>
                    </div>
                    <input type="file" wire:model="newImagesBuffer"
                           multiple
                           accept="image/*"
                           class="hidden">
                </div>
            </div>
        </div>
    @endif

    <!-- Loading States -->
    <div wire:loading wire:target="newImagesBuffer" class="text-center py-4">
        <div class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:outline-none focus:ring-gray-200 focus:text-blue-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700">
            <svg aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-gray-200 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#1C64F2"/>
            </svg>
            Processing images...
        </div>
    </div>

    @if($this->totalImages >= config('profile.images.count.max'))
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 dark:bg-blue-900/20 dark:border-blue-800">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">
                        Maximum photos reached
                    </h3>
                    <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                        <p>You've reached the maximum of {{ config('profile.images.count.max') }} photos. Remove existing photos to add new ones.</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
