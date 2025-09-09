@props([
'value',     // Placeholder'dan gelen değer
'color' => 'gray',
'field' => null,
'type' => 'old',
])

<div class="flex flex-col gap-1">
    <span>{{ ucwords(str_replace('_', ' ', $field ?? '')) }} ({{ $type }})</span>
    <div class="flex items-center gap-2">
      <a href="{{ $value }}" target="_blank" > <span style="color: {{ $color }}">{{ $value }}</span>
        </a>
        @if($value && (Str::startsWith($value, ['http://', 'https://', 'storage/'])))
            <button style="background: {{ $color  }}; color: white; border: 2px solid {{ $color }}; padding: 3px 5px; border-radius: 6px; cursor: pointer;"> <a href="{{ $value }}" target="_blank"
               class="inline-block px-2 py-1 text-sm bg-blue-500 text-white rounded hover:bg-blue-600">
                View {{ $type  }}
                </a> </button>
        @endif
    </div>
</div>
