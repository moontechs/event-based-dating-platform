@extends('layouts.app')

@section('title', 'Incoming Requests')

@section('content')
@php use Illuminate\Support\Facades\Storage; @endphp
<div class="min-h-screen dark:bg-neutral-900">
    <!-- People List -->
    <div class="max-w-7xl px-4 sm:px-6 lg:px-8 py-12 lg:py-12 mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-12">
            @forelse($incomingRequests as $request)
                @include('connections.incoming-pending-card', ['connectionUser' => $request->sender])
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="mx-auto h-16 w-16 text-gray-400 dark:text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-black dark:text-white">No incoming requests</h3>
                    <p class="mt-2 text-gray-500 dark:text-neutral-400">You don't have any pending connection requests at the moment.</p>
                    <div class="mt-6">
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
