<!DOCTYPE html>
<!--
    This is a starter template page. Use this page to start your new project from
    scratch. This page gets rid of all links and provides the needed markup only.
    -->
<html>

<head>
    <meta charset="UTF-8">
    <title>Bus Management | @yield('Page Title')</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <!-- CSRF -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap 3.3.2 -->
    <link href="{{ asset('bower_components/admin-lte/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet"
        type="text/css" />
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

<body class="skin-blue">
    <div class="wrapper">

        <!-- Header -->
        @include('admin/layouts/partials/header')

        <!-- Sidebar -->
        @include('admin/layouts/partials/sidebar')

        @yield('content')
        <!-- Content Wrapper. Contains page content -->
        {{-- <div class="content-wrapper"> --}}
        <!-- Content Header (Page header) -->
        {{-- <section class="content-header"> --}}
        {{-- <h1>
                        {{ $page_title or "Page Title" }}
                        <small>{{ $page_description or null }}</small>
                    </h1> --}}
        <!-- You can dynamically generate breadcrumbs here -->
        {{-- <ol class="breadcrumb"> --}}
        {{-- <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li> --}}
        {{-- <li class="active">Here</li>
                    </ol>
                </section> --}}

        <!-- Main content -->
        {{-- <section class="content"> --}}
        <!-- Your Page Content Here -->
        {{-- </section><!-- /.content --> --}}
        {{-- </div><!-- /.content-wrapper --> --}}

        <!-- Footer -->
        @include('admin/layouts/partials/footer')

    </div><!-- ./wrapper -->

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

    <!-- Bootstrap 3.3.2 JS -->
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

    @hasSection('addtional-scripts')
        @yield('addtional-scripts')
    @endif
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
    <!-- Optionally, you can add Slimscroll and FastClick plugins.
          Both of these plugins are recommended to enhance the
          user experience -->
</body>

</html>
