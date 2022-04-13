<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App Url -->
    <meta name="app-url" content="{{ url('/') }}">
    <!-- Favicon -->
    <link rel="icon" href="{{asset('asset/img/favicon-32x32.png')}}" type="image/png" sizes="32x32">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('asset/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Sweetalert2 -->
    <link rel="stylesheet" href="{{asset('asset/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">

    <!-- Daterange picker -->
    <link rel="stylesheet" href=" {{asset('asset/plugins/daterangepicker/daterangepicker.css')}}">

    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('asset/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('asset/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
{{--    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">--}}
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">

    <!-- Full calendar -->
    <link rel="stylesheet" href=" {{asset('asset/plugins/fullcalendar/lib/main.css')}}">

    <!-- Select 2 -->
    <link rel="stylesheet" href="{{asset('asset/plugins/select2/css/select2.css')}}">
    <link rel="stylesheet" href="{{asset('asset/plugins/select2-bootstrap4-theme/select2-bootstrap4.css')}}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('asset/css/adminlte.min.css')}}">


    <!-- Styles -->
    <link href="{{ asset('asset/css/custom.css') }}" rel="stylesheet">

    @stack('css')
</head>
