<div>
    @auth
        @if($this->canMarkAttendance)
            <div class="mt-auto md:w-1/3 md:mx-auto">
                @if($this->userAttending)
                    <button wire:click="toggleAttendance"
                            class="py-2 px-3 w-full inline-flex justify-center items-center gap-x-2 text-sm font-medium text-nowrap rounded-xl border border-transparent bg-red-600 text-white hover:bg-red-700 focus:outline-hidden transition disabled:opacity-50 disabled:pointer-events-none cursor-pointer"
                    >
                        Cancel Attendance
                    </button>
                @else
                    <button wire:click="toggleAttendance"
                            class="py-2 px-3 w-full inline-flex justify-center items-center gap-x-2 text-sm font-medium text-nowrap rounded-xl border border-transparent bg-yellow-400 text-black hover:bg-yellow-500 focus:outline-hidden transition disabled:opacity-50 disabled:pointer-events-none cursor-pointer"
                    >
                        Mark Attendance
                    </button>
                    <div class="mt-3 p-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                        <p class="text-sm text-blue-700 dark:text-blue-300 text-center">
                            💡 We may ask for proof of attendance
                        </p>
                    </div>
                @endif
            </div>
        @else
            <div class="text-center md:w-1/3 md:mx-auto">
                <h3 class="font-medium text-black dark:text-white mb-2">Attendance Closed</h3>
                <p class="text-sm text-black dark:text-white">
                    @if($this->isPastEvent)
                        This event has ended.
                    @endif
                </p>
            </div>
        @endif
    @else
        <div class="text-center">
            <h3 class="font-medium text-black dark:text-white mb-2">Login Required</h3>
            <p class="text-sm text-black dark:text-white mb-4">You need to log in to mark attendance for this event.</p>
            <a href="{{ route('login') }}"
               class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium text-nowrap rounded-xl border border-transparent bg-yellow-400 text-black hover:bg-yellow-500 focus:outline-hidden focus:bg-yellow-500 transition disabled:opacity-50 disabled:pointer-events-none cursor-pointer">
                Login to Continue
            </a>
        </div>
    @endauth
</div>
