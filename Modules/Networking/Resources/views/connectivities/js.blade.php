<script>
    $('.date').datepicker({
        format: "dd-mm-yyyy",
        autoclose: true,
        todayHighlight: true,
        showOtherMonths: true
    }).datepicker("setDate", new Date());

    /* Adds and removes quantity row on click */
    $("#physical_connectivity")
        .on('click', '.remove-network-info-row', function() {
            $(this).closest('tr').remove();
        });

    $(function() {
        $('.select2').select2();
    });
</script>
