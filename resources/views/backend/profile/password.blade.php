@extends('backend.layouts.mastar')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Profile</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Profile</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-7">
            <div class="card">

                @include('backend.partials.errors')

                <form id="addFrm" action="{{route('backend.updatepassword')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="card-title">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>
                                        Profile
                                    </h5>
                                </div>
                                <div class="col-md-6">

                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="oldpassword">Old Password</label>
                            <input type="password" class="form-control required" name="oldpassword" id="oldpassword"/>
                        </div>
                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input type="password" class="form-control required" name="password" id="password"/>
                        </div>
                        <div class="form-group">
                            <label for="confirmpassword">Confirm Password</label>
                            <input type="password" class="form-control required" name="confirmpassword" id="confirmpassword"/>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success float-right">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection


@section('script')

@endsection
