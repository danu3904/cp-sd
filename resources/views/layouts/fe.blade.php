<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>SD Negeri 05 Taman</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="{{asset('favicon.ico')}}" rel="icon">

    @include('includes.fe.style')
    @yield('style')

    @stack('styles')
</head>

<body>
    <!-- Navbar Start -->
    @include('includes.fe.navbar')
    <!-- Navbar End -->

    @yield('content')

    <!-- Footer Start -->
    @include('includes.fe.footer')
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary p-3 back-to-top"><i class="fa fa-angle-double-up"></i></a>


    @include('includes.fe.script')
    @yield('script')
</body>

</html>