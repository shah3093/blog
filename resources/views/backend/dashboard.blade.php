@extends('backend.layouts.mastar')

@section('content')
    <div class="row">
        <!-- Column -->

        <div class="col-md-6 col-lg-2 col-xlg-3">
            <div class="card card-hover">
                <div class="box bg-cyan text-center">
                    <a href="{{route('backend.categories.index')}}">
                        <h1 class="font-light text-white"><i class="mdi mdi-buffer"></i></h1>
                        <h6 class="text-white">Category</h6>
                    </a>
                </div>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-4 col-xlg-3">
            <div class="card card-hover">
                <div class="box bg-success text-center">
                    <a href="{{route('backend.posts.index')}}">
                        <h1 class="font-light text-white"><i class="mdi mdi-file"></i></h1>
                        <h6 class="text-white">Post</h6>
                    </a>
                </div>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-4 col-xlg-3">
            <div class="card card-hover">
                <div class="box bg-warning text-center">
                    <a href="{{route('backend.series.index')}}">
                        <h1 class="font-light text-white"><i class="mdi mdi-stairs"></i></h1>
                        <h6 class="text-white">Series</h6>
                    </a>
                </div>
            </div>
        </div>

        <!-- Column -->
        <div class="col-md-6 col-lg-2 col-xlg-3">
            <div class="card card-hover">
                <div class="box bg-info text-center">
                    <a href="{{route('backend.tags.index')}}">
                        <h1 class="font-light text-white"><i class="mdi mdi-tag"></i></h1>
                        <h6 class="text-white">Tag</h6>
                    </a>
                </div>
            </div>
        </div>
        <!-- Column -->
        <!-- Column -->
        <div class="col-md-6 col-lg-4 col-xlg-3">
            <div class="card card-hover">
                <div class="box bg-danger text-center">
                    <a href="{{route('backend.questions.index')}}">
                        <h1 class="font-light text-white"><i class="mdi mdi-comment-question-outline"></i></h1>
                        <h6 class="text-white">Question</h6>
                    </a>
                </div>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-2 col-xlg-3">
            <div class="card card-hover">
                <div class="box bg-info text-center">
                    <a href="{{route('backend.menus.index')}}">
                        <h1 class="font-light text-white"><i class="mdi mdi-menu"></i></h1>
                        <h6 class="text-white">Menu</h6>
                    </a>
                </div>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-2 col-xlg-3">
            <div class="card card-hover">
                <div class="box bg-cyan text-center">
                    <a href="{{route('backend.pages.index')}}">
                        <h1 class="font-light text-white"><i class="mdi mdi-page-layout-body"></i></h1>
                        <h6 class="text-white">Page</h6>
                    </a>
                </div>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-2 col-xlg-3">
            <div class="card card-hover">
                <div class="box bg-success text-center">
                    <a href="{{route('backend.extrafile.index')}}">
                        <h1 class="font-light text-white"><i class="mdi mdi-file-cloud"></i></h1>
                        <h6 class="text-white">Extra file</h6>
                    </a>
                </div>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-2 col-xlg-3">
            <div class="card card-hover">
                <div class="box bg-warning text-center">
                    <a href="{{route('backend.profile')}}">
                        <h1 class="font-light text-white"><i class="mdi mdi-face-profile"></i></h1>
                        <h6 class="text-white">Profile</h6>
                    </a>
                </div>
            </div>
        </div>
        <!-- Column -->
    </div>
@endsection
