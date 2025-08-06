@extends('layouts.app')

@section('content')
@php use Illuminate\Support\Facades\Storage; @endphp
<div class="min-h-screen">
    <!-- Hero -->
    <div class="px-4 sm:px-6 lg:px-8 ">
        <div class="h-120 md:h-[40dvh] flex flex-col bg-cover bg-center bg-no-repeat rounded-2xl"
             @if($event->image_path)
                 style="background-image: url('{{ Storage::url($event->image_path) }}')"
             @endif
        >
            <div class="mt-auto w-2/3 md:max-w-lg ps-5 pb-5 md:ps-10 md:pb-10">
                <h1 class="text-xl md:text-3xl lg:text-5xl text-white">
                    {{ $event->title }}
                </h1>
            </div>
        </div>
    </div>
    <!-- End Hero -->

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="max-w-7xl px-4 sm:px-6 lg:px-8 py-12 lg:py-12 mx-auto">
            <!-- Event Details List -->
            <div class="mb-2 mt-4 text-sm">
                <div class="flex flex-col">
                    <!-- Date & Time -->
                    <div class="py-3 border-t border-gray-200 dark:border-neutral-700">
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <span class="font-medium text-black dark:text-white">Date & Time</span>
                            </div>
                            <div class="text-end">
                                        <span class="text-black dark:text-white">
                                            {{ $event->local_date_time->format('M j, Y') }}<br>
                                            {{ $event->local_date_time->format('g:i A') }} {{ $event->formatted_timezone }}
                                        </span>
                            </div>
                        </div>
                    </div>

                    <!-- Location -->
                    <div class="py-3 border-t border-gray-200 dark:border-neutral-700">
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <span class="font-medium text-black dark:text-white">Location</span>
                            </div>
                            <div class="text-end">
                                <span class="text-black dark:text-white">{{ $event->city }}, {{ $event->country }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Category -->
                    <div class="py-3 border-t border-gray-200 dark:border-neutral-700">
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <span class="font-medium text-black dark:text-white">Category</span>
                            </div>
                            <div class="text-end">
                                <span class="text-black dark:text-white">{{ $event->category->name }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Attendees -->
                    <div class="py-3 border-t border-gray-200 dark:border-neutral-700">
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <span class="font-medium text-black dark:text-white">Attendees</span>
                            </div>
                            <div class="text-end">
                                <span class="text-black dark:text-white">{{ $statistics['total_attendees'] }} people</span>
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="py-3 border-t border-gray-200 dark:border-neutral-700">
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <span class="font-medium text-black dark:text-white">Status</span>
                            </div>
                            <div class="text-end">
                                    <span class="text-black dark:text-white">
                                        @if($statistics['is_past_event'])
                                            Past Event
                                        @elseif($statistics['is_future_event'])
                                            Upcoming Event
                                        @else
                                            Happening Now
                                        @endif
                                    </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @livewire('toggle-attendance', ['event' => $event, 'statistics' => $statistics])
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 prose">
        {!! $event->description !!}
    </div>

    @auth
        @livewire('attendees-list', ['event' => $event])
    @endif
</div>

@endsection
