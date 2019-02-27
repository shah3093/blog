@extends('frontend.layouts.mastar')

@section('metatag')
    <title>{{$series->title}}</title>
    <meta name="keywords" content="{{$series->seo_keywords}}">
    <meta name="description" content="{{$series->seo_descriptions}}">
    <meta name="author" content="Azad">

    <meta name="og:title" content="{{$series->title}}"/>
    <meta name="og:url" content="{{route('post',['slug'=>$series->slug])}}"/>
    <meta name="og:image" content="{{$series->featuredImage}}"/>
    <meta name="og:site_name" content="Azad Blogs"/>
    <meta name="og:description" content="{{$series->seo_descriptions}}"/>

    <meta name="twitter:card" content="{{$series->seo_descriptions}}">

@endsection


@section('content')

    <section class="site-section py-lg">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h2>{{$series->name}}</h2>
                    <button style="margin-bottom: 25px" class="btn btn-primary d-md-none d-lg-none d-xl-none" data-toggle="collapse" data-target="#demo">
                        <i class="fa fa-bars"></i>
                        Sidebar menu
                    </button>
                    <ul class="nav flex-column collapse d-none d-sm-none d-md-block" id="demo">
                        @foreach($results as $result)
                            <li class="nav-item">
                                <a class="nav-link" href="#">{{$result['name']}}</a>
                                <ul>
                                    @foreach($result['posts'] as $upost)
                                        <?php
                                        $tmparray[] = $upost['slug'];
                                        $cattmparray[$upost['slug']] = $result['slug']
                                        ?>
                                        <li class="nav-item">
                                            <a {!! $upost->id == $post->id ? 'style="color: gray"':"" !!} class="nav-link" href="{{route('aseries',['sslug'=>$series->slug,'catslug'=>$result['slug'],'pslug'=>$upost->slug])}}">{{$upost->title}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="col-md-8">
                    <?php
                    $key = array_search($post->slug, $tmparray);
                    $previouslug = "";
                    $catpreviousslug = "";
                    $nextslug = "";
                    $catnextslug = "";
                    if($key != 0) {
                        $previouslug = $tmparray[$key - 1];
                        $catpreviousslug = $cattmparray[$previouslug];
                    }
                    if(isset($tmparray[$key + 1])) {
                        $nextslug = $tmparray[$key + 1];
                        $catnextslug = $cattmparray[$nextslug];
                    }
                    ?>
                    <h2>{{$post->title}}</h2>
                    <div class="row" style="margin-bottom: 25px;margin-top: 15px">
                        <div class="col">
                            @if($previouslug != "")
                                <a href="{{route('aseries',['sslug'=>$series->slug,'catslug'=>$catpreviousslug,'pslug'=>$previouslug])}}" class="btn pull-left btn-success">Previous</a>
                            @else
                                <a disabled="true" href="#" class="btn pull-left btn-success disabled">Previous</a>
                            @endif
                        </div>
                        <div class="col">
                            @if($nextslug != "")
                                <a href="{{route('aseries',['sslug'=>$series->slug,'catslug'=>$catnextslug,'pslug'=>$nextslug])}}" class="btn pull-right btn-success">Next</a>
                            @else
                                <a href="#"  disabled="true" class="btn pull-right btn-success disabled">Next</a>
                            @endif
                        </div>
                    </div>
                    {!! $post->content !!}
                    <div class="row" style="margin-top: 25px">
                        <div class="col">
                            @if($previouslug != "")
                                <a href="{{route('aseries',['sslug'=>$series->slug,'catslug'=>$catpreviousslug,'pslug'=>$previouslug])}}" class="btn pull-left btn-success">Previous</a>
                            @else
                                <a disabled="true" href="#" class="btn pull-left btn-success disabled">Previous</a>
                            @endif
                        </div>
                        <div class="col">
                            @if($nextslug != "")
                                <a href="{{route('aseries',['sslug'=>$series->slug,'catslug'=>$catnextslug,'pslug'=>$nextslug])}}" class="btn pull-right btn-success">Next</a>
                            @else
                                <a href="#"  disabled="true" class="btn pull-right btn-success disabled">Next</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')
    <script>

        $('#demo').on('hidden.bs.collapse', function () {
            $("#demo").removeClass("d-none d-sm-none d-md-block");
        });
        //
        // $('#demo').on('hide.bs.collapse', function () {
        //    $("#demo").addClass("d-none d-sm-none d-md-block");
        // });
        $(window).resize(function () {
            var width = $(window).width();
            console.log(width);
            if (width > 720) {
                $("#demo").addClass("d-none d-sm-none d-md-block");
            }
        });
    </script>
@endsection

