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


    <!-- Chartist -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/chartist/css/chartist.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css') }}">

    <link href="{{ asset('assets/plugins/toastr/css/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/fullcalendar/css/fullcalendar.min.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/plugins/tables/css/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss'])

    <link href="{{ asset('assets/css/theme.css') }}" rel="stylesheet">
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

    <!-- Chartjs -->
    <script src="{{ asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
    <!-- Circle progress -->
    <script src="{{ asset('assets/plugins/circle-progress/circle-progress.min.js') }}"></script>
    <!-- Datamap -->
    <script src="{{ asset('assets/plugins/d3v3/index.js') }}"></script>
    <script src="{{ asset('assets/plugins/topojson/topojson.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datamaps/datamaps.world.min.js') }}"></script>
    <!-- Morrisjs -->
    <script src="{{ asset('assets/plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/morris/morris.min.js') }}"></script>
    <!-- Pignose Calender -->
    <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/pg-calendar/js/pignose.calendar.min.js') }}"></script>
    <!-- ChartistJS -->
    <script src="{{ asset('assets/plugins/chartist/js/chartist.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/jqueryui/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/fullcalendar/js/fullcalendar.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/tables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/tables/js/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/tables/js/datatable-init/datatable-basic.min.js') }}"></script>

    @vite(['resources/js/view-event-calendar.js'])

    <!-- Toastr -->
    <script src="{{ asset('assets/plugins/toastr/js/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/toastr/js/toastr.init.js') }}"></script>

    <script>
        function triggerToaster(msg) {
            toastr.success(msg,
                "Success",
                {
                    timeOut:5e3,
                    closeButton:!0,
                    debug:!1,
                    newestOnTop:!0,
                    progressBar:!0,
                    positionClass:"toast-top-right",
                    preventDuplicates:!0,
                    onclick:null,
                    showDuration:"300",
                    hideDuration:"1000",
                    extendedTimeOut:"1000",
                    showEasing:"swing",
                    hideEasing:"linear",
                    showMethod:"fadeIn",
                    hideMethod:"fadeOut",
                    tapToDismiss:!1
                }
            )
        }
        function triggerErrorToaster(msg) {
            toastr.error(msg,
                "Error",
                {
                    timeOut:5e3,
                    closeButton:!0,
                    debug:!1,
                    newestOnTop:!0,
                    progressBar:!0,
                    positionClass:"toast-top-right",
                    preventDuplicates:!0,
                    onclick:null,
                    showDuration:"300",
                    hideDuration:"1000",
                    extendedTimeOut:"1000",
                    showEasing:"swing",
                    hideEasing:"linear",
                    showMethod:"fadeIn",
                    hideMethod:"fadeOut",
                    tapToDismiss:!1
                }
            )
        }
    </script>
    @stack('scripts')
</body>
</html>
