@extends('backend.layouts.mastar') 
@section('breadcrumb')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Question and answer List</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Question and answer List</li>
                    </ol>
                </nav>
                <a href="{{route('backend.quizzes.index')}}" class="btn btn-danger "><i class="mdi mdi-skip-backward"></i> Back</a>
            </div>
        </div>
    </div>
</div>
@endsection
 
@section('content')
<div class="row">
    <div class="col-md-10 offset-md-1">
        <form id="addFrm" action="{{route('backend.addquizequestion',['quizid'=>$quizid])}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    @foreach ($questions as $key=>$question)
                    <div id="rowid{{$key}}">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label># Question </label>
                                    <button type="button" data-rowid="rowid{{$key}}" class="deletequestion btn btn-danger" data-questionid="{{$question['id']}}"
                                        style="float: right;margin-bottom: 5px;"><i class="mdi mdi-delete"></i></button>
                                    <input type="text" id="name" class="form-control" name="Question[{{$key}}][question]" value="{{$question->question}}" />
                                    <input type="hidden" value="{{$question->id}}" name="Question[{{$key}}][id]" />
                                </div>
                            </div>
                            <div class="col-md-8 offset-md-1">
                                <div class="form-group">
                                    <label>Answers <span><small>(add answers and sepearet them by comma )</small></span></label>
                                    <?php $correctanswer = ""; $answerid=""?>
                                    <input type="text" id="name" class="form-control" name="Answer[{{$key}}][answer]" value="@foreach($question->answers as $answer){{$answer->answer}} <?php $correctanswer = $answer->correct_answer;$answerid=$answer->id ?>@endforeach"
                                    />
                                </div>
                            </div>
                            <div class="col-md-6 offset-md-1">
                                <div class="form-group">
                                    <label>Correct answer</label>
                                    <input type="text" id="name" class="form-control" name="Answer[{{$key}}][correct_answer]" value="{{$correctanswer}}" />
                                    <input type="hidden" name="Answer[{{$key}}][id]" value="{{$answerid}}" />
                                </div>
                            </div>
                        </div>
                        <hr/>
                    </div>
                    @endforeach

                    <span id="questonsection">

                    </span>


                    <div class="pull-right" style="float: right;">
                        <button data-key={{$key+2}} id="addQuestion" type="button" class="btn btn-primary">Add Question</button>
                    </div>

                </div>
                <div class="card-footer">
                    <a href="{{route('backend.quizzes.index')}}" type="submit" class="btn btn-danger">Cancel</a>
                    <button type="submit" class="btn btn-success float-right">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
 
@section('script')
<script>
    $("#addQuestion").on("click",function(e){
        e.preventDefault;
        var key2 = key = $(this).attr('data-key');
        key++;
        $("#addQuestion").attr('data-key',key);
        $.get( "{{url('questionsection')}}"+"/"+key2 ,function( resp ) {
            $("#questonsection").append(resp);
        });
    });

    $(".deletequestion").on("click",function(e){
        e.preventDefault;
        var questionid = $(this).data('questionid');
        var rowid = $(this).data("rowid");
        if(questionid == 0){
                $("#"+rowid).remove();
            }else{
                if(confirm("are you sure ?")){
                    $.get( "{{url('deletequestion')}}"+"/"+questionid ,function( resp ) {
                        if(resp != "ERROR"){
                            $("#"+rowid).remove();
                        }
                    });
                }
            }
    });

</script>
@endsection