<script>
    $('.date').datepicker({
        format: "dd-mm-yyyy",
        autoclose: true,
        todayHighlight: true,
        showOtherMonths: true
    });

    $('.bankList').select2({
        placeholder: 'Select an option'
    });

    $('#client_name').on('keyup', function() {
            let myObject = {}
            jquaryUiAjax(this, "{{ route('get_client_info_for_sales') }}", uiList, myObject);

            function uiList(item) {
                console.log(item);
                $('#client_name').val(item.value).attr('value', item.value);
                $('#client_no').val(item.client_no).attr('value', item.client_no);
                $('#mq_id').val(item.mq_no).attr('value', item.mq_no);
                $('#offer_id').val(item.offer_id).attr('value', item.offer_id);
                var appendedData = '';
                item.details.forEach(element => {
                    var percentage = (element.total_offer_mrc / element.costing.product_total_cost) - 1; 
                    appendedData += ` <div class="card">
                        <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" class="checkbox" name="Language" value="Primary">
                                                <span class="cr">
                                                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                                </span>
                                                <span>${element.fr_details.link_name}</span>
                                            </label>
                                        </div>
                                        <div class="row">
                                            <x-input-box colGrid="3" name="delivery_date" value="{{ $delivery_date ?? '' }}" label="Delivery Date" class="date"/>
                                            <x-input-box colGrid="3" name="billing_address" value="{{ $billing_address ?? '' }}" label="Billing Address" />
                                            <x-input-box colGrid="3" name="collection_address" value="{{ $collection_address ?? '' }}" label="Collection Address" />
                                            <x-input-box colGrid="3" name="bill_payment_date" value="{{ $bill_payment_date ?? '' }}" label="Bill Payment Date" class="date"/>
                                            <div class="col-3">
                                                <div class="form-check-inline">
                                                    <label class="form-check-label" for="bbts">
                                                        <input type="radio" class="form-check-input link_from" id="bbts" name="link_from"
                                                            value="bbts" @checked(@$link_from == 'bbts' || ($form_method == 'POST' && !old()))>
                                                        Prepaid
                                                    </label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <label class="form-check-label" for="vendor">
                                                        <input type="radio" class="form-check-input link_from" id="vendor" name="link_from"
                                                            value=" " @checked(@$link_from == 'vendor')>
                                                            Postpaid
                                                    </label>
                                                </div>
                                            </div>
                                            <x-input-box colGrid="3" name="mrc" value="${element.total_offer_mrc}" label="MRC" />
                                            <x-input-box colGrid="3" name="otc" value="${element.total_offer_otc}" label="OTC" />
                                        </div>
                                        <div>

                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <th>Product/Service</th>
                                                    <th>Quantity</th>
                                                    <th>Unit</th>
                                                    <th>Price</th>
                                                    <th>Total Price</th>
                                                </thead>
                                                <tbody>
                                                `
                                                let total = 0;
                                                
                                                element.costing.costing_products.forEach(itm => {

                                                    appendedData += `<tr>
                                                        <td>
                                                            <div class="input-group input-group-sm input-group-primary">
                                                                <input type="text" name="link_type[]" class="form-control text-center"
                                                                    id="link_type" readonly value="${itm.product_id}">
                                                            </div>
                                                        </td>
                                                        <td> 
                                                            <div class="input-group input-group-sm input-group-primary">
                                                                <input type="text" name="vendor[]" class="form-control text-right"
                                                                    id="vendor" readonly value="${itm.quantity}">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group input-group-sm input-group-primary">
                                                                <input type="text" name="vendor[]" class="form-control text-center"
                                                                    id="vendor" readonly value="${itm.unit}">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group input-group-sm input-group-primary">
                                                                <input type="text" name="bbts_or_pop_or_ldp[]"
                                                                    class="form-control text-right" id="bbtsOrPopOrLdp" readonly value="${itm.rate}">
                                                            </div>
                                                        </td>
                                                        <td class="d-none">
                                                            <div class="input-group input-group-sm input-group-primary">
                                                                <input type="text" name="bbts_or_pop_or_ldp[]"
                                                                    class="form-control text-right" readonly value="${(Number(percentage) * Number(itm.rate)) + Number(itm.rate)}">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group input-group-sm input-group-primary">
                                                                <input type="text" name="bbts_or_pop_or_ldp[]"
                                                                    class="form-control text-right" id="bbtsOrPopOrLdp" readonly value="${((Number(percentage) * Number(itm.rate)) + Number(itm.rate)) * Number(itm.quantity)}">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    `
                                                    total += ((Number(percentage) * Number(itm.rate)) + Number(itm.rate)) * Number(itm.quantity);
                                                })
                                                
                                                appendedData += `
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="3" style="text-align: left;"></td>
                                                        <td style="text-align: center;">Total MRC</td>
                                                        <td>
                                                            <div class="input-group input-group-sm input-group-primary">
                                                                <input type="text" name="total_mrc" class="form-control text-right total_mrc" readonly value="${total}">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" style="text-align: left;"></td>
                                                        <td style="text-align: center;">Total OTC</td>
                                                        <td>
                                                            <div class="input-group input-group-sm input-group-primary">
                                                                <input type="text" name="total_otc" class="form-control"
                                                                    id="total_otc" readonly>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                `
                });
                $('#fr_details').append(appendedData);
                return false;
            }
        })

        $('#mq_id').on('keyup', function() {
            let myObject = {}
            jquaryUiAjax(this, "{{ route('get_frs_based_on_mq') }}", uiList, myObject);

            function uiList(item) {
                $('#client_name').val(item.client_name).attr('value',item.client_name);
                $('#client_no').val(item.client_no).attr('value',item.client_no);
                return false;
            }
        })
        $(document).on('change','.checkbox',function(item){
            var vvall = 0;
            $('.checkbox').each((score) => { 
                if ($(this).is(':checked')) {
                    var totalMRCValue = Number($(this).parent().parent().parent().find('.total_mrc').val());
                    vvall += totalMRCValue;
                }

            });
            $('#g_total_mrc').val(vvall);
        })


</script>
