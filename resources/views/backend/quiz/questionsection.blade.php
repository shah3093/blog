<div id="rowid{{$key}}">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label># Question </label>
                <button type="button" data-rowid="rowid{{$key}}" class="deletequestion btn btn-danger" data-questionid="0" href="#" style="float: right;margin-bottom: 5px;"><i class="mdi mdi-delete"></i></button>
                <input type="text" id="name" class="form-control" name="Question[{{$key}}][question]" />
            </div>
        </div>
        <div class="col-md-8 offset-md-1">
            <div class="form-group">
                <label>Answers <span><small>(add answers and sepearet them by two ** )</small></span></label>
                <input type="text" id="name" class="form-control" name="Answer[{{$key}}][answer]" />
            </div>
        </div>
        <div class="col-md-6 offset-md-1">
            <div class="form-group">
                <label>Correct answer</label>
                <input type="text" id="name" class="form-control" name="Answer[{{$key}}][correct_answer]" />
            </div>
        </div>
    </div>

    <hr/>
</div>

<script>
    $(".deletequestion").on("click",function(e){
        e.preventDefault;
        var questionid = $(this).data('questionid');
        var rowid = $(this).data("rowid");
        $("#"+rowid).remove();
    });

</script>