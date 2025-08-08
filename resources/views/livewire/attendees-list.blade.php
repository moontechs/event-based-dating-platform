@php use Illuminate\Support\Facades\Storage; @endphp
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @if($this->attendances->count() > 0 && \Illuminate\Support\Facades\Auth::user()->hasCompletedProfile())
        <div class="mb-6 sm:mb-10 max-w-2xl text-center mx-auto">
            <h1 class="font-medium text-black text-3xl sm:text-4xl dark:text-white">
                Attendees
            </h1>
        </div>

        <!-- Attendances Grid -->
        <div class="max-w-7xl px-4 sm:px-6 lg:px-8 py-12 lg:py-12 mx-auto">
            <!-- Card Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-12">
                @foreach($this->attendances as $attendance)
                    <!-- Card -->
                    <div class="group flex flex-col">
                        <div class="relative">
                            <div class="aspect-4/4 overflow-hidden rounded-2xl">
                                <img class="size-full object-cover rounded-2xl"
                                     loading="lazy"
                                     src="{{ Storage::url($attendance->user->getMainProfileImagePath()) }}"
                                     alt="{{ $attendance->user->name }}"
                                >
                            </div>

                            <div class="pt-4">
                                <h3 class="font-medium md:text-lg text-black dark:text-white">
                                    @auth
                                        @if(in_array($attendance->user->id, $this->connectionData['accepted'] ?? []))
                                            {{ $attendance->user->full_name }}
                                        @else
                                            {{ $attendance->user->name }}
                                        @endif
                                    @else
                                        {{ $attendance->user->name }}
                                    @endauth
                                </h3>

                                <p class="mt-2 font-semibold text-black dark:text-white">
                                </p>
                            </div>

                            <a class="after:absolute after:inset-0 after:z-1" href="{{ route('users.show', $attendance->user->slug) }}"></a>
                        </div>

                        <div class="mb-2 mt-4 text-sm">
                            <!-- List -->
                            <div class="flex flex-col">
                                <!-- Item -->
                                <div class="py-3 border-t border-gray-200 dark:border-neutral-700">
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <span class="font-medium text-black dark:text-white">
                                                {{ $attendance->user->age }}
                                            </span>
                                        </div>

                                        <div class="text-end min-h-[2lh]">
                                            <span class="text-black dark:text-white">
                                                @if($attendance->user->relationship_intent)
                                                    {{ $attendance->user->relationship_intent->label() }}
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Item -->
                            </div>
                            <!-- End List -->

                            @livewire('send-connection-request-buttons', ['user' => $attendance->user, 'connectionData' => $this->connectionData], key('send-connection-request-button-'.$attendance->user->slug))
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        @if(! \Illuminate\Support\Facades\Auth::user()->hasCompletedProfile())
        <div class="group flex flex-col">
            <div class="text-center">
                <h3 class="font-medium text-black dark:text-white mb-2">Complete your profile</h3>
                <p class="text-sm text-black dark:text-white">You will be able to see attendees and match with them</p>
            </div>
        </div>
        @elseif($this->attendances->count() === 0)
            <div class="group flex flex-col">
                <div class="text-center">
                    <h3 class="font-medium text-black dark:text-white mb-2">No Attendees Yet</h3>
                    <p class="text-sm text-black dark:text-white">Be the first to mark attendance for this event!</p>
                </div>
            </div>
        @endif
    @endif
</div>
