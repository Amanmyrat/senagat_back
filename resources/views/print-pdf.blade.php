{{-- resources/views/print-pdf.blade.php - Alternatif --}}
    <!DOCTYPE html>
<html>
<head>
    <title>Yazdır - {{ $filename }}</title>
    <meta charset="utf-8">
</head>
<body>
<script>
    // PDF'i yeni pencerede aç ve yazdır
    const pdfData = 'data:application/pdf;base64,{{ $pdfBase64 }}';
    const printWindow = window.open(pdfData, '_blank');

    if (printWindow) {
        printWindow.onload = function() {
            printWindow.print();
        };
    } else {
        alert('Lütfen popup engelleyiciyi devre dışı bırakın.');
    }

    // Mevcut pencereyi kapat
    setTimeout(function() {
        window.close();
    }, 1000);
</script>
</body>
</html>
