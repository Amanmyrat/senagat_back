{{-- resources/views/print-pdf.blade.php - Alternatif --}}
    <!DOCTYPE html>
<html>
<head>
    <title>Print - {{ $filename }}</title>
    <meta charset="utf-8">
</head>
<body>
<script>

    const pdfData = 'data:application/pdf;base64,{{ $pdfBase64 }}';
    const printWindow = window.open(pdfData, '_blank');

    if (printWindow) {
        printWindow.onload = function() {
            printWindow.print();
        };
    } else {
        alert('Please disable your popup blocker.');
    }

    setTimeout(function() {
        window.close();
    }, 1000);
</script>
</body>
</html>
