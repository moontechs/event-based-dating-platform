<!-- Card -->
<div class="group flex flex-col">
    @include('components.pending-connection', ['connectionUser' => $connectionUser])

    <div class="mt-auto">
        @livewire('connection-request-button', ['user' => $connectionUser], key('connection-'.$connectionUser->slug))
    </div>
</div>
<!-- End Card -->
