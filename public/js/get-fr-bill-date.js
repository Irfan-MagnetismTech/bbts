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
            } else {
                // Handle the case where no data is returned or an error occurs
                console.log("No data found or an error occurred.");
            }
        },

    });
});

