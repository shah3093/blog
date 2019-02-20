@extends('frontend.layouts.mastar')

@section('content')

    <section class="site-section py-lg">
        <div class="container">
            <div class="row blog-entries">
                <div class="col-md-12 col-lg-8 main-content">
                    <div id="notfound">
                        <div class="notfound">
                            <div class="notfound-404">
                                <h1>Oops!</h1>
                            </div>
                            <h2>404 - Page not found</h2>
                            <p>The page you are looking for might have been removed had its name changed or is
                                temporarily unavailable.</p>
                            <a href="{{url("/")}}">Go To Homepage</a>
                        </div>
                    </div>
                </div>
                @include('frontend.partials.sidebar')
            </div>
        </div>
    </section>

@endsection

@section('styles')
    <link href="{{URL::asset('frontend/css/error.css')}}" rel="stylesheet"/>
@endsection
