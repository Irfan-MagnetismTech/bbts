$(document).on("keyup focus", "#client_name", function () {
    $(this).autocomplete({
        source: function (request, response) {
            $.ajax({
                url: window.location.origin + "/search-client",
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
            $("#client_address").val(ui.item.address);

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

$("#equipment_type").on("change", function () {
    $("#fr_no").trigger("change");
}); 

$("#fr_no").on("change", function () {
    let fr_no = $(this).val();
    let type = $("#equipment_type").val();
    $("#link_no").html("");
    if (type == "Link") {
        let link_no = $("#link_no");
        populateDropdownByAjax(
            window.location.origin + "/search-link-no",
            {
                fr_no: fr_no,
            },
            link_no,
            "value",
            "label"
        );
    }
});
