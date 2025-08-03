<!-- Card -->
<div class="group flex flex-col">
    @include('components.pending-connection', ['connectionUser' => $connectionUser])

    <div class="mt-auto">
        @include('components.cancel-connection', ['connectionUser' => $connectionUser])
    </div>
</div>
<!-- End Card -->
