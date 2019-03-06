@foreach($comments as $key=>$comment)
    <div class="bio mb-2" id="biocomment{{$comment->id}}">
        <div class="bio-body">

            <div class="row">
                <div class="col-md-7">
                    <h4>{{$comment->visitors->name}}</h4>

                </div>
                @if(Auth::guard('visitor')->id() == $comment->visitors->id)
                    <div class="col-md-5" id="actiondiv{{$key}}">
                        <button data-biocomment="biocomment{{$comment->id}}" data-commentid="{{$comment->id}}" class="btn pull-right deletecomment" style="color: red;">
                            <i class="fa fa-trash"></i></button>
                        <button data-actiondiv="actiondiv{{$key}}" data-showcommentid="showcommentid{{$key}}" data-hidecommentid="hidecommentid{{$key}}" data-commentid="{{$comment->id}}" class="btn pull-right editcomment">
                            <i class="fa fa-edit"></i></button>

                    </div>
                @endif
            </div>
            <p id="showcommentid{{$key}}">{{$comment->comment}} </p>
            <div style="display: none;" id="hidecommentid{{$key}}">
                <div class="form-group">
                    <input name="comment" value="{{$comment->comment}}" id="commentedit{{$comment->id}}"/>
                    <input type="hidden" name="comentid" value="{{$comment->id}}" id="commentid{{$comment->id}}"/>
                </div>
                <button data-actiondiv="actiondiv{{$key}}" data-showcommentid="showcommentid{{$key}}" data-hidecommentid="hidecommentid{{$key}}" data-commentid="{{$comment->id}}" class="btn btn-success saveedit">
                    Save
                </button>
                <button data-actiondiv="actiondiv{{$key}}" data-showcommentid="showcommentid{{$key}}" data-hidecommentid="hidecommentid{{$key}}" class="btn btn-danger quitedit">
                    Cancel
                </button>
            </div>
        </div>
    </div>
@endforeach

<script>
    $(".editcomment").on("click", function (e) {
        e.preventDefault();
        var hidecommentid = $(this).data("hidecommentid");
        var showcommentid = $(this).data("showcommentid");
        var actiondiv = $(this).data("actiondiv");
        $("#" + showcommentid).css("display", "none");
        $("#" + actiondiv).css("display", "none");
        $("#" + hidecommentid).css("display", "");
    });

    $(".quitedit").on("click", function (e) {
        e.preventDefault();
        var hidecommentid = $(this).data("hidecommentid");
        var showcommentid = $(this).data("showcommentid");
        var actiondiv = $(this).data("actiondiv");
        $("#" + showcommentid).css("display", "");
        $("#" + actiondiv).css("display", "");
        $("#" + hidecommentid).css("display", "none");
    });

    $(".saveedit").on("click", function (e) {
        e.preventDefault();
        var hidecommentid = $(this).data("hidecommentid");
        var showcommentid = $(this).data("showcommentid");
        var actiondiv = $(this).data("actiondiv");
        var commentid = $(this).data("commentid");
        var comment = $("#commentedit" + commentid).val();
        var commentid = $("#commentid" + commentid).val();
        var csrf = "{{csrf_token()}}";
        var url = "{{route('updateComment')}}";
        $.post(url, {'_token': csrf, 'comment': comment, 'commentid': commentid}, function (resp) {
            if (resp == "ERROR") {

            } else {
                $("#" + showcommentid).html(resp);
                $("#commentedit" + commentid).val(resp);
                $("#" + showcommentid).css("display", "");
                $("#" + actiondiv).css("display", "");
                $("#" + hidecommentid).css("display", "none");
            }
        });
    });

    $(".deletecomment").on("click", function (e) {
        e.preventDefault();
        var commentid = $(this).data("commentid");
        var biocomment = $(this).data("biocomment");
        var csrf = "{{csrf_token()}}";
        var url = "{{route('deleteComment')}}";
        if(confirm("Want to delete ? ")){
            $.post(url, {'_token': csrf,'commentid': commentid}, function (resp) {
                if (resp == "ERROR") {

                } else {
                    $("#"+biocomment).remove();
                }
            });
        }
    })


</script>
