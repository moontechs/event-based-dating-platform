@extends('layouts.app')

@section('title', 'Incoming Requests')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Incoming Requests</h1>
            <p class="mt-2 text-gray-600">People who want to connect with you</p>
        </div>

        <!-- Incoming Requests List -->
        <div class="bg-white rounded-lg shadow-sm border">
            <div class="p-6">
                @forelse($incomingRequests as $request)
                    <div class="flex items-center justify-between p-6 border border-gray-200 rounded-lg mb-4 last:mb-0 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center space-x-4">
                            @if($request->sender->photo_path)
                                <a href="{{ route('users.show', $request->sender->slug) }}">
                                    <img src="{{ Storage::url($request->sender->photo_path) }}"
                                         alt="{{ $request->sender->name }}"
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
                                <a href="{{ route('users.show', $request->sender->slug) }}">
                                    <div class="flex items-center space-x-3">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $request->sender->name }}</h3>
                                        @if($request->sender->relationship_intent)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $request->sender->relationship_intent->label() }}
                                            </span>
                                        @endif
                                    </div>
                                </a>
                                <div class="flex items-center space-x-2 mt-1">
                                    Age
                                </div>
                            </div>
                        </div>
                        <div class="flex space-x-3">
                            <form method="POST" action="{{ route('connections.accept', $request->sender) }}" class="inline">
                                @csrf
                                <button type="submit"
                                        class="text-xs py-1 px-2 rounded-md border border-blue-300 text-blue-600 hover:bg-blue-50 transition-colors duration-200 cursor-pointer disabled:opacity-50">
                                    Connect
                                </button>
                            </form>
                            <form method="POST" action="{{ route('connections.reject', $request->sender) }}" class="inline">
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">No incoming requests</h3>
                        <p class="mt-2 text-gray-500">You don't have any pending connection requests at the moment.</p>
                        <div class="mt-6">
                            <a href="{{ route('events.index') }}"
                               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="mr-2 -ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Browse Events
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
