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

@section('stylesheet')
    <link href="{{URL::asset("backend/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css")}}" rel="stylesheet">
@endsection

@section('script')
    <script src="{{URL::asset('backend/assets/extra-libs/DataTables/datatables.min.js')}}"></script>
    <script>
        $('#zero_config').DataTable();
    </script>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <div class="row">
                    <div class="col-md-6">
                        <h5>
                            Category Listing
                        </h5>
                    </div>
                    <div class="col-md-6">
                        <div class="ml-auto text-right">
                            <a href="{{route('backend.categories.create')}}" class="btn btn-sm btn-info">
                                <i class="mdi mdi-plus"></i>
                                Add Category
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table id="zero_config" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Created by</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{$category->name}}</td>
                            <td>{{$category->status == 1 ? "Active":"Inactive"}}</td>
                            <td>{{$category->created}}</td>
                            <td>
                                <a href="{{route('backend.categories.edit',['category'=>$category->id])}}" type="button" class="btn btn-primary ">
                                    <i class="mdi mdi-table-edit"></i>
                                </a>
                                <form class="deletedatafrm btn" action="{{route('backend.categories.destroy',['category'=>$category->id])}}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger  deletedata"><i class="mdi mdi-delete"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection
