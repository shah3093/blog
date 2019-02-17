@extends('backend.layouts.mastar')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Page</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Page</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')

    @include('backend.partials.errors')

    <form id="addFrm" action="{{route('backend.page.update',['page'=>$page->id])}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="parent">Parent page</label>
                            <select id="parent" name="data[parent_id]" class="form-control">
                                <option value="">Select page</option>
                                @foreach($pages as $result)
                                    @if($result->id != $page->id)
                                        <option {{$result->id == $page->parent_id ? 'selected':''}} value="{{$result->id}}">{{$result->title}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="title">Title <span class="text-danger">*</span></label>
                            <input type="text" id="title" class="form-control " value="{{$page->title}}" name="data[title]" placeholder="TItle.."/>
                        </div>
                        <div class="form-group">
                            <label for="contentT">Content <span class="text-danger">*</span></label>
                            <textarea id="contentT" name="data[content]">{{$page->content}}</textarea>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="featuredImage">Featured image <span class="text-danger">*</span>
                                        <small>(To update image click on that image)</small>
                                    </label>
                                    <?php
                                    $url = "";
                                    $check = preg_match('/page/', $page->featuredImage);
                                    if(empty($check)) {
                                        $url = $page->featuredImage;
                                    } else {
                                        $url = Storage::url($page->featuredImage);
                                    }
                                    ?>
                                    <img class="image-view-in-form" id="blah" src="{{$url}}" alt="your image" onclick="document.getElementById('image').click();"/>
                                    <input type="file" id="image" class="image form-control hide" onchange="readURL(this);" name="image"/>
                                </div>

                                <div class="form-group">
                                    <label for="type">Status</label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="custom-control custom-radio">
                                                <input <?php echo $page->status == 1 ? 'checked' : ''; ?> value="1" type="radio" class="custom-control-input" id="active" name="data[status]">
                                                <label class="custom-control-label" for="active">Active</label>
                                            </div>
                                        </div>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-4">
                                            <div class="custom-control custom-radio">
                                                <input <?php echo $page->status == 0 ? 'checked' : ''; ?> value="0" type="radio" class="custom-control-input" id="inactive" name="data[status]">
                                                <label class="custom-control-label" for="inactive">Inactive</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="type">Make it popular</label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="custom-control custom-radio">
                                                <input <?php echo $page->isPopular == 1 ? 'checked' : ''; ?> value="1" type="radio" class="custom-control-input" id="yes" name="data[isPopular]">
                                                <label class="custom-control-label" for="yes">Yes</label>
                                            </div>
                                        </div>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-4">
                                            <div class="custom-control custom-radio">
                                                <input <?php echo $page->isPopular == 0 ? 'checked' : ''; ?> value="0" type="radio" class="custom-control-input" id="no" name="data[isPopular]">
                                                <label class="custom-control-label" for="no">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="seo_keywords">SEO keywords</label>
                                    <textarea class="form-control" id="seo_keywords" name="data[seo_keywords]">{{$page->seo_keywords}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="seo_descriptions">SEO description</label>
                                    <textarea class="form-control" id="seo_descriptions" name="data[seo_descriptions]">{{$page->seo_descriptions}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="card">
            <div class="card-footer">
                <a href="{{route('backend.page.index')}}" type="submit" class="btn btn-danger">Cancel</a>
                <button type="submit" class="btn btn-success float-right">Save</button>
            </div>
        </div>

    </form>


@endsection

@section('stylesheet')
    <link href="{{URL::asset("backend/assets/libs/summernote/dist/summernote.css")}}" rel="stylesheet">
    <link href="{{URL::asset("backend/custom/css/custome-summernote.css")}}" rel="stylesheet">
    <script>
        var deletefilemethodurl = "{{route('backend.deletefile')}}";
        var storefilemethodurl = "{{route('backend.storefile')}}";
        var _token = "{{csrf_token()}}";
    </script>
@endsection

@section('script')
    <script src="{{URL::asset('backend/custom/scripts/custom.js')}}"></script>
    <script src="{{URL::asset('backend/assets/libs/summernote/dist/summernote.js')}}"></script>
    <script src="{{URL::asset('backend/custom/scripts/custom-summernote.js')}}"></script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(150)
                        .height(200);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
