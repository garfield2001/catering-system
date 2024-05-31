<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    @stack('css')
</head>

<body class="@yield('body-class')">
    @yield('content')
    {{-- @stack('scripts') --}}
</body>

</html>
