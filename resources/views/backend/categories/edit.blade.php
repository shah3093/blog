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
                            <li class="breadcrumb-item active" aria-current="page">Category</li>
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

                <form id="addFrm" action="{{route('backend.categories.update',['category'=>$category->id])}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
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
                                        <a href="{{route('backend.categories.index')}}" class="btn btn-sm btn-danger">
                                            <i class="mdi mdi-skip-backward"></i>
                                            Back
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="name">Name <span class="text-danger">*</span></label>
                            <input type="text" id="name" class="form-control required" value="{{$category->name}}" name="name" placeholder="Name"/>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="image">Featured image <span class="text-danger">*</span></label>
                                    <small>(To update image click on that image)</small>
                                    <?php
                                    $url = "";
                                    $check = preg_match('/category/', $category->featuredImage);
                                    if(empty($check)) {
                                        $url = $category->featuredImage;
                                    } else {
                                        $url = Storage::url($category->featuredImage);
                                    }
                                    ?>
                                    <img class="image-view-in-form" id="blah" src="{{$url}}" alt="your image" onclick="document.getElementById('image').click();"/>
                                    <input type="file" id="image" class="image form-control hide" onchange="readURL(this);" name="image"/>
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
                                                <input <?php echo $category->homepageTop == 1 ? 'checked' : ''; ?> type="radio" value="1" class="custom-control-input" id="top1" name="homepageTop">
                                                <label class="custom-control-label" for="top1">Yes</label>
                                            </div>
                                        </div>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-4">
                                            <div class="custom-control custom-radio">
                                                <input <?php echo $category->homepageTop == 0 ? 'checked' : ''; ?> value="0" type="radio" class="custom-control-input" id="top2" name="homepageTop">
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
                                                <input <?php echo $category->status == 1 ? 'checked' : ''; ?> value="1" type="radio" class="custom-control-input" id="active" name="status">
                                                <label class="custom-control-label" for="active">Active</label>
                                            </div>
                                        </div>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-4">
                                            <div class="custom-control custom-radio">
                                                <input <?php echo $category->status == 0 ? 'checked' : ''; ?> value="0" type="radio" class="custom-control-input" id="inactive" name="status">
                                                <label class="custom-control-label" for="inactive">Inactive</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox mr-sm-2">
                                <input {{$isSeries == 1 ? 'checked':''}} type="checkbox" class="custom-control-input" id="isseries">
                                <label class="custom-control-label" for="isseries">Series</label>
                            </div>
                        </div>
                        <div id="seriesdiv" class="row {{$isSeries == 1 ? '':'hide'}}">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="series_id">Series</label>
                                    <select id="series_id" name="series_id" class="form-control">
                                        <option value="">Select series</option>
                                        @foreach($series as $se)
                                            <option {{$seriesid == $se->id ? "selected":""}}  value="{{$se->id}}">{{$se->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sort_order">Sort order</label>
                                    <input type="number" id="sort_order" class="form-control" value="{{$sort_order}}" name="sort_order"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name">Description </label>
                            <textarea id="editor" name="description" class="form-control" style="height: 300px;">{{$category->description}}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="seo_d">SEO Description </label>
                                    <textarea id="seo_d" name="seo_descriptions" class="form-control" style="height: 150px;">{{$category->seo_descriptions}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="seo_k">SEO Keywords </label>
                                    <textarea id="seo_k" name="seo_keywords" class="form-control" style="height: 150px;">{{$category->seo_keywords}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">

                        <a href="{{route('backend.categories.index')}}" type="submit" class="btn btn-danger">Cancel</a>
                        <button type="submit" class="btn btn-success float-right">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection


@section('script')
    <script>
        $(function () {
            $("#isseries").on("click", function (e) {
                if ($(this).is(':checked')) {
                    $("#seriesdiv").removeClass("hide");
                } else {
                    $("#seriesdiv").addClass("hide");
                    $("#sort_order").val("");
                    $("#series_id option:selected").removeAttr("selected");
                }
            });
        });


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
