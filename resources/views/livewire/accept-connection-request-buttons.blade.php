<div class="flex gap-2">
    <button type="button" wire:click="accept"
            class="py-2 px-3 w-full inline-flex justify-center items-center gap-x-2 text-sm font-medium text-nowrap rounded-xl border border-transparent bg-yellow-400 text-black hover:bg-yellow-500 focus:outline-hidden focus:bg-yellow-500 transition disabled:opacity-50 disabled:pointer-events-none cursor-pointer">
        Accept
    </button>

    <button type="button" wire:click="reject"
            wire:confirm="Are you sure you want to reject this connection request? You will not be able to reconnect."
            class="py-2 px-3 w-full inline-flex justify-center items-center gap-x-2 text-sm font-medium text-nowrap rounded-xl border border-transparent bg-red-400 text-black hover:bg-red-500 focus:outline-hidden focus:bg-red-500 transition disabled:opacity-50 disabled:pointer-events-none cursor-pointer">
        Reject
    </button>
</div>
