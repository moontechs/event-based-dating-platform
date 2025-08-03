<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <link rel="canonical" href="{{ config('app.url') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Explore the Coffee Shop demo with a clean product detail page and flexible checkout options for modern, clean, and minimal e-commerce experiences.">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') {{ config('app.name', 'Event Dating Platform') }}</title>

{{--    <link rel="shortcut icon" href="../../favicon.ico">--}}

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="dark:bg-neutral-900">
    <div class="min-h-screen">
        <!-- Navigation -->
        @include('components.navigation')

        <main id="content">
            <!-- Flash Messages -->
            @if(session('success') || session('error') || session('info'))
                <div class="fixed top-20 right-4 z-50 max-w-md flash-messages">
                    @if(session('success'))
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4 shadow-md">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-green-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="text-sm text-green-800">
                                    {{ session('success') }}
                                </div>
                                <button type="button" class="ml-auto text-green-400 hover:text-green-600" onclick="this.parentElement.parentElement.remove()">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4 shadow-md flash-messages">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-red-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="text-sm text-red-800">
                                    {{ session('error') }}
                                </div>
                                <button type="button" class="ml-auto text-red-400 hover:text-red-600" onclick="this.parentElement.parentElement.remove()">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endif

                    @if(session('info'))
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4 shadow-md flash-messages">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-blue-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="text-sm text-blue-800">
                                    {{ session('info') }}
                                </div>
                                <button type="button" class="ml-auto text-blue-400 hover:text-blue-600" onclick="this.parentElement.parentElement.remove()">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>

                <script>
                    // Auto-hide flash messages after 5 seconds
                    setTimeout(function() {
                        const flashMessages = document.querySelectorAll('.flash-messages');
                        flashMessages.forEach(function(message) {
                            message.style.transition = 'opacity 0.5s ease-out';
                            message.style.opacity = '0';
                            setTimeout(function() {
                                message.remove();
                            }, 500);
                        });
                    }, 5000);
                </script>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
