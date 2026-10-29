<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Document' }}</title>
    @include('pdf.styles')
</head>
<body>

<h2>{{ __('Profil Barada') }}</h2>
<div class="section">
    <div class="grid">
        <div class="field">
            <label>{{ __('Ady') }}</label>
            <span>{{ $record->first_name ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('Familiýasy') }}</label>
            <span>{{ $record->last_name ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('Atasynyň ady') }}</label>
            <span>{{ $record->middle_name ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('Telefon belgisi') }}</label>
            <span>{{ $record->phone ?? $record->user?->phone ?? '—'  }}</span>
        </div>
        <div class="field">
            <label>{{ __('Doglan senesi') }}</label>
            <span>
    {{ $record->birth_date
        ? \Carbon\Carbon::parse($record->birth_date)->format('d.m.Y')
        : '—'
    }}
</span>
        </div>
        <div class="field">
            <label>{{ __('Pasport belgisi') }}</label>
            <span>{{ $record->passport_number ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('Berilen senesi') }}</label>
            <span>
    {{ $record->issued_date
        ? \Carbon\Carbon::parse($record->issued_date)->format('d.m.Y')
        : '—'
    }}
</span>
        </div>
        <div class="field">
            <label>{{ __('Berilen ýeri') }}</label>
            <span>{{ $record->issued_by ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('Raýatlygy') }}</label>
            <span>{{ $record->citizenship ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('Öý telefon belgisi') }}</label>
            <span>{{ $record->home_phone ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('Öý salgysy') }}</label>
            <span>{{ $record->home_address ?? '—' }}</span>
        </div>

        @php
            $passportPaths = $record->passportScanPaths();
        @endphp
        @if($passportPaths !== [])
            <div class="field full-width">
                <label>{{ __('Pasport skany') }}</label>
                @foreach($passportPaths as $path)
                    <div style="font-size:12px; color:#6b7280; margin-top:8px;">
                        {{ $loop->iteration }} / {{ $loop->count }}
                    </div>
                    @include('pdf.partials.file-viewer', ['path' => $path])
                @endforeach
            </div>
        @endif
    </div>
</div>
@yield('content')
@include('pdf.partials.changes', ['record' => $record])
@include('pdf.partials.status', ['record' => $record])

</body>
</html>



