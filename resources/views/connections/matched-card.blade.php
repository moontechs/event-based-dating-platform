<!-- Card -->
<div class="group flex flex-col">
    @include('components.matched-connection', ['connectionUser' => $connectionUser])

    <div class="mt-auto flex gap-2">
        @include('components.reject-connection', ['connectionUser' => $connectionUser])
    </div>
</div>
<!-- End Card -->
