<div class="flex flex-col gap-1">
    <span >{{ ucwords(str_replace('_', ' ', $field ?? '')) }} (Old)</span>
    <span style="color: {{ $color }}">{{ $value }}</span>
</div>
