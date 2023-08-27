<script>
    function appendDataServiceRow() {
        let row_index = $("#data_service tr:last").prop('rowIndex');

        var html = `
            <tr>
                <td>
                    <select name="product_id[]" class="form-control select2" required>
                        <option value="" slected disable>Select Product</option>
                        @foreach ($products as $data)
                            <option value="{{ $data->product->id }}">{{ $data->product->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" name="quantity[]" class="form-control quantity" autocomplete="off" required>
                </td>
                <td>
                    <select name="ip_ipv4[]" class="form-control select2 ip_ipv4" >
                        <option value="" slected disable>Select IP Address</option>
                        @foreach ($ipv4Ips as $ip)
                            <option value="{{ $ip->address }}">{{ $ip->address }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select name="ip_ipv6[]" class="form-control select2 ip_ipv6" >
                        <option value="" slected disable>Select IP Address</option>
                        @foreach ($ipv6Ips as $ip)
                            <option value="{{ $ip->address }}">{{ $ip->address }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="text" name="subnetmask[]" class="form-control subnetmask" autocomplete="off">
                </td>
                <td>
                    <input type="text" name="gateway[]" class="form-control gateway" autocomplete="off">
                </td>
                <td>
                    <input type="text" name="vlan[]" class="form-control vlan" autocomplete="off">
                </td>
                <td>
                    <input type="text" name="mrtg_user[]" class="form-control mrtg_user" autocomplete="off" >
                </td>
                <td>
                    <input type="text" name="mrtg_pass[]" class="form-control mrtg_pass" autocomplete="off" >
                </td>
                ${(row_index > 0) ? 
                `<td>
                    <button type="button" class="btn btn-danger btn-sm fa fa-minus remove-data-service-row"></button>
                </td>`:
                `<td>
                    <button type="button" class="btn btn-success btn-sm fa fa-plus add-data-service-row"></button>
                </td>`
                }
            </tr>
        `;
        $("#data_service tbody").append(html);
    }

    function appendBandwidthDistributionRow() {
        let row_index = $("#bandwidth_distribution tr:last").prop('rowIndex');

        var html = `
            <tr>
                <td>
                    <select name="ip_address[]" class="form-control select2" required>
                        <option value="" slected disable>Select IP Address</option>
                        @foreach ($ips as $ip)
                            <option value="{{ $ip->id }}">{{ $ip->address }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="text" name="bandwidth[]" class="form-control bandwidth"
                        autocomplete="off" value="{{ $line->bandwidth }}">
                </td>
                <td>
                    <input type="text" name="remarks[]" class="form-control remarks"
                        autocomplete="off" value="{{ $line->remarks }}">
                </td>
                ${(row_index > 0) ? 
                `<td>
                    <button type="button" class="btn btn-danger btn-sm fa fa-minus remove-bandwidth-distribution-row"></button>
                </td>`:
                `<td>
                    <button type="button" class="btn btn-success btn-sm fa fa-plus add-bandwidth-distribution-row"></button>
                </td>`
                }
            </tr>
        `;
        $("#bandwidth_distribution tbody").append(html);
    }

    // all input fields of logical connectivity facilities
    const dns_input_fields = "#dns_domain, #dns_mx_record, #dns_a_record, #dns_reverse_record, #dns_ip_address";
    const smtp_input_fields = "#smtp_domain, #smtp_server";
    const vpn_input_fields =
        "#vpn_purpose, #vpn_source_ip, #vpn_destination_ip, #vpn_bandwidth, #vpn_iig_name, #vpn_tunnel_active_date, #vpn_submission_date, #vpn_remarks";
    const vc_input_fields =
        "#vc_issued_date, #vc_source_ip, #vc_destination_ip, #vc_iig_name, #vc_itc_name, #vc_renewal_date, #vc_remarks";
    const bgp_input_fields = "#bgp_primary_peering, #bgp_secondary_peering, #bgp_client_prefix, #bgp_client_as";

    // on edit mode, if facility type is selected then enable all input fields of that facility type
    $(document).ready(function() {
        @php
            $inputFieldsMap = [
                'dns' => 'dns_input_fields',
                'smtp' => 'smtp_input_fields',
                'vpn' => 'vpn_input_fields',
                'vc' => 'vc_input_fields',
                'bgp' => 'bgp_input_fields',
            ];
        @endphp

        @foreach ($facilityTypes as $facilityType)
            @if (isset($inputFieldsMap[$facilityType]))
                $(<?= $inputFieldsMap[$facilityType] ?>).prop('disabled', false);
            @endif
        @endforeach

        //call the functions to append data service and bandwidth distribution rows
        @if (empty($logicalConnectivityInternet))
            appendDataServiceRow();
            appendBandwidthDistributionRow();
            initializeSelect2();
        @endif
        initializeSelect2();
    });

    /* Adds and removes quantity row on click */
    $("#data_service")
        .on('click', '.remove-data-service-row', function() {
            $(this).closest('tr').remove();
        }).on('click', '.add-data-service-row', function() {
            appendDataServiceRow();
            initializeSelect2();
        });

    /* Adds and removes bandwidth row on click */
    $("#bandwidth_distribution")
        .on('click', '.remove-bandwidth-distribution-row', function() {
            $(this).closest('tr').remove();
        }).on('click', '.add-bandwidth-distribution-row', function() {
            appendBandwidthDistributionRow();
            initializeSelect2();
        });

    function initializeSelect2() {
        $('.select2').select2({
            placeholder: 'Select an option'
        });
    }

    //on checkbox check enable input box and on uncheck disable input box
    function checkboxChange(e, inputFields) {
        if (e.checked) {
            $(inputFields).prop('disabled', false);
        } else {
            $(inputFields).prop('disabled', true);
        }
    }

    //initialize datepicker
    $('.date').datepicker({
        format: "dd-mm-yyyy",
        autoclose: true,
        todayHighlight: true,
        showOtherMonths: true
    });
</script>
