@extends('layouts.backend-layout')
@section('title', 'Feasibility Requirement')

@php
    $is_old = old('client_id') ? true : false;
    $form_heading = !empty($collections->id) ? 'Update' : 'Add';
    $form_url = !empty($collections->id) ? route('collections.update', $collections->id) : route('collections.store');
    $form_method = !empty($collections->id) ? 'PUT' : 'POST';
@endphp

@section('breadcrumb-title')
    {{ ucfirst($form_heading) }} Bill Collection
@endsection

@section('breadcrumb-button')
    <a href="{{ route('collections.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')

    {!! Form::open([
        'url' => $form_url,
        'method' => $form_method,
        'encType' => 'multipart/form-data',
        'class' => 'custom-form',
    ]) !!}

    {{-- Comparative Statement --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        @php
                            $client_name = $is_old ? old('client_name') : $collections->lead_generation->client_name ?? null;
                            $client_no = $is_old ? old('client_no') : $collections->client_no ?? null;
                            $is_existing = $is_old ? old('is_existing') : $collections->is_existing ?? null;
                            $date = $is_old ? old('date') : $collections->date ?? null;
                            $mr_no = $is_old ? old('mr_no') : $collections->mr_no ?? null;
                            $remarks = $is_old ? old('remarks') : $collections->remarks ?? null;
                        @endphp
                        <div class="col-xl-3 col-md-3">
                            <div class="form-item">
                                <input type="text" class="form-control" name="client_no" id="client_no"
                                    value="" autocomplete="off" readonly>
                                <label for="client_no">Client NO<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-3">
                            <div class="form-item">
                                <input type="text" class="form-control" name="client_name" id="client_name"
                                    value="" autocomplete="off" required>
                                <label for="client_name">Client Name<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-3">
                            <div class="form-item">
                                <input type="text" class="form-control" name="mr_no" id="mr_no"
                                    value="" autocomplete="off" required>
                                <label for="mr_no">MR No<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-3">
                            <div class="form-item">
                                <input type="date" name="date" id="date" class="form-control"
                                    value="{{ $date ? $date : now()->format('Y-m-d') }}" autocomplete="off">
                                <label for="client_type">Date<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-3">
                            <div class="form-item">
                                <input type="text" class="form-control" name="remarks" id="remarks"
                                    value="" autocomplete="off" required>
                                <label for="remarks">Remarks<span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <hr>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th colspan="6" class="bg-secondary">Payments</th>
                                    </tr>
                                    <tr>
                                        <th>Payment Method</th>
                                        <th>Bank Name</th>
                                        <th>Instrument No</th>
                                        <th>Instrument Date</th>
                                        <th>Amount</th>
                                        <th>
                                            <button type="button" class="btn btn-sm btn-warning" id="addRow"><i
                                                    class="fas fa-plus"></i></button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="paymentBody">
                                    @if (!empty($feasibility_requirement))
                                        @foreach ($feasibility_requirement->feasibilityRequirementDetails as $item)
                                            <tr class="payment_details_row">
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <select name="payment_method[]" class="form-control"
                                                        autocomplete="off">
                                                            <option value="">Select Payment Method</option>
                                                            <option value="bank">BANK</option>
                                                            <option value="cash">CASH</option>
                                                            <option value="bkash">BKASH</option>
                                                            <option value="nogod">NOGOD</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="bank_name[]" class="form-control"
                                                            value="" autocomplete="off"
                                                            placeholder="Bank Name">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="lat[]" class="form-control"
                                                            value="" autocomplete="off"
                                                            placeholder="Instrument No">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="long[]" class="form-control"
                                                            value="" autocomplete="off"
                                                            placeholder="Instrument Date">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="contact_name[]" class="form-control"
                                                            value="" autocomplete="off"
                                                            placeholder="Amount">
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" attr_one=""
                                                        class="btn btn-sm btn-danger removeRow"><i
                                                            class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr class="payment_details_row">
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <select name="payment_method[]" class="form-control"
                                                        autocomplete="off">
                                                        <option value="">Select Payment Method</option>
                                                        <option value="bank">BANK</option>
                                                        <option value="cash">CASH</option>
                                                        <option value="bkash">BKASH</option>
                                                        <option value="nogod">NOGOD</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="bank_name[]" class="form-control bank_name" autocomplete="off" placeholder="Bank Name">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="instrument_no[]" class="form-control instrument_no" autocomplete="off" placeholder="Instrument No">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="instrument_date[]" class="form-control instrument_date" autocomplete="off" placeholder="Instrument Date">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="amount[]" class="form-control amount" autocomplete="off" placeholder="Amount">
                                                </div>
                                            </td>
                                            <td>
                                                <button type="button" attr_one=""
                                                    class="btn btn-sm btn-danger removeRow"><i
                                                        class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-right"></td>
                                        <td>
                                            <div class="input-group input-group-sm input-group-primary">
                                                <input type="text" name="total_amount" class="form-control"
                                                    id="total_amount" autocomplete="off" placeholder="Total Amount" readonly>
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="col-md-12">
                            <hr>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th colspan="9" class="bg-secondary">Bills</th>
                                    </tr>
                                    <tr>
                                        <th>Bill No</th>
                                        <th>Bill Amount</th>
                                        <th>Previous Due</th>
                                        <th>Discount</th>
                                        <th>Penalty</th>
                                        <th>Net Amount</th>
                                        <th>Receive Amount</th>
                                        <th>Due</th>
                                        <th>
                                            <button type="button" class="btn btn-sm btn-warning" id="addBillRow"><i
                                                    class="fas fa-plus"></i></button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="billBody">
                                    @if (!empty($feasibility_requirement))
                                        @foreach ($feasibility_requirement->feasibilityRequirementDetails as $item)
                                            <tr class="bill_details_row">
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="bill_no[]" class="form-control bill_no"
                                                            value="" autocomplete="off"
                                                            placeholder="Bill No">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="previous_due[]" class="form-control previous_due" autocomplete="off" placeholder="Previous Due">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="bill_amount[]" class="form-control bill_amount"
                                                            value="" autocomplete="off"
                                                            placeholder="Bill Amount">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="long[]" class="form-control"
                                                            value="" autocomplete="off"
                                                            placeholder="Discount">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="contact_name[]" class="form-control"
                                                            value="" autocomplete="off"
                                                            placeholder="Penalty">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="net_amount[]" class="form-control net_amount"
                                                            value="" autocomplete="off"
                                                            placeholder="Net Amount">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="long[]" class="form-control"
                                                            value="" autocomplete="off"
                                                            placeholder="Receive Amount">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="contact_name[]" class="form-control"
                                                            value="" autocomplete="off"
                                                            placeholder="Due">
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" attr_one=""
                                                        class="btn btn-sm btn-danger removeBillRow"><i
                                                            class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr class="bill_details_row">
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="bill_no[]" class="form-control bill_no" autocomplete="off" placeholder="Bill No">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="bill_amount[]" class="form-control bill_amount" autocomplete="off" placeholder="Bill Amount" readonly>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="previous_due[]" class="form-control previous_due" autocomplete="off" placeholder="Previous Due" readonly>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="discount[]" class="form-control discount" autocomplete="off" placeholder="Discount">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="penalty[]" class="form-control penalty" autocomplete="off" placeholder="Penalty">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="net_amount[]" class="form-control net_amount" autocomplete="off" placeholder="Net Amount" readonly>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="receive_amount[]" class="form-control receive_amount" autocomplete="off" placeholder="Receive Amount">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="due[]" class="form-control due" autocomplete="off" placeholder="Due" readonly>
                                                </div>
                                            </td>
                                            <td>
                                                <button type="button" attr_one=""
                                                    class="btn btn-sm btn-danger removeBillRow"><i
                                                        class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" class="text-right">Total</td>
                                        <td>
                                            <div class="input-group input-group-sm input-group-primary">
                                                <input type="text" name="total_net_amount" class="form-control"
                                                    id="total_net_amount" autocomplete="off" placeholder="Total Net" readonly>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm input-group-primary">
                                                <input type="text" name="total_receive_amount" class="form-control"
                                                    id="total_receive_amount" autocomplete="off" placeholder="Total Received" readonly>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm input-group-primary">
                                                <input type="text" name="total_due" class="form-control"
                                                    id="total_due" autocomplete="off" placeholder="Total Due" readonly>
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <button
                            class="py-2 btn btn-success ">{{ !empty($collections->id) ? 'Update' : 'Save' }}</button>
                    </div>
                </div>
                {!! Form::close() !!}
            @endsection

            @section('script')
                <script>


                    $('#addRow').on('click', function() {
                        addRow();
                    });

                    $('#addBillRow').on('click', function() {
                        addBillRow();
                    });

                    function addRow() {
                        $('.payment_details_row').first().clone().appendTo('.paymentBody');
                        $('.payment_details_row').last().find('input').val('');
                        $('.payment_details_row').last().find('select').val('');
                    };

                    function addBillRow() {
                        $('.bill_details_row').first().clone().appendTo('.billBody');
                        $('.bill_details_row').last().find('input').val('');
                        $('.bill_details_row').last().find('select').val('');
                    };

                    $(document).keydown(function(event) {
                        if (event.ctrlKey && event.key === 'Insert') {
                            event.preventDefault();
                            addRow();
                        }
                    });

                    $(document).keydown(function(event) {
                        if (event.ctrlKey && event.key === 'Delete') {
                            event.preventDefault();
                            if ($('.payment_details_row').length > 1) {
                                $('.payment_details_row').last().remove();
                            }
                        }
                    });

                    $(document).keydown(function(event) {
                        if (event.altKey && event.key === 'Insert') {
                            event.preventDefault();
                            addBillRow();
                        }
                    });

                    $(document).keydown(function(event) {
                        if (event.altKey && event.key === 'Delete') {
                            event.preventDefault();
                            if ($('.bill_details_row').length > 1) {
                                $('.bill_details_row').last().remove();
                            }
                        }
                    });

                    $(document).on('click', '.removeRow', function() {
                        let count = $('.payment_details_row').length;
                        if (count > 1) {
                            $(this).closest('tr').remove();
                        }
                    });

                    $(document).on('click', '.removeBillRow', function() {
                        let count = $('.bill_details_row').length;
                        if (count > 1) {
                            $(this).closest('tr').remove();
                        }
                    });

                    $('#client_name').on('input keyup', function() {
                        var client_name = $(this).val();
                        let myObject = {
                            "client_name" : client_name,
                        }
                        jquaryUiAjax(this, "{{ route('get_client') }}", uiList, myObject);

                        function uiList(item) {
                            $('#client_name').val(item.value).attr('value', item.value);
                            $('#client_no').val(item.client_no).attr('value', item.client_no);
                            $('#client_id').val(item.client_id).attr('value', item.client_id);
                        }
                    });

                    $(document).on('input keyup','.bill_no', function() {
                        var client_no = $('#client_no').val();
                        let myObject = {
                            "client_no" : client_no,
                        }

                        var source = $(this);
                        jquaryUiAjax(this, "{{ route('get_bill') }}", uiList, myObject);

                        function uiList(item) {
                            $(source).val(item.value).attr('value', item.value);
                            $(source).closest('tr').find('.bill_amount').val(item.amount);
                            $(source).closest('tr').find('.previous_due').val(item.previous_due);
                            if(item.previous_due){
                                $(source).closest('tr').find('.net_amount').val(item.previous_due);
                                $(source).closest('tr').find('.due').val(item.previous_due);
                            }else{
                                $(source).closest('tr').find('.net_amount').val(item.amount);
                                $(source).closest('tr').find('.due').val(item.amount);
                            }
                            calculateBillTotal();
                        }
                    });
                    $(document).on('keyup','.penalty,.discount,.receive_amount',function(){
                        var previous_due = $(this).closest('tr').find('.previous_due').val();
                        var bill_amount = $(this).closest('tr').find('.bill_amount').val();
                        var penalty = $(this).closest('tr').find('.penalty').val() ?? 0;
                        var discount = $(this).closest('tr').find('.discount').val();
                        var receive_amount = $(this).closest('tr').find('.receive_amount').val();
                        if(previous_due > 0){
                            var net = previous_due - penalty - discount;
                            var due = previous_due - penalty - discount - receive_amount;
                        }else{
                            var net = bill_amount - penalty - discount;
                            var due = bill_amount - penalty - discount - receive_amount;
                        }
                        $(this).closest('tr').find('.net_amount').val(net);
                        (due>0) ? $(this).closest('tr').find('.due').val(due) : $(this).closest('tr').find('.due').val("0");
                        calculateBillTotal();
                    })
                    function calculateBillTotal(){
                        var totalNetAmount = 0;
                        $(".net_amount").each(function () {
                            totalNetAmount += parseFloat($(this).val() ? $(this).val() : 0);
                        })

                        var totalReceiveAmount = 0;
                        $(".receive_amount").each(function () {
                            totalReceiveAmount += parseFloat($(this).val() ? $(this).val() : 0);
                        })

                        var totalDue = 0;
                        $(".due").each(function () {
                            totalDue += parseFloat($(this).val() ? $(this).val() : 0);
                        })
                        $('#total_net_amount').val(totalNetAmount);
                        $('#total_receive_amount').val(totalReceiveAmount);
                        $('#total_due').val(totalDue);
                    }
                    $(document).on('keyup','.amount',function(){
                        calculatePaymentTotal();
                    })

                    function calculatePaymentTotal(){
                        var totalPayment = 0;
                        $(".amount").each(function () {
                            totalPayment += parseFloat($(this).val() ? $(this).val() : 0);
                        })
                        $('#total_amount').val(totalPayment);
                    }

                </script>
            @endsection
