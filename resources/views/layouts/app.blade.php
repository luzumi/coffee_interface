<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GetMeCoffee</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @yield('scripts')
</head>
<body>

    <div style="max-width: 100vw; max-height: 100vh">
        @yield('content')
    </div>

</body>

</html>
