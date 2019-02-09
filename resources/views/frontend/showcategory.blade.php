@extends('frontend.layouts.mastar')

@section('content')
    <section class="site-section">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h2 class="mb-4">Category: {{$category->name}}</h2>
                </div>
            </div>
            <div class="row blog-entries">
                <div class="col-md-12 col-lg-8 main-content">
                    <div class="row mb-5 mt-5">
                        <div class="col-md-12">
                            @foreach($posts as $post)
                                <div class="post-entry-horzontal">
                                    <a href="{{route('showpost',['slug'=>$post->slug])}}">
                                        <div class="image element-animate" data-animate-effect="fadeIn" style="background-image: url('{{$post->featuredImage}}');"></div>
                                        <span class="text">
<div class="post-meta">
<span class="mr-2">{{$post->created_At}}</span> &bullet;
<span class="ml-2"><span class="fa fa-comments"></span> 3</span>
</div>
<h2>{{$post->title}}</h2>
</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
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
