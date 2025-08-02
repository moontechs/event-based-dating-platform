<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @if($events->count() > 0)
        <!-- Events Grid -->
        <div class="max-w-7xl px-4 sm:px-6 lg:px-8 py-12 lg:py-24 mx-auto">
            <!-- Card Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-12">
                @foreach($events as $event)
                    <!-- Card -->
                    <div class="group flex flex-col">
                        <div class="relative">
                            <div class="aspect-4/4 overflow-hidden rounded-2xl">
                                <img class="size-full object-cover rounded-2xl"
                                     loading="lazy"
                                     src="{{ Storage::url($event->image_path) }}"
                                     alt="{{ $event->title }}"
                                >
                            </div>

                            <div class="pt-4">
                                <h3 class="font-medium md:text-lg text-black dark:text-white">
                                    {{ $event->title }}
                                </h3>

                                <p class="mt-2 font-semibold text-black dark:text-white">
                                </p>
                            </div>

                            <a class="after:absolute after:inset-0 after:z-1" href="{{ route('events.show', $event) }}"></a>
                        </div>

                        <div class="mb-2 mt-4 text-sm">
                            <!-- List -->
                            <div class="flex flex-col">
                                <!-- Item -->
                                <div class="py-3 border-t border-gray-200 dark:border-neutral-700">
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <span class="font-medium text-black dark:text-white">{{ $event->local_date_time->format('M d, Y') }}</span>
                                        </div>

                                        <div class="text-end">
                                            <span class="text-black dark:text-white">{{ $event->city }}, {{ $event->country }}</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Item -->
                            </div>
                            <!-- End List -->
                        </div>

                        {{--                            <div class="mt-auto">--}}
                        {{--                                <a class="py-2 px-3 w-full inline-flex justify-center items-center gap-x-2 text-sm font-medium text-nowrap rounded-xl border border-transparent bg-yellow-400 text-black hover:bg-yellow-500 focus:outline-hidden focus:bg-yellow-500 transition disabled:opacity-50 disabled:pointer-events-none"--}}
                        {{--                                   href="{{ route('events.show', $event) }}"--}}
                        {{--                                >--}}
                        {{--                                    View Details--}}
                        {{--                                </a>--}}
                        {{--                            </div>--}}
                    </div>
                @endforeach
            </div>
        </div>


        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $events->links() }}
        </div>
    @else
    @endif
</div>
