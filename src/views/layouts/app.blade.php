<!DOCTYPE html>
<html lang="en">
    @includeFirst(['sections.head', 'framework::sections.head'])
    <body id="page-top" class="{{(session()->get('sidebarMode', 'expanded') == 'expanded' ? '' : 'sidebar-toggled')}}">
        <!-- Page Wrapper -->
        <div id="wrapper">
            @includeFirst(['sections.sidebar', 'framework::sections.sidebar'])
            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">
                <!-- Main Content -->
                <div id="content">
                    @includeFirst(['sections.topbar', 'framework::sections.topbar'])
                    <!-- Begin Page Content -->
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                    <!-- /.container-fluid -->
                </div>
                <!-- End of Main Content -->
            </div>
            <!-- End of Content Wrapper -->
        </div>
        <!-- End of Page Wrapper -->
        <div class="loadingAjax"></div>
        <script src="{{ asset('/js/sb-admin-2.min.js') }}" type="text/javascript"></script>
    </body>
</html>
