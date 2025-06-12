<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Simple Task Management')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css?v=' . filemtime(public_path('css/app.css'))) }}">
</head>

<body>
    <!-- @include('layouts.partials.header') -->
    <main class="container">
        @yield('content')
    </main>
    <!-- @include('layouts.partials.footer') -->
</body>

</html>