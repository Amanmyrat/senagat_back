@extends('pdf.base')

@section('content')
{{-- ===================== CARD INFORMATION ===================== --}}
<h2>{{ __('Kart barada') }}</h2>
<div class="section">
    <div class="grid">
        <div class="field">
            <label>{{ __('Ady') }}</label>
            <span>{{ $record->cardType?->getTranslation('title', 'tk') ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('Telefon belgisi') }}</label>
            <span>{{ $record->user?->phone ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('Şahamça ady') }}</label>
            <span>{{ $record->branch?->getTranslation('name', 'tk') ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('Iş Orny') }}</label>
            <span>
        {{ $record->work_position === 'jobless' ? 'Işsiz' : ($record->work_position ?? '—') }}
    </span>
        </div>
        <div class="field">
            <label>{{ __('Iş Telefony') }}</label>
            <span>{{ $record->work_phone ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('E-poçta') }}</label>
            <span>{{ $record->email ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('Gizlin söz') }}</label>
            <span>{{ $record->secret_word ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('Bahasy') }}</label>
            <span>{{ $record->cardType?->price ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('Internet Hyzmaty') }}</label>
            <span>
                <span class="checkbox-val {{ $record->internet_service ? 'checkbox-yes' : 'checkbox-no' }}">
                    {{ $record->internet_service ? '✔ ' . __('Howa') : '✘ ' . __('Ýok') }}
                </span>
            </span>
        </div>
        <div class="field">
            <label>{{ __('Eltip bermek') }}</label>
            <span>
                <span class="checkbox-val {{ $record->delivery ? 'checkbox-yes' : 'checkbox-no' }}">
                    {{ $record->delivery ? '✔ ' . __('Howa') : '✘ ' . __('Ýok') }}
                </span>
            </span>
        </div>
    </div>
</div>
@endsection
