<script>
    function appendDataServiceRow() {
        let row_index = $("#data_service tr:last").prop('rowIndex');

        var html = `
            <tr>
                <td>
                    <select name="product_id[]" class="form-control select2" required>
                        <option value="" slected disable>Select Product</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select name="data_type[]" class="form-control select2" required>
                        <option value="" slected disable>Select an option</option>
                        @foreach ($dataTypes as $data_type)
                            <option value="{{ $data_type->name }}">{{ $data_type->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" name="quantity[]" class="form-control quantity" autocomplete="off" required>
                </td>
                <td>
                    <input type="text" name="ip_ipv4[]" class="form-control ip_ipv4" autocomplete="off" >
                </td>
                <td>
                    <input type="text" name="ip_ipv6[]" class="form-control ip_ipv6" autocomplete="off" >
                </td>
                <td>
                    <input type="text" name="subnetmask[]" class="form-control subnetmask" autocomplete="off" >
                </td>
                <td>
                    <input type="text" name="gateway[]" class="form-control gateway" autocomplete="off" >
                </td>
                <td>
                    <input type="text" name="vlan[]" class="form-control vlan" autocomplete="off" >
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

    $(document).ready(function() {
        @if (empty($logicalConnectivityData))
            appendDataServiceRow();
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

    function initializeSelect2() {
        $('.select2').select2({
            placeholder: 'Select an option'
        });
    }
</script>
