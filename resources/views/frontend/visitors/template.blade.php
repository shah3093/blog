@extends('frontend.layouts.mastar')


@section('content')

    <section class="site-section py-lg">
        <div class="container">
            <div class="row blog-entries">
                <div class="col-md-12 col-lg-8 main-content">
                    <h1 class="mb-4">Profile</h1>
                    <div class="post-content-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="profile-img">
                                    <i class="fa fa-5x fa-user"></i>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="profile-head">


                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-3" style="border-right: 1px solid darkgrey">
                                <div class="profile-work">
                                    <p></p>
                                    <a href="{{route('visitors.editname')}}">Edit Name</a><br/>
                                    <a href="{{route('visitors.editpassword')}}">Edit Password</a><br/>
                                    <a href="#">Bookmarks</a><br/>
                                    <a href="#">Comments</a><br/>
                                    <a href="#">Questions</a><br/>
                                </div>
                            </div>
                            <div class="col-md-9">
                                @yield('profileContainer')
                            </div>
                        </div>

                    </div>
                </div>

                @include('frontend.partials.sidebar')
            </div>
        </div>
    </section>

@section('profileContainer')
    <h1>He</h1>
@endsection



@endsection


