<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#36A2CD">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="shortcut icon" href="{{ asset('idea.png') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset(mix('/css/app.css')) }}">
</head>

<body>
    <div id="app">
    </div>
    <script type="application/javascript" defer src="{{ asset(mix('js/manifest.js')) }}"></script>
    <script type="application/javascript" defer src="{{ asset(mix('js/vendor.js')) }}"></script>
    <script type="application/javascript" defer src="{{ asset(mix('js/app.js')) }}"></script>
    {{-- <script defer src="../js/face-api.min.js"></script> --}}
    {{-- <script defer src="../js/script.js"></script> --}}
    
</body>

</html>
