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

    @include('backend.partials.errors')

    <form autocomplete="off" id="addFrm" action="{{route('backend.questions.update',['id'=>$question->id])}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="name">Visitor Name</label>
                                    <input readonly type="text" id="name" class="form-control " value="{{$question->visitors->name}}"/>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="email">Visitor Email</label>
                                    <input readonly type="text" id="email" class="form-control " value="{{$question->visitors->email}}"/>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="date">Question Ask date</label>
                                    <input readonly type="text" id="date" class="form-control " value="{{$question->created_at}}"/>
                                </div>
                            </div>
                            <div class="col">

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input name="Question[title]" type="text" id="title" class="form-control " value="{{$question->title}}"/>
                        </div>
                        <div class="form-group">
                            <label for="details">Details</label>
                            <textarea readonly class="form-control" rows="8">{{$question->details}}</textarea>
                        </div>

                    </div>
                </div>

            </div>
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <label for="status">Status</label>
                                <select id="status" class="form-control" name="Question[status]">
                                    <option {{$question->status == "PENDING" ? "selected":""}} value="PENDING">Pending
                                    </option>
                                    <option {{$question->status == "ANSWERD" ? "selected":""}} value="ANSWERD">
                                        Answered
                                    </option>
                                    <option {{$question->status == "IRRELEVANT" ? "selected":""}} value="IRRELEVANT">
                                        Irrelevant
                                    </option>
                                </select>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="type">Show in section</label>
                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <div class="col-md-4">
                                            <div class="custom-control custom-radio">
                                                <input {{$question->show == 1 ? "checked":""}} value="1" type="radio" class="custom-control-input" id="publish" name="Question[show]">
                                                <label class="custom-control-label" for="publish">Show</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="custom-control custom-radio">
                                                <input {{$question->show == 0 ? "checked":""}} value="0" type="radio" class="custom-control-input" id="draft" name="Question[show]">
                                                <label class="custom-control-label" for="draft">Hide</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tag">Type</label>
                            <div class="row">
                                <div class="col-md-9">
                                    <input type="text" id="tag" class="form-control"/>
                                    <input type="hidden" id="tagsvalue" class="form-control" value="{{$typestr}}" name="types"/>
                                    <span id="badgewarring" class="hide">Click on the type button to remove tag</span>
                                </div>
                                <div class="col-md-3">
                                    <button id="addTagbtn" class="btn btn-default">Add</button>
                                </div>
                            </div>
                            <br/>
                            <span id="tagsbadge">
                                @foreach($question->questiontypes as $type)
                                    <span onclick='return removetagbtn(this)' style='margin-right: 3px' class='btn badge badge-success tagclass' data-value='{{$type->type}}'>
                                            {{$type->type}}
                                        </span>
                                @endforeach
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="contentT">Answer <span class="text-danger">*</span></label>
                            <textarea id="contentT" name="answer">{{isset($question->answer->answer)?$question->answer->answer:""}}</textarea>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="card">
            <div class="card-footer">
                <a href="{{route('backend.questions.index')}}" type="submit" class="btn btn-danger">Cancel</a>
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

        function removetagbtn(el) {
            var value = $(el).attr("data-value");
            var tagsvalue = $("#tagsvalue").val();
            if (tagsvalue.search(value) != -1) {
                $(el).remove();
                tagsvalue = tagsvalue.replace(value, "");
                $("#tagsvalue").val(tagsvalue);
            }
        }
    </script>
@endsection

@section('script')
    <script src="{{URL::asset('backend/custom/scripts/custom.js')}}"></script>
    <script src="{{URL::asset('backend/assets/libs/summernote/dist/summernote.js')}}"></script>
    <script src="{{URL::asset('backend/custom/scripts/custom-summernote.js')}}"></script>
    <script src="{{URL::asset('backend/custom/scripts/posttag.js')}}"></script>
    <script>
        var alltags = [
            @forEach($tags as $tag)
                "{{$tag->type}}",
            @endforeach
        ];
    </script>
@endsection

