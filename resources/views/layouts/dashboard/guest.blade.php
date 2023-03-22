<!DOCTYPE html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" />

        <!-- Fonts -->
        <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"> -->

        <!-- Styles -->
        <link rel="stylesheet" href="{{asset('css/guest/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/guest/vegas.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/guest/star-animation.css')}}">
        <link rel="stylesheet" href="{{asset('css/guest/fontawesome-all.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/guest.css')}}">
        <!-- remixicon -->
        <!-- <link rel="stylesheet" href="{{ asset('vendor/remixicon/fonts/remixicon.css') }}"/> -->

    </head>
    <body>
    {{--    <div class="wrapper">

        </div>--}}
        {{ $slot }}
        <script src="{{asset('js/guest/jquery-3.5.0.min.js') }}"></script>
        <script src="{{asset('js/guest/popper.min.js') }}"></script>
        <script src="{{asset('js/guest/bootstrap.min.js') }}"></script>
        <script src="{{asset('js/guest/imagesloaded.pkgd.min.js') }}"></script>
        <script src="{{asset('js/guest.js') }}"></script>
    </body>
</html>
