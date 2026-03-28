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
    @include('pdf.partials.status', ['record' => $record])
    @if($record->status === 'rejected' && !empty($record->rejection_reasons))
        <div class="field">
            <label>{{ __('Ret sebäpleri') }}</label>
            <span style="display:flex; flex-wrap:wrap; gap:6px;">
    @foreach($record->rejection_reasons as $reason)
                    <span class="badge badge-danger">
            {{ $reason }}
        </span>
                @endforeach
</span>
        </div>
@endif

@endsection
