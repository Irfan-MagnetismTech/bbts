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
        calculateTotalOtc($(this));
    });



    function calculateTotalOtc(event) {
        var total_otc = 0;
        var total_cost_otc = 0;
        event.closest('.mainRow').find('.offer_otc').each(function() {
            let offer_otc = $(this).val() ? $(this).val() : 0;
            total_otc += parseFloat(offer_otc);
        });
        event.closest('.mainRow').find('.total_cost_otc').each(function() {
            let cost_otc = $(this).val() ? $(this).val() : 0;
            total_cost_otc += parseFloat(cost_otc);
        });
        event.closest('.mainRow').find('.total_offer_otc').val(total_otc);
        event.closest('.mainRow').find('.grand_total_otc').val(total_cost_otc);
    }

    $('.offer_mrc').on('input', function() {
        calculateTotalMrc($(this));
        calculateGrandTotal($(this))
    });

    function calculateTotalMrc(event) {
        var total_offer_mrc = 0
        event.closest('.mainRow').find('.offer_mrc').each(function() {
            let offer_mrc = $(this).val() ? $(this).val() : 0;
            total_offer_mrc += parseFloat(offer_mrc);
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

    $('.offer_otc').on('keyup', function() {
        calculateMrc($(this));
        calculateTotalMrc($(this));
        calculateGrandTotal($(this))
    });

    function calculateMrc(value) {
        let offer_otc = value.closest('tr').find('.offer_otc').val();
        let link_invest = value.closest('tr').find('.link_invest').val() || 0;
        let month = value.closest('tr').find('.month').val();
        let capacity_amount = value.closest('tr').find('.capacity_amount').val() || 0;
        let operation_cost = value.closest('tr').find('.operation_cost').val() || 0;

        let roi = (link_invest - offer_otc) / month;
        console.log('month', month)
        let mrc = Number(roi) + Number(capacity_amount) + Number(operation_cost);
        console.log(offer_otc, link_invest, month, capacity_amount, operation_cost, roi, mrc)
        value.closest('tr').find('.offer_mrc').val(mrc.toFixed(2));
    }

    $('.equipment_offer_price').on('input', function() {
        calculateEquipmentROI($(this));
        calculateGrandTotal($(this));
    });

    function calculateEquipmentROI(value) {
        let equipment_otc = value.closest('tr').find('.equipment_offer_price').val();
        let month = value.closest('tr').find('.month').val();
        let equipment_invest = value.closest('tr').find('.equipment_invest').val();
        let equipment_roi = (equipment_invest - equipment_otc) / month;
        value.closest('tr').find('.equipment_total_mrc').val(equipment_roi.toFixed(2));
    }

    function calculateGrandTotal(event) {
        var total_offer_mrc = event.closest('.mainRow').find('.total_offer_mrc').val() ?? 0;
        total_offer_mrc = total_offer_mrc ? total_offer_mrc : 0;
        var equipment_total_mrc = event.closest('.mainRow').find('.equipment_total_mrc').val() ?? 0;
        equipment_total_mrc = equipment_total_mrc ? equipment_total_mrc : 0;
        var offer_product_amount = event.closest('.mainRow').find('.offer_product_amount').val() ?? 0;
        offer_product_amount = offer_product_amount ? offer_product_amount : 0;
        var offer_management_cost = event.closest('.mainRow').find('.offer_management_cost').val() ?? 0;
        offer_management_cost = offer_management_cost ? offer_management_cost : 0;
        var grand_total_mrc = parseFloat(total_offer_mrc) + parseFloat(equipment_total_mrc) + parseFloat(
            offer_product_amount) + parseFloat(offer_management_cost);

        event.closest('.mainRow').find('.grand_total').val(grand_total_mrc.toFixed(2));
    }
</script>
