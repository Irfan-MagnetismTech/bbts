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
                calculateTotalAmount();
            } else {
                // Handle the case where no data is returned or an error occurs
                console.log("No data found or an error occurred.");
            }
        },
    });
});

function addRow(value) {
    const vatAmount = value.vat_amount ?? 0;
    const totalPrice = value.total_price ?? 0;
    const totalAmount = (parseFloat(vatAmount) + parseFloat(totalPrice)).toFixed(2);

    let row = `<tr>
                            <td>
                                <input name="product_name[]" class="form-control product_name" readonly autocomplete="off" type="text" value="${value.product_name}" readonly>
                                <input name="product_id[]" class="form-control product_id" readonly autocomplete="off" type="hidden" value="${value.product_id}">
                            </td>
                            <td>
                                <input name="quantity[]" class="form-control quantity" autocomplete="off" type="text" value="${value.quantity}" readonly>
                            </td>
                            <td>
                                <input name="unit[]" class="form-control unit" autocomplete="off" type="text" value="${value.unit}" readonly>
                            </td>
                            <td>
                                <input name="unit_price[]" class="form-control unit_price" autocomplete="off" type="text" value="${value.price}" readonly>
                            </td>
                            <td>
                                <input name="total_price[]" class="form-control total_price" autocomplete="off" type="text" value="${totalPrice}" readonly>
                            </td>
                            <td>
                                <input name="vat[]" class="form-control vat" autocomplete="off" type="text" value="${vatAmount}" readonly>
                            </td>
                            <td>
                                <input name="total_amount[]" class="form-control total_amount" autocomplete="off" type="text" value="${totalAmount}" readonly>
                            </td>
                        </tr>
                    `;
    $('#errTable tbody').append(row);
}

function emptyRow() {
    $('#errTable tbody').empty();
}

function calculateTotalAmount(){
    var totalAmount = 0;
    $(".total_amount").each(function () {
        totalAmount += parseFloat($(this).val() ? $(this).val() : 0);
    })
    $('#net_total_amount').val(totalAmount.toFixed(2));
}


$(document).on("change", "#fr_no", function () {
    var selectedFrNo = $(this).val(); // Get the selected "fr_no" value

    // Send the selected value to the server using AJAX
    $.ajax({
        url: window.location.origin + "/billing/get_fr_bill_date",
        type: "get",
        dataType: "json",
        data: {
            fr_no: selectedFrNo, // Pass the selected "fr_no" value
        },
        success: function (data) {
            // Handle the server's response here
            if (data.length > 0) {
                $("#billing_date").val(data[0].billing_date);

                const billingDateValue = $("#billing_date").val();

                // Check if the billingDateValue is not empty before creating a Date object
                if (billingDateValue) {
                    const inputDate = new Date(billingDateValue);
                    const lastDayOfMonth = new Date(inputDate.getFullYear(), inputDate.getMonth() + 1, 0);
                    const remainingDays = lastDayOfMonth.getDate() - inputDate.getDate();

                    // Set the remaining days in the input field with the id "days"
                    $("#days").val(remainingDays);
                }

                calculatePayableAmount();
            } else {
                // Handle the case where no data is returned or an error occurs
                $("#billing_date").val('');
                $("#days").val('0');

                calculatePayableAmount();
            }
        },

    });
});

function calculatePayableAmount() {
    var days = $("#days").val();
    var netTotalAmount = parseFloat($("#net_total_amount").val());

    // Check if 'days' is a valid number
    if (days > 0 && netTotalAmount > 0) {
        let amount = (parseFloat(days) * netTotalAmount) / 30;
        $("#payable_amount").val(amount.toFixed(2));
    } else {
        $("#payable_amount").val('0.00');
    }
}

