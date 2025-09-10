@props([
'value',
'color' => 'gray',
'field' => null,
'type' => 'old',
])

<div class="flex flex-col gap-1">
    <span>{{ __('resource.' . $field) }} ({{ __('resource.' .$type) }})</span>
    <div class="flex items-center gap-2">
      <a href="{{ $value }}" target="_blank" > <span style="color: {{ $color }}">{{ $value }}</span>
        </a>
        @if($value && (Str::startsWith($value, ['http://', 'https://', 'storage/'])))
            <button  class="ml-auto" style="background: {{ $color  }}; color: white; border: 2px solid {{ $color }}; padding: 3px 5px; border-radius: 6px; cursor: pointer;">
                <a href="{{ $value }}" target="_blank"
               class="inline-block px-2 py-1 text-sm bg-blue-500 text-white rounded hover:bg-blue-600">
                    {{ __('resource.view') }} ({{ __('resource.' . $type)  }})
                </a> </button>
        @endif
    </div>
</div>



