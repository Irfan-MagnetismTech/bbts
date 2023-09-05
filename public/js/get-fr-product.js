$(document).on("change", "#fr_no", function () {
    emptyRow()
    var selectedFrNo = $(this).val(); // Get the selected "fr_no" value

    // Send the selected value to the server using AJAX
    $.ajax({
        url: window.location.origin + "/billing/get_fr_product",
        type: "get",
        dataType: "json",
        data: {
            fr_no: selectedFrNo, // Pass the selected "fr_no" value
        },
        success: function (data) {
            // Handle the server's response here
            if (data.length > 0) {
                $.each(data, function(key, value) {
                    addRow(value)
                });
            } else {
                // Handle the case where no data is returned or an error occurs
                console.log("No data found or an error occurred.");
            }
        },
    });
});

function addRow(value) {
    let row = `<tr>
                            <td>
                                <input name="product_name[]" class="form-control product_name" readonly autocomplete="off" type="text" value="${value.product_name}" readonly>
                                <input name="product_id[]" class="form-control product_id" readonly autocomplete="off" type="hidden" value="${value.product_id}">
                            </td>
                            <td>
                                <input name="quantity[]" class="form-control quantity" autocomplete="off" type="text" value="${value.quantity}" readonl>
                            </td>
                            <td>
                                <input name="unit[]" class="form-control unit" autocomplete="off" type="text" value="${value.unit}" readonly>
                            </td>
                            <td>
                                <input name="rate[]" class="form-control rate" autocomplete="off" type="text" value="${value.rate}" readonly>
                            </td>
                            <td>
                                <input name="price[]" class="form-control price" autocomplete="off" type="text" value="${value.price}" readonly>
                            </td>
                            <td>
                                <input name="vat_amount[]" class="form-control vat_amount" autocomplete="off" type="text" value="${value.vat_amount}" readonly>
                            </td>
                            <td>
                                <input name="total_price[]" class="form-control total_price" autocomplete="off" type="text" value="${value.total_price}" readonly>
                            </td>
                        </tr>
                    `;
    $('#errTable tbody').append(row);
}

function emptyRow() {
    $('#errTable tbody').empty();
}
