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

