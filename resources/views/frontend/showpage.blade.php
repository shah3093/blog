@extends('frontend.layouts.mastar')

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

