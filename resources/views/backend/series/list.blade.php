@extends('backend.layouts.mastar')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Series List</h4>
                <a id="addCategory" data-seriesid="{{$seriesid}}" class="btn btn-primary ml-3" href="#"><i class="fa fa-plus"></i></a>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Series List</li>
                        </ol>
                    </nav>
                    <a href="{{route('backend.series.index')}}" class="btn btn-danger "><i class="mdi mdi-skip-backward"></i> Back</a>
                </div>
            </div>
        </div>
     </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-9">
            @foreach($results as $result)
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title m-b-0">
                            #{{$result['sort_order']}}
                            <a target="_blank" href="{{route('backend.categories.edit',['category'=>$result['id']])}}">{{$result['name']}}</a>
                            <a data-sortorder="{{$result['sort_order']}}" data-categoryid="{{$result['id']}}" data-catname="{{$result['name']}}" data-seid="{{$result['series_id']}}" href="#" class="btn edit-category text-right"><i class="fa fa-edit"></i></a>
                            <form class="deletedatafrm btn" action="{{route('backend.deletecategoryseries',['id'=>$result['id']])}}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn deletedata">
                                    <span style="color: red;"><i class="mdi mdi-delete"></i></span></button>
                            </form>
                        </h4>

                    </div>
                    <ul class="list-style-none">
                        @foreach($result['posts'] as $post)
                            <li class="d-flex no-block card-body">
                                <i class="fa fa-check-circle w-30px m-t-5"></i>
                                <div>
                                    <a target="_blank" href="{{route('backend.posts.edit',['post'=>$post->id])}}" class="m-b-0 font-medium p-0">
                                        {{$post->title}}
                                    </a>
                                </div>
                                <div class="ml-auto">
                                    <div class="tetx-right">
                                        <h5 class="text-muted m-b-0">
                                            {{$post->sort_order}}
                                        </h5>
                                        <a data-sortorder="{{$post->sort_order}}" data-postid="{{$post->id}}" data-post="{{$post->title}}" href="#" class="btn edit-post"><i class="fa fa-edit"></i></a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>


    <!----POST MODAL --------->
    <div class="modal fade" id="postModal" role="dialog">
        <div class="modal-dialog ">
            <form id="post-edit-frm" action="{{route('backend.postedit')}}" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="post-modal-title" class="modal-title">Post</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>
                    <div class="modal-body">
                        <span id="post-error"></span>
                        @csrf
                        <div class="form-group">
                            <label for="name">Sort order </label>
                            <input type="number" class="form-control" name="sort_order" id="p-sort-order" value="0"/>
                            <input type="hidden" name="postid" id="post-id" value="0"/>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button id="savepost" type="button" class="btn btn-success">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!----POST MODAL --------->

    <!---CATEGORY MODAL---------->
    <div class="modal fade" id="categoryModal" role="dialog">
        <div class="modal-dialog ">
            <form id="category-edit-frm" action="{{route('backend.categoryedit')}}" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="category-modal-title" class="modal-title">Category</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <span id="category-error"></span>
                        @csrf
                        <div class="form-group">
                            <label for="name">Sort order </label>
                            <input type="number" class="form-control" name="sort_order" id="c-sort-order" value="0"/>
                            <input type="hidden" name="categoryid" id="cat-id" value="0"/>
                            <input type="hidden" name="seriesid" id="se-id" value="0"/>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button id="savecategory" type="button" class="btn btn-success">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!---CATEGORY MODAL---------->

    <!----Category List------>
    <div class="modal fade" id="addCatModal" role="dialog">
        <div class="modal-dialog ">
            <form id="add-cat-edit-frm" action="{{route('backend.categoryadd')}}" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="add-cat-modal-title" class="modal-title">Category</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>
                    <div class="modal-body">
                        <span id="add-error"></span>
                        @csrf
                        <div class="form-group">
                            <label for="name">Category</label>
                            <select name="category" class="form-control">
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                            <input type="hidden" value="{{$seriesid}}" name="series"/>
                        </div>
                        <div class="form-group">
                            <label for="name">Sort order</label>
                            <input type="number" value="0" name="sort_order" class="form-control"/>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button id="addcatpost" type="button" class="btn btn-success">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!----Category List------>

@endsection


@section('script')
    <script>
        $(".edit-post").on("click", function (e) {
            e.preventDefault();
            var posttitle = $(this).attr('data-post');
            var sortorder = $(this).attr('data-sortorder');
            var postid = $(this).attr('data-postid');
            $("#post-modal-title").html(posttitle);
            $("#post-id").val(postid);
            $("#p-sort-order").val(sortorder);
            $("#postModal").modal("toggle");
        });

        $("#addCategory").on("click", function (e) {
            e.preventDefault();
            $("#addCatModal").modal("toggle");
        });

        $(".edit-category").on("click", function (e) {
            e.preventDefault();
            var catname = $(this).attr('data-catname');
            var sortorder = $(this).attr('data-sortorder');
            var categoryid = $(this).attr('data-categoryid');
            var seriesid = $(this).attr('data-seid');
            $("#category-modal-title").html(catname);
            $("#cat-id").val(categoryid);
            $("#se-id").val(seriesid);
            $("#c-sort-order").val(sortorder);
            $("#categoryModal").modal("toggle");
        });

        $("#savepost").on("click", function (e) {
            e.preventDefault();
            var url = $("#post-edit-frm").attr('action');
            var data = new FormData(document.getElementById("post-edit-frm"));
            var errorid = "#post-error";
            ajaxcall(data, url, errorid);
        });

        $("#addcatpost").on("click", function (e) {
            e.preventDefault();
            var url = $("#add-cat-edit-frm").attr('action');
            var data = new FormData(document.getElementById("add-cat-edit-frm"));
            var errorid = "#add-error";
            ajaxcall(data, url, errorid);
        });

        $("#savecategory").on("click", function (e) {
            e.preventDefault();
            var url = $("#category-edit-frm").attr('action');
            var data = new FormData(document.getElementById("category-edit-frm"));
            var errorid = "#category-error";
            ajaxcall(data, url, errorid);
        });

        function ajaxcall(data, url, errorid) {
            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                async: false,
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                success: function (resp) {
                    if (resp != 'DONE') {
                        $(errorid).html(resp);
                    } else {
                        location.reload();
                    }
                }
            });
        }
    </script>
@endsection
