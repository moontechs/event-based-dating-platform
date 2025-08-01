@extends('layouts.app')

@section('title', 'Sent Requests')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Sent Requests</h1>
            <p class="mt-2 text-gray-600">Connection requests you've sent that are still pending</p>
        </div>

        <!-- Sent Requests List -->
        <div class="bg-white rounded-lg shadow-sm border">
            <div class="p-6">
                @forelse($sentRequests as $request)
                    <div class="flex items-center justify-between p-6 border border-gray-200 rounded-lg mb-4 last:mb-0 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center space-x-4">
                            @if($request->receiver->photo_path)
                                <a href="{{ route('users.show', $request->receiver->slug) }}">
                                    <img src="{{ Storage::url($request->receiver->photo_path) }}"
                                         alt="{{ $request->receiver->name }}"
                                         class="w-16 h-16 rounded-full object-cover">
                                </a>
                            @else
                                <div class="w-16 h-16 bg-gray-300 rounded-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            @endif
                            <div class="flex-1">
                                <a href="{{ route('users.show', $request->receiver->slug) }}">
                                    <div class="flex items-center space-x-3">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $request->receiver->name }}</h3>
                                        @if($request->receiver->relationship_intent)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $request->receiver->relationship_intent->label() }}
                                            </span>
                                        @endif
                                    </div>
                                </a>
                                <div class="flex items-center space-x-2 mt-1">
                                    Age
                                </div>
                            </div>
                        </div>
                        <div>
                            <form method="POST" action="{{ route('connections.cancel', $request->receiver) }}" class="inline">
                                @csrf
                                <button type="submit"
                                        class="text-xs py-1 px-2 rounded-md border border-orange-300 text-orange-600 hover:bg-orange-50 transition-colors duration-200 cursor-pointer disabled:opacity-50">
                                    Cancel
                                </button>
                            </form>
{{--                            <form action="{{ route('connections.cancel', $request) }}" method="POST" class="inline">--}}
{{--                                @csrf--}}
{{--                                @method('PATCH')--}}
{{--                                <button type="submit"--}}
{{--                                        onclick="return confirm('Are you sure you want to cancel this connection request?')"--}}
{{--                                        class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">--}}
{{--                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>--}}
{{--                                    </svg>--}}
{{--                                    Cancel--}}
{{--                                </button>--}}
{{--                            </form>--}}
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">No sent requests</h3>
                        <p class="mt-2 text-gray-500">You haven't sent any connection requests yet.</p>
                        <div class="mt-6">
                            <a href="{{ route('events.index') }}"
                               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="mr-2 -ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Browse Events to Meet People
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
