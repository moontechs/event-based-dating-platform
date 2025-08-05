@extends('layouts.app')

@section('title', 'My Matches')

@section('content')
@php use Illuminate\Support\Facades\Storage; @endphp
<div class="min-h-screen dark:bg-neutral-900">
    <!-- People List -->
    <div class="max-w-7xl px-4 sm:px-6 lg:px-8 py-12 lg:py-24 mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-12">
            @forelse($matches as $match)
                @php
                    $otherUser = $match->sender_id === auth()->id() ? $match->receiver : $match->sender;
                @endphp
                @include('connections.matched-card', ['connectionUser' => $otherUser])
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="mx-auto h-16 w-16 text-gray-400 dark:text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-black dark:text-white">No matches yet</h3>
                    <p class="mt-2 text-gray-500 dark:text-neutral-400">When someone accepts your connection request, they'll appear here.</p>
                    <div class="mt-6 space-y-3">
                        <a href="{{ route('events.index') }}"
                           class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium text-nowrap rounded-xl border border-transparent bg-yellow-400 text-black hover:bg-yellow-500 focus:outline-hidden focus:bg-yellow-500 transition disabled:opacity-50 disabled:pointer-events-none cursor-pointer">
                            Browse events to meet people
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
        <!-- End Card Grid -->
    </div>
    <!-- End People List -->
</div>
@endsection
