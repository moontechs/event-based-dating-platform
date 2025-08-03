@extends('layouts.app')

@section('content')
@php use Illuminate\Support\Facades\Storage; @endphp
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
{{--    <div class="bg-white shadow-sm border-b border-gray-200">--}}
{{--        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">--}}
{{--            <div class="flex items-center justify-between">--}}
{{--                <div>--}}
{{--                    <h1 class="text-3xl font-bold text-gray-900">Events</h1>--}}
{{--                    <p class="mt-2 text-sm text-gray-600">--}}
{{--                        Discover and join events to meet new people with similar interests--}}
{{--                    </p>--}}
{{--                </div>--}}

{{--                <!-- Quick Actions -->--}}
{{--                <div class="flex items-center space-x-3">--}}
{{--                    <a href="{{ route('events.search') }}"--}}
{{--                       class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 py-2 px-4 cursor-pointer">--}}
{{--                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
{{--                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />--}}
{{--                        </svg>--}}
{{--                        Search Events--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <!-- Filters Section -->
{{--    <div class="bg-white border-b border-gray-200">--}}
{{--        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">--}}
{{--            <form method="GET" action="{{ route('events.index') }}" class="space-y-4 sm:space-y-0 sm:flex sm:items-end sm:space-x-4">--}}
{{--                <!-- Category Filter -->--}}
{{--                <div class="flex-1">--}}
{{--                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>--}}
{{--                    <select name="category" id="category"--}}
{{--                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm cursor-pointer">--}}
{{--                        <option value="">All Categories</option>--}}
{{--                        @foreach($categories as $category)--}}
{{--                            <option value="{{ $category->id }}" {{ (request('category') == $category->id) ? 'selected' : '' }}>--}}
{{--                                {{ $category->name }}--}}
{{--                            </option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}
{{--                </div>--}}

{{--                <!-- City Filter -->--}}
{{--                <div class="flex-1">--}}
{{--                    <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>--}}
{{--                    <select name="city" id="city"--}}
{{--                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm cursor-pointer">--}}
{{--                        <option value="">All Cities</option>--}}
{{--                        @foreach($cities as $city)--}}
{{--                            <option value="{{ $city }}" {{ (request('city') === $city) ? 'selected' : '' }}>--}}
{{--                                {{ $city }}--}}
{{--                            </option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}
{{--                </div>--}}

{{--                <!-- Country Filter -->--}}
{{--                <div class="flex-1">--}}
{{--                    <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Country</label>--}}
{{--                    <select name="country" id="country"--}}
{{--                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm cursor-pointer">--}}
{{--                        <option value="">All Countries</option>--}}
{{--                        @foreach($countries as $country)--}}
{{--                            <option value="{{ $country }}" {{ (request('country') === $country) ? 'selected' : '' }}>--}}
{{--                                {{ $country }}--}}
{{--                            </option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}
{{--                </div>--}}

{{--                <!-- Date Range -->--}}
{{--                <div class="flex-1">--}}
{{--                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>--}}
{{--                    <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"--}}
{{--                           class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">--}}
{{--                </div>--}}

{{--                <div class="flex-1">--}}
{{--                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>--}}
{{--                    <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"--}}
{{--                           class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">--}}
{{--                </div>--}}

{{--                <!-- Search -->--}}
{{--                <div class="flex-1">--}}
{{--                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>--}}
{{--                    <input type="text" name="search" id="search" value="{{ request('search') }}"--}}
{{--                           placeholder="Search events..."--}}
{{--                           class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">--}}
{{--                </div>--}}

{{--                <!-- Filter Button -->--}}
{{--                <div class="flex space-x-2">--}}
{{--                    <button type="submit"--}}
{{--                            class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 py-2 px-4 cursor-pointer">--}}
{{--                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
{{--                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.121A1 1 0 013 6.414V4z" />--}}
{{--                        </svg>--}}
{{--                        Filter--}}
{{--                    </button>--}}

{{--                    @if(request()->hasAny(['category', 'city', 'country', 'start_date', 'end_date', 'search']))--}}
{{--                        <a href="{{ route('events.index') }}"--}}
{{--                           class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 py-2 px-4 cursor-pointer">--}}
{{--                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
{{--                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />--}}
{{--                            </svg>--}}
{{--                            Clear--}}
{{--                        </a>--}}
{{--                    @endif--}}
{{--                </div>--}}
{{--            </form>--}}
{{--        </div>--}}
{{--    </div>--}}

    <!-- Hero -->
    <div class="px-4 sm:px-6 lg:px-8 ">
        <div class="h-120 md:h-[40dvh] flex flex-col bg-[url('https://images.unsplash.com/photo-1542338332-76971ae8c292?q=80&w=1024&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')] bg-cover bg-center bg-no-repeat rounded-2xl">
            <div class="mt-auto w-2/3 md:max-w-lg ps-5 pb-5 md:ps-10 md:pb-10">
                <h1 class="text-xl md:text-3xl lg:text-5xl text-white">
                    VINDE - if you know, you know
                </h1>
            </div>
        </div>
    </div>
    <!-- End Hero -->

    <!-- Events List -->
    @include('components.events-list')
</div>
@endsection
