<!DOCTYPE html>
<html>
<head>
    <title>Broadcast</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    @yield('script')
</head>
<body>

@yield('content')

<script type="text/javascript"  src="{{ asset('js/app.js') }}"></script>
</body>
<footer>Footer</footer>
</html>
　
