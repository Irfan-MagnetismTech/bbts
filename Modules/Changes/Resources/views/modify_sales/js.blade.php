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

    $('#client_name').on('keyup', function() {
        let myObject = {}
        jquaryUiAjax(this, "{{ route('get-client-info-for-sales-modification-fr') }}", uiList, myObject);

        function uiList(item) {
            $('#client_name').val(item.value).attr('value', item.value);
            $('#client_no').val(item.client_no).attr('value', item.client_no);
            $('#client_id').val(item.client_id).attr('value', item.client_id);
            $('#mq_no').val(item.mq_no).attr('value', item.mq_no);
            // var indx = $('.checkbox').length;
            //foreach loop details
            var fr_list = '<option>Select FR</option>';
            $.each(item.details, function(detail) {
                fr_list += `
                    <option value="${detail}">${detail}</option>
                `;
            })
            $('#fr_no').html(fr_list);
            initializeDate();
            selectTwo();
            return false;
        }
    })

    $('#fr_no').on('change', function() {
        let client_no = $('#client_no').val();
        let fr_no = $(this).val();
        let mq_no = $('#mq_no').val();
        //ajax request
        $.ajax({
            url: "{{ route('get-sale-modication-fr-details') }}",
            type: 'GET',
            data: {
                client_no: client_no,
                fr_no: fr_no,
                mq_no: mq_no
            },
            success: function(data) {
                console.log(data);
            }
        })
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
