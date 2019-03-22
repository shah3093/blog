@extends('backend.layouts.mastar')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Quiz</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Quiz</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <div class="row">
                    <div class="col-md-6">
                        <h5>
                            Quizzes
                        </h5>
                    </div>
                    <div class="col-md-6">
                        <div class="ml-auto text-right">
                            <a href="{{route('backend.quizzes.create')}}" class="btn btn-sm btn-info">
                                <i class="mdi mdi-plus"></i>
                                Add Quiz
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
                        <th>List</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($quizzes as $quiz)
                        <tr>
                            <td>{{$quiz->name}}</td>
                            <td>{{$quiz->status == 1 ? "Active":"Inactive"}}</td>
                            <td>{{$quiz->created}}</td>
                            <td>
                                <a href="{{route('backend.quizequestionlistlist',['id'=>$quiz->id])}}" type="button" class="btn btn-success ">
                                    <i class="mdi mdi-view-list"></i>
                                </a>
                            </td>
                            <td>

                                <a href="{{route('backend.quizzes.edit',['quiz'=>$quiz->id])}}" type="button" class="btn btn-primary ">
                                    <i class="mdi mdi-table-edit"></i>
                                </a>
                                <form class="deletedatafrm btn" action="{{route('backend.quizzes.destroy',['quiz'=>$quiz->id])}}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger  deletedata">
                                        <i class="mdi mdi-delete"></i></button>
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
    <script>
        $(document).ready(function () {
            $('#zero_config').DataTable({
                "order": [[4, "desc"]],
                "columnDefs": [
                    {"targets": [4], "orderable": false}
                ],
                "columns": [
                    {"width": "50%"},
                    {"width": "7%"},
                    {"width": "12%"},
                    {"width": "5%"},
                    {"width": "15%"}
                ],
            });
        });
    </script>
@endsection
