@extends('pdf.base')

@section('content')
{{-- ===================== International Payment INFORMATION ===================== --}}
<h2>{{ __('Halkara Töleg Arzalar barada') }}</h2>
<div class="section">
    <div class="grid">
        <div class="field">
            <label>{{ __('Ady') }}</label>
            <span>{{ $record->type?->getTranslation('title', 'tk') ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('Şahamça ady') }}</label>
            <span>{{ $record->branch?->getTranslation('name', 'tk') ?? '—' }}</span>
        </div>
    </div>
</div>
@if(!empty($record->uploaded_files))
    <div class="field full-width">
        <label>{{ __('Faýllar') }}</label>

        <div style="display:flex; flex-direction:column; gap:12px;">
            @foreach($record->uploaded_files as $file)

                @include('pdf.partials.file-viewer', [
                    'path' => $file
                ])

            @endforeach
        </div>
    </div>
@endif

@endsection
