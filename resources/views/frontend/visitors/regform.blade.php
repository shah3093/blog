@extends('frontend.layouts.mastar')


@section('content')

    <section class="site-section py-lg">
        <div class="container">
            <div class="row blog-entries">
                <div class="col-md-12 col-lg-8 main-content">
                    <div class="col-md-12 col-lg-8 main-content">
                        <h1 class="mb-4">Registration Forms</h1>
                        <div class="post-content-body">
                            @include('frontend.partials.errors')
                            <form action="{{route('visitors.registradb')}}" method="post" autocomplete="off" >
                                @csrf
                                <div class="form-group">
                                    <label for="name">Name:</label>
                                    <input value="{{old('name')}}" name="name" type="text" class="form-control" id="name">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email address:</label>
                                    <input value="{{old('email')}}" name="email" type="email" class="form-control" id="email">
                                </div>
                                <div class="form-group">
                                    <label for="pwd">Password:</label>
                                    <input name="password" type="password" class="form-control" id="pwd">
                                </div>

                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>

                    </div>

                </div>
                @include('frontend.partials.sidebar')
            </div>
        </div>
    </section>





@endsection

