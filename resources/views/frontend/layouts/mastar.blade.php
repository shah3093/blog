<!doctype html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('metatag')

    <link rel="stylesheet" href="{{URL::asset('frontend/fonts/vendor/flaticon/font/flaticon.css')}}">
    <link rel="stylesheet" href="{{URL::asset('frontend/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('frontend/css/animate.css')}}">

    <link href="{{mix('frontend/css/app.css')}}" rel="stylesheet"/>
    <link href="{{mix('frontend/css/all.css')}}" rel="stylesheet"/>
    <link href="{{URL::asset('frontend/css/custom.css')}}" rel="stylesheet"/>

    @yield('styles')
</head>
<body>
@include('frontend.partials.header')

@yield('top-categories')

@yield('content')

@yield('releated-post')

@include('frontend.partials.footer')


{{--<div id="loader" class="show fullscreen">--}}
    {{--<svg class="circular" width="48px" height="48px">--}}
        {{--<circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/>--}}
        {{--<circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#f4b214"/>--}}
    {{--</svg>--}}
{{--</div>--}}


<script src="{{mix('frontend/js/app.js')}}"></script>
{{--<script src="{{URL::asset('js/jquery-3.2.1.min.js')}}"></script>--}}
<script src="{{URL::asset('frontend/js/jquery-migrate-3.0.0.js')}}"></script>
{{--<script src="{{URL::asset('js/popper.min.js')}}"></script>--}}
{{--<script src="{{URL::asset('js/bootstrap.min.js')}}"></script>--}}
<script src="{{URL::asset('frontend/js/owl.carousel.min.js')}}"></script>
<script src="{{URL::asset('frontend/js/jquery.waypoints.min.js')}}"></script>
{{--<script src="{{URL::asset('js/jquery.stellar.min.js')}}"></script>--}}
<script src="{{URL::asset('frontend/js/main.js')}}"></script>
<script src="{{URL::asset('frontend/js/printThis.js')}}"></script>
<script src="{{URL::asset('frontend/js/custom.js')}}"></script>

@yield('script')

</body>
</html>
