@extends('pdf.base')

@section('content')
{{-- ===================== Certificate INFORMATION ===================== --}}
<h2>{{ __('Güwanama barada') }}</h2>
<div class="section">
    <div class="grid">
        <div class="field">
            <label>{{ __('Ady') }}</label>
            <span>{{ $record->certificateType?->getTranslation('title', 'tk')?? '—' }}</span>
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
            <label>{{ __('Öý salgysy') }}</label>
            <span>{{ $record->home_address ?? '—' }}</span>
        </div>
</div>
@endsection
