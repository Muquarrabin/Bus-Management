<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ticket Booking</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{asset('web/css/styles.css')}}" rel="stylesheet" />

    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet"
          type="text/css" />
    <!-- Ionicons -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Datatable -->
    <link href="{{ asset('bower_components/admin-lte/datatables.net-bs/css/dataTables.bootstrap.min.css') }}"
          rel="stylesheet" type="text/css" />
    <!--Datepicker -->
    <link href="{{ asset('bower_components/admin-lte/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}"
          rel="stylesheet" type="text/css" />
    <!--Timepicker -->
    <link href="{{ asset('bower_components/admin-lte/plugins/timepicker/bootstrap-timepicker.min.css') }}"
          rel="stylesheet" type="text/css" />
    <!--Select2 -->
    <link href="{{ asset('bower_components/admin-lte/select2/dist/css/select2.min.css') }}"
          rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{ asset('bower_components/admin-lte/dist/css/AdminLTE.min.css') }}" rel="stylesheet"
          type="text/css" />
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
              page. However, you can choose any other skin. Make sure you
              apply the skin class to the body tag so the changes take effect.
        -->
    <link href="{{ asset('bower_components/admin-lte/dist/css/skins/skin-blue.min.css') }}" rel="stylesheet"
          type="text/css" />
    <link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/sweetalert2/sweetalert2.min.css') }}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<!-- Responsive navbar-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Ticket Booking</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
{{--                <li class="nav-item"><a class="nav-link active" aria-current="page" href="#">Home</a></li>--}}
{{--                <li class="nav-item"><a class="nav-link" href="#">Link</a></li>--}}
{{--                <li class="nav-item dropdown">--}}
{{--                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Dropdown</a>--}}
{{--                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">--}}
{{--                        <li><a class="dropdown-item" href="#">Action</a></li>--}}
{{--                        <li><a class="dropdown-item" href="#">Another action</a></li>--}}
{{--                        <li><hr class="dropdown-divider" /></li>--}}
{{--                        <li><a class="dropdown-item" href="#">Something else here</a></li>--}}
{{--                    </ul>--}}
{{--                </li>--}}
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                @else
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/ticket/book-ticket/details') }}">Back to Booking Details</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>

        </div>
    </div>
</nav>
<!-- Page content-->
<div class="container">
{{--    <div class="text-center mt-5">--}}
{{--        <h1>A Bootstrap 5 Starter Template</h1>--}}
{{--        <p class="lead">A complete project boilerplate built with Bootstrap</p>--}}
{{--        <p>Bootstrap v5.1.3</p>--}}
{{--    </div>--}}
    @yield('content')
</div>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.1.3 -->
<script src="{{ asset('bower_components/admin-lte/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/jquery-validation/dist/jquery.validate.min.js') }}">
</script>
<script
    src="{{ asset('bower_components/admin-lte/plugins/jquery-validation-unobtrusive/jquery.validate.unobtrusive.min.js') }}">
</script>
{{-- ajax header setup --}}
<script src="{{ asset('js/ajaxSetup.js') }}"></script>

{{--<!-- Bootstrap 3.3.2 JS -->--}}
<script src="{{ asset('bower_components/admin-lte/bootstrap/dist/js/bootstrap.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>


<!-- Datatables -->
<script src="{{ asset('bower_components/admin-lte/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/datatables.net-bs/js/dataTables.bootstrap.min.js') }}">
</script>

<!-- DatePicker -->
<script src="{{ asset('bower_components/admin-lte/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<!-- TimePicker -->
<script src="{{ asset('bower_components/admin-lte/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('bower_components/admin-lte/select2/dist/js/select2.full.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('bower_components/admin-lte/dist/js/adminlte.min.js') }}" type="text/javascript"></script>

<!-- Core theme JS-->
<script src="{{asset('web/js/scripts.js')}}"></script>
@hasSection('addtional-scripts')
    @yield('addtional-scripts')
@endif
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
</body>
</html>
