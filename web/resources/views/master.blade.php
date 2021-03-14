<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    @yield('robots')
</head>
<body>
<div id="body">
    @yield('page')
    <footer></footer>
</div>
</body>
</html>
