<script>
    $('.date').datepicker({
        autoclose: true,
        todayHighlight: true,
        showOtherMonths: true
    });

    $('.bankList').select2({
        placeholder: 'Select an option'
    });

    $('.offer_otc').on('input', function() {
        // calculateOtc($(this));
        var offer_otc = $(this).val();
        var client_equipment_amount = $(this).closest('tr').find('.client_equipment_amount').val();
        var total_amount = parseFloat(offer_otc) + parseFloat(client_equipment_amount);
        $(this).closest('tr').find('.total_cost_otc').val(total_amount);
        $(this).val(offer_otc);
        var total_otc = 0;
        var total_cost_otc = 0;

        //otc calculation
        var total_otc = $(this).closest('tr').find('.offer_otc').val();
        console.log('total_otc', total_otc)
        var row = $(this).closest('.mainRow').find('.total_offer_otc').val(total_otc);
        console.log('row', row)
        var total_cost_otc = $(this).closest('tr').find('.total_cost_otc').val();
        console.log('total_cost_otc', total_cost_otc)
        $(this).closest('.mainRow').find('.grand_total_otc').val(total_cost_otc);
        // calculateTotalOtc($(this));
    });



    function calculateTotalOtc(event) {


        //total cost calculation
        // event.closest('tr').find('.total_cost_otc').each(function() {
        //     total_cost_otc += parseFloat($(this).val());
        // });
        // event.closest('.offer_details_row').find('.grand_total_otc').val(total_cost_otc);
    }

    $('.offer_mrc').on('input', function() {
        calculateTotalMrc($(this));
        calculateGrandTotal($(this))
    });

    function calculateTotalMrc(event) {
        console.log('fine')
        var total_offer_mrc = 0
        event.closest('tr').find('.offer_mrc').each(function() {
            total_offer_mrc += parseFloat($(this).val());
        });
        console.log(total_offer_mrc)
        event.closest('.mainRow').find('.total_offer_mrc').val(total_offer_mrc);
    }

    $('.equipment_offer_price').on('input', function() {
        calculateEquipmentPrice($(this));
        calculateGrandTotal($(this))
    });

    function calculateEquipmentPrice(event) {
        var equipment_offer_price = event.val();
        console.log('equipment_offer_price', equipment_offer_price)
        var client_equipment_amount = event.closest('.mainRow').find('.product_equipment_price').val() ?? 0;
        console.log('client_equipment_amount', client_equipment_amount)
        var total_amount = parseFloat(equipment_offer_price) + parseFloat(client_equipment_amount);
        event.closest('tr').find('.equipment_total_otc').val(total_amount);
    }

    $('.total_offer_mrc, .equipment_total_mrc, .offer_product_amount').on('input', function() {
        calculateGrandTotal($(this));
    });

    function calculateGrandTotal(event) {
        var total_offer_mrc = event.closest('.mainRow').find('.total_offer_mrc').val();
        total_offer_mrc = total_offer_mrc ? total_offer_mrc : 0;
        var equipment_total_mrc = event.closest('.mainRow').find('.equipment_total_mrc').val();
        equipment_total_mrc = equipment_total_mrc ? equipment_total_mrc : 0;
        var offer_product_amount = event.closest('.mainRow').find('.offer_product_amount').val();
        offer_product_amount = offer_product_amount ? offer_product_amount : 0;
        var offer_management_cost = event.closest('.mainRow').find('.offer_management_cost').val();
        offer_management_cost = offer_management_cost ? offer_management_cost : 0;
        var grand_total_mrc = parseFloat(total_offer_mrc) + parseFloat(equipment_total_mrc) + parseFloat(
            offer_product_amount) + parseFloat(offer_management_cost);
        event.closest('.mainRow').find('.grand_total').val(grand_total_mrc);
    }
</script>
