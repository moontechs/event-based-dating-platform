@extends('layouts.app')

@section('content')
@php use Illuminate\Support\Facades\Storage; @endphp
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Search Events</h1>
                    <p class="mt-2 text-sm text-gray-600">
                        Find events that match your interests and location
                    </p>
                </div>

                <!-- Back Button -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('events.index') }}"
                       class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 py-2 px-4 cursor-pointer">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Back to Events
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Section -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <form method="GET" action="{{ route('events.search') }}" class="space-y-4">
                <!-- Main Search -->
                <div class="flex space-x-4">
                    <div class="flex-1">
                        <label for="q" class="sr-only">Search events</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text"
                                   name="q"
                                   id="q"
                                   value="{{ $query ?? request('q') }}"
                                   placeholder="Search events by title, description, location..."
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                   autofocus>
                        </div>
                    </div>
                    <button type="submit"
                            class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 py-3 px-6 cursor-pointer">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Search
                    </button>
                </div>

                <!-- Advanced Filters -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Category Filter -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select name="category" id="category"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm cursor-pointer">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ (request('category') == $category->id) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- City Filter -->
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                        <select name="city" id="city"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm cursor-pointer">
                            <option value="">All Cities</option>
                            @foreach($cities as $city)
                                <option value="{{ $city }}" {{ (request('city') === $city) ? 'selected' : '' }}>
                                    {{ $city }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Country Filter -->
                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                        <select name="country" id="country"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm cursor-pointer">
                            <option value="">All Countries</option>
                            @foreach($countries as $country)
                                <option value="{{ $country }}" {{ (request('country') === $country) ? 'selected' : '' }}>
                                    {{ $country }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Clear Filters -->
                    <div class="flex items-end">
                        @if(request()->hasAny(['category', 'city', 'country']))
                            <a href="{{ route('events.search', ['q' => $query]) }}"
                               class="block w-full text-center py-2 px-4 text-sm font-medium rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 cursor-pointer">
                                Clear Filters
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Search Suggestions -->
                <div class="flex flex-wrap gap-2">
                    <span class="text-sm text-gray-500">Try searching for:</span>
                    <button type="button"
                            onclick="document.getElementById('q').value='networking'; this.closest('form').submit();"
                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 hover:bg-gray-200 cursor-pointer">
                        networking
                    </button>
                    <button type="button"
                            onclick="document.getElementById('q').value='social meetup'; this.closest('form').submit();"
                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 hover:bg-gray-200 cursor-pointer">
                        social meetup
                    </button>
                    <button type="button"
                            onclick="document.getElementById('q').value='food'; this.closest('form').submit();"
                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 hover:bg-gray-200 cursor-pointer">
                        food
                    </button>
                    <button type="button"
                            onclick="document.getElementById('q').value='sports'; this.closest('form').submit();"
                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 hover:bg-gray-200 cursor-pointer">
                        sports
                    </button>
                    <button type="button"
                            onclick="document.getElementById('q').value='arts'; this.closest('form').submit();"
                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 hover:bg-gray-200 cursor-pointer">
                        arts
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Search Results -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(isset($query) && $query)
            @if($events && $events->count() > 0)
                <!-- Results Summary -->
                <div class="mb-6">
                    <h2 class="text-lg font-medium text-gray-900">
                        Search Results for "{{ $query }}"
                    </h2>
                    <p class="text-sm text-gray-600 mt-1">
                        Found {{ $events->total() }} events matching your search
                    </p>
                </div>

                <!-- Events Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    @foreach($events as $event)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-200">
                            <!-- Event Image -->
                            <div class="aspect-w-16 aspect-h-9 bg-gray-200">
                                @if($event->image_path)
                                    <img src="{{ Storage::url($event->image_path) }}"
                                         alt="{{ $event->title }}"
                                         class="w-full h-48 object-cover">
                                @else
                                    <div class="w-full h-48 bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center">
                                        <svg class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M13 7L8 2 3 7v4h18V7z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Event Content -->
                            <div class="p-6">
                                <!-- Category Badge -->
                                @if($event->category)
                                    <div class="mb-3">
                                        <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $event->category->name }}
                                        </span>
                                    </div>
                                @endif

                                <!-- Event Title -->
                                <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                                    {!! preg_replace('/(' . preg_quote($query, '/') . ')/i', '<mark class="bg-yellow-200 px-1 rounded">$1</mark>', e($event->title)) !!}
                                </h3>

                                <!-- Event Description -->
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                    {!! preg_replace('/(' . preg_quote($query, '/') . ')/i', '<mark class="bg-yellow-200 px-1 rounded">$1</mark>', e($event->description)) !!}
                                </p>

                                <!-- Event Details -->
                                <div class="space-y-2 mb-4">
                                    <!-- Date & Time -->
                                    <div class="flex items-center text-sm text-gray-500">
                                        <svg class="h-4 w-4 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>
                                            {{ $event->local_date_time->format('M d, Y - g:i A') }}
                                            <span class="text-xs ml-1">{{ $event->formatted_timezone }}</span>
                                        </span>
                                    </div>

                                    <!-- Location -->
                                    <div class="flex items-center text-sm text-gray-500">
                                        <svg class="h-4 w-4 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span>
                                            {!! preg_replace('/(' . preg_quote($query, '/') . ')/i', '<mark class="bg-yellow-200 px-1 rounded">$1</mark>', e($event->city . ', ' . $event->country)) !!}
                                        </span>
                                    </div>

                                    <!-- Attendees -->
                                    <div class="flex items-center text-sm text-gray-500">
                                        <svg class="h-4 w-4 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <span>{{ $event->attendees_count }} attending</span>
                                    </div>
                                </div>

                                <!-- Action Button -->
                                <a href="{{ route('events.show', $event) }}"
                                   class="block w-full text-center py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg cursor-pointer transition-colors duration-200">
                                    View Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="flex justify-center">
                    {{ $events->appends(request()->query())->links() }}
                </div>
            @else
                <!-- No Results -->
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No events found</h3>
                    <p class="mt-2 text-sm text-gray-500">
                        We couldn't find any events matching "{{ $query }}". Try a different search term.
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('events.index') }}"
                           class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 py-2 px-4 cursor-pointer">
                            Browse All Events
                        </a>
                    </div>
                </div>
            @endif
        @else
            <!-- Search Instructions -->
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">Search for Events</h3>
                <p class="mt-2 text-sm text-gray-500 max-w-md mx-auto">
                    Enter keywords to search for events by title, description, location, or category.
                    You can search for event types like "networking", "food", or specific cities.
                </p>

                <!-- Popular Categories -->
                <div class="mt-8">
                    <h4 class="text-sm font-medium text-gray-900 mb-4">Popular Categories</h4>
                    <div class="flex flex-wrap justify-center gap-2 max-w-2xl mx-auto">
                        @foreach($categories as $category)
                            <a href="{{ route('events.index', ['category' => $category->id]) }}"
                               class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800 hover:bg-blue-200 cursor-pointer transition-colors duration-200">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
