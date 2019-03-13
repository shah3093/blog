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

                    <div class="post-content-body mt-5-custom">
                        <div id="errordiv" style="color: red;"></div>
                        <form action="{{route('saveComments',['postid'=>$post->id])}}" method="post" class="mb-5-custom" autocomplete="off">
                            <div class="form-group">
                                <label for="comment">Comment:</label>
                                <textarea name="comment" placeholder="What are you doing right now?" class="form-control" rows="5" id="comment"></textarea>
                            </div>
                            @if(Auth::guard('visitor')->check() || Auth::guard('web')->check())
                                <button data-url="{{route('saveComments',['postid'=>$post->id])}}" id="savecomment" type="submit" class="btn btn-primary pull-right">
                                    Submit
                                </button>
                            @else
                                <a href="#" data-toggle="modal" data-target="#loginModal" type="submit" class="btn btn-primary pull-right">
                                    Submit
                                </a>
                                @include('frontend.partials.login')
                            @endif
                            {{--<a href="#" id="refreshcomment" class="btn btn-info pull-right mr-2">--}}
                            {{--<i class="fa fa-refresh"></i>--}}
                            {{--</a>--}}
                        </form>

                        <div id="commentsection"></div>

                    </div>
                </div>
                @include('frontend.partials.sidebar')
            </div>
        </div>
    </section>





@endsection



@section('script')
    <script>

        function getCommentSection() {
            var csrf = "{{csrf_token()}}";
            var comment = $("#comment").val();
            var url = "{{route('getcomments',['postid'=>$post->id])}}";
            $.post(url, {'_token': csrf, 'comment': comment}, function (resp) {
                $("#commentsection").html(resp);
                $("#errordiv").html("");
            });
        }

        getCommentSection();


        $("body").on('click', '#refreshcomment', function (e) {
            e.preventDefault();
            getCommentSection();
        });

        $("body").on('click', '#submitdata', function (e) {
            e.preventDefault();
            var url = $(this).data('url');
            var email = $("#email").val();
            var pwd = $("#pwd").val();
            var csrf = "{{csrf_token()}}";
            $.post(url, {'email': email, 'password': pwd, '_token': csrf}, function (resp) {
                if (resp != "DONE") {
                    $("#errordiv").html(resp);
                } else {
                    location.reload();
                }
            });
        });
        $("body").on('click', '#savecomment', function (e) {
            e.preventDefault();
            var url = $(this).data('url');
            var comment = $("#comment").val();
            var csrf = "{{csrf_token()}}";
            $.post(url, {'comment': comment, '_token': csrf}, function (resp) {
                if (resp != "DONE") {
                    $("#errordiv").html(resp);
                } else {
                    $("#comment").val("");
                    getCommentSection();
                }
            });
        });
    </script>
@endsection
