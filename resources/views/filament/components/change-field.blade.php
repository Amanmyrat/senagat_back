<div class="flex flex-col gap-1">
    <span >{{ ucwords(str_replace('_', ' ', $field ?? '')) }} ({{ $type }})</span>
    <span style="color: {{ $color }}">{{ $value }}</span>
</div>
