<!doctype html>
<html class="h-100" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon.png') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link href="{{ asset('assets/plugins/toastr/css/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/fullcalendar/css/fullcalendar.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/theme.css') }}" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss'])
</head>
<body class="h-100">

    @include('includes.preloader')

    <div id="app" class="h-100">
        <div id="main-wrapper">

            @include('includes.navheader')

            @include('includes.header')

            @include('includes.sidebar')

            <div class="content-body">

                @include('includes.breadcrumbs')

                <div class="container-fluid">

                    @include('includes.alerts.redirect-response')

                    @yield('content')

                </div>

            </div>

        </div>

        @include('includes.footer')

    </div>

    <script src="{{ asset('assets/plugins/common/common.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom.min.js') }}"></script>
    <script src="{{ asset('assets/js/settings.js') }}"></script>
    <script src="{{ asset('assets/js/gleek.js') }}"></script>
    <script src="{{ asset('assets/js/styleSwitcher.js') }}"></script>

    <script src="{{ asset('assets/plugins/jqueryui/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/fullcalendar/js/fullcalendar.min.js') }}"></script>

    @vite(['resources/js/event-calendar.js'])

    @stack('scripts')
</body>
</html>
