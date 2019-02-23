@extends('backend.layouts.mastar')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Tag</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tag</li>
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

                <form id="addFrm" action="{{route('backend.tags.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="card-title">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>
                                        Category
                                    </h5>
                                </div>
                                <div class="col-md-6">
                                    <div class="ml-auto text-right">
                                        <a href="{{route('backend.tags.index')}}" class="btn btn-sm btn-danger">
                                            <i class="mdi mdi-skip-backward"></i>
                                            Back
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name">Name <span class="text-danger">*</span></label>
                            <input type="text" id="name" class="form-control required" value="{{old('name')}}" name="name" placeholder="Name"/>
                        </div>
                    </div>
                    <div class="card-footer">

                        <a href="{{route('backend.tags.index')}}" type="submit" class="btn btn-danger">Cancel</a>
                        <button type="submit" class="btn btn-success float-right">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection


@section('script')
    <script src="{{URL::asset('backend/custom/scripts/custom.js')}}"></script>

@endsection
