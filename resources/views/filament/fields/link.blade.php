@php
    $link = $getState();
@endphp

@if ($link)
    <a href="{{ $link }}" target="_blank" class="text-primary underline">
        View
    </a>
@else
    <span>No file</span>
@endif
