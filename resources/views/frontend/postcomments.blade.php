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
                    <a href="{{route('post',['slug'=>$post->slug])}}" target="_blank">
                        <h1 class="mb-4">{{$post->title}}</h1>
                    </a>

                    <div class="post-content-body">
                        <div id="errordiv" style="color: red;"></div>
                        <form action="{{route('saveComments',['postid'=>$post->id])}}" method="post" class="mb-5-custom" autocomplete="off">
                            <div class="form-group">
                                <label for="comment">Comment:</label>
                                <textarea name="comment" placeholder="What are you doing right now?" class="form-control" rows="5" id="comment"></textarea>
                            </div>
                            @auth('visitor')
                                <button data-url="{{route('saveComments',['postid'=>$post->id])}}" id="savecomment" type="submit" class="btn btn-primary pull-right">
                                    Submit
                                </button>
                            @endauth
                            @guest('visitor')
                                <a href="#" data-toggle="modal" data-target="#loginModal" type="submit" class="btn btn-primary pull-right">
                                    Submit
                                </a>
                                @include('frontend.partials.login')
                            @endguest
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
                    getCommentSection();
                }
            });
        });
    </script>
@endsection



