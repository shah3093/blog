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
                            <li class="breadcrumb-item active" aria-current="page">Menu</li>
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

                <form id="addFrm" action="{{route('backend.menu.update',['menu'=>$menu->id])}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="card-body">
                        <div class="card-title">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>
                                        Menu
                                    </h5>
                                </div>
                                <div class="col-md-6">
                                    <div class="ml-auto text-right">
                                        <a href="{{route('backend.menu.index')}}" class="btn btn-sm btn-danger">
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
                                    <label for="parent">Parent</label>
                                    <select id="parent" name="parent_id" class="form-control">
                                        <option value=""> Select menu</option>
                                        @foreach($menus as $result)
                                            @if($result->id != $menu->id)
                                                <option {{ $result->id == $menu->id ? "selected":"" }} value="{{$result->id}}"> {{$result->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name <span class="text-danger">*</span></label>
                                    <input type="text" value="{{$menu->name}}" id="name" class="required image form-control" name="name"/>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="menu_type">Menu type <span class="text-danger">*</span></label>
                                    <select id="menu_type" name="menu_type" class="form-control required">
                                        <option value=""> Select menu type</option>
                                        <option {{ "home" == $menu->menu_type ? "selected":"" }} value="home"> Home
                                        </option>
                                        <option {{ "page" == $menu->menu_type ? "selected":"" }} value="page"> Page
                                        </option>
                                        <option {{ "category" == $menu->menu_type ? "selected":"" }} value="category">
                                            Category
                                        </option>
                                        <option {{ "post" == $menu->menu_type ? "selected":"" }} value="post"> Post
                                        </option>
                                        <option {{ "contact" == $menu->menu_type ? "selected":"" }} value="contact">
                                            Contact
                                        </option>
                                        <option {{ "custom" == $menu->menu_type ? "selected":"" }} value="custom">
                                            Custom
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="menuitem">Menu item <span class="text-danger">*</span></label>
                                    <span id="menuitemdiv">
                                        @if($menu->menu_type == "home")
                                            <input type="text" readonly value="home" class="required form-control" name="menu_url" id="menuitem"/>
                                        @elseif($menu->menu_type == "contact")
                                            <input type="text" readonly value="contact" class="required form-control" name="menu_url" id="menuitem"/>
                                        @elseif($menu->menu_type == "custom")
                                            <input type="url" value="" class="required form-control" name="menu_url" id="menuitem"/>
                                        @elseif($menu->menu_type == "page")
                                            <select class="required form-control select2" name="menu_url" id="menuitem">
        <option value="">Select page</option>
                                                @foreach($pages as $page)
                                                    <option {{ 'showpage/'.$page->slug == $menu->menu_url ? "selected":"" }} value="showpage/{{$page->slug}}">{{$page->title}}</option>
                                                @endforeach
    </select>
                                        @elseif($menu->menu_type == "category")
                                            <select class="required form-control select2" name="menu_url" id="menuitem">
        <option value="">Select category</option>
                                                @foreach($categories as $category)
                                                    <option {{ 'showcategory/'.$category->slug == $menu->menu_url ? "selected":"" }} value="showcategory/{{$category->slug}}">{{$category->name}}</option>
                                                @endforeach
    </select>
                                        @elseif($menu->menu_type == "post")
                                            <select class="required form-control select2" name="menu_url" id="menuitem">
        <option value="">Select post</option>
                                                @foreach($posts as $post)
                                                    <option {{ 'showpost/'.$post->slug == $menu->menu_url ? "selected":"" }} value="showpost/{{$post->slug}}">{{$post->title}}</option>
                                                @endforeach
    </select>
                                        @endif
                                    </span>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type">Status</label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="custom-control custom-radio">
                                                <input <?php echo $menu->status == 1 ? "checked" : ""; ?> value="1" type="radio" class="custom-control-input" id="yes" name="status">
                                                <label class="custom-control-label" for="yes">Active</label>
                                            </div>
                                        </div>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-4">
                                            <div class="custom-control custom-radio">
                                                <input <?php echo $menu->status == 0 ? "checked" : ""; ?> value="0" type="radio" class="custom-control-input" id="no" name="status">
                                                <label class="custom-control-label" for="no">Inactive</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sort_order">Sort order</label>
                                    <input value="{{$menu->sort_order}}" type="number" class="form-control" id="sort_order" name="sort_order"/>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">

                        <a href="{{route('backend.menu.index')}}" type="submit" class="btn btn-danger">Cancel</a>
                        <button type="submit" class="btn btn-success float-right">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('stylesheet')
    <link href="{{URL::asset("backend/assets/libs/select2/dist/css/select2.min.css")}}" rel="stylesheet">
@endsection

@section('script')
    <script src="{{URL::asset('backend/assets/libs/select2/dist/js/select2.min.js')}}"></script>
    <script src="{{URL::asset('backend/custom/scripts/custom.js')}}"></script>

    <script>
        $(function () {
            $("#menu_type").on("change", function (event) {
                event.preventDefault();
                if ($(this).val() != "") {
                    $.post("{{route('backend.getMenyTypes')}}", {
                        'type': $(this).val(),
                        '_token': "{{csrf_token()}}"
                    }, function (re) {
                        $("#menuitemdiv").empty();
                        $("#menuitemdiv").html(re);
                    });
                }
            });
        });
    </script>
@endsection
