@section('script')
    <script>
        function initializeSelect2() {
            $('.select2').select2({
                placeholder: 'Select an option'
            });
        }
        
        $('.date').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true,
            showOtherMonths: true
        });

        /* Adds and removes quantity row on click */
        $("#service_table").on('click', '.add-service-row', () => {
            appendServiceRow();
            initializeSelect2();
            totalAmount();
        }).on('click', '.remove-requisition-row', function() {
            if ($('#service_table tbody tr').length == 1) {
                return false;
            }
            $(this).closest('tr').remove();
            totalAmount();
        });

        function appendServiceRow() {
            let row_index = $("#service_table tr:last").prop('rowIndex');
            let row = `<tr>
                        <td>
                            <select class="form-control select2 service_id" name="service_id[]" required>
                                <option value="" selected disabled>Select Service</option>
                                @foreach (@$products as $product)
                                    <option value="{{ $product->id }}">
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" class="form-control quantity" name="quantity[]" required>
                        </td>
                        <td>
                            <input type="number" class="form-control rate" name="rate[]" required>
                        </td>
                        <td>
                            <input type="number" class="form-control amount" name="amount[]" readonly>
                        </td>
                        <td>
                            <input type="text" class="form-control remarks" name="remarks[]" required>
                        </td>
                        ${(row_index > 1) ? 
                            `<td>
                                <button type="button" class="btn btn-danger btn-sm fa fa-minus remove-requisition-row"></button>
                            </td>`:
                            `<td>
                                <button type="button" class="btn btn-success btn-sm fa fa-plus add-service-row"></button>
                            </td>`
                        }
                    </tr>`;
            $('#service_table tbody').append(row);
        }

        $('#service_table').on('change', '.service_id', function() {
            let service_id = $(this).val();
            let service_ids = [];
            $('.service_id').each(function() {
                service_ids.push($(this).val());
            });
            let count = 0;
            service_ids.forEach(function(id) {
                if (id == service_id) {
                    count++;
                }
            });
            if (count > 1) {
                $(this).val('');
                initializeSelect2();
                Swal.fire({
                    title: 'Service is already selected',
                    type: 'warning',
                });
            }
        });

        $('#bbts_link_id').on('keyup', function() {
            let myObject = {}
            jquaryUiAjax(this, "{{ route('get_bbts_link_id') }}", uiList, myObject);

            function uiList(item) {
                $('#bbts_link_id').val(item.label).attr('value', item.label);
                $('#division_id').val(item.division_id).trigger('change');
                $('#link_name').val(item.link_name).attr('value', item.link_name);
                $('#link_type').val(item.link_type).attr('value', item.link_type);
                $('#vendor_link_id').val(item.vendor_link_id).attr('value', item.vendor_link_id);
                $('#vendor').val(item.vendor_name).attr('value', item.vendor_name);
                $('#from_location').val(item.from_location).attr('value', item.from_location);
                $('#to_location').val(item.to_location).attr('value', item.to_location);
                $('#from_site').val(item.from_site).attr('value', item.from_site);
                $('#to_site').val(item.to_site).attr('value', item.to_site);
                $('#gps').val(item.gps).attr('value', item.gps);
                $('#vendor_link_id').val(item.vendor_link_id).attr('value', item.vendor_link_id);
                $('#remarks').val(item.remarks).attr('value', item.remarks);
                $('#district_id').val(item.district_id).trigger('change');
                $('#thana_id').val(item.thana_id).trigger('change');
                return false;
            }
        })

        initializeSelect2();

        $('#service_table').on('keyup', '.quantity, .rate', function() {
            let quantity = $(this).closest('tr').find('.quantity').val();
            let rate = $(this).closest('tr').find('.rate').val();
            let amount = quantity * rate;
            $(this).closest('tr').find('.amount').val(amount);

            totalAmount();
        });

        function totalAmount() {
            let total = 0;
            $('#service_table tbody tr').each(function() {
                let amount = $(this).find('.amount').val() - 0;
                total += amount;
            });
            $('.total').val(total);
        }
        $(document).ready(function() {
            @if ($form_method == 'POST')
                appendServiceRow();
                initializeSelect2();
            @endif
        });

        $('#existing').on('click', function() {
            let bbts_link_id = $('#bbts_link_id').val();

            if (bbts_link_id == '') {
                Swal.fire({
                    title: 'BBTS Link ID is required!',
                    type: 'warning',
                }).then((result) => {
                    $('#new').prop('checked', true);
                })
                return false;
            }

            $.ajax({
                url: "{{ route('existingServices') }}",
                type: 'GET',
                data: {
                    bbts_link_id: bbts_link_id
                },
                success: function(data) {
                    $('#service_table tbody').html('');
                    var row = '';
                    data.service_lines.forEach(function(service, key) {
                        row += `<tr>
                                <td>
                                    <select class="form-control select2 service_id" name="service_id[]" required>
                                        <option value="" selected disabled>Select Service</option>
                                        @foreach (@$products as $product)
                                            <option value="{{ $product->id }}" ${(service.product_id == {{ $product->id }}) ? 'selected' : ''}>
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" class="form-control quantity" name="quantity[]" value="${service.quantity}" required>
                                </td>
                                <td>
                                    <input type="number" class="form-control rate" name="rate[]" value="${service.rate}" required>
                                </td>
                                <td>
                                    <input type="number" class="form-control amount" name="amount[]" value="${service.quantity * service.rate}" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control remarks" name="remarks[]" value="${service.remarks}" required>
                                </td>
                                ${(key > 0) ? 
                                    `<td>
                                        <button type="button" class="btn btn-danger btn-sm fa fa-minus remove-requisition-row"></button>
                                    </td>`:
                                    `<td>
                                        <button type="button" class="btn btn-success btn-sm fa fa-plus add-service-row"></button>
                                    </td>`
                                }
                            </tr>`;
                    });
                    $('#service_table tbody').append(row);
                    initializeSelect2();
                    totalAmount();
                }
            });
        });

        $('#new').on('click', function() {
            $('#service_table tbody').html('');
            $('.total').val('');
            appendServiceRow();
            initializeSelect2();
        });
    </script>
@endsection
