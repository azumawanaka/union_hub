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

    <!-- Scripts -->
    @if(auth()->user()->role === 1)
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @else
        @vite(['resources/sass/app.scss'])
    @endif

    <!-- Custom Stylesheet -->
    <link href="{{ asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
    <!-- Daterange picker plugins css -->
    <link href="{{ asset('assets/plugins/timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/plugins/tables/css/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/plugins/toastr/css/toastr.min.css') }}" rel="stylesheet">
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

                    @include('includes.alerts.redirect-response')

                    @yield('content')

                    @include('pages.modals.delete-confirmation')

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

    <script src="{{ asset('assets/plugins/tables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/tables/js/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/tables/js/datatable-init/datatable-basic.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>
    <!-- Clock Plugin JavaScript -->
    <script src="{{ asset('assets/plugins/clockpicker/dist/jquery-clockpicker.min.js') }}"></script>
    <!-- Date Picker Plugin JavaScript -->
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <!-- Date range Plugin JavaScript -->
    <script src="{{ asset('assets/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

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
