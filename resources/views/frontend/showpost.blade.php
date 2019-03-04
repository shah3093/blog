@extends('frontend.layouts.mastar')

@section('metatag')
    <title>{{$post->title}}</title>
    <meta name="keywords" content="{{$post->seo_keywords}}">
    <meta name="description" content="{{$post->seo_descriptions}}">
    <meta name="author" content="Azad">

    <meta name="og:title" content="{{$post->title}}"/>
    <meta name="og:url" content="{{route('post',['slug'=>$post->slug])}}"/>
    <meta name="og:image" content="{{$post->featuredImage}}"/>
    <meta name="og:site_name" content="Azad Blogs"/>
    <meta name="og:description" content="{{$post->seo_descriptions}}"/>

    <meta name="twitter:card" content="{{$post->seo_descriptions}}">

@endsection


@section('content')

    <section class="site-section py-lg">
        <div class="container">
            <div class="row blog-entries">
                <div class="col-md-12 col-lg-8 main-content">
                    <h1 id="post-header" class="mb-4">{{$post->title}}</h1>
                    <div class="post-meta">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                @if(isset($post->category->name))
                                    <a class="category" href="{{route('category',['slug'=>$post->category->slug])}}">{{$post->category->name}}</a>
                                @endif
                                <span class="mr-2">{{$post->created_at}} </span>
                                @if($post->tags->count() > 0)
                                    <div>
                                        <p> Tags:
                                            @foreach($post->tags as $tag)
                                                <a href="{{route('tag',['name'=>$tag->name])}}">#{{$tag->name}}</a>,
                                            @endforeach
                                        </p>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <span class="pull-right">
                            <a href="https://twitter.com/share?url={{route('post',['slug'=>$post->slug])}}" data-toggle="tooltip" title="Share on twitter" class="btn category btn-social shareweb">
                                <i class="fa fa-twitter"></i>
                            </a>
                            <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{route('post',['slug'=>$post->slug])}}" data-toggle="tooltip" title="Share on facebook" class="btn category shareweb btn-social" style="color: black">
                                <i class="fa fa-facebook"></i>
                            </a>
                            <a href="#" data-toggle="tooltip" title="Print" id="print-post" class="btn category btn-social">
                                <i class="fa fa-print"></i>
                            </a>
                            <a href="{{route('pdf',['type'=>'post','slug'=>$post->slug])}}" data-toggle="tooltip" title="PDF" class="btn category btn-social">
                                <i class="fa fa-file-pdf-o"></i>
                            </a>

                        </span>
                            </div>
                        </div>


                    </div>
                    <div class="post-content-body">
                        {!! $post->content !!}
                    </div>
                    @if($post->tags->count() > 0)
                        <div class="pt-5">
                            <p> Tags:
                                @foreach($post->tags as $tag)
                                    <a href="{{route('tag',['name'=>$tag->name])}}">#{{$tag->name}}</a>,
                                @endforeach
                            </p>
                        </div>
                    @endif
                </div>
                @include('frontend.partials.sidebar')
            </div>
        </div>
    </section>





@endsection

@section('releated-post')
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mb-3 ">Related Post</h2>
                </div>
            </div>
            <div class="row">
                @foreach($releteadposts as $post)
                    <div class="col-md-6 col-lg-4 item" style="max-width: 100% !important;">
                        <a href="{{route('post',['slug'=>$post->slug])}}" class="a-block d-flex align-items-center height-md" style="background-image: url('{{$post->featuredImage}}'); ">
                            <div class="text">
                                <h3>{{$post->title}}</h3>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
