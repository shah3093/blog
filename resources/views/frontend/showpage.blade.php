@extends('frontend.layouts.mastar')

@section('metatag')
    <title>{{$page->title}}</title>
    <meta name="keywords" content="{{$page->seo_keywords}}">
    <meta name="description" content="{{$page->seo_descriptions}}">
    <meta name="author" content="Azad">

    <meta name="og:title" content="{{$page->title}}"/>
    <meta name="og:url" content="{{route('page',['slug'=>$page->slug])}}"/>
    <meta name="og:image" content="{{$page->featuredImage}}"/>
    <meta name="og:site_name" content="Azad Blogs"/>
    <meta name="og:description" content="{{$page->seo_descriptions}}"/>

    <meta name="twitter:card" content="{{$page->seo_descriptions}}">

@endsection

@section('content')

    <section class="site-section py-lg">
        <div class="container">
            <div class="row blog-entries">
                <div class="col-md-12 col-lg-8 main-content">
                    <h1 class="mb-4">{{$page->title}}</h1>
                    <div class="post-content-body">
                        {!! $page->content !!}
                    </div>

                </div>
                @include('frontend.partials.sidebar')
            </div>
        </div>
    </section>





@endsection

