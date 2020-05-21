<!-- app/views/layouts/layout.blade.php -->
<html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href={{ asset("favicon.png") }} />
    <title>Local Dev</title>
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @yield('content')
    </div>
    <script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>

