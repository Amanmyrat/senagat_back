<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Document' }}</title>
    @include('pdf.styles')
</head>
<body>

@include('pdf.partials.profile', ['record' => $record])

@yield('content')


</body>
</html>
