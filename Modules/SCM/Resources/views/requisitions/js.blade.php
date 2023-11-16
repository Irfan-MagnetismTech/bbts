@section('script')
    <script src="{{ asset('js/search-client.js') }}"></script>
    <script src="{{ asset('js/search-employee.js') }}"></script>
    <script>
        $('#date').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true,
            showOtherMonths: true
        }).datepicker("setDate", new Date());;
        /* Append row */
        @if (empty($requisition) && empty(old('material_name')))
            appendCalculationRow();
        @endif
        function appendCalculationRow() {
            var type = $("input[name=type]:checked").val()
            let row = `<tr>
                            <td>
                                <input type="text" name="material_name[]" class="form-control material_name" required autocomplete="off">
                                <input type="hidden" name="material_id[]" class="form-control material_id">
                            </td>
                            <td>
                                <input type="text" name="item_code[]" class="form-control item_code" autocomplete="off" readonly>
                            </td>
                            <td>
                                <input type="text" name="unit[]" class="form-control unit" autocomplete="off" readonly>
                            </td>
                             <td>
                                <select name="brand_id[]" class="form-control form-control-sm brand_id select2">
                                    <option value="">Select Brand</option>
                                    @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                                </td>
                                <td>
                                <input list="models" name="model[]" id="model[]" class="form-control model">
                                <datalist id="models">
                                @foreach ($models as $model)
                                <option value="{{ $model }}">
                                @endforeach
                                </datalist>
                                </td>
                                <td>
                                <input type="text" name="description[]" class="form-control description" autocomplete="off">
                                </td>
                                ${ type === 'warehouse' || type === 'pop' ?
                            `<td class="current_stock" style="display: block">
                                    <input type="text" class="form-control current_stock" autocomplete="off" readonly>
                                </td>`
                            :
                            `<td class="current_stock" style="display: none">
                                    <input type="text" class="form-control current_stock" autocomplete="off" readonly>
                                </td>`
                            }
                            <td>
                                <input type="text" name="quantity[]" class="form-control quantity" autocomplete="off">
                            </td>
                            <td>
                                <input type="text" name="purpose[]" class="form-control purpose" autocomplete="off">
                            </td>
                            <td>
                                <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i>
                            </td>
                    </tr>
                    `;
            $('#material_requisition tbody').append(row);
            $('.select2').select2({});
        }

        /* Adds and removes quantity row on click */
        $("#material_requisition")
            .on('click', '.add-requisition-row', () => {
                appendCalculationRow();
            })
            .on('click', '.remove-calculation-row', function() {
                $(this).closest('tr').remove();
            });

        //Search Client
        var client_details = [];
        @if ($formType === 'edit')
            client_details = {!! collect($clientInfos ?? []) !!}
        @endif

        //Select FR key based on link name
        $('#client_links').on('change', function() {
            var link_name = $("input[name='gender']:checked").val();
            var link_name = $(this).val();
            var client_id = $('#client_id').val();
            var client = client_details.find(function(element) {
                return element.link_name == link_name;
            });
            $('#fr_id').val(client.fr_id);
            $('#fr_composite_key').val(client.fr_composite_key);
        });

        //Search Material
        $(document).on('keyup focus', '.material_name', function() {
            let branch_id = $('#branch_id').find(':selected').val();
            $(this).autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ url('search-material') }}",
                        type: 'get',
                        dataType: "json",
                        data: {
                            search: request.term,
                            branch_id
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                select: function(event, ui) {
                    $(this).closest('tr').find('.material_name').val(ui.item.label);
                    $(this).closest('tr').find('.material_id').val(ui.item.value);
                    $(this).closest('tr').find('.item_code').val(ui.item.item_code);
                    $(this).closest('tr').find('.unit').val(ui.item.unit);
                    $(this).closest('tr').find('.current_stock').val(ui.item.stock_data);
                    return false;
                }
            });

        });

        $(function() {
            onChangeRadioButton();

            $('.select2').select2();

            //using form custom function js file
            fillSelect2Options("{{ route('searchBranch') }}", '#branch_id');
            associativeDropdown("{{ route('searchPopByBranchId') }}", 'search', '#branch_id', '#pop_id', 'get',
                null)

            $(".radioButton").click(function() {
                onChangeRadioButton()
            });
        });

        function onChangeRadioButton() {
            var radioValue = $("input[name='type']:checked").val();
            if (radioValue == 'client') {
                $('.pop_id').hide('slow');
                $('.client_address').show('slow').removeClass("d-none");
                $('.client_no').show('slow').removeClass("d-none");
                $('.link_no').show('slow').removeClass("d-none");
                $('.fr_no').show('slow').removeClass("d-none");
                $('.client_name').show('slow').removeClass("d-none");
                $('.employee').show('slow').addClass("d-none");
                $('.current_stock').hide('slow');
            } else if (radioValue == 'warehouse') {
                $('.pop_id').hide('slow');
                $('.client_address').show('slow').addClass("d-none");
                $('.client_no').show('slow').addClass("d-none");
                $('.link_no').show('slow').addClass("d-none");
                $('.fr_no').show('slow').addClass("d-none");
                $('.client_name').show('slow').addClass("d-none");
                $('.employee').show('slow').addClass("d-none");
                $('.current_stock').show('slow');
            } else if (radioValue == 'pop') {
                $('.pop_id').show('slow');
                $('.client_address').show('slow').addClass("d-none");
                $('.client_no').show('slow').addClass("d-none");
                $('.link_no').show('slow').addClass("d-none");
                $('.fr_no').show('slow').addClass("d-none");
                $('.client_name').show('slow').addClass("d-none");
                $('.employee').show('slow').addClass("d-none");
                $('.current_stock').show('slow');


            } else if (radioValue == 'general') {
                $('.pop_id').show('slow');
                $('.client_address').show('slow').addClass("d-none");
                $('.client_no').show('slow').addClass("d-none");
                $('.link_no').show('slow').addClass("d-none");
                $('.fr_no').show('slow').addClass("d-none");
                $('.client_name').show('slow').addClass("d-none");
                $('.employee').show('slow').removeClass("d-none");
                $('.current_stock').show('slow');
            }
        }
    </script>
@endsection
