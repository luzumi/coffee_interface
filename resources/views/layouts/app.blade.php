<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GetMeCoffee</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gruppo&family=Unbounded:wght@200;400;600;800&display=swap"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sono&display=swap" rel="stylesheet">
    {{--    <meta name="csrf-token" content="{{ csrf_token() }}">--}}
    @yield('scripts')
</head>
<body class="body">

<div class="border">
    <img class="itb" src=" {{ asset('storage/media/ITB_Logo_blank_farbe.svg') }}" alt="Logo ITB"/>
    <img class="uni-logo" src=" {{ asset('storage/media/UHB_Logo_Web_RGB.svg') }}" alt="Logo Universität Bremen"/>

    <div class="content">
        @yield('content')
    </div>
</div>

</body>

</html>
