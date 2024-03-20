<!-- Start header -->
@include('backend.layouts.header')
<!-- End header -->

<!-- Start leftsidebar -->
@include('backend.layouts.leftsidebar')
<!-- End leftsidebar -->

    <!-- Main Content -->
    @yield('content')
    <!-- End of Main Content -->

<!-- Start Footer -->
@include('backend.layouts.footer')
<!-- End Footer -->