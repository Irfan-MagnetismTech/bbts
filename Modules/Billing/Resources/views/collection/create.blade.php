@extends('layouts.backend-layout')
@section('title', 'Bill Collection')

@php
    $is_old = old('client_no') ? true : false;
    $form_heading = !empty($collection->id) ? 'Update' : 'Add';
    $form_url = !empty($collection->id) ? route('collections.update', $collection->id) : route('collections.store');
    $form_method = !empty($collection->id) ? 'PUT' : 'POST';
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
                            $client_name = $is_old ? old('client_name') : $collection->client->client_name ?? null;
                            $client_no = $is_old ? old('client_no') : $collection->client_no ?? null;
                            $date = $is_old ? old('date') : $collection->date ?? null;
                            $mr_no = $is_old ? old('mr_no') : $collection->mr_no ?? null;
                            $remarks = $is_old ? old('remarks') : $collection->remarks ?? null;
                            $total_amount = $is_old ? old('total_amount') : $collection->total_amount ?? null;
                            $total_net_amount = $is_old ? old('total_net_amount') : $collection->total_net_amount ?? null;
                            $total_bill_amount = $is_old ? old('total_bill_amount') : $collection->total_bill_amount ?? null;
                            $total_previous_due = $is_old ? old('total_previous_due') : $collection->total_previous_due ?? null;
                            $total_vat = $is_old ? old('total_vat') : $collection->total_vat ?? null;
                            $total_tax = $is_old ? old('total_tax') : $collection->total_tax ?? null;
                            $total_receive_amount = $is_old ? old('total_receive_amount') : $collection->total_receive_amount ?? null;
                            $grand_total = $is_old ? old('grand_total') : $collection->grand_total ?? null;
                            $total_due = $is_old ? old('total_due') : $collection->total_due ?? null;
                        @endphp
                        <div class="col-xl-3 col-md-3">
                            <div class="form-item">
                                <input type="text" class="form-control" name="client_no" id="client_no"
                                    autocomplete="off" readonly value="{{ $client_no }}">
                                <label for="client_no">Client NO<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-3">
                            <div class="form-item">
                                <input type="text" class="form-control" name="client_name" id="client_name"
                                    autocomplete="off" required value="{{ $client_name }}">
                                <label for="client_name">Client Name<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-3">
                            <div class="form-item">
                                <input type="text" class="form-control" name="mr_no" id="mr_no" autocomplete="off"
                                    required value="{{ $mr_no }}">
                                <label for="mr_no">MR No<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-3">
                            <div class="form-item">
                                <input type="date" name="date" id="date" class="form-control"
                                    value="{{ $date ? $date : now()->format('Y-m-d') }}" autocomplete="off"
                                    value="{{ $date }}">
                                <label for="client_type">Date<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-3">
                            <div class="form-item">
                                <input type="text" class="form-control" name="remarks" id="remarks" autocomplete="off"
                                    value="{{ $remarks }}">
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
                                    @if (!empty($collection))
                                        @foreach ($collection->lines as $item)
                                            <tr class="payment_details_row">
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <select name="payment_method[]" class="form-control"
                                                            autocomplete="off">
                                                            <option value="">Select Payment Method</option>
                                                            <option value="bank"
                                                                @if ($item->payment_method == 'bank') Selected @endif>BANK
                                                            </option>
                                                            <option value="cash"
                                                                @if ($item->payment_method == 'cash') Selected @endif>CASH
                                                            </option>
                                                            <option value="bkash"
                                                                @if ($item->payment_method == 'bkash') Selected @endif>BKASH
                                                            </option>
                                                            <option value="nogod"
                                                                @if ($item->payment_method == 'nogod') Selected @endif>NOGOD
                                                            </option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="bank_name[]" class="form-control"
                                                            autocomplete="off" placeholder="Bank Name"
                                                            value="{{ $item->bank_name }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="instrument_no[]" class="form-control"
                                                            autocomplete="off" placeholder="Instrument No"
                                                            value="{{ $item->instrument_no }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="instrument_date[]" class="form-control"
                                                            autocomplete="off" placeholder="Instrument Date"
                                                            value="{{ $item->instrument_date }}">
                                                    </div>
                                                </td>
                                                {{-- <td>
                                                    <div class="input-group input-group-sm input-group-primary amount">
                                                        <input type="text" name="amount[]" class="form-control"
                                                            autocomplete="off" placeholder="Amount"
                                                            value="{{ $item->amount }}">
                                                    </div>
                                                </td> --}}
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="amount[]" class="form-control amount"
                                                            autocomplete="off" placeholder="Amount" value="{{ $item->amount }}">
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
                                                    <input type="text" name="bank_name[]"
                                                        class="form-control bank_name" autocomplete="off"
                                                        placeholder="Bank Name">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="instrument_no[]"
                                                        class="form-control instrument_no" autocomplete="off"
                                                        placeholder="Instrument No">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="instrument_date[]"
                                                        class="form-control instrument_date" autocomplete="off"
                                                        placeholder="Instrument Date">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="amount[]" class="form-control amount"
                                                        autocomplete="off" placeholder="Amount">
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
                                                    id="total_amount" autocomplete="off" placeholder="Total Amount"
                                                    readonly value="{{ $grand_total }}">
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
                                        <th colspan="12" class="bg-secondary">Bills</th>
                                    </tr>
                                    <tr>
                                        <th>Bill No</th>
                                        <th>Bill Amount</th>
                                        <th>Previous Due</th>
                                        <th>Discount</th>
                                        <th>Penalty</th>
                                        <th>Net Amount</th>
                                        <th>Vat</th>
                                        <th>Tax</th>
                                        <th>Receive Amount</th>
                                        <th>Total</th>
                                        <th>Due</th>
                                        @if (!empty($collection))
                                        <th>
                                            <button type="button" class="btn btn-sm btn-warning" id="addBillRow"><i
                                                    class="fas fa-plus"></i></button>
                                        </th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="billBody">
                                    @if (!empty($collection))
                                    {{-- @dd($collection->collectionBill); --}}
                                        @foreach ($collection->collectionBills as $item)
                                            <tr class="bill_details_row">
                                                
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="bill_no[]"
                                                            class="form-control bill_no" autocomplete="off"
                                                            placeholder="Bill No" value="{{ $item->bill_no }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="bill_amount[]"
                                                            class="form-control bill_amount" autocomplete="off"
                                                            placeholder="Bill Amount" value="{{ $item->amount }}" readonly>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="previous_due[]"
                                                            class="form-control previous_due" autocomplete="off"
                                                            placeholder="Previous Due" value="{{ $item->previous_due }}"
                                                            readonly>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="discount[]"
                                                            class="form-control discount" autocomplete="off"
                                                            placeholder="Discount" value="{{ $item->discount }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="penalty[]"
                                                            class="form-control penalty" autocomplete="off"
                                                            placeholder="Penalty" value="{{ $item->penalty }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="net_amount[]"
                                                            class="form-control net_amount" autocomplete="off"
                                                            placeholder="Net Amount" value="{{ $item->net_amount }}"
                                                            readonly>
                                                    </div>
                                                </td>
    
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="vat[]" class="form-control vat"
                                                            autocomplete="off" placeholder="Vat" value="{{ $item->vat }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="tax[]" class="form-control tax"
                                                            autocomplete="off" placeholder="Tax" value="{{ $item->tax }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="receive_amount[]"
                                                            class="form-control receive_amount" autocomplete="off"
                                                            placeholder="Receive Amount"
                                                            value="{{ $item->receive_amount }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="total[]"
                                                            class="form-control total" id="total"
                                                            autocomplete="off" placeholder="Total" value="{{ $item->total }}" readonly>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="due[]" class="form-control due"
                                                            autocomplete="off" placeholder="Due"
                                                            value="{{ $item->due }}" readonly>
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
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="1" class="text-right">Total</td>
                                        <td>
                                            <div class="input-group input-group-sm input-group-primary">
                                                <input type="text" name="total_bill_amount" class="form-control"
                                                    id="total_bill_amount" autocomplete="off"
                                                    placeholder="Total Bill Amount" value="{{ $total_bill_amount }}" readonly>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm input-group-primary">
                                                <input type="text" name="total_previous_due" class="form-control"
                                                    id="total_previous_due" autocomplete="off"
                                                    placeholder="Total Previous Due" readonly
                                                    value="{{ $total_previous_due }}">
                                            </div>
                                        </td>
                                        <td colspan="2" class="text-right"></td>
                                        <td>
                                            <div class="input-group input-group-sm input-group-primary">
                                                <input type="text" name="total_net_amount" class="form-control"
                                                    id="total_net_amount" autocomplete="off" placeholder="Total Net"
                                                    readonly value="{{ $total_net_amount }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm input-group-primary">
                                                <input type="text" name="total_vat" class="form-control"
                                                    id="total_vat" autocomplete="off" placeholder="Total Vat" readonly
                                                    value="{{ $total_vat }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm input-group-primary">
                                                <input type="text" name="total_tax" class="form-control"
                                                    id="total_tax" autocomplete="off" placeholder="Total Tax" readonly
                                                    value="{{ $total_tax }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm input-group-primary">
                                                <input type="text" name="total_receive_amount" class="form-control"
                                                    id="total_receive_amount" autocomplete="off"
                                                    placeholder="Total Received" readonly
                                                    value="{{ $total_receive_amount }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm input-group-primary">
                                                <input type="text" name="grand_total" class="form-control"
                                                    id="grand_total" autocomplete="off" placeholder="Grand Total" readonly
                                                    value="{{ $grand_total }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm input-group-primary">
                                                <input type="text" name="total_due" class="form-control"
                                                    id="total_due" autocomplete="off" placeholder="Total Due" readonly
                                                    value="{{ $total_due }}">
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <button class="py-3 px-5 btn btn-success ">{{ !empty($collections->id) ? 'Update' : 'Save' }}</button>
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
                            const removePaymentRow =  $(this).closest('tr')
                            const amount = removePaymentRow.find('.amount').val();
                            const previousAmount =  $('#total_amount').val();
                            $('#total_amount').val(previousAmount - amount);
                            removePaymentRow.remove();



                        }
                    });

                    // $(document).on('click', '.removeBillRow', function() {
                    //     let count = $('.bill_details_row').length;
                    //     if (count > 1) {
                    //         $(this).closest('tr').remove();
                    //     }
                    // });
                    $(document).on('click', '.removeBillRow', function() {
                        let count = $('.bill_details_row').length;
                        if (count > 1) {
                            // Find the input element with class 'bill_amount' in the closest table row
                            const removedRow = $(this).closest('tr');

                            const billAmountValue = removedRow.find('.bill_amount').val();
                            const previousDuetValue = removedRow.find('.previous_due').val();
                            const vat = removedRow.find('.vat').val();
                            const tax = removedRow.find('.tax').val();
                            const total = removedRow.find('.total').val();
                            const receiveAmount = removedRow.find('.receive_amount').val();


                            const preTotalBillAmount = $('#total_bill_amount').val();
                            const preTotalPreviousDue = $('#total_previous_due').val();
                            const previousTotalVat = $('#total_vat').val();
                            const previousTotalTax = $('#total_tax').val();
                            const previousGrandTotal = $('#grand_total').val();
                            const preTotalReceiveAmount = $('#total_receive_amount').val();


                            $('#total_bill_amount').val(preTotalBillAmount - billAmountValue);
                            $('#total_previous_due').val(preTotalPreviousDue - previousDuetValue);
                            $('#total_vat').val(previousTotalVat - vat);
                            $('#total_tax').val(previousTotalTax - tax);
                            $('#grand_total').val(previousGrandTotal - total);
                            $('#total_receive_amount').val(preTotalReceiveAmount - receiveAmount);
                            removedRow.remove();
                        }
                    });



                    $('#client_name').on('input keyup', function() {
                        var client_name = $(this).val();
                        let myObject = {
                            "client_name": client_name,
                        }
                        jquaryUiAjax(this, "{{ route('get_client') }}", uiList, myObject);

                        function uiList(item) {
                            $('#client_name').val(item.value).attr('value', item.value);
                            $('#client_no').val(item.client_no).attr('value', item.client_no);
                            $('#client_id').val(item.client_id).attr('value', item.client_id);

                            $.ajax({
                                url: "{{ route('get_unpaid_bill') }}",
                                data: {
                                    client_no: item.client_no,
                                    _token: "{{ csrf_token() }}"
                                },
                                success: function(data) {
                                //   console.log(data);
                                    let totalBillAmount = 0;
                                    let totalPreviousDue = 0; 
                                    $(".billBody").empty();
                                    data.forEach(element => {
                                        let previousAmount = element.amount - element.total_receive
                                        console.log(element);
                                        totalBillAmount += element.amount;
                                        totalPreviousDue += previousAmount;

                                        // amount = amount + element.amount;
                                        // $('.bill_details_row').first().clone().appendTo('.billBody');
                                        // $('.bill_details_row').last().find('input').val('');
                                        // $('.bill_details_row').last().find('select').val('');
                                        
                                        var newChild = $(`<tr class="bill_details_row">
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input value=${element.bill_no} type="text" name="bill_no[]" class="form-control bill_no"
                                                        autocomplete="off" placeholder="Bill No">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" value=${element.amount} name="bill_amount[]"
                                                        class="form-control bill_amount" autocomplete="off"
                                                        placeholder="Bill Amount" readonly>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" value = ${previousAmount} name="previous_due[]"
                                                        class="form-control previous_due" autocomplete="off"
                                                        placeholder="Previous Due" readonly>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="discount[]" class="form-control discount"
                                                        autocomplete="off" placeholder="Discount">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="penalty[]" class="form-control penalty"
                                                        autocomplete="off" placeholder="Penalty">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="net_amount[]"
                                                        class="form-control net_amount" autocomplete="off"
                                                        placeholder="Net Amount" readonly>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="vat[]" class="form-control vat"
                                                        autocomplete="off" placeholder="Vat">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="tax[]" class="form-control tax"
                                                        autocomplete="off" placeholder="tax">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="receive_amount[]"
                                                        class="form-control receive_amount" autocomplete="off"
                                                        placeholder="Receive Amount">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="total[]"
                                                        class="form-control total" id="total"
                                                        autocomplete="off" placeholder="Total" readonly>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="due[]" class="form-control due"
                                                        autocomplete="off" placeholder="Due" readonly>
                                                </div>
                                            </td>
                                            <td>
                                                <button type="button" attr_one=""
                                                    class="btn btn-sm btn-danger removeBillRow"><i
                                                        class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>`);

                                        $(".billBody").append(newChild);


                                        // $('.bill_no').val(element.bill_no);


                                    });
                                    // console.log(sum);
                                    $('#total_bill_amount').val(totalBillAmount);
                                    $('#total_previous_due').val(totalPreviousDue);
                                    // console.log(data);
                                    // data.forEach(element => {
                                    //     html += '<option value="' + element.id + '">' + element.text +
                                    //         '</option>';
                                    // });
                                    // $('#district').html(html);
                                }
                            });
                        }


                    });

                    $(document).on('input keyup', '.bill_no', function() {
                        var client_no = $('#client_no').val();
                        let myObject = {
                            "client_no": client_no,
                        }

                        var source = $(this);
                        jquaryUiAjax(this, "{{ route('get_bill') }}", uiList, myObject);

                        function uiList(item) {
                            let previousDue
                            if(item.previous_due > 0)
                            {
                                previousDue = item.previous_due
                            }
                            else{
                                previousDue = item.amount;
                            }
                            $(source).val(item.value).attr('value', item.value);
                            $(source).closest('tr').find('.bill_amount').val(item.amount);
                            $(source).closest('tr').find('.previous_due').val(previousDue);
                            if (item.previous_due) {
                                $(source).closest('tr').find('.net_amount').val(item.previous_due);
                                $(source).closest('tr').find('.due').val(item.previous_due);
                            } else {
                                $(source).closest('tr').find('.net_amount').val(item.amount);
                                $(source).closest('tr').find('.due').val(item.amount);
                            }
                            calculateBillTotal();
                        }
                    });
                    $(document).on('keyup', '.penalty,.discount,.receive_amount,.vat,.tax,.total', function() {
                        var previous_due = $(this).closest('tr').find('.previous_due').val();
                        var bill_amount = $(this).closest('tr').find('.bill_amount').val();
                        var penalty = $(this).closest('tr').find('.penalty').val() ?? 0;
                        var discount = $(this).closest('tr').find('.discount').val();
                        var vat = parseFloat($(this).closest('tr').find('.vat').val()) || 0;
                        var tax = parseFloat($(this).closest('tr').find('.tax').val()) || 0;
                        var receive_amount = parseFloat($(this).closest('tr').find('.receive_amount').val()) || 0;
                        var total = vat + tax + receive_amount;
                        var total = $(this).closest('tr').find('.total').val();
                        var total = vat + tax + receive_amount;
                        $(this).closest('tr').find('.total').val(total)


                        if (previous_due > 0) {
                            var net = previous_due - penalty - discount;
                            // var due = previous_due - penalty - discount - receive_amount;
                               var due = net - total;
                        } else {
                            var net = bill_amount - penalty - discount;
                            // var due = bill_amount - penalty - discount - receive_amount;
                            var due = net - total;
                        }
                        $(this).closest('tr').find('.net_amount').val(net);
                        (due > 0) ? $(this).closest('tr').find('.due').val(due): $(this).closest('tr').find('.due').val("0");
                        calculateBillTotal();
                    })

                    function calculateBillTotal() {
                        var totalNetAmount = 0;
                        $(".net_amount").each(function() {
                            totalNetAmount += parseFloat($(this).val() ? $(this).val() : 0);
                        })
                        var totalBillAmount = 0;
                        $(".bill_amount").each(function() {
                            totalBillAmount += parseFloat($(this).val() ? $(this).val() : 0);
                        })
                        var totalPreviousDue = 0;
                        $(".previous_due").each(function() {
                            totalPreviousDue += parseFloat($(this).val() ? $(this).val() : 0);
                        })

                        var totalVat = 0;
                        $(".vat").each(function() {
                            totalVat += parseFloat($(this).val() ? $(this).val() : 0);
                        })
                        var totalTax = 0;
                        $(".tax").each(function() {
                            totalTax += parseFloat($(this).val() ? $(this).val() : 0);
                        })
                        var totalReceiveAmount = 0;
                        $(".receive_amount").each(function() {
                            totalReceiveAmount += parseFloat($(this).val() ? $(this).val() : 0);
                        })
                        var totalSingleTotal = 0;
                        $(".total").each(function() {
                            totalSingleTotal = totalVat + totalTax + totalReceiveAmount;
                        })

                        var totalDue = 0;
                        $(".due").each(function() {
                            totalDue += parseFloat($(this).val() ? $(this).val() : 0);
                        })
                        $('#total_net_amount').val(totalNetAmount);
                        $('#total_bill_amount').val(totalBillAmount);
                        $('#total_previous_due').val(totalPreviousDue);
                        $('#total_vat').val(totalVat);
                        $('#total_tax').val(totalTax);
                        $('#total_receive_amount').val(totalReceiveAmount);
                        $('#grand_total').val(totalSingleTotal);
                        $('#total_due').val(totalDue);
                    }
                    $(document).on('keyup', '.amount', function() {
                        calculatePaymentTotal();
                    })
                    $(document).on('keyup', '.amount', function() {
                        calculatePaymentTotal();
                    })

                    function calculatePaymentTotal() {
                        var totalPayment = 0;
                        $(".amount").each(function() {
                            totalPayment += parseFloat($(this).val() ? $(this).val() : 0);
                            console.log(totalPayment);
                        })
                        $('#total_amount').val(totalPayment);
                    }
                </script>
            @endsection
