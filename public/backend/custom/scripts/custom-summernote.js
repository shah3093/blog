$(document).ready(function () {
    $('#contentT').summernote({
        height: "600px",
        popatmouse: false,
        callbacks: {
            onImageUpload: function (image) {
                uploadImage(image[0]);
            },
            onMediaDelete: function (target) {
                deleteImage(target[0].src);
            }
        }
    });
    
    function deleteImage(imgSrc) {
        console.log(imgSrc);
        $.post(deletefilemethodurl, {
            'text': imgSrc,
            '_token': _token
        }, function (re) {
            console.log(re);
        });
    }
    
    function deleteFile(text) {
        $.post(deletefilemethodurl, {
            'text': text,
            '_token': _token
        }, function (re) {
            console.log(re);
        });
    }
    
    function uploadImage(image) {
        var data = new FormData();
        data.append("image", image);
        data.append("_token", _token);
        // console.log(data);
        $.ajax({
            url: storefilemethodurl,
            cache: false,
            contentType: false,
            processData: false,
            data: data,
            type: "post",
            success: function (url) {
                if (url != "FILE_NOT_FOUND") {
                    var file;
                    var pattern = /(jpeg|gif|png|jpg)/g;
                    if (pattern.test(url)) {
                        var image = $('<img>').attr('src', url);
                        file = image[0];
                    } else {
                        var link = $('<a></a>').attr('href', url).text("Download");
                        file = link[0];
                    }
                    $('#contentT').summernote("insertNode", file);
                }
                
            },
            error: function (data) {
                console.log(data);
            }
        });
    }
});
