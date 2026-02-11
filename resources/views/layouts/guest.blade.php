<!DOCTYPE HTML>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title','Homeradar')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- CSS du thème --}}
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/color.css') }}">
    <link rel="shortcut icon" href="{{ asset('asset/images/favicon.ico') }}">
    
</head>
<body>
    {{-- header/nav si besoin --}}
    @yield('content')

    {{-- JS du thème (évite Google Maps ici si inutile) --}}
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    
</body>
</html>
