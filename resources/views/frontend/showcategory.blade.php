@extends('frontend.layouts.mastar')

@section('metatag')
    <title>{{$category->name}}</title>
    <meta name="keywords" content="{{$category->seo_keywords}}">
    <meta name="description" content="{{$category->seo_descriptions}}">
    <meta name="author" content="Azad">

    <meta name="og:title" content="{{$category->name}}"/>
    <meta name="og:url" content="{{route('category',['slug'=>$category->slug])}}"/>
    <?php
    $url = "";
    $check = preg_match('/category/', $category->featuredImage);
    if (empty($check)) {
        $url = $category->featuredImage;
    } else {
        $url = Storage::url($category->featuredImage);
    }
    ?>
    <meta name="og:image" content="{{$url}}"/>
    <meta name="og:site_name" content="Azad Blogs"/>
    <meta name="og:description" content="{{$category->seo_descriptions}}"/>

    <meta name="twitter:card" content="{{$category->seo_descriptions}}">

@endsection


@section('content')
    <section class="site-section">
        <div class="container">
            <div class="row mb-4">
                <div class="col">
                    <h2 class="mb-4">Category: {{$category->name}}</h2>
                </div>
            </div>
            <div class="row blog-entries">
                <div class="col-md-12 col-lg-8 main-content">
                    <div class="row mb-5 mt-5">
                        <div class="col">
                            @foreach($posts as $post)
                                <?php
                                $url = "";
                                $check = preg_match('/post/', $post->featuredImage);
                                if (empty($check)) {
                                    $url = $post->featuredImage;
                                } else {
                                    $url = Storage::url($post->featuredImage);
                                }
                                ?>
                                <div class="post-entry-horzontal">
                                    <a href="{{route('post',['slug'=>$post->slug])}}">
                                        <div class="image element-animate custom-image" data-animate-effect="fadeIn"
                                             style="background-image: url('{{$url}}');"></div>
                                        <span class="text custom-text">
                                            <h2>{{$post->title}}</h2>
                                            <p>{{$post->excerpt}}</p>
                                        </span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <div class="col text-center">
                            <nav aria-label="Page navigation" class="text-center">
                                {{ $posts->links('frontend.partials.template-paginate') }}
                            </nav>
                        </div>
                    </div>
                </div>
                @include('frontend.partials.sidebar')
            </div>
        </div>
    </section>
@endsection
