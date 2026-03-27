<h2>{{ __('Statusy') }}</h2>
<div class="section">
    <div class="field">
        <label>{{ __('Arzanyň ýagdaýy') }}</label>
        <span>
            @php

                $statusClass = match($record->status) {
                    'approved' => 'badge-success',
                    'rejected' => 'badge-danger',
                    default    => 'badge-warning',
                };
                $statusLabel = match($record->status) {
                    'approved' => 'Tassyklandy',
                    'rejected' => 'Red edildi',
                    'pending' => 'Garaşylýar',
                    default    => ucfirst($record->status ?? __('Garaşylýar')),
                };
            @endphp
            <span class="badge {{ $statusClass }}">{{ $statusLabel }}</span>
        </span>
    </div>
</div>
