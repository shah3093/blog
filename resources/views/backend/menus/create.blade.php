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

                <form id="addFrm" action="{{route('backend.menus.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
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
                                        <a href="{{route('backend.menus.index')}}" class="btn btn-sm btn-danger">
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
                                        @foreach($menus as $menu)
                                            <option {{ $menu->id == old('parent_id') ? "selected":"" }} value="{{$menu->id}}"> {{$menu->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name <span class="text-danger">*</span></label>
                                    <input type="text" value="{{old('name')}}" id="name" class="required image form-control" name="name"/>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="menu_type">Menu type <span class="text-danger">*</span></label>
                                    <select id="menu_type" name="menu_type" class="form-control required">
                                        <option value=""> Select menu type</option>
                                        <option {{ "home" == old('menu_type') ? "selected":"" }} value="home"> Home
                                        </option>
                                        <option {{ "name" == old('menu_type') ? "selected":"" }} value="name"> Name
                                        </option>
                                        <option {{ "page" == old('menu_type') ? "selected":"" }} value="page"> Page
                                        </option>
                                        <option {{ "category" == old('menu_type') ? "selected":"" }} value="category">
                                            Category
                                        </option>
                                        <option {{ "post" == old('menu_type') ? "selected":"" }} value="post"> Post
                                        </option>
                                        <option {{ "contact" == old('menu_type') ? "selected":"" }} value="contact">
                                            Contact
                                        </option>
                                        <option {{ "custom" == old('menu_type') ? "selected":"" }} value="custom">
                                            Custom
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="menuitem">Menu item <span class="text-danger">*</span></label>
                                    <span id="menuitemdiv">
                                        <input type="text" readonly value="" id="menuitem" class="required form-control" name="menu_url"/>
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
                                                <input checked value="1" type="radio" class="custom-control-input" id="yes" name="status">
                                                <label class="custom-control-label" for="yes">Active</label>
                                            </div>
                                        </div>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-4">
                                            <div class="custom-control custom-radio">
                                                <input value="0" type="radio" class="custom-control-input" id="no" name="status">
                                                <label class="custom-control-label" for="no">Inactive</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sort_order">Sort order</label>
                                    <input value="0" type="number" class="form-control" id="sort_order" name="sort_order"/>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">

                        <a href="{{route('backend.menus.index')}}" type="submit" class="btn btn-danger">Cancel</a>
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
