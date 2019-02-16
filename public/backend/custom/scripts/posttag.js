$(document).ready(function () {
    
    function tagvalugenerator(values) {
        var tagsvalue = "";
        tagsvalue += $("#tagsvalue").val();
        if (tagsvalue.search(values) == -1) {
            if (tagsvalue == "") {
                tagsvalue = values;
            } else {
                tagsvalue += "," + values;
            }
            $("#tagsvalue").val(tagsvalue);
            $("#badgewarring").removeClass('hide');
            var badge = "<span onclick='return removetagbtn(this)' style='margin-right: 3px' class='btn badge badge-success tagclass' data-value='" + values + "'>" + values + "</span>";
            $("#tagsbadge").append(badge);
        }
    }
    
    $("#tag").autocomplete({
        source: alltags,
        select: function (event, ui) {
            tagvalugenerator(ui.item.value);
        },
        close: function (event, ui) {
            $("#tag").val("");
        }
    });
    
    $("#addTagbtn").on("click", function (e) {
        e.preventDefault();
        var values = $("#tag").val();
        if (values.search(",") != -1) {
            var results = values.split(",");
            for (var i = 0; i < results.length; i++) {
                tagvalugenerator(results[i]);
            }
        } else {
            tagvalugenerator(values);
        }
        $("#tag").val("");
    });
    
    
});
