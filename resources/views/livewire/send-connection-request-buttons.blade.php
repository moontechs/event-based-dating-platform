<div>
    @auth
        @if($this->isCurrentUser)
            <span class="text-xs text-yellow-600 font-medium">
            You
        </span>
        @elseif($this->showCancelButton)
            <div class="flex-shrink-0">
                <button type="button"
                        wire:click="cancelRequest"
                        wire:loading.attr="disabled"
                        class="py-2 px-3 w-full inline-flex justify-center items-center gap-x-2 text-sm font-medium text-nowrap rounded-xl border border-transparent bg-red-400 text-black hover:bg-red-500 focus:outline-hidden focus:bg-red-400 transition cursor-pointer">
                    Cancel
                </button>
            </div>
        @elseif($this->showConnectButton)
            <div class="flex-shrink-0">
                <button type="button"
                        wire:click="sendRequest"
                        wire:loading.attr="disabled"
                        class="py-2 px-3 w-full inline-flex justify-center items-center gap-x-2 text-sm font-medium text-nowrap rounded-xl border border-transparent bg-yellow-400 text-black hover:bg-yellow-500 focus:outline-hidden focus:bg-yellow-400 transition cursor-pointer">
                    Connect
                </button>
            </div>
        @endif
    @endauth
</div>
