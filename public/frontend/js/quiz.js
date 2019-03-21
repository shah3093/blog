$(function () {
    var answer_corect = 0;
    var answer_wrong = 0;
    var loading = $('#loadbar').hide();
    $(document)
        .ajaxStart(function () {
            loading.show();
        }).ajaxStop(function () {
            loading.hide();
        });

    $("label.btn").on('click', function () {
        var correct_answer = $(this).attr('data-iscorrect');
        var nextquestionid = $(this).attr('data-nextquestionid');
        var currentquestionid = $(this).attr('data-currentquestionid');
        $('#loadbar').show();
        $('#quiz').fadeOut();
        if (correct_answer == 1) {
            answer_corect++;
        } else {
            answer_wrong++;
        }
        
        if ($("#" + nextquestionid).length) {
            $("#" + currentquestionid).addClass("hide-div");
            $("#" + nextquestionid).removeClass("hide-div");
        }else{
            $("#" + currentquestionid).addClass("hide-div");
            $("#result-details").removeClass("hide-div");
            $("#answer_wrong").html("Wrong answer : "+answer_wrong);
            $("#answer_corect").html("Correct answer : "+answer_corect);
        }
    });

    $("#showallanswer").on("click",function(e){
        e.preventDefault();
        $("#result-details").addClass("hide-div");
        $("#allanswerdiv").removeClass("hide-div");
    });

});