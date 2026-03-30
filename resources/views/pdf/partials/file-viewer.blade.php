@if($path)

    @php
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $pdfUrl = asset('storage/' . $path);

        $fullPath = public_path('storage/' . $path);
        if (!file_exists($fullPath)) {
            $fullPath = storage_path('app/public/' . $path);
        }

        $exists = file_exists($fullPath);
    @endphp

    {{-- FILE NOT FOUND --}}
    @if(!$exists)
        <small style="color:#ef4444;">
            Dosya bulunamadı: {{ $path }}
        </small>

        {{-- IMAGE --}}
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
             style="width:60%; border:1px solid #d1d5db; border-radius:6px; margin-top:8px;">

        {{-- PDF --}}
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

        {{-- PDF → IMAGE (BEST) --}}
        @if(!empty($pages))
            @foreach($pages as $i => $page)
                <div style="font-size:11px; color:#6b7280; margin: 6px 0;">
                    {{ __('Sahypa') }} {{ $i + 1 }}
                </div>

                <img src="data:image/png;base64,{{ $page }}"
                     style="width:60%; margin-bottom:10px; border:1px solid #d1d5db; border-radius:6px;">
            @endforeach

        @else
            <embed src="{{ $pdfUrl }}"
                   type="application/pdf"
                   width="100%"
                   height="800px"
                   style="border:1px solid #d1d5db; border-radius:8px; margin-top:8px;">

            <div style="margin-top:6px;">
                <a href="{{ $pdfUrl }}" target="_blank" style="font-size:12px;">
                    📄 {{ __('Täze penjirede aç') }}
                </a>
            </div>
        @endif

    @endif

@endif
