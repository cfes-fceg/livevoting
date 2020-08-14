<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="d-flex flex-column h-100">
<header>
    @include('nav')
</header>
@include('no-save-warning')

<main class="py-4 flex-shrink-0">
    <div class="container">
        @yield('content')
    </div>
</main>

@include('footer')
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
