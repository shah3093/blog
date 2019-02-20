<!doctype html>
<html lang="en">
<head>
    <title>Colorlib Balita &mdash; Minimal Blog Template</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: kalpurush !important;
        }
    </style>
</head>
<body>
<section class="site-section py-lg">
    <div class="container">
        <div class="row blog-entries">
            <div class="col-md-12 col-lg-8 main-content">
                <h1 class="mb-4">{{$post->title}}</h1>
                <div class="post-meta">
                    <span class="mr-2">{{$post->created_at}} </span>
                </div>
                <div class="post-content-body">
                    {!! $post->content !!}
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>





