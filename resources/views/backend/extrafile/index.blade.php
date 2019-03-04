@extends('backend.layouts.mastar')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Extra File</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Extra File</li>
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
                            Extra File Listing
                        </h5>
                    </div>
                    <div class="col-md-6">
                        <div class="ml-auto text-right">
                            <a href="{{route('backend.extrafile.create')}}" class="btn btn-sm btn-info">
                                <i class="mdi mdi-plus"></i>
                                Add Extra File
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table id="zero_config" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>File</th>
                        <th>Copy link</th>
                        <th>Created by</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($files as $key=>$file)
                        <tr>
                           <td>{{$key+1}}</td>
                            <td><a target="_blank" href="{{URL::asset('uploads/'.$file->file_name)}}">File</a></td>
                            <td>
                               <button data-link="{{URL::asset('uploads/'.$file->file_name)}}" class="btn btn-primary copylink">
                                    <i class="mdi mdi-content-copy"></i></button>
                            </td>
                            <td>{{$file->created}}</td>
                            <td>
                                <form class="deletedatafrm btn" action="{{route('backend.extrafile.destroy',['file'=>$file->id])}}" method="POST">
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
        $('.copylink').click(function () {
            value = $(this).data('link'); //Upto this I am getting value
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(value).select();
            document.execCommand("copy");
            $temp.remove();
            swal("Link Copied", "", "success");
        });
    </script>
@endsection
