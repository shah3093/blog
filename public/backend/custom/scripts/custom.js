$(function () {
    $("#addFrm").submit(function (event) {
        var check = 0;
        $(".required").each(function () {
            if (!$(this).val()) {
                $(this).addClass('error-signal');
                check = 1;
                event.preventDefault();
            } else {
                $(this).removeClass("error-signal");
            }
        });
    });
    
    $(".image").on("blur", function (event) {
        event.preventDefault();
        const file = this.files[0];
        const fileType = file['type'];
        const validImageTypes = ['image/gif', 'image/jpeg', 'image/png', 'image/bmp'];
        if (!validImageTypes.includes(fileType)) {
            $(this).val("");
            alert("Invalid image type");
        }
    });
    
    $(".select2").select2();
    
    /*Delete data sweet alert */
    $(".deletedatafrm").on("click", function (event) {
        event.preventDefault();
        var url = $(this).attr("href");
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this data!",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    $(this).submit();
                }
            });
    });
    
    $('#zero_config').DataTable();
    
});
