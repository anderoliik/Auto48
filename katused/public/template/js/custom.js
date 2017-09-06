var admin_url = "http://ubuntu.ametikool.ee/~TAK15_Liik/katused/public/admin/";

$(".delete-confirm").click(function () {
    var title = "Are you sure?*";
    var text = "You will not be able to recover this imaginary file!*";
    var confirmButtonText = "Yes, delete it!*";

    var heading_1 = "Deleted*";
    var confirm_text = "Your imaginary file has been deleted.*";

    var ID = $(this).data("delete-id");
    var url = $(this).data("url");

    var closestTr = $(this).closest("tr");

    swal({
            title: title,
            text: text,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: confirmButtonText,
            closeOnConfirm: false
        },
        function(){
            $.ajax({
                method: "POST",
                url: admin_url + url + ".php?ID=" + ID
            })
                .done(function( data ) {
                    if(data == '') {
                        closestTr.remove();
                        swal(heading_1, confirm_text, "success");
                    } else {
                        swal("ERROR", data, "error");
                    }

                });
        });
});

$(".delete-picture").click(function () {
    var ID = $(this).data("picture-id");

    $.ajax({
        method: "POST",
        data: {ID: ID},
        url: admin_url + "pages/pictures/delete.php"
    })
        .done(function( data ) {
            if(data == '') {
                $("#picture_" + ID).remove();
                swal("Deleted", "Your imaginary file has been deleted.", "success");
            } else {
                swal("ERROR", data, "error");
            }

        });
});

$(".set-main-picture").click(function () {
    var name = $(this).data("picture-name");
    var ID = $(this).data("product-id");

    $.ajax({
        method: "POST",
        data: {name: name, ID: ID},
        url: admin_url + "pages/pictures/set-to-main.php"
    })
        .done(function( data ) {
            if(data == '') {
                swal("Default selected", "Your imaginary file has been deleted.", "success");
            } else {
                swal("ERROR", data, "error");
            }

        });
});

$(".make-default-lang").click(function () {
    var lang = $(this).data("lang");
    console.log(lang);

    $.ajax({
        method: "POST",
        data: {lang: lang},
        url: admin_url + "pages/language/set-main-language.php"
    })
        .done(function( data ) {
            if(data == '') {
                swal("Success", "Default language changed", "success");
                $(".confirm").click(function () {
                    console.log("test");
                    location.reload();
                });
            } else {
                swal("ERROR", data, "error");
            }

        });
});