<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @section('fonts')
            <link rel="dns-prefetch" href="//fonts.gstatic.com">
            <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
        @show
        @section('css')
            <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        @show
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicons/favicon-96x96.png') }}">
    </head>
    <body>
        @yield('content')
        @section('js')
            <script src="{{ asset('js/app.js') }}" defer></script>
        @show
    </body>
</html>
