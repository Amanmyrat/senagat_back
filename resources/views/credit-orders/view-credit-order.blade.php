@extends('pdf.base')

@section('content')
{{-- ===================== CREDIT INFORMATION ===================== --}}
<h2>{{ __('resource.card_information') }}</h2>
<div class="section">
    <div class="grid">
        <div class="field">
            <label>{{ __('resource.title') }}</label>
            <span>{{ $record->credit?->getTranslation('name', 'tk') ?? '—' }}</span>
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
            <label>{{ __('resource.amount') }}</label>
            <span>{{ $record->amount ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('resource.interest') }}</label>
            <span>{{ $record->interest ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('resource.monthly_payment') }}</label>
            <span>{{ $record->monthly_payment ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('Telekeçimi') }}</label>
            <span>
        {{ $record->role === 'manager' ? 'Ýok' : 'Howa' }}
    </span>
        </div>
        <div class="field">
            <label>{{ __('resource.patent_number') }}</label>
            <span>{{ $record->patent_number ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('resource.registration_number') }}</label>
            <span>{{ $record->patent_number ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('resource.work_address') }}</label>
            <span>{{ $record->work_address ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('workplace') }}</label>
            <span>{{ $record->workplace ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('resource.position') }}</label>
            <span>{{ $record->position ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('resource.term') }}</label>
            <span>{{ $record->term ?? '—' }}</span>
        </div>

        <div class="field">
            <label>{{ __('resource.manager_work_address') }}</label>
            <span>{{ $record->manager_work_address ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('resource.salary') }}</label>
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
