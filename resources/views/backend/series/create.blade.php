@extends('backend.layouts.mastar')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Category</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Series</li>
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

                <form id="addFrm" action="{{route('backend.series.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="card-title">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>
                                        Series
                                    </h5>
                                </div>
                                <div class="col-md-6">
                                    <div class="ml-auto text-right">
                                        <a href="{{route('backend.series.index')}}" class="btn btn-sm btn-danger">
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

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="image">Featured image <span class="text-danger">*</span></label>
                                    <input type="file" value="{{old('image')}}" id="image" class="required image form-control" name="image"/>
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-3">
                                <div class="form-group">

                                    <div class="row text-center">
                                        <label for="name"> Homepage Top </label>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" value="1" class="custom-control-input" id="top1" name="homepageTop">
                                                <label class="custom-control-label" for="top1">Yes</label>
                                            </div>
                                        </div>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-4">
                                            <div class="custom-control custom-radio">
                                                <input checked value="0" type="radio" class="custom-control-input" id="top2" name="homepageTop">
                                                <label class="custom-control-label" for="top2">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name"> Status</label>
                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="custom-control custom-radio">
                                                <input checked value="1" type="radio" class="custom-control-input" id="active" name="status">
                                                <label class="custom-control-label" for="active">Active</label>
                                            </div>
                                        </div>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-4">
                                            <div class="custom-control custom-radio">
                                                <input value="0" type="radio" class="custom-control-input" id="inactive" name="status">
                                                <label class="custom-control-label" for="inactive">Inactive</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name">Description </label>
                            <textarea id="editor" name="description" class="form-control" style="height: 300px;">{{old('description')}}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="seo_d">SEO Description </label>
                                    <textarea id="seo_d" name="seo_descriptions" class="form-control" style="height: 150px;">{{old('seo_descriptions')}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="seo_k">SEO Keywords </label>
                                    <textarea id="seo_k" name="seo_keywords" class="form-control" style="height: 150px;">{{old('seo_keywords')}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">

                        <a href="{{route('backend.series.index')}}" type="submit" class="btn btn-danger">Cancel</a>
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
