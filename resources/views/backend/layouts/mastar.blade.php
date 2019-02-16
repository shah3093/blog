<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{URL::asset("backend/assets/images/favicon.png")}}">
    <title>Matrix Template - The Ultimate Multipurpose admin template</title>


    <link href="{{URL::asset("backend/dist/css/style.min.css")}}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{URL::asset("backend/custom/css/custom.css")}}" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <script src="{{URL::asset("backend/assets/libs/jquery/dist/jquery.min.js")}}"></script>
    @yield('stylesheet')
</head>
<body>
<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div class="preloader">
    <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
    </div>
</div>
<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<div id="main-wrapper">
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->
@include('backend.partials.header')
<!-- ============================================================== -->
    <!-- End Topbar header -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
@include('backend.partials.leftsidebar')
<!-- ============================================================== -->
    <!-- End Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
    @yield('breadcrumb')

    <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->
        @yield('content')

        <!-- ============================================================== -->
            <!-- End PAge Content -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Right sidebar -->
            <!-- ============================================================== -->
            <!-- .right-sidebar -->
            <!-- ============================================================== -->
            <!-- End Right sidebar -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
        <footer class="footer text-center">
            All Rights Reserved by Matrix-admin. Designed and Developed by <a href="https://wrappixel.com">WrapPixel</a>.
        </footer>
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->

<!-- All Jquery -->
<!-- ============================================================== -->
<script src="{{URL::asset("backend/dist/js/jquery.ui.touch-punch-improved.js")}}"></script>
<script src="{{URL::asset("backend/dist/js/jquery-ui.min.js")}}"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="{{URL::asset("backend/assets/libs/popper.js/dist/umd/popper.min.js")}}"></script>
<script src="{{URL::asset("backend/assets/libs/bootstrap/dist/js/bootstrap.min.js")}}"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="{{URL::asset("backend/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js")}}"></script>
<script src="{{URL::asset("backend/assets/extra-libs/sparkline/sparkline.js")}}"></script>
<!--Wave Effects -->
<script src="{{URL::asset("backend/dist/js/waves.js")}}"></script>
<!--Menu sidebar -->
<script src="{{URL::asset("backend/dist/js/sidebarmenu.js")}}"></script>
<!--Custom JavaScript -->
<script src="{{URL::asset("backend/dist/js/custom.min.js")}}"></script>
<!--Sweet Alert---->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>


    /*Delete data sweet alert */
    $(".deletedatafrm").on("click", function (event) {
        event.preventDefault();
        var url = $(this).attr("href");
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this data!",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    $(this).submit();
                }
            });
    });

</script>

@yield('script')

</body>
</html>
