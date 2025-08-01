@php
    $currentRoute = request()->route()->getName();
@endphp

<!-- Navigation -->
<nav class="bg-white shadow-sm border-b border-gray-200 relative z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo and Brand -->
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        <span class="ml-2 text-xl font-bold text-gray-900 hidden sm:block">EventConnect</span>
                    </a>
                </div>
            </div>

            @auth
                @if(auth()->user()->hasCompletedProfile())
                    <!-- Desktop Navigation -->
                    <div class="hidden md:flex md:items-center md:space-x-8">
                        <!-- Events -->
                        <a href="{{ route('events.index') }}" 
                           class="@if(str_starts_with($currentRoute, 'events.')) text-blue-600 border-b-2 border-blue-600 @else text-gray-600 hover:text-gray-900 @endif px-3 py-2 text-sm font-medium transition-colors">
                            Events
                        </a>

                        <!-- Connections Dropdown -->
                        <div class="relative group">
                            <button class="@if(str_starts_with($currentRoute, 'connections.')) text-blue-600 @else text-gray-600 hover:text-gray-900 @endif px-3 py-2 text-sm font-medium transition-colors flex items-center">
                                Connections
                                <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <!-- Dropdown Menu -->
                            <div class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                <div class="py-1">
                                    <a href="{{ route('connections.incoming') }}" 
                                       class="@if($currentRoute === 'connections.incoming') bg-blue-50 text-blue-600 @else text-gray-700 hover:bg-gray-50 @endif block px-4 py-2 text-sm">
                                        Incoming Requests
                                    </a>
                                    <a href="{{ route('connections.sent') }}" 
                                       class="@if($currentRoute === 'connections.sent') bg-blue-50 text-blue-600 @else text-gray-700 hover:bg-gray-50 @endif block px-4 py-2 text-sm">
                                        Sent Requests
                                    </a>
                                    <a href="{{ route('connections.matches') }}" 
                                       class="@if($currentRoute === 'connections.matches') bg-blue-50 text-blue-600 @else text-gray-700 hover:bg-gray-50 @endif block px-4 py-2 text-sm">
                                        My Matches
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Profile -->
                        <a href="{{ route('profile.show') }}" 
                           class="@if(str_starts_with($currentRoute, 'profile.') || str_starts_with($currentRoute, 'users.')) text-blue-600 border-b-2 border-blue-600 @else text-gray-600 hover:text-gray-900 @endif px-3 py-2 text-sm font-medium transition-colors">
                            Profile
                        </a>
                    </div>

                    <!-- Desktop User Menu -->
                    <div class="hidden md:flex md:items-center md:space-x-4">
                        <span class="text-sm text-gray-600 hidden lg:block">{{ auth()->user()->name }}</span>
                        <a href="{{ route('logout') }}" 
                           class="text-gray-600 hover:text-gray-900 text-sm font-medium transition-colors">
                            Logout
                        </a>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="md:hidden flex items-center">
                        <button type="button" 
                                id="mobile-menu-button"
                                class="text-gray-600 hover:text-gray-900 focus:outline-none focus:text-gray-900 p-2"
                                aria-controls="mobile-menu" 
                                aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <svg id="menu-icon" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                            <svg id="close-icon" class="h-6 w-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                @else
                    <!-- Incomplete profile - show limited navigation -->
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('profile.setup') }}" 
                           class="bg-blue-600 text-white px-4 py-2 text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                            Complete Profile
                        </a>
                        <a href="{{ route('logout') }}" 
                           class="text-gray-600 hover:text-gray-900 text-sm font-medium transition-colors">
                            Logout
                        </a>
                    </div>
                @endif
            @else
                <!-- Guest Navigation -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" 
                       class="text-gray-600 hover:text-gray-900 text-sm font-medium transition-colors">
                        Login
                    </a>
                </div>
            @endauth
        </div>
    </div>

    @auth
        @if(auth()->user()->hasCompletedProfile())
            <!-- Mobile menu -->
            <div id="mobile-menu" class="md:hidden hidden">
                <div class="px-2 pt-2 pb-3 space-y-1 bg-white border-t border-gray-200">
                    <!-- Events -->
                    <a href="{{ route('events.index') }}" 
                       class="@if(str_starts_with($currentRoute, 'events.')) bg-blue-50 text-blue-600 border-l-4 border-blue-600 @else text-gray-600 hover:bg-gray-50 @endif block px-3 py-2 text-base font-medium transition-colors">
                        Events
                    </a>

                    <!-- Connections Section -->
                    <div class="px-3 py-2">
                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Connections</div>
                        <div class="space-y-1">
                            <a href="{{ route('connections.incoming') }}" 
                               class="@if($currentRoute === 'connections.incoming') bg-blue-50 text-blue-600 border-l-4 border-blue-600 @else text-gray-600 hover:bg-gray-50 @endif block px-3 py-2 text-sm font-medium transition-colors">
                                Incoming Requests
                            </a>
                            <a href="{{ route('connections.sent') }}" 
                               class="@if($currentRoute === 'connections.sent') bg-blue-50 text-blue-600 border-l-4 border-blue-600 @else text-gray-600 hover:bg-gray-50 @endif block px-3 py-2 text-sm font-medium transition-colors">
                                Sent Requests
                            </a>
                            <a href="{{ route('connections.matches') }}" 
                               class="@if($currentRoute === 'connections.matches') bg-blue-50 text-blue-600 border-l-4 border-blue-600 @else text-gray-600 hover:bg-gray-50 @endif block px-3 py-2 text-sm font-medium transition-colors">
                                My Matches
                            </a>
                        </div>
                    </div>

                    <!-- Profile -->
                    <a href="{{ route('profile.show') }}" 
                       class="@if(str_starts_with($currentRoute, 'profile.') || str_starts_with($currentRoute, 'users.')) bg-blue-50 text-blue-600 border-l-4 border-blue-600 @else text-gray-600 hover:bg-gray-50 @endif block px-3 py-2 text-base font-medium transition-colors">
                        Profile
                    </a>

                    <!-- User Info and Logout -->
                    <div class="px-3 py-4 border-t border-gray-200 mt-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
                            <a href="{{ route('logout') }}" 
                               class="text-red-600 hover:text-red-700 text-sm font-medium transition-colors">
                                Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endauth
