@extends('backend.layouts.mastar') 
@section('breadcrumb')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Series</h4>
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

            <form id="addFrm" action="{{route('backend.quizzes.update',['quiz'=>$quiz->id])}}" method="post" enctype="multipart/form-data">
                @csrf @method('put')
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
                                    <a href="{{route('backend.quizzes.index')}}" class="btn btn-sm btn-danger">
                                            <i class="mdi mdi-skip-backward"></i>
                                            Back
                                        </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="post">Post  <span class="text-danger">*</span></label>
                                <select id="post" name="post" class="form-control select2 required">
                                    <option value="">Select post</option>
                                    @foreach($posts as $post)
                                        <option {{$post->id == $quiz->post_id ? 'selected':''}} value="{{$post->id}}">{{$post->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name <span class="text-danger">*</span></label>
                                <input type="text" id="name" class="form-control required" value="{{$quiz->name}}" name="name" placeholder="Name" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="image">Featured image <span class="text-danger">*</span></label>
                                <small>(To update image click on that image)</small>
                                <?php
                                    $url = "";
                                    $check = preg_match('/quiz/', $quiz->featuredImage);
                                    if(empty($check)) {
                                        $url = $quiz->featuredImage;
                                    } else {
                                        $url = Storage::url($quiz->featuredImage);
                                    }
                                    ?>
                                    <img class="image-view-in-form" id="blah" src="{{$url}}" alt="your image" onclick="document.getElementById('image').click();"
                                    />
                                    <input type="file" id="image" class="image form-control hide" onchange="readURL(this);" name="image" />
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
                                            <input <?php echo $quiz->homepageTop == 1 ? 'checked' : ''; ?> type="radio" value="1"
                                            class="custom-control-input" id="top1" name="homepageTop">
                                            <label class="custom-control-label" for="top1">Yes</label>
                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-4">
                                        <div class="custom-control custom-radio">
                                            <input <?php echo $quiz->homepageTop == 0 ? 'checked' : ''; ?> value="0" type="radio"
                                            class="custom-control-input" id="top2" name="homepageTop">
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
                                            <input <?php echo $quiz->status == 1 ? 'checked' : ''; ?> value="1" type="radio"
                                            class="custom-control-input" id="active" name="status">
                                            <label class="custom-control-label" for="active">Active</label>
                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-4">
                                        <div class="custom-control custom-radio">
                                            <input <?php echo $quiz->status == 0 ? 'checked' : ''; ?> value="0" type="radio"
                                            class="custom-control-input" id="inactive" name="status">
                                            <label class="custom-control-label" for="inactive">Inactive</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">Description </label>
                        <textarea id="editor" name="description" class="form-control" style="height: 300px;">{{$quiz->description}}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="seo_d">SEO Description </label>
                                <textarea id="seo_d" name="seo_descriptions" class="form-control" style="height: 150px;">{{$quiz->seo_descriptions}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="seo_k">SEO Keywords </label>
                                <textarea id="seo_k" name="seo_keywords" class="form-control" style="height: 150px;">{{$quiz->seo_keywords}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">

                    <a href="{{route('backend.quizzes.index')}}" type="submit" class="btn btn-danger">Cancel</a>
                    <button type="submit" class="btn btn-success float-right">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
 
@section('script')
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