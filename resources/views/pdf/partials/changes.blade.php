<h2>{{ __('Üýtgeşmeler') }}</h2>

@php
    $fieldLabels = [
        'first_name' => 'Ady',
        'last_name' => 'Familiýasy',
        'middle_name' => 'Atasynyň ady',
        'birth_date' => 'Doglan senesi',
        'passport_number' => 'Pasport belgisi',
        'issued_date' => 'Berilen senesi',
        'issued_by' => 'Berilen ýeri',
        'citizenship' => 'Raýatlygy',
        'home_phone' => 'Öý telefon belgisi',
        'home_address' => 'Öý salgysy',
        'scan_passport' => 'Pasport skany',
    ];
@endphp

<div class="section">
    <div class="grid">

        @if(!$record->latestChangeLog || empty($record->latestChangeLog->changes))
            <div class="field full-width">
                <span>Üýtgeşme ýok</span>
            </div>
        @else

            @foreach($record->latestChangeLog->changes as $field => $values)

                @php
                    if ($field === 'approved') continue;

                    $old = $values['old'] ?? '—';
                    $new = $values['new'] ?? '—';

                    // DATE FORMAT
                    if (in_array($field, ['birth_date', 'issued_date'])) {
                        try {
                            $old = $old ? \Carbon\Carbon::parse($old)->format('d.m.Y') : '—';
                            $new = $new ? \Carbon\Carbon::parse($new)->format('d.m.Y') : '—';
                        } catch (\Exception $e) {}
                    }

                    $label = $fieldLabels[$field] ?? ucfirst(str_replace('_',' ',$field));
                @endphp

                {{-- ================= PASSPORT SPECIAL ================= --}}
                @if($field === 'scan_passport')

                    @php
                        $paths = [
                            'old' => \App\Models\UserProfile::normalizePassportPaths($values['old'] ?? null),
                            'new' => \App\Models\UserProfile::normalizePassportPaths($values['new'] ?? null),
                        ];
                    @endphp

                    @foreach($paths as $type => $files)

                        <div class="field full-width">
                            <H1>
                                {{ $label }}
                                ({{ $type === 'old' ? 'Öňki' : 'Täze' }})
                            </H1>

                            @forelse($files as $scanPath)
                                <div style="font-size:12px; color:#6b7280; margin-top:8px;">
                                    {{ $loop->iteration }} / {{ $loop->count }}
                                </div>
                                @include('pdf.partials.file-viewer', ['path' => $scanPath])
                            @empty
                                <span>—</span>
                            @endforelse

                        </div>

                    @endforeach

                    {{-- ================= NORMAL FIELDS ================= --}}
                @else

                    <div class="field">
                        <label>{{ $label }} (Öňki)</label>
                        <span style="background:#fee2e2; text-decoration: line-through;">
                            {{ $old }}
                        </span>
                    </div>

                    <div class="field">
                        <label>{{ $label }} (Täze)</label>
                        <span style="background:#dcfce7; font-weight: bold;">
                            {{ $new }}
                        </span>
                    </div>

                @endif

            @endforeach

        @endif

    </div>
</div>
