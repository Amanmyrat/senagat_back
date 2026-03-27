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
                            'old' => $old,
                            'new' => $new,
                        ];
                    @endphp

                    @foreach($paths as $type => $file)

                        <div class="field full-width">
                            <H1>
                                {{ $label }}
                                ({{ $type === 'old' ? 'Öňki' : 'Täze' }})
                            </H1>

                            @php
                                $scanPath = $file;
                                $ext      = strtolower(pathinfo($scanPath, PATHINFO_EXTENSION));
                                $pdfUrl   = asset('storage/' . $scanPath);
                                $fullPath = public_path('storage/' . $scanPath);

                                if (!file_exists($fullPath)) {
                                    $fullPath = storage_path('app/public/' . $scanPath);
                                }
                            @endphp

                            @if(!$scanPath || !file_exists($fullPath))
                                <span>—</span>

                            @elseif(in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                @php
                                    $mime = match($ext) {
                                        'jpg', 'jpeg' => 'image/jpeg',
                                        'png' => 'image/png',
                                        'gif' => 'image/gif',
                                        'webp' => 'image/webp',
                                        default => 'image/jpeg',
                                    };
                                    $base64 = base64_encode(file_get_contents($fullPath));
                                @endphp

                                <img src="data:{{ $mime }};base64,{{ $base64 }}"
                                     style="width:60%; border:1px solid #ccc; border-radius:6px; margin-bottom:10px;">

                            @elseif($ext === 'pdf')
                                @php
                                    $pages = [];

                                    if (extension_loaded('imagick')) {
                                        try {
                                            $imagick = new \Imagick();
                                            $imagick->setResolution(150, 150);
                                            $imagick->readImage($fullPath);

                                            foreach ($imagick as $page) {
                                                $page->setImageFormat('png');
                                                $pages[] = base64_encode($page->getImageBlob());
                                            }
                                        } catch (\Exception $e) {
                                            $pages = [];
                                        }
                                    }
                                @endphp

                                @if(!empty($pages))
                                    @foreach($pages as $i => $page)
                                        <div style="font-size:11px; color:#6b7280;">
                                            Sahypa {{ $i + 1 }}
                                        </div>
                                        <img src="data:image/png;base64,{{ $page }}"
                                             style="width:60%; margin-bottom:10px; border:1px solid #ccc;">
                                    @endforeach
                                @else
                                    <embed src="{{ $pdfUrl }}"
                                           type="application/pdf"
                                           width="100%"
                                           height="600px"
                                           style="margin-bottom:10px;">
                                @endif

                                <a href="{{ $pdfUrl }}" target="_blank">
                                    📄 Open PDF
                                </a>
                            @endif

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
