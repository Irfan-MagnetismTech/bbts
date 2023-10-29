<script>
    function addProductEdit() {
        let table_row = `
                        <tr class="product_details_row">
                            <td>
                                <select name="product_category[]" class="form-control product_category select2">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="product[]" class="form-control product select2">
                                    <option value="">Select Product</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="prev_quantity[]" class="form-control prev_quantity" value="">
                            </td>
                            <td>
                                <input type="text" name="unit[]" class="form-control unit" value="">
                            </td>
                            <td>
                                <input type="text" name="plan[]" class="form-control plan" value="">
                            </td>
                            <td>
                                <input type="text" name="remarks[]" class="form-control remarks" value="">
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger removeProductRow"><i class="fas fa-minus"></i></button>
                            </td>
                        </tr>
                    `;
        $('.select2').select2();
        $('.productBody').append(table_row);
    };

    $(document).on('click', '.removeProductRow', function(e) {
        e.preventDefault();
        $(this).closest('tr').remove();
    });

    function addConnectivityEdit() {
        let table_row = `
                        <tr class="connectivity_details_row">
                            <td>
                                <select name="link_type[]" class="form-control link_type select2">
                                    <option value="">Select Link Type</option>
                                    <option value="Primary">Primary</option>
                                    <option value="Secondary">Secondary</option>
                                    <option value="Tertiary">Tertiary</option>
                                </select>
                            </td>
                            <td>
                                <select name="method[]" class="form-control method select2">
                                    <option value="">Select Method</option>
                                    <option value="Fiber">Fiber</option>
                                    <option value="Radio">Radio</option>
                                    <option value="GSM">GSM</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="connectivity_capacity[]" class="form-control connectivity_capacity" value="">
                            </td>
                            <td>
                                <input type="text" name="uptime_req[]" class="form-control uptime_req" value="">
                            </td>
                            <td>
                                <select name="vendor_id[]" class="form-control vendor_id select2">
                                    <option value="">Select Vendor</option>
                                    @foreach ($vendors as $vendor)
                                        <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger removeConnectivityRow"><i class="fas fa-minus"></i></button>
                            </td>
                        </tr>
                    `;
        $('.select2').select2();
        $('.connectivityEditBody').append(table_row);
    };

    $(document).on('click', '.removeConnectivityRow', function(e) {
        e.preventDefault();
        $(this).closest('tr').remove();
    });


    $('#client_no').on('input', function() {
        var client_id = $(this).val();
        var html = '<option value="">Select Fr No</option>';
        $(this).autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('searchClient') }}",
                    data: {
                        client_id: client_id,
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            select: function(event, ui) {
                $('#client_no').val(ui.item.value).attr('value', ui.item.value);
                $('#client_name').val(ui.item.label).attr('value', ui.item.label);
                //foreach loop for fr no
                $.each(ui.item.frDetails, function(key, value) {
                    html += '<option value="' + value + '">' + value +
                        '</option>';
                });
                $('#fr_no').html(html);
                return false;
            }
        });
    });

    $('#fr_no').on('change', function() {
        $('#loader').show();
        var fr_no = $(this).val();
        var client_no = $('#client_no').val();
        var logical_table = '';
        var physical_table = '';
        $.ajax({
            url: "{{ route('getLogicalConnectivityData') }}",
            data: {
                fr_no: fr_no,
                client_no: client_no,
                _token: "{{ csrf_token() }}"
            },
            success: function(data) {
                $.each(data.logical_connectivity.lines, function(key, value) {
                    logical_table += `
                                    <tr class="product_details_row">
                                        <td>
                                            <select name="product_category[]" class="form-control product_category select2">
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" ${value.product_category === "{{ $category->name }}" ? 'selected' : ''}>{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="product[]" class="form-control product select2">
                                                <option value="">Select Product</option>
                                                @foreach ($products->where('category_id') as $product)
                                                    <option value="{{ $product->id }}" ${value.product_id == {{ $product->id }} ? 'selected' : ''}>{{ $product->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="prev_quantity[]" class="form-control prev_quantity" value="${value.quantity}">
                                        </td>
                                        <td>
                                            <input type="text" name="unit[]" class="form-control unit" value="${value.product.unit}">
                                        </td>
                                        <td>
                                            <input type="text" name="plan[]" class="form-control plan" value="">
                                        </td>
                                        <td>
                                            <input type="text" name="remarks[]" class="form-control remarks" value="${value.remarks}">
                                        </td>
                                    </tr>
                                `;
                });
                $('.select2').select2();
                $('.productBody').html(logical_table);
                $.each(data.physical_connectivity.lines, function(key, value) {
                    physical_table += `
                                    <tr class="connectivity_details_row">
                                        <td>
                                            <select class="form-control link_type select2">
                                                <option value="">Select Link Type</option>
                                                <option value="Primary" ${value.link_type === "Primary" ? 'selected' : ''}>Primary</option>
                                                <option value="Secondary" ${value.link_type === "Secondary" ? 'selected' : ''}>Secondary</option>
                                                <option value="Tertiary" ${value.link_type === "Tertiary" ? 'selected' : ''}>Tertiary</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control method select2">
                                                <option value="">Select Method</option>
                                                <option value="Fiber" ${value.method === "Fiber" ? 'selected' : ''}>Fiber</option>
                                                <option value="Radio" ${value.method === "Radio" ? 'selected' : ''}>Radio</option>
                                                <option value="GSM" ${value.method === "GSM" ? 'selected' : ''}>GSM</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control vendor" value="${value?.connectivity_link?.vendor?.name}">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control bts_pop" value="${value.pop}">
                                        </td>
                                        <td>
                                            <a href="#" title="Edit" class="btn btn-sm btn-outline-warning physicalLinkEdit"><i class="fas fa-pen"></i></a>
                                        </td>
                                    </tr>
                                `;
                });
               
                $('.connectivityBody').html(physical_table);
                $('.select2').select2();
                $('#logical-table').fadeIn();
                $('#physical-table').fadeIn();
                $('#logical-table-edit').fadeIn();
                $('#physical-table-edit').fadeIn();
                $('#loader').hide();
            }
        });
    });

    $(document).on('change', '.product_category', function(e) {
        let category_id = $(this).val();
        console.log(category_id)
        let all_products = {!! json_encode($products) !!};
        let products = all_products.filter(product => product.category_id == category_id);
        console.log(products)
        let html = '<option value="">Select Product</option>';
        products.forEach(product => {
            html += `<option value="${product.id}">${product.name}</option>`;
        });
        $(this).closest('tr').find('.product').html(html);
    });

    $(document).on('change', '.product', function(e) {
        let products = {!! json_encode($products) !!};
        let product_id = $(this).val();
        let product = products.find(product => product.id == product_id);
        $(this).closest('tr').find('.unit').val(product.unit);
    });

    $(document).on('click', '.physicalLinkEdit', function(e) {
        e.preventDefault();
        let link_type = $(this).closest('tr').find('.link_type').val();
        let method = $(this).closest('tr').find('.method').val();
        let html = `
                        <tr class="connectivity_details_row">
                            <td>
                                <select name="link_type[]" class="form-control link_type select2">
                                    <option value="">Select Link Type</option>
                                    <option value="Primary" ${link_type === "Primary" ? 'selected' : ''}>Primary</option>
                                    <option value="Secondary" ${link_type === "Secondary" ? 'selected' : ''}>Secondary</option>
                                    <option value="Tertiary" ${link_type === "Tertiary" ? 'selected' : ''}>Tertiary</option>
                                </select>
                            </td>
                            <td>
                                <select name="method[]" class="form-control method select2">
                                    <option value="">Select Method</option>
                                    <option value="Fiber" ${method === "Fiber" ? 'selected' : ''}>Fiber</option>
                                    <option value="Radio" ${method === "Radio" ? 'selected' : ''}>Radio</option>
                                    <option value="GSM" ${method === "GSM" ? 'selected' : ''}>GSM</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="connectivity_capacity[]" class="form-control connectivity_capacity" value="">
                            </td>
                            <td>
                                <input type="text" name="uptime_req[]" class="form-control uptime_req" value="">
                            </td>
                            <td>
                                <select name="vendor_id[]" class="form-control vendor_id select2">
                                    <option value="">Select Vendor</option>
                                    @foreach ($vendors as $vendor)
                                        <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger removeConnectivityRow"><i class="fas fa-minus"></i></button>
                            </td>
                        </tr>
                    `;
        $('.select2').select2();
        $('.connectivityEditBody').append(html);
    });

    $(document).on('change', '#mrc_decrease', function(e) {
        if ($(this).is(':checked')) {
            $('#existing_mrc').closest('.col-3').show();
            $('#decrease_mrc').closest('.col-3').show();
        } else {
            $('#existing_mrc').closest('.col-3').hide();
            $('#decrease_mrc').closest('.col-3').hide();
        }
    });

    $(document).on('change', '#temporary_inactive', function(e) {
        if ($(this).is(':checked')) {
            $('#from_date').closest('.col-3').show();
            $('#to_date').closest('.col-3').show();
        } else {
            $('#from_date').closest('.col-3').hide();
            $('#to_date').closest('.col-3').hide();
        }
    })

    $('#date, #activation_date, #from_date, #to_date').datepicker({
        format: "dd-mm-yyyy",
        autoclose: true,
        todayHighlight: true,
        showOtherMonths: true
    });
</script>
