<!-- Card -->
<div class="group flex flex-col" wire:key="send-connection-request-{{ $connectionUser->slug }}">
    @include('components.pending-connection', ['connectionUser' => $connectionUser])

    <div class="mt-auto">
        @livewire('send-connection-request-buttons', ['user' => $connectionUser], key('send-buttons-'.$connectionUser->slug))
    </div>
</div>
<!-- End Card -->
