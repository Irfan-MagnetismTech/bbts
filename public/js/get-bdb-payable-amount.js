$(document).on("keyup focus", "#days", function () {
    var days = $(this).val();
    var netTotalAmount = parseFloat($("#net_total_amount").val());

    // Check if 'days' is a valid number
    if (!isNaN(days) && !isNaN(netTotalAmount)) {
        let amount = (parseFloat(days) * netTotalAmount) / 30;
        $("#payable_amount").val(amount.toFixed(2));
    } else {
        $("#payable_amount").val('');
    }
});
