@php
    if (!$path) return;

    $ext      = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    $pdfUrl   = asset('storage/' . $path);
    $fullPath = public_path('storage/' . $path);

    if (!file_exists($fullPath)) {
        $fullPath = storage_path('app/public/' . $path);
    }
@endphp

@if(!file_exists($fullPath))
    <small style="color:#ef4444;">Dosya bulunamadı: {{ $path }}</small>

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

@elseif($ext === 'pdf')
    <embed src="{{ $pdfUrl }}"
           type="application/pdf"
           width="100%"
           height="800px"
           style="border:1px solid #d1d5db; border-radius:8px; margin-top:8px;">
@endif
