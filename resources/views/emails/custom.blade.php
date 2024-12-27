<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
</head>
<body>
    @if (is_object($body))
        <p> Pemain Baru : {{ $body['name'] }}</p>
        <p>Lengkapi detail profile: {{ url('user.html') }}</p>
    @else
    <p>{{ $body }}</p>
    @endif
</body>
</html>