</nav>

@auth
    @if(auth()->user()->hasCompletedProfile())
        <!-- Mobile menu JavaScript -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const mobileMenuButton = document.getElementById('mobile-menu-button');
                const mobileMenu = document.getElementById('mobile-menu');
                const menuIcon = document.getElementById('menu-icon');
                const closeIcon = document.getElementById('close-icon');

                if (mobileMenuButton && mobileMenu) {
                    mobileMenuButton.addEventListener('click', function() {
                        const isOpen = !mobileMenu.classList.contains('hidden');
                        
                        if (isOpen) {
                            // Close menu
                            mobileMenu.classList.add('hidden');
                            menuIcon.classList.remove('hidden');
                            closeIcon.classList.add('hidden');
                            mobileMenuButton.setAttribute('aria-expanded', 'false');
                        } else {
                            // Open menu
                            mobileMenu.classList.remove('hidden');
                            menuIcon.classList.add('hidden');
                            closeIcon.classList.remove('hidden');
                            mobileMenuButton.setAttribute('aria-expanded', 'true');
                        }
                    });

                    // Close menu when clicking outside
                    document.addEventListener('click', function(event) {
                        if (!mobileMenuButton.contains(event.target) && !mobileMenu.contains(event.target)) {
                            mobileMenu.classList.add('hidden');
                            menuIcon.classList.remove('hidden');
                            closeIcon.classList.add('hidden');
                            mobileMenuButton.setAttribute('aria-expanded', 'false');
                        }
                    });

                    // Close menu on window resize to desktop
                    window.addEventListener('resize', function() {
                        if (window.innerWidth >= 768) { // md breakpoint
                            mobileMenu.classList.add('hidden');
                            menuIcon.classList.remove('hidden');
                            closeIcon.classList.add('hidden');
                            mobileMenuButton.setAttribute('aria-expanded', 'false');
                        }
                    });
                }
            });
        </script>
    @endif
@endauth