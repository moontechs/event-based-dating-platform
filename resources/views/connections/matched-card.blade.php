<!-- Card -->
<div class="group flex flex-col">
    @include('components.matched-connection', ['connectionUser' => $connectionUser])

    <div class="mt-auto flex gap-2">
        @livewire('disconnect-match-button', ['connectionUser' => $connectionUser], key('disconnect-'.$connectionUser->slug))
    </div>
</div>
<!-- End Card -->
