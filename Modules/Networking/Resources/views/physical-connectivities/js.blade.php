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
                    link_options +=
                        `<option value="${element.connectivity_point + '_' + element.fr_no}">${element.connectivity_point + '_' + element.fr_no}</option>`;
                });
                $("#connectivity_point").html(link_options);

                return false;
            },
        });
    });

    $("#connectivity_point").on("change", function() {
        $("#physical_connectivity tbody").html("");

        let connectivity_point = $(this).val().split("_")[1];
        let sale_id = $("#sale_id").val();

        $.ajax({
            url: "{{ route('getFrDetailsData') }}",
            type: "get",
            dataType: "json",
            data: {
                fr_no: connectivity_point,
                sale_id: sale_id,
            },
            success: function(data) {
                if (data.fr_details == null) {
                    $("#fr_no").val("");
                    $("#contact_person").val("");
                    $("#contact_number").val("");
                    $("#email").val("");
                    $("#contact_address").val("");
                    $("#lat").val("");
                    $("#long").val("");

                    $("#physical_connectivity tbody").html(
                        `<tr><td colspan="11" class="text-center">No Data Found</td></tr>`
                    );
                    Swal.fire('No data found')
                    return false;
                }
                $("#fr_no").val(data.fr_details.fr_no);
                $("#contact_person").val(data.fr_details.contact_name);
                $("#contact_number").val(data.fr_details.contact_number);
                $("#email").val(data.fr_details.contact_email);
                $("#contact_address").val(data.fr_details.location);
                $("#lat").val(data.fr_details.lat);
                $("#long").val(data.fr_details.long);

                $("#physical_connectivity tbody").html("");
                console.log(data.sale_link_details.length)
                if (data.sale_link_details.length == 0) {
                    $("#physical_connectivity tbody").html(
                        `<tr><td colspan="11" class="text-center">No Data Found</td></tr>`
                    );
                }
                appendNetworkInfoRow(data.sale_link_details);
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
                                    autocomplete="off" value="${element.final_survey_details.method}" readonly>
                            </td>
                            <td>
                                <input type="text" name="pop[]" class="form-control pop"
                                    autocomplete="off" value="${element.final_survey_details.pop.name}" readonly>
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
                                <input type="text" name="connectivity_details[]" class="form-control connectivity_details"
                                    autocomplete="off" value="">
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
