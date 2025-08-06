<!-- Card -->
<div class="group flex flex-col">
    @include('components.pending-connection', ['connectionUser' => $connectionUser])

    <div class="mt-auto">
        @livewire('accept-connection-request-buttons', ['user' => $connectionUser], key('accept-buttons-'.$connectionUser->slug))
    </div>
</div>
<!-- End Card -->
