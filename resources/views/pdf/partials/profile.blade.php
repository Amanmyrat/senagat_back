
{{-- ===================== PROFILE INFORMATION ===================== --}}
<h2>{{ __('Profil Barada') }}</h2>
<div class="section">
    <div class="grid">
        <div class="field">
            <label>{{ __('Ady') }}</label>
            <span>{{ $record->profile?->first_name ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('Familiýasy') }}</label>
            <span>{{ $record->profile?->last_name ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('Atasynyň ady') }}</label>
            <span>{{ $record->profile?->middle_name ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('Telefon belgisi') }}</label>
            <span>{{ $record->user?->phone ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('Doglan senesi') }}</label>
            <span>{{ $record->profile?->birth_date ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('Pasport belgisi') }}</label>
            <span>{{ $record->profile?->passport_number ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('Berilen senesi') }}</label>
            <span>{{ $record->profile?->issued_date ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('Berilen ýeri') }}</label>
            <span>{{ $record->profile?->issued_by ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('Raýatlygy') }}</label>
            <span>{{ $record->profile?->citizenship ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('resource.home_phone_number') }}</label>
            <span>{{ $record->profile?->home_phone ?? '—' }}</span>
        </div>
        <div class="field">
            <label>{{ __('resource.home_address') }}</label>
            <span>{{ $record->profile?->home_address ?? '—' }}</span>
        </div>

        @if($record->profile?->scan_passport)
            <div class="field full-width">
                <label>{{ __('resource.scan_passport') }}</label>
                @php
                    $scanPath = $record->profile->scan_passport;
                    $ext      = strtolower(pathinfo($scanPath, PATHINFO_EXTENSION));
                    $pdfUrl   = asset('storage/' . $scanPath);
                    $fullPath = public_path('storage/' . $scanPath);

                    if (!file_exists($fullPath)) {
                        $fullPath = storage_path('app/public/' . $scanPath);
                    }
                @endphp

                @if(!file_exists($fullPath))
                    <small style="color:#ef4444;">Dosya bulunamadı: {{ $scanPath }}</small>

                @elseif(in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                    @php
                        $mime = match($ext) {
                            'jpg', 'jpeg' => 'image/jpeg',
                            'png'         => 'image/png',
                            'gif'         => 'image/gif',
                            'webp'        => 'image/webp',
                            default       => 'image/jpeg',
                        };
                        $base64 = base64_encode(file_get_contents($fullPath));
                    @endphp
                    <img src="data:{{ $mime }};base64,{{ $base64 }}"
                         alt="Scan Passport" class="passport-img">

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
                            <div style="font-size:11px; color:#6b7280; margin: 6px 0 2px;">
                                Sahypa {{ $i + 1 }} / {{ count($pages) }}
                            </div>
                            <img src="data:image/png;base64,{{ $page }}"
                                 style="width:60%; margin-bottom:10px; border:1px solid #d1d5db; border-radius:6px; display:block;">
                        @endforeach
                    @else
                        <embed src="{{ $pdfUrl }}"
                               type="application/pdf"
                               width="100%"
                               height="800px"
                               style="border:1px solid #d1d5db; border-radius:8px; margin-top:8px; display:block;">
                    @endif

                    <a href="{{ $pdfUrl }}" target="_blank" class="pdf-link no-print">
                        📄 Open new Tab
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
