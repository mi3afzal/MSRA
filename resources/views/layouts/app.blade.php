<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('partials._adminHead')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        @include('partials._adminNavbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('partials._adminMainSidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            @include('partials._breadcrumb')

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    @yield('content')
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        @include('partials._adminFooter')

        <!-- Control Sidebar -->
        @include('partials._adminControlSidebar')
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

</body>

</html>