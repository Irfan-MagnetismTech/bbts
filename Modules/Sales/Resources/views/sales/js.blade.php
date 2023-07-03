<script>
    
    function initializeDate(){
            $('.date').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true,
            showOtherMonths: true
        });
    }

    initializeDate();

    function selectTwo(){
        $('.bankList').select2({
        placeholder: 'Select an option'
        });
    }
   
    selectTwo();

    $('#client_name').on('keyup', function() {
            let myObject = {}
            jquaryUiAjax(this, "{{ route('get_client_info_for_sales') }}", uiList, myObject);

            function uiList(item) {
                $('#client_name').val(item.value).attr('value', item.value);
                $('#client_no').val(item.client_no).attr('value', item.client_no);
                $('#mq_id').val(item.mq_no).attr('value', item.mq_no);
                $('#offer_id').val(item.offer_id).attr('value', item.offer_id);
                console.log(item);
                var indx = $('.checkbox').length;
                $('#fr_details').empty();
                var appendedData = '';
                item.details.forEach(element => {
                    var percentage = (element.total_offer_mrc / element.costing.product_total_cost) - 1; 
                    appendedData += ` <div class="card">
                        <div class="card-body">
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="checkbox-fade fade-in-primary">
                                                <label>
                                                    <input type="checkbox" class="checkbox" value="Primary" name="checked[${indx}]">
                                                    <span class="cr">
                                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                                    </span>
                                                    <span>${element.fr_details.connectivity_point}</span>
                                                    <input type="hidden" class="fr_no" name="fr_no[${indx}]" value="${element.fr_no}">
                                                </label>
                                                </div>
                                            </div>
                                            <div class="col-9">`
                                                element.offer_link.forEach(elmnt => {
                                                    appendedData += `<span>${elmnt.link_type}</span><input type="hidden" name="link_no[${indx}][]"value="${elmnt.link_no}">`
                                                })

                    appendedData += `</div>
                                        </div>
                                        
                                        <div class="row">
                                            <x-input-box colGrid="3" name="delivery_date[${indx}]" value="{{ $delivery_date ?? '' }}" label="Delivery Date" class="date"/>
                                            <x-input-box colGrid="3" name="billing_address[${indx}]" value="{{ $billing_address ?? '' }}" label="Billing Address" />
                                            <span class="btn btn-inverse btn-outline-inverse btn-icon" data-toggle="tooltip" title='Add Billing Address' id="add_billing"><i class="icofont icofont-ui-add"></i></span>
                                            <x-input-box colGrid="3" name="collection_address[${indx}]" value="{{ $collection_address ?? '' }}" label="Collection Address" />
                                             <span class="btn btn-inverse btn-outline-inverse btn-icon" data-toggle="tooltip" title='Add Collection Address' id="add_collection"><i class="icofont icofont-ui-add"></i></span>
                                            <x-input-box colGrid="3" name="bill_payment_date[${indx}]" value="{{ $bill_payment_date ?? '' }}" label="Bill Payment Date" class="date"/>
                                            <div class="col-3">
                                                <div class="form-check-inline">
                                                    <label class="form-check-label" for="prepaid">
                                                        <input type="radio" class="form-check-input payment_status" id="prepaid" name="payment_status[${indx}]"
                                                            value="prepaid" @checked(@$payment_status == 'prepaid' || ($form_method == 'POST' && !old()))>
                                                        Prepaid
                                                    </label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <label class="form-check-label" for="postpaid">
                                                        <input type="radio" class="form-check-input payment_status" id="postpaid" name="payment_status[${indx}]"
                                                            value="postpaid" @checked(@$payment_status == 'postpaid')>
                                                            Postpaid
                                                    </label>
                                                </div>
                                            </div>
                                            <x-input-box colGrid="3" name="mrc[${indx}]" value="${element.total_offer_mrc}" label="MRC" />
                                            <x-input-box colGrid="3" name="otc[${indx}]" value="${element.total_offer_otc}" label="OTC" />
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
                                                                <input type="text" name="service[${indx}][]" class="form-control text-center"
                                                                    id="service" readonly value="${itm.product_id}">
                                                            </div>
                                                        </td>
                                                        <td> 
                                                            <div class="input-group input-group-sm input-group-primary">
                                                                <input type="text" name="quantity[${indx}][]" class="form-control text-right"
                                                                    id="quantity" readonly value="${itm.quantity}">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group input-group-sm input-group-primary">
                                                                <input type="text" name="unit[${indx}][]" class="form-control text-center"
                                                                    id="unit" readonly value="${itm.unit}">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group input-group-sm input-group-primary">
                                                                <input type="text" name="rate[${indx}][]"
                                                                    class="form-control text-right" readonly value="${itm.rate}">
                                                            </div>
                                                        </td>
                                                        <td class="d-none">
                                                            <div class="input-group input-group-sm input-group-primary">
                                                                <input type="text" name="price[${indx}][]"
                                                                    class="form-control text-right" readonly value="${(Number(percentage) * Number(itm.rate)) + Number(itm.rate)}">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group input-group-sm input-group-primary">
                                                                <input type="text" name="total_price[${indx}][]"
                                                                    class="form-control text-right" readonly value="${((Number(percentage) * Number(itm.rate)) + Number(itm.rate)) * Number(itm.quantity)}">
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
                                                                <input type="text" name="total_mrc[${indx}]" class="form-control text-right total_mrc" readonly value="${total}">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                        </div>
                    </div>
                `
                });
                $('#fr_details').append(appendedData);
                initializeDate();
                selectTwo();
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
        $(document).on('change','.checkbox',function(){
            var vvall = 0;
            $('.checkbox').each((score) => { 
                if ($(this).is(':checked')) {
                    var totalMRCValue = Number($(this).parent().parent().parent().parent().parent().parent().find('.total_mrc').val());
                    vvall += totalMRCValue;
                    console.log(totalMRCValue);
                }

            });
            $('#grand_total').val(vvall);
        })

    $(document).on('click','.add_billing',function(){

    })

</script>
