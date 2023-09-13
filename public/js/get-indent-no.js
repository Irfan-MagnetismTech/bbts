$(document).on("keyup focus", "#indent_no", function () {
    $(this).autocomplete({
        source: function (request, response) {
            $.ajax({
                url: window.location.origin + "/scm/get-indent-no",
                type: "get",
                dataType: "json",
                data: {
                    search: request.term,
                },
                success: function (data) {
                    response(data);
                },
            });
        },
        select: function (event, ui) {
            $("#indent_no").val(ui.item.label);
        },
    });
});
