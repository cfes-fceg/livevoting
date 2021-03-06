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
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    {!! \Biscolab\ReCaptcha\Facades\ReCaptcha::htmlScriptTagJsApi([]) !!}

</head>
<body class="d-flex flex-column h-100">
@if(!isset($excludeHeader) || !$excludeHeader)
    <header>
        @include('nav')
    </header>
    @include('no-save-warning')
@endif

<main class="py-4 flex-shrink-0">
    <div class="container">
        @yield('content')
    </div>
</main>

@include('footer')
<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>
@if(isset($triggerPrint) && $triggerPrint)
    <script type="text/javascript">
        window.print();
    </script>
@endif
</body>
</html>
