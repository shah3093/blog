@extends('frontend.layouts.mastar')

@section('content')

    <section class="site-section py-lg">
        <div class="container">
            <div class="row blog-entries">
                <div class="col-md-12 col-lg-8 main-content">
                    <h1 class="mb-4">{{$post->title}}</h1>
                    <div class="post-meta">
                        <span class="category">{{$post->category->name}}</span>
                        <span class="mr-2">{{$post->created_at}} </span> &bullet;
                        <span class="ml-2"><span class="fa fa-comments"></span> 3</span>
                    </div>
                    <div class="post-content-body">
                        {!! $post->content !!}
                    </div>
                    <div class="pt-5">
                        <p> Tags: <a href="#">#manila</a>,
                            <a href="#">#asia</a></p>
                    </div>
                    {{--<div class="pt-5">--}}
                        {{--<h3 class="mb-5">6 Comments</h3>--}}
                        {{--<ul class="comment-list">--}}
                            {{--<li class="comment">--}}
                                {{--<div class="vcard">--}}
                                    {{--<img src="images/person_1.jpg" alt="Image placeholder">--}}
                                {{--</div>--}}
                                {{--<div class="comment-body">--}}
                                    {{--<h3>Jean Doe</h3>--}}
                                    {{--<div class="meta">January 9, 2018 at 2:21pm</div>--}}
                                    {{--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur quidem laborum--}}
                                        {{--necessitatibus, ipsam impedit vitae autem, eum officia, fugiat saepe enim--}}
                                        {{--sapiente--}}
                                        {{--iste iure! Quam voluptas earum impedit necessitatibus, nihil?</p>--}}
                                    {{--<p><a href="#" class="reply">Reply</a></p>--}}
                                {{--</div>--}}
                            {{--</li>--}}
                        {{--</ul>--}}

                        {{--<div class="comment-form-wrap pt-5">--}}
                            {{--<h3 class="mb-5">Leave a comment</h3>--}}
                            {{--<form action="#" class="p-5 bg-light">--}}
                                {{--<div class="form-group">--}}
                                    {{--<label for="name">Name *</label>--}}
                                    {{--<input type="text" class="form-control" id="name">--}}
                                {{--</div>--}}
                                {{--<div class="form-group">--}}
                                    {{--<label for="email">Email *</label>--}}
                                    {{--<input type="email" class="form-control" id="email">--}}
                                {{--</div>--}}
                                {{--<div class="form-group">--}}
                                    {{--<label for="website">Website</label>--}}
                                    {{--<input type="url" class="form-control" id="website">--}}
                                {{--</div>--}}
                                {{--<div class="form-group">--}}
                                    {{--<label for="message">Message</label>--}}
                                    {{--<textarea name="" id="message" cols="30" rows="10" class="form-control"></textarea>--}}
                                {{--</div>--}}
                                {{--<div class="form-group">--}}
                                    {{--<input type="submit" value="Post Comment" class="btn btn-primary">--}}
                                {{--</div>--}}
                            {{--</form>--}}
                        {{--</div>--}}
                    {{--</div>--}}
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
                        <a href="#" class="a-block d-flex align-items-center height-md" style="background-image: url('{{$post->featuredImage}}'); ">
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
