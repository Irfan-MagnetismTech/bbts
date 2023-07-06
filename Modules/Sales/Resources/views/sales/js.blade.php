<script src="{{ asset('js/custom-function.js') }}"></script>
<script>
    var select_selector;
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
                $('#client_id').val(item.client_id).attr('value', item.client_id);
                $('#mq_id').val(item.mq_no).attr('value', item.mq_no);
                $('#offer_id').val(item.offer_id).attr('value', item.offer_id);
                var indx = $('.checkbox').length;
                $('#fr_details').empty();
                var appendedData = '';
                item.details.forEach(element => {
                    var percentage = (element.total_offer_mrc / element.costing.product_total_cost) - 1; 
                    appendedData += `<div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="checkbox-fade fade-in-primary">
                                                    <label>
                                                        <input type="checkbox" class="checkbox" value="Primary" name="checked[${indx}]">
                                                        <span class="cr">
                                                            <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                                        </span>
                                                        <span>${element.fr_details.connectivity_point} ( ${element.fr_no} )</span>
                                                        <input type="hidden" class="fr_no" name="fr_no[${indx}]" value="${element.fr_no}">
                                                    </label>
                                                    </div>
                                                </div>
                                                <div class="col-9">`
                    element.offer_links.forEach(elmnt => {
                                        appendedData += `<span>${elmnt.link_type}</span>
                                        <input type="hidden" name="link_no[${indx}][]"value="${elmnt.link_no}">
                                        <input type="hidden" name="link_type[${indx}][]"value="${elmnt.link_type}">`
                                    })

                    appendedData += `</div>
                                        </div>
                                            <div class="row">
                                                <x-input-box colGrid="3" name="delivery_date[${indx}]" value="{{ $delivery_date ?? '' }}" label="Delivery Date" class="date"/>
                                                <div class="col-2">
                                                    <select name="billing_address[${indx}]">`
                    item.billing_address.forEach(ele => {
                        appendedData +=`<option ele="${ele.id}">${ele.address}</option>`
                    })
                    appendedData +=  `</select>
                                                </div>
                                                <span class="btn btn-inverse btn-sm btn-outline-inverse btn-icon" data-toggle="tooltip" title='Add Billing Address' id="add_billing"><i class="icofont icofont-ui-add" onClick="ShowModal('billing','${element.fr_no}',this)"></i></span>
                                                <div class="col-2">
                                        <select name="collection_address[${indx}]">`
                    item.collection_address.forEach(ele => {
                        appendedData +=`<option ele="${ele.id}">${ele.address}</option>`
                    })
                    appendedData +=   `</select>
                                                </div>
                                                <span class="btn btn-inverse btn-sm btn-outline-inverse btn-icon" data-toggle="tooltip" title='Add Collection Address' id="add_collection" onClick="ShowModal('collection','${element.fr_no}',this)"><i class="icofont icofont-ui-add"></i></span>
                                                <x-input-box colGrid="3" name="bill_payment_date[${indx}]" value="{{ $bill_payment_date ?? '' }}" label="Bill Payment Date" class="date"/>
                                                <div class="col-3">
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label" for="prepaid_${+indx}">
                                                            <input type="radio" class="form-check-input payment_status" id="prepaid_${+indx}" name="payment_status[${indx}]"
                                                                value="prepaid" checked>
                                                            Prepaid
                                                        </label>
                                                    </div>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label" for="prepaid_${+indx}">
                                                            <input type="radio" class="form-check-input payment_status" id="prepaid_${+indx}" name="payment_status[${indx}]"
                                                                value="postpaid">
                                                                Postpaid
                                                        </label>
                                                    </div>
                                                </div>
                                                <x-input-box colGrid="3" name="mrc[${indx}]" value="${element.total_offer_mrc}" label="MRC" attr="readonly" />
                                                <x-input-box colGrid="3" name="otc[${indx}]" value="${element.total_offer_otc}" label="OTC" attr="readonly"/>
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
                                                    <input type="text" name="product_name[${indx}][]" class="form-control text-center"
                                                        id="service_name" readonly value="${itm.product.name}">
                                                    <input type="hidden" name="product_id[${indx}][]" class="form-control text-center"
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
                                            <td class="d-none">
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="rate[${indx}][]"
                                                        class="form-control text-right" readonly value="${itm.rate}">
                                                </div>
                                            </td>
                                            <td>
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
                    appendedData += `</tbody>
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
                </div> `
                indx++
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
            $('.checkbox').each((index, element) => { 
                var checkbox = $(element);
                if (checkbox.prop('checked')) {
                    var totalMRCValue = Number($(checkbox).parent().parent().parent().parent().parent().parent().find('.total_mrc').val());
                    vvall += totalMRCValue;
                }
            });
            $('#grand_total').val(vvall);
        })

    function updateAddress(){
        var form_data = {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                };

            $('.modal_data').each(function(index, element) {
            var name = $(element).attr('name');
            var value = $(element).is('select') ? $(element).find('option:selected').val() : $(element).val();
            form_data[name] = value;
            });
            console.log(JSON.stringify(form_data));
            fetch("{{ route('updateAddress') }}", {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json',
                },
                body: JSON.stringify(form_data),
                })
                .then(function(response) {
                    if (!response.ok) {
                        console.log("not okay", response.responseJSON);
                    }
                    return response.json();
                })
                .then(function(data) {
                     // handle success response
                     if (data.status == 'success') {
                        opt = `<option></option>`;
                            data.listdata.forEach(function(itm) {
                                opt += `<option value="${itm.id}">${itm.address}</option>`;
                        });
                            select_selector.html('');
                            select_selector.html(opt);
                            $("#modal-13").modal("hide");
                            $("#modal-13").removeClass("md-show");
                    } else {
                        $('#errorlist').empty();
                        $('#errorlist').removeClass('d-none');
                        $.each(data, function(key, value) {
                            $('#errorlist').append('<p>' + value + '</p>');
                        });
                    }
                })
                .catch(function(error) {
                console.error("Error saving form data:", error);
                });
    }
    function ShowModal(a,b,ds){
        select_selector = $(ds).parent().prev().find('select');
        console.log(select_selector);
        $("#modal-13").modal("show");
        $("#modal-13").addClass("md-show");
        $("#client_no_add").val($('#client_no').val());
        $("#fr").val(b);
        if(a == 'billing'){
            let prev_elmnt = $('#payment_method_add').closest('tr').prev();
            $('#title').html('Billing Address');
            $('#update_type').val('billing');
            prev_elmnt.nextAll('tr').remove();
            prev_elmnt.after(`
                <tr>
                    <td>Submission By</td>
                    <td>
                        <input type="text" id="submission_by_add" name="submission_by_add" class="modal_data form-control"/>
                    </td>
                </tr>
                <tr>
                    <td>Submission Date</td>
                    <td>
                        <input type="text" id="submission_date_add" name="submission_date_add" class="modal_data form-control"/>
                    </td>
                </tr>
            `);
        }else{
            let prev_elmnt = $('#submission_by_add').closest('tr').prev();
            $('#title').html('Collection Address');
            $('#update_type').val('collection');
            prev_elmnt.nextAll('tr').remove();
            prev_elmnt.after(`
                <tr>
                    <td>Payment Method</td>
                    <td>
                        <input type="text" id="payment_method_add" name="payment_method_add" class="modal_data form-control"/>
                    </td>
                </tr>
                <tr>
                    <td>Payment Date</td>
                    <td>
                        <input type="text" id="payment_date_add" name="payment_date_add" class="modal_data form-control"/>
                    </td>
                </tr>
            `);
        }
    //     let myObject = {
    //     'client_no': $('#client_no').val()
    // };

    // function successcallback(dataa) {
    //     console.log(dataa);
    // }

    // function failcallback() {
    //     console.log('error');
    // }

    // jquaryAjaxCall("{{ route('test_test_test') }}", myObject, successcallback);
    }

    function HideModal(){
        $("#modal-13").modal("hide");
        $("#modal-13").removeClass("md-show");
    }

    associativeDropdown("{{ route('get-districts') }}", 'division_id', '#division_id', '#district_id', 'get', null)
    associativeDropdown("{{ route('get-thanas') }}", 'district_id', '#district_id', '#thana_id', 'get', null)

</script>
