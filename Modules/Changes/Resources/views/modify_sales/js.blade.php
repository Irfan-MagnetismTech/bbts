<script src="{{ asset('js/custom-function.js') }}"></script>
<script>
    var select_selector;

    function initializeDate() {
        $('.date').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true,
            showOtherMonths: true
        });
    }

    initializeDate();

    function selectTwo() {
        $('.bankList').select2({
            placeholder: 'Select an option'
        });
    }

    selectTwo();

    $(document).ready(function() {
        let connectivity_requirement_id = {!! $connectivity_requirement_id !!};
        console.log(connectivity_requirement_id)
        $.ajax({
            url: "{{ route('get-client-info-for-sale-modification') }}",
            method: 'GET', // HTTP method (GET, POST, PUT, DELETE, etc.)
            data: {
                'connectivity_requirement_id': connectivity_requirement_id
            },
            success: function(data) {
                console.log(data)
                uiList(data)
            },
            error: function(xhr, status, error) {
                // This function is called if there is an error
                console.log('Error:', status, error);
            }
        });

        function uiList(offer) {
            console.log(offer.client)
            $('#client_name').val(offer.client.client_name).attr('value', offer.client.client_name);
            $('#client_no').val(offer.client_no).attr('value', offer.client_no);
            $('#client_id').val(offer.client.id).attr('value', offer.client.id);
            $('#offer_id').val(offer.id).attr('value', offer.id);
            var indx = $('.checkbox').length;
            $('#fr_details').empty();
            var appendedData = '';
            offer.offer_details.forEach(element => {
                let offer_mrc = element.total_offer_mrc ?? 0;
                let product_amount = element.offer_product_amount ?? 0;
                let management_cost = element.management_cost ?? 0;
                let total_mrc = offer_mrc + product_amount + management_cost + element
                    .equipment_total_mrc;

                var percentage = (total_mrc / element.costing.product_total_cost) - 1;
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
                                                        <input type="hidden" class="costing_id" name="costing_id[${indx}]" value="${element.costing.id}">
                                                    </label>
                                                    </div>
                                                </div>
                                                <div class="col-9">`
                element.offer_links.forEach(elmnt => {
                    appendedData += `<span>${elmnt.link_type}</span>
                                        <input type="hidden" name="link_no[${indx}][]"value="${elmnt.link_no}">
                                        <input type="hidden" name="link_type[${indx}][]"value="${elmnt.link_type}">`
                })

                appendedData +=
                    `</div>
                                        </div>
                                            <div class="row">
                                                <x-input-box colGrid="3" name="delivery_date[${indx}]" value="{{ $delivery_date ?? '' }}" label="Delivery Date" class="date"/>
                                                <div class="col-xl-2 col-md-2">
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <select name="billing_address_id[${indx}]" class="form-control">`
                offer.billing_address.forEach(ele => {
                    appendedData += `<option value="${ele.id}">${ele.address}</option>`
                })
                appendedData +=
                    `
                                                        </select>
                                                        <label class="input-group-addon input-group-addon-manual"><i class="icofont icofont-ui-add" onClick="ShowModal('billing','${element.fr_no}',this)"></i></label>
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 col-md-2">
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <select name="collection_address_id[${indx}]" class="form-control">`
                offer.collection_address.forEach(ele => {
                    appendedData += `<option value="${ele.id}">${ele.address}</option>`
                })
                appendedData += `</select>  
                                                        <label class="input-group-addon input-group-addon-manual"><i class="icofont icofont-ui-add" onClick="ShowModal('collection','${element.fr_no}',this)"></i></label>
                                                    </div>
                                                </div>
                                                <x-input-box colGrid="3" name="bill_payment_date[${indx}]" label="Bill Payment Date" class="container" attr='readonly' value=""/>
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
                                                <x-input-box colGrid="3" name="mrc[${indx}]" value="${element.grand_total}" label="MRC" attr="readonly" />
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
                                                    <th>Unit Price</th>
                                                    <th>Total Price</th> 
                                                    <th>VAT</th>
                                                    <th>Total Amount</th>
                                                </thead>
                                                <tbody>
                                                `
                let total = 0;
                sub_total_vat = 0;
                sub_total_amount = 0;
                element.costing.costing_products.forEach(itm => {
                    // console.log(percentage, itm.rate, itm.quantity);
                    let total_price = (Number(percentage) * Number(itm.rate) + Number(itm
                        .rate)) * Number(itm.quantity);
                    let total_amount = Number(itm.product_vat_amount) + total_price;
                    total += total_price;
                    sub_total_vat += Number(itm.product_vat_amount);
                    sub_total_amount += total_amount;
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
                                                    class="form-control text-right price" readonly value="${((Number(percentage) * Number(itm.rate)) + Number(itm.rate)).toFixed(2)}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm input-group-primary">
                                                <input type="text" name="total_price[${indx}][]"
                                                    class="form-control text-right total_price" readonly value="${total_price.toFixed(2)}">
                                            </div>
                                        </td> 
                                        <td>
                                            <div class="input-group input-group-sm input-group-primary">
                                                <input type="text" name="vat_amount[${indx}][]"
                                                    class="form-control text-right vat_amount" readonly value="${Number(itm.product_vat_amount).toFixed(2)}">
                                            </div>
                                        </td> 
                                        <td>
                                            <div class="input-group input-group-sm input-group-primary">
                                                <input type="text" name="total_amount[${indx}][]"
                                                    class="form-control text-right total_amount" readonly value="${total_amount.toFixed(2)}">
                                            </div>
                                        </td>
                                    </tr>
                                    `

                })
                appendedData += `</tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" style="text-align: left;"></td>
                                            <td style="text-align: center;">Total MRC</td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="total_mrc[${indx}]" class="form-control text-right total_mrc" readonly value="${total.toFixed(2)} ">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="sub_total_vat[${indx}]" class="form-control text-right sub_total_vat" readonly value="${sub_total_vat.toFixed(2)}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="sub_total_amount[${indx}]" class="form-control text-right sub_total_amount" readonly value="${sub_total_amount.toFixed(2)}">
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
            $('#client_name').val(item.client_name).attr('value', item.client_name);
            $('#client_no').val(item.client_no).attr('value', item.client_no);
            return false;
        }
    })

    $('#account_holder').on('keyup', function() {
        let myObject = {}
        jquaryUiAjax(this, "{{ route('get_employees') }}", uiList, myObject);

        function uiList(item) {
            $('#account_holder').val(item.label).attr('value', item.label);
            $('#employee_id').val(item.id).attr('value', item.id);
            return false;
        }
    })

    $(document).on('change', '.checkbox', function() {
        var vvall = 0;
        $('.checkbox').each((index, element) => {
            var checkbox = $(element);
            if (checkbox.prop('checked')) {
                var totalMRCValue = Number($(checkbox).parent().parent().parent().parent().parent()
                    .parent().parent().find('.total_mrc').val());
                vvall += totalMRCValue;
            }
        });
        $('#grand_total').val(vvall.toFixed(2));
    })

    // $(document).on('keyup','.vat_percent',function(){
    //     let mrc = Number($(this).closest('tr').prev().find('.total_mrc').val());
    //     let vat_percent = Number($(this).val());
    //     let vat_tk = mrc * vat_percent / 100;
    //     $(this).closest('tr').find('.vat_amount').val(vat_tk);
    // })

    // $(document).on('keyup','.vat_percent',function(){
    //     let mrc = Number($(this).closest('tr').find('.total_price').val());
    //     let vat_percent = Number($(this).val());
    //     let vat_tk = mrc * vat_percent / 100;
    //     $(this).closest('tr').find('.vat_amount').val(vat_tk);
    // })


    function updateAddress() {
        var form_data = {
            '_token': $('meta[name="csrf-token"]').attr('content'),
        };

        $('.modal_data').each(function(index, element) {
            var name = $(element).attr('name');
            var value = $(element).is('select') ? $(element).find('option:selected').val() : $(element).val();
            form_data[name] = value;
        });
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
                    opt = ``;
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

    function ShowModal(a, b, ds) {
        select_selector = $(ds).parent().parent().find('select');
        $("#modal-13").modal("show");
        $("#modal-13").addClass("md-show");
        $("#client_no_add").val($('#client_no').val());
        $("#fr").val(b);
        if (a == 'billing') {
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
        } else {
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

    function HideModal() {
        $("#modal-13").modal("hide");
        $("#modal-13").removeClass("md-show");
    }

    associativeDropdown("{{ route('get-districts') }}", 'division_id', '#division_id', '#district_id', 'get', null)
    associativeDropdown("{{ route('get-thanas') }}", 'district_id', '#district_id', '#thana_id', 'get', null)

    var day_picker_selector;
    $(document).ready(function() {
        $(document).on('click', '.container', function() {
            day_picker_selector = $(this);
            $('.box').css('left', (($(this).offset().left) - 50) + 'px').css('top', (($(this).offset()
                .top) - 150) + 'px');
        })
        $(document).on('click', '.day_td', function() {
            day_picker_selector.val($(this).text());
            $('.box').css('left', '-1000px');
        })

        $(document).on('click', function(event) {
            var $table = $('.box');
            var $inpt = $('.container');
            if (!$table.is(event.target) && !$table.has(event.target).length && !$inpt.is(event
                    .target) && !$inpt.has(event.target).length) {
                $('.box').css('left', '-1000px');
            }
        });
    });
</script>
