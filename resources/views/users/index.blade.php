@extends('layouts.app')

@section('content')
@php use Illuminate\Support\Facades\Storage; @endphp
<div class="min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Browse Users</h1>
            <p class="mt-2 text-gray-600">Connect with other users in the community</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($users as $user)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <!-- Profile Photo -->
                        <div class="flex-shrink-0 mb-4">
                            @if($user->getMainProfileImagePath())
                                <img class="h-16 w-16 rounded-full object-cover mx-auto"
                                     src="{{ Storage::url($user->getMainProfileImagePath()) }}"
                                     alt="{{ $user->full_name ?? $user->name }}">
                            @else
                                <div class="h-16 w-16 rounded-full bg-gray-300 flex items-center justify-center mx-auto">
                                    <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- User Info -->
                        <div class="text-center">
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">
                                {{ explode(' ', $user->full_name ?? $user->name)[0] }}
                            </h3>
                            @if($user->relationship_intent)
                                <p class="text-sm text-gray-600 mb-4">
                                    {{ $user->relationship_intent->label() }}
                                </p>
                            @endif

                            <!-- View Profile Button using slug -->
                            <a href="{{ route('users.show', $user->slug) }}"
                               class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 py-2 px-4 cursor-pointer">
                                View Profile
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
