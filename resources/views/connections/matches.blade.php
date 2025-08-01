@extends('layouts.app')

@section('title', 'My Matches')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">My Matches</h1>
            <p class="mt-2 text-gray-600">People you're connected with</p>
        </div>

        <!-- Matches List -->
        <div class="bg-white rounded-lg shadow-sm border">
            <div class="p-6">
                @forelse($matches as $match)
                    @php
                        $otherUser = $match->sender_id === auth()->id() ? $match->receiver : $match->sender;
                    @endphp
                    <div class="flex items-center justify-between p-6 border border-gray-200 rounded-lg mb-4 last:mb-0 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center space-x-4">
                            @if($otherUser->photo_path)
                                <a href="{{ route('users.show', $otherUser->slug) }}">
                                    <img src="{{ Storage::url($otherUser->photo_path) }}"
                                         alt="{{ $otherUser->full_name }}"
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
                                <a href="{{ route('users.show', $otherUser->slug) }}">
                                    <div class="flex items-center space-x-3">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $otherUser->full_name }}</h3>
                                        @if($otherUser->relationship_intent)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $otherUser->relationship_intent->label() }}
                                        </span>
                                        @endif
                                    </div>
                                </a>
                                <div class="flex items-center space-x-2 mt-1">
                                    Age
                                </div>
                                <div class="flex items-center space-x-2 mt-1">
{{--                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">--}}
{{--                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>--}}
{{--                                        </svg>--}}
{{--                                        Matched--}}
{{--                                    </span>--}}
{{--                                    <span class="text-sm text-gray-600">• {{ $match->updated_at->diffForHumans() }}</span>--}}
                                </div>
                                @if($otherUser->whatsapp_number)
                                    <p class="text-sm text-gray-600 mt-1">
                                        WhatsApp: {{ $otherUser->whatsapp_number }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="flex space-x-3">
                            <form method="POST" action="{{ route('connections.reject', $otherUser) }}" class="inline">
                                @csrf
                                <button type="submit"
                                        class="text-xs py-1 px-2 rounded-md border border-orange-300 text-orange-600 hover:bg-orange-50 transition-colors duration-200 cursor-pointer disabled:opacity-50">
                                    Reject
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">No matches yet</h3>
                        <p class="mt-2 text-gray-500">When someone accepts your connection request, they'll appear here.</p>
                        <div class="mt-6 space-y-3">
                            <a href="{{ route('events.index') }}"
                               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="mr-2 -ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Browse Events
                            </a>
                            <div class="text-center">
                                <a href="{{ route('connections.incoming') }}" class="text-sm text-blue-600 hover:text-blue-800">
                                    Check your incoming requests →
                                </a>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
