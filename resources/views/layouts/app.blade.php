<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">


@include('includes.header')


<body class="hold-transition sidebar-mini">
    <div id="app">
        <div class="wrapper">
            <!-- Navbar -->
        @include('includes.navbar')
        <!-- /.navbar -->

            <!-- Main Sidebar Container -->
        @include('includes.sidebar')

        <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Main content -->
                @yield('content')
            <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <!-- Main Footer -->
            @include('includes.footer')

        </div>
    </div>

@include('includes.scripts')
</body>
</html>
