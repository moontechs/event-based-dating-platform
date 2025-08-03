<!-- Card -->
<div class="group flex flex-col">
    @include('components.pending-connection', ['connectionUser' => $connectionUser])

    <div class="mt-auto flex gap-2">
        @include('components.accept-connection', ['connectionUser' => $connectionUser])
        @include('components.reject-connection', ['connectionUser' => $connectionUser])
    </div>
</div>
<!-- End Card -->
