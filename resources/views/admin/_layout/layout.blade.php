<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
    @include('admin._layout.partials.head')
    <body class="hold-transition sidebar-mini">
        <div class="wrapper">

            <!-- Navbar -->
            @include('admin._layout.partials.nav_bar')
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            @include('admin._layout.partials.side_bar')

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                @yield('content')
            </div>
            <!-- /.content-wrapper -->

            <!-- Main Footer -->
            @include('admin._layout.partials.footer')
        </div>
        <!-- ./wrapper -->
        @include('admin._layout.partials.scripts')
    </body>
</html>
