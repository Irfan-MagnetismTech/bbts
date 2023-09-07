$(document).on("keyup focus", "#client_name", function () {
    $(this).autocomplete({
        source: function (request, response) {
            $.ajax({
                url: window.location.origin + "/billing/get_client",
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
            $("#client_name").val(ui.item.label);
            $("#client_no").val(ui.item.client_no);
            $("#client_id").val(ui.item.client_id);

            $("#fr_no").html("");
            var link_options = '<option value="">Select Option</option>';

            ui.item.saleDetails.forEach(function (element) {
                link_options += `<option value="${element.fr_no}">${element.fr_no}</option>`;
            });
            client_details = ui.item.details;
            $("#fr_no").html(link_options);

            return false;
        },
    });
});
