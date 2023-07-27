<script>
    
    
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
                $({{ $inputFieldsMap[$facilityType] }}).prop('disabled', false);
            @endif
        @endforeach        
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
</script>
