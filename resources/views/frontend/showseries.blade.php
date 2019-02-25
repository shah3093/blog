@extends('frontend.layouts.mastar')

@section('metatag')
    <title>{{$category->title}}</title>
    <meta name="keywords" content="{{$category->seo_keywords}}">
    <meta name="description" content="{{$category->seo_descriptions}}">
    <meta name="author" content="Azad">

    <meta name="og:title" content="{{$category->title}}"/>
    <meta name="og:url" content="{{route('post',['slug'=>$category->slug])}}"/>
    <meta name="og:image" content="{{$category->featuredImage}}"/>
    <meta name="og:site_name" content="Azad Blogs"/>
    <meta name="og:description" content="{{$category->seo_descriptions}}"/>

    <meta name="twitter:card" content="{{$category->seo_descriptions}}">

@endsection


@section('content')

    <section class="site-section py-lg">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    {!! $seriesstr !!}
                </div>
                <div class="col-md-8">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                        <button class="btn btn-primary" id="menu-toggle">Toggle Menu</button>
                    </nav>

                </div>
            </div>
        </div>
    </section>

@endsection

@section('styles')
    <link href="{{URL::asset('frontend/css/simple-sidebar.css')}}" rel="stylesheet"/>
@endsection

@section('script')
    <script>
        $("#menu-toggle").click(function (e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    </script>
@endsection

