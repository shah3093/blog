@extends('frontend.layouts.mastar')

@section('top-categories')
    <section class="site-section pt-5 d-none d-sm-none d-md-none d-lg-block">
        <div class="container">
            <div class="row owl-carousel owl-theme">
                @foreach($categoriesTopPage as $category)
                    <div class="col-md-6 col-lg-4 item" style="max-width: 100% !important;">
                        <?php
                        $url = "";
                        $check = preg_match('/category/', $category->featuredImage);
                        if(empty($check)) {
                            $url = $category->featuredImage;
                        } else {
                            $url = Storage::url($category->featuredImage);
                        }
                        ?>
                        <a href="{{route('category',['slug'=>$category->slug])}}" class="a-block d-flex align-items-center height-md" style="background-image: url('{{$url}}'); ">
                            <div class="text">
                                <h3>{{$category->name}}</h3>
                            </div>
                        </a>
                    </div>
                @endforeach
                @foreach($postsTopPage as $post)
                    <div class="col-md-6 col-lg-4 item" style="max-width: 100% !important;">
                        <?php
                        $url = "";
                        $check = preg_match('/post/', $post->featuredImage);
                        if(empty($check)) {
                            $url = $post->featuredImage;
                        } else {
                            $url = Storage::url($post->featuredImage);
                        }
                        ?>
                        <a href="{{route('post',['slug'=>$post->slug])}}" class="a-block d-flex align-items-center height-md" style="background-image: url('{{$url}}'); ">
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

@section('content')
    <section class="site-section py-sm">
        <div class="container">
            <div class="row blog-entries">
                <div class="col main-content">

                    <div class="row">
                        @foreach($posts as $post)
                            <div class="col-md-6">
                                <a href="{{route('post',['slug'=>$post->slug])}}" class="blog-entry element-animate" data-animate-effect="fadeIn">
                                    <?php
                                    $url = "";
                                    $check = preg_match('/post/', $post->featuredImage);
                                    if(empty($check)) {
                                        $url = $post->featuredImage;
                                    } else {
                                        $url = Storage::url($post->featuredImage);
                                    }
                                    ?>

                                    <img src="{{$url}}" alt="{{$post->title}}">
                                    <div class="blog-content-body">
                                        <div class="post-meta">
                                            <span class="category">
                                                @if(isset($post->category->name))
                                                    {{$post->category->name}}
                                                @endif
                                            </span>
                                            <span class="mr-2">{{$post->created_at}} </span>
                                        </div>
                                        <h2>{{$post->title}}</h2>
                                    </div>
                                </a>
                            </div>
                        @endforeach
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

@section('script')
    <script>
        $('.owl-carousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: true
        })
    </script>
@endsection

