@extends('pdf.base')

@section('content')
{{-- ===================== CREDIT INFORMATION ===================== --}}
<h2>{{ __('Kredit Barada') }}</h2>
<div class="section">
    <div class="grid">
        <div class="field">
            <label>{{ __('Karzyň ady') }}</label>
            <span>{{ $record->credit?->getTranslation('name', 'tk') ?? '—' }}</span>
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
            <label>{{ __('Mukdar') }}</label>
            <span>{{ $record->amount ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('Göterim') }}</label>
            <span>{{ $record->interest ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('Aýlyk Töleg') }}</label>
            <span>{{ $record->monthly_payment ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('Telekeçimi') }}</label>
            <span>
        {{ $record->role === 'manager' ? 'Ýok' : 'Howa' }}
    </span>
        </div>
        <div class="field">
            <label>{{ __('Patent Belgisi') }}</label>
            <span>{{ $record->patent_number ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('Bellige Alynş Belgisi') }}</label>
            <span>{{ $record->patent_number ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('Iş Salgysy') }}</label>
            <span>{{ $record->work_address ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('Iş Orny') }}</label>
            <span>{{ $record->workplace ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('Orny') }}</label>
            <span>{{ $record->position ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('Möhlet') }}</label>
            <span>{{ $record->term ?? '—' }}</span>
        </div>

        <div class="field">
            <label>{{ __('Iş Salgysy') }}</label>
            <span>{{ $record->manager_work_address ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('Aýlyk Hak') }}</label>
            <span>{{ $record->salary ?? '—' }}</span>
        </div>
{{--        <div class="field">--}}
{{--            <label>{{ __('resource.internet_service') }}</label>--}}
{{--            <span>--}}
{{--                <span class="checkbox-val {{ $record->internet_service ? 'checkbox-yes' : 'checkbox-no' }}">--}}
{{--                    {{ $record->internet_service ? '✔ ' . __('yes') : '✘ ' . __('no') }}--}}
{{--                </span>--}}
{{--            </span>--}}
{{--        </div>--}}
{{--        <div class="field">--}}
{{--            <label>{{ __('resource.delivery') }}</label>--}}
{{--            <span>--}}
{{--                <span class="checkbox-val {{ $record->delivery ? 'checkbox-yes' : 'checkbox-no' }}">--}}
{{--                    {{ $record->delivery ? '✔ ' . __('yes') : '✘ ' . __('no') }}--}}
{{--                </span>--}}
{{--            </span>--}}
{{--        </div>--}}
    </div>
</div>
@endsection
