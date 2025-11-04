<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Print Direct</title>
</head>
<body>
<iframe
    id="pdfFrame"
    src="data:application/pdf;base64,{{ $base64 }}"
    style="width:0;height:0;border:none;"
></iframe>

<script>
    window.onload = function () {
        const iframe = document.getElementById('pdfFrame');
        iframe.onload = function () {

            iframe.contentWindow.focus();
            iframe.contentWindow.print();
        };
    };
</script>
</body>
</html>
