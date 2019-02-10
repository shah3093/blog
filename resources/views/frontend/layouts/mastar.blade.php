<!doctype html>
<html lang="en">
<head>
    <title>Colorlib Balita &mdash; Minimal Blog Template</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{URL::asset('frontend/fonts/vendor/flaticon/font/flaticon.css')}}">
    <link rel="stylesheet" href="{{URL::asset('frontend/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('frontend/css/animate.css')}}">

    <meta http-equiv="content-type" content="text/html;charset=UTF-8"/>

    <link href="{{mix('frontend/css/app.css')}}" rel="stylesheet"/>
    <link href="{{mix('frontend/css/all.css')}}" rel="stylesheet"/>

    @yield('styles')
</head>
<body>
@include('frontend.partials.header')

@yield('top-categories')

@yield('content')

@yield('releated-post')

@include('frontend.partials.footer')


<div id="loader" class="show fullscreen">
    <svg class="circular" width="48px" height="48px">
        <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/>
        <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#f4b214"/>
    </svg>
</div>


<script src="{{mix('frontend/js/app.js')}}"></script>
{{--<script src="{{URL::asset('js/jquery-3.2.1.min.js')}}"></script>--}}
<script src="{{URL::asset('frontend/js/jquery-migrate-3.0.0.js')}}"></script>
{{--<script src="{{URL::asset('js/popper.min.js')}}"></script>--}}
{{--<script src="{{URL::asset('js/bootstrap.min.js')}}"></script>--}}
<script src="{{URL::asset('frontend/js/owl.carousel.min.js')}}"></script>
<script src="{{URL::asset('frontend/js/jquery.waypoints.min.js')}}"></script>
{{--<script src="{{URL::asset('js/jquery.stellar.min.js')}}"></script>--}}
<script src="{{URL::asset('frontend/js/main.js')}}"></script>

@yield('script')

</body>
</html>
