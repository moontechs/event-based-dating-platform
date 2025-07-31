@extends('layouts.app')

@section('content')
@php use Illuminate\Support\Facades\Storage; @endphp
<div class="min-h-screen bg-gray-50">
    <!-- Navigation -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center space-x-4">
                <a href="{{ route('events.index') }}"
                   class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 cursor-pointer">
                    <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Events
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Event Content -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <!-- Event Image -->
                    <div class="aspect-w-16 aspect-h-9 bg-gray-200">
                        @if($event->image_path)
                            <img src="{{ Storage::url($event->image_path) }}"
                                 alt="{{ $event->title }}"
                                 class="w-full h-64 lg:h-80 object-cover">
                        @else
                            <div class="w-full h-64 lg:h-80 bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center">
                                <svg class="h-24 w-24 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M13 7L8 2 3 7v4h18V7z" />
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Event Header -->
                    <div class="p-6">
                        <!-- Category Badge -->
                        @if($event->category)
                            <div class="mb-4">
                                <span class="inline-flex items-center gap-x-1.5 py-2 px-4 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    {{ $event->category->name }}
                                </span>
                            </div>
                        @endif

                        <!-- Event Title -->
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $event->title }}</h1>

                        <!-- Event Details Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                            <!-- Date & Time -->
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-10 w-10 rounded-lg bg-blue-100">
                                        <svg class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">Date & Time</h3>
                                    <p class="text-sm text-gray-600 mt-1">
                                        {{ $event->local_date_time->format('l, F j, Y') }}<br>
                                        {{ $event->local_date_time->format('g:i A') }}
                                        <span class="text-xs text-gray-500">{{ $event->formatted_timezone }}</span>
                                    </p>
                                </div>
                            </div>

                            <!-- Location -->
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-10 w-10 rounded-lg bg-green-100">
                                        <svg class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">Location</h3>
                                    <p class="text-sm text-gray-600 mt-1">
                                        {{ $event->city }}, {{ $event->country }}
                                    </p>
                                </div>
                            </div>

                            <!-- Attendees Count -->
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-10 w-10 rounded-lg bg-purple-100">
                                        <svg class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">Attendees</h3>
                                    <p class="text-sm text-gray-600 mt-1">
                                        {{ $statistics['total_attendees'] }} people attending
                                    </p>
                                </div>
                            </div>

                            <!-- Event Status -->
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-10 w-10 rounded-lg {{ $statistics['is_past_event'] ? 'bg-gray-100' : 'bg-orange-100' }}">
                                        <svg class="h-5 w-5 {{ $statistics['is_past_event'] ? 'text-gray-600' : 'text-orange-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">Status</h3>
                                    <p class="text-sm text-gray-600 mt-1">
                                        @if($statistics['is_past_event'])
                                            Past Event
                                        @elseif($statistics['is_future_event'])
                                            Upcoming Event
                                        @else
                                            Happening Now
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Event Description -->
                        @if($event->description)
                            <div class="mb-6">
                                <h2 class="text-lg font-semibold text-gray-900 mb-3">About This Event</h2>
                                <div class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $event->description }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="space-y-6">
                    <!-- Attendance Action -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        @auth
                            @if($statistics['can_mark_attendance'])
                                <form method="POST" action="{{ route('events.attend', $event) }}" id="attendance-form">
                                    @csrf
                                    <button type="submit"
                                            class="w-full py-3 px-4 text-sm font-medium rounded-lg cursor-pointer transition-colors duration-200 {{ $statistics['user_attending'] ? 'bg-red-600 hover:bg-red-700 text-white' : 'bg-blue-600 hover:bg-blue-700 text-white' }}"
                                            id="attendance-btn">
                                        @if($statistics['user_attending'])
                                            <svg class="h-5 w-5 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Cancel Attendance
                                        @else
                                            <svg class="h-5 w-5 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                            Mark Attendance
                                        @endif
                                    </button>
                                </form>
                            @else
                                <div class="text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <h3 class="text-sm font-medium text-gray-900 mb-2">Attendance Closed</h3>
                                    <p class="text-sm text-gray-500">
                                        @if($statistics['is_past_event'])
                                            This event has ended and attendance can no longer be modified.
                                        @endif
                                    </p>
                                </div>
                            @endif
                        @else
                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                <h3 class="text-sm font-medium text-gray-900 mb-2">Login Required</h3>
                                <p class="text-sm text-gray-500 mb-4">You need to log in to mark attendance for this event.</p>
                                <a href="{{ route('login') }}"
                                   class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 py-2 px-4 cursor-pointer">
                                    Login to Continue
                                </a>
                            </div>
                        @endauth
                    </div>

                    <!-- Attendees List -->
                    @if($event->attendances->count() > 0)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">
                                Attendees ({{ $event->attendances->count() }})
                            </h2>

                            <div class="space-y-3 max-h-96 overflow-y-auto">
                                @foreach($event->attendances as $attendance)
                                    <div class="flex items-center space-x-3">
                                        <!-- Profile Photo -->
                                        <div class="flex-shrink-0">
                                            @if($attendance->user->photo_path)
                                                <img class="h-10 w-10 rounded-full object-cover" loading="lazy"
                                                     src="{{ Storage::url($attendance->user->photo_path) }}"
                                                     alt="{{ $attendance->user->name }}">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                    <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- User Info -->
                                        <div class="flex-1 min-w-0">
                                            <a href="{{ route('users.show', $attendance->user->slug) }}"
                                               class="text-sm font-medium text-gray-900 hover:text-blue-600 cursor-pointer">
                                                {{ explode(' ', $attendance->user->name)[0] }}
                                            </a>
                                            @if($attendance->user->relationship_intent)
                                                <p class="text-xs text-gray-500">
                                                    {{ $attendance->user->relationship_intent->label() }}
                                                </p>
                                            @endif
                                        </div>

                                        <!-- Current User Indicator -->
                                        @auth
                                            @if($attendance->user->id === auth()->id())
                                                <span class="text-xs text-blue-600 font-medium">
                                                    You
                                                </span>
                                            @endif
                                        @endauth
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <h3 class="text-sm font-medium text-gray-900 mb-2">No Attendees Yet</h3>
                                <p class="text-sm text-gray-500">Be the first to mark attendance for this event!</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Handle attendance form submission with AJAX
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('attendance-form');
    const btn = document.getElementById('attendance-btn');

    if (form && btn) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Disable button and show loading
            btn.disabled = true;
            btn.innerHTML = '<svg class="animate-spin h-5 w-5 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2v4m0 12v4m8-8h-4M4 12H0m16.24-7.76l-2.83 2.83M7.76 16.24l-2.83 2.83m12.73 0l-2.83-2.83M7.76 7.76L4.93 4.93"/></svg>Processing...';

            // Submit form
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload page to update attendee list
                    window.location.reload();
                } else {
                    alert(data.message || 'An error occurred');
                    btn.disabled = false;
                    // Restore original button text
                    if (data.attending) {
                        btn.innerHTML = '<svg class="h-5 w-5 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>Cancel Attendance';
                        btn.className = 'w-full py-3 px-4 text-sm font-medium rounded-lg cursor-pointer transition-colors duration-200 bg-red-600 hover:bg-red-700 text-white';
                    } else {
                        btn.innerHTML = '<svg class="h-5 w-5 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>Mark Attendance';
                        btn.className = 'w-full py-3 px-4 text-sm font-medium rounded-lg cursor-pointer transition-colors duration-200 bg-blue-600 hover:bg-blue-700 text-white';
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating attendance');
                btn.disabled = false;
            });
        });
    }
});
</script>
@endpush
@endsection
