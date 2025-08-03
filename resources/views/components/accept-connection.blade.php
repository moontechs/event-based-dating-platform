<form method="POST" action="{{ route('connections.accept', $connectionUser) }}" class="inline w-full">
    @csrf
    <button type="submit"
            class="py-2 px-3 w-full inline-flex justify-center items-center gap-x-2 text-sm font-medium text-nowrap rounded-xl border border-transparent bg-yellow-400 text-black hover:bg-yellow-500 focus:outline-hidden focus:bg-yellow-500 transition disabled:opacity-50 disabled:pointer-events-none cursor-pointer">
        Accept
    </button>
</form>
