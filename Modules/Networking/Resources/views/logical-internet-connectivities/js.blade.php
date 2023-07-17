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
                    <input type="text" name="ip_ipv4[]" class="form-control ip_ipv4" autocomplete="off" required>
                </td>
                <td>
                    <input type="text" name="ip_ipv6[]" class="form-control ip_ipv6" autocomplete="off" required>
                </td>
                <td>
                    <input type="text" name="subnetmask[]" class="form-control subnetmask" autocomplete="off" required>
                </td>
                <td>
                    <input type="text" name="gateway[]" class="form-control gateway" autocomplete="off" required>
                </td>
                <td>
                    <input type="text" name="vlan[]" class="form-control vlan" autocomplete="off" required>
                </td>
                <td>
                    <input type="text" name="mrtg_user[]" class="form-control mrtg_user" autocomplete="off" required>
                </td>
                <td>
                    <input type="text" name="mrtg_pass[]" class="form-control mrtg_pass" autocomplete="off" required>
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

    $(document).ready(function() {
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
</script>
