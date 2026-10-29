@props([
'value',
'color' => 'gray',
'field' => null,
'type' => 'old',
])

@php
    $items = is_array($value) ? array_values($value) : [$value];
@endphp

<div class="flex flex-col gap-2">
    <span>{{ __('resource.' . $field) }} ({{ __('resource.' .$type) }})</span>
    @foreach($items as $item)
        <div class="flex items-center gap-2">
            <a href="{{ $item }}" target="_blank">
                <span style="color: {{ $color }}">{{ $item }}</span>
            </a>
            @if(is_string($item) && $item !== '' && $item !== '-' && (Str::startsWith($item, ['http://', 'https://', 'storage/', '/storage/'])))
                <button class="ml-auto" style="background: {{ $color }}; color: white; border: 2px solid {{ $color }}; padding: 3px 5px; border-radius: 6px; cursor: pointer;">
                    <a href="{{ $item }}" target="_blank"
                       class="inline-block px-2 py-1 text-sm bg-blue-500 text-white rounded hover:bg-blue-600">
                        {{ __('resource.view') }} ({{ __('resource.' . $type) }})
                    </a>
                </button>
            @endif
        </div>
    @endforeach
</div>
