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
        @if($record->role === 'entrepreneur')
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
        @endif
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
        @if($record->salary_document)
            <div class="field full-width">
                <h2>{{ __('Aýlyk haky barada güwanama') }}</h2>

                @include('pdf.partials.file-viewer', [
                    'path' => $record->salary_document
                ])
            </div>
        @endif
        @if($record->role === 'manager')
        @if($record->profit_document)
            <div class="field full-width">
                <h2>{{ __('Zähmet depderçesiniň tassyklanylan göçürmesi') }}</h2>

                @include('pdf.partials.file-viewer', [
                    'path' => $record->profit_document
                ])
            </div>
        @endif
        @endif
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

</div>
@endsection
