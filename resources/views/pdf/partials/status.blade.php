<h2>{{ __('resource.card_order_status') }}</h2>
<div class="section">
    <div class="field">
        <label>{{ __('resource.card_order_status') }}</label>
        <span>
            @php

                $statusClass = match($record->status) {
                    'approved' => 'badge-success',
                    'rejected' => 'badge-danger',
                    default    => 'badge-warning',
                };
                $statusLabel = match($record->status) {
                    'approved' => __('resource.approved'),
                    'rejected' => __('resource.rejected'),
                    default    => ucfirst($record->status ?? __('resource.pending')),
                };
            @endphp
            <span class="badge {{ $statusClass }}">{{ $statusLabel }}</span>
        </span>
    </div>
</div>
