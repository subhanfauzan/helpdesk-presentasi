<!doctype html>
<html lang="en">


<!-- Mirrored from themesbrand.com/symox/layouts/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 16 Mar 2022 01:30:44 GMT -->

<!-- header -->
@include('layouts.header')


<body data-layout="horizontal" data-topbar="dark" id="body_overflow">

    <!-- Begin page -->
    <div id="layout-wrapper">

        <!-- navbar -->
        @include('layouts.navbar')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <!-- content -->
            <!-- End Page-content -->
            @yield('content')

            @include('layouts.footer')
            <!-- footer -->
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    <!-- <a href="#" class="right-bar-toggle layout-setting-btn" id="right-bar-toggle">
        <i class="icon-sm mb-2" data-feather="settings"></i> <span class="align-middle">Settings</span>
    </a> -->


    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->

    @include('layouts.script')
    @yield('script')


    <!-- <script src="{{asset('public/assets/js/app.js')}}"></script> -->

</body>

<!-- Mirrored from themesbrand.com/symox/layouts/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 16 Mar 2022 01:31:08 GMT -->

</html>