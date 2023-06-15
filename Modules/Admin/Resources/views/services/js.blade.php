@section('script')
    <script>
        $('.date').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true,
            showOtherMonths: true
        });

        /* Adds and removes quantity row on click */
        $("#service_table").on('click', '.add-service-row', () => {
            appendServiceRow();
            $('.select2').select2({
                placeholder: 'Select an option'
            });
        }).on('click', '.remove-requisition-row', function() {
            if ($('#service_table tbody tr').length == 1) {
                return false;
            }
            $(this).closest('tr').remove();
        });

        function appendServiceRow() {
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
                            <input type="number" class="form-control amount" name="amount[]" required>
                        </td>
                        <td>
                            <input type="text" class="form-control remarks" name="remarks[]" required>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm fa fa-minus remove-requisition-row"></button>
                        </td>
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
                $(this).select2({
                    placeholder: 'Select option'
                });
                alert('Service already selected');
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
                $('#vendor_id').val(item.vendor_id).attr('value', item.vendor_id);
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

        $('.select2').select2({
            placeholder: 'Select an option'
        });

        $('#service_table').on('keyup', '.quantity, .rate', function() {
            let quantity = $(this).closest('tr').find('.quantity').val();
            let rate = $(this).closest('tr').find('.rate').val();
            let amount = quantity * rate;
            $(this).closest('tr').find('.amount').val(amount);

            let total = 0;
            $('#service_table tbody tr').each(function() {
                let amount = $(this).find('.amount').val() - 0;
                total += amount;
            });
            $('.total').val(total);
        });
    </script>
@endsection
