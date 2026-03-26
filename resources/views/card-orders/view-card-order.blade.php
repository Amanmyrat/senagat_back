@extends('pdf.base')

@section('content')
{{-- ===================== CARD INFORMATION ===================== --}}
<h2>{{ __('resource.card_information') }}</h2>
<div class="section">
    <div class="grid">
        <div class="field">
            <label>{{ __('resource.title') }}</label>
            <span>{{ $record->cardType?->title ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('resource.phone') }}</label>
            <span>{{ $record->user?->phone ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('resource.branch_name') }}</label>
            <span>{{ $record->branch?->getTranslation('name', 'tk') ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('resource.work_position') }}</label>
            <span>
        {{ $record->work_position === 'jobless' ? 'Işsiz' : ($record->work_position ?? '—') }}
    </span>
        </div>
        <div class="field">
            <label>{{ __('resource.work_phone') }}</label>
            <span>{{ $record->work_phone ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('resource.email') }}</label>
            <span>{{ $record->email ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('resource.secret_word') }}</label>
            <span>{{ $record->secret_word ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('resource.price') }}</label>
            <span>{{ $record->cardType?->price ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('resource.internet_service') }}</label>
            <span>
                <span class="checkbox-val {{ $record->internet_service ? 'checkbox-yes' : 'checkbox-no' }}">
                    {{ $record->internet_service ? '✔ ' . __('yes') : '✘ ' . __('no') }}
                </span>
            </span>
        </div>
        <div class="field">
            <label>{{ __('resource.delivery') }}</label>
            <span>
                <span class="checkbox-val {{ $record->delivery ? 'checkbox-yes' : 'checkbox-no' }}">
                    {{ $record->delivery ? '✔ ' . __('yes') : '✘ ' . __('no') }}
                </span>
            </span>
        </div>
    </div>
</div>
@endsection
