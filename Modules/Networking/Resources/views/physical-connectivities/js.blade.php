<script>
    $(document).on("keyup focus", "#client_name", function() {
        $(this).autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('searchClientWithFrDetails') }}",
                    type: "get",
                    dataType: "json",
                    data: {
                        search: request.term,
                    },
                    success: function(data) {
                        response(data);
                    },
                });
            },
            select: function(event, ui) {
                $("#client_name").val(ui.item.label);
                $("#client_no").val(ui.item.client_no);
                $('#client_type').val(ui.item.client_type);

                $("#connectivity_point").html("");
                var link_options = '<option value="">Select Option</option>';

                ui.item.frDetails.forEach(function(element) {
                    console.log(element)
                    link_options +=
                        `<option value="${element.fr_no}">${element.connectivity_point + '-' + element.fr_no}</option>`;
                });
                $("#connectivity_point").html(link_options);

                return false;
            },
        });
    });

    $("#connectivity_point").on("change", function() {
        let connectivity_point = $(this).val();

        $.ajax({
            url: "{{ route('getFrDetailsData') }}",
            type: "get",
            dataType: "json",
            data: {
                connectivity_point: connectivity_point,
            },
            success: function(data) {
                $("#fr_no").val(data.fr_no);
                $("#contact_person").val(data.contact_name);
                $("#contact_number").val(data.contact_number);
                $("#email").val(data.contact_email);
                $("#contact_address").val(data.location);
                $("#lat_long").val(data.lat_long);

                $("#physical_connectivity tbody").html("");
                appendNetworkInfoRow(data.planning.final_survey_details);
                console.log(data.planning.final_survey_details);
            },
        });
    });

    function appendNetworkInfoRow(data) {
        data.forEach(function(element) {
            let row = `<tr>
                            <td>
                                <input type="text" name="link_type[]" class="form-control link_type"
                                    autocomplete="off" value="${element.link_type}" readonly>
                            </td>
                            <td>
                                <input type="text" name="method[]" class="form-control method"
                                    autocomplete="off" value="${element.method}" readonly>
                            </td>
                            <td>
                                <input type="text" name="pop[]" class="form-control pop"
                                    autocomplete="off" value="${element.method}" readonly>
                            </td>
                            <td>
                                <input type="text" name="ldp[]" class="form-control ldp"
                                    autocomplete="off" value="">
                            </td>
                            <td>
                                <input type="text" name="link_id[]" class="form-control link_id"
                                    autocomplete="off" value="">
                            </td>
                            <td>
                                <input type="text" name="device_ip[]" class="form-control device_ip"
                                    autocomplete="off" value="">
                            </td>
                            <td>
                                <input type="text" name="port[]" class="form-control port"
                                    autocomplete="off" value="">
                            </td>
                            <td>
                                <input type="text" name="vlan[]" class="form-control vlan"
                                    autocomplete="off" value="">
                            </td>
                            <td>
                                <input type="text" name="distance[]" class="form-control distance"
                                    autocomplete="off" value="${element.distance}" readonly>
                            </td>
                            <td>
                                <input type="text" name="connectivity_details[]" class="form-control connectivity_details"
                                    autocomplete="off" value="">
                            </td>
                            <td>
                                <input type="text" name="backbone[]" class="form-control backbone"
                                    autocomplete="off" value="${element.method}" readonly>
                            </td>
                            <td>
                                <input type="text" name="comment[]" class="form-control comment"
                                    autocomplete="off" value="">
                            </td>
                            <td>
                                <i class="btn btn-danger btn-sm fa fa-minus remove-network-info-row"></i>
                            </td>
                        </tr>`;
            $("#physical_connectivity tbody").append(row);
        });
    }

    $('#date').datepicker({
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
