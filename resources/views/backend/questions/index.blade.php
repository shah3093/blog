@extends('backend.layouts.mastar')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Question</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Question</li>
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
                            Question Listing
                        </h5>
                    </div>
                    <div class="col-md-6">
                        <div class="ml-auto text-right">
                            {{--<a href="{{route('backend.questions.create')}}" class="btn btn-sm btn-info">--}}
                            {{--<i class="mdi mdi-plus"></i>--}}
                            {{--Add Question--}}
                            {{--</a>--}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table id="zero_config" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Visitor Name</th>
                        <th>Status</th>
                        <th>Types</th>
                        <th>Details</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($questions as $question)
                        <tr>
                            <td>{{$question->visitors->name}}</td>
                            <td>{{$question->status}}</td>
                            <td>
                                @foreach($question->questiontypes as $type)
                                    <span class="badge badge-info">{{$type->type}}</span>
                                @endforeach
                            </td>
                            <td>{{substr($question->details,0,20)."...."}}</td>
                            <td>
                                <a href="{{route('backend.questions.edit',['questions'=>$question->id])}}" type="button" class="btn btn-primary ">
                                    <i class="mdi mdi-table-edit"></i>
                                </a>
                                <form class="deletedatafrm btn" action="{{route('backend.questions.destroy',['questions'=>$question->id])}}" method="POST">
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
        $('#zero_config').DataTable({
            "order": [[4, "desc"]],
            "columnDefs": [
                {"targets": [1, 4], "orderable": false}
            ],
            "columns": [
                {"width": "15%"},
                {"width": "15%"},
                {"width": "15%"},
                {"width": "20%"},
                {"width": "10%"}
            ],
            initComplete: function () {
                this.api().columns(1).every(function () {
                    var column = this;
                    var select = $('<select class="form-control"><option value=""></option></select>')
                        .appendTo($(column.header()).html('Parent Name'))
                        .on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            column
                                .search(val ? '^' + val + '$' : '', true, false)
                                .draw();
                        });

                    column.data().unique().sort().each(function (d, j) {
                        select.append('<option value="' + d + '">' + d + '</option>')
                    });
                });
            }
        });
    </script>
@endsection
