$(function () {
    $("#print-post").on("click", function (e) {
        e.preventDefault();
        var header = "<br/>" + $("#post-header").html() + "<br/>";
        $('.post-content-body').printThis({
            header: "<h1>" + header + "</h1>",
            base: "https://jasonday.github.io/printThis/"
        });
    });
    
    $('[data-toggle="tooltip"]').tooltip();
    
    $(".shareweb").on("click", function () {
        javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');
        return false;
    });
});
