@extends('layouts.backend-layout')
@section('title', 'Broken Days Bill')

@php
    $is_old = old('client_no') ? true : false;
    $form_heading = !empty($brokenDaysBill->id) ? 'Update' : 'Generate';
    $form_url = !empty($brokenDaysBill->id) ? route('broken-days-bills.update', $brokenDaysBill->id) : route('broken-days-bills.store');
    $form_method = !empty($brokenDaysBill->id) ? 'PUT' : 'POST';
@endphp

@section('breadcrumb-title')
    Broken Days Bill {{ ucfirst($form_heading) }}
@endsection

@section('breadcrumb-button')
    <a href="{{ route('broken-days-bills.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
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
                            $client_name = $is_old ? old('client_name') : $brokenDaysBill->client->client_name ?? null;
                            $client_no = $is_old ? old('client_no') : $brokenDaysBill->client_no ?? null;
                            $date = $is_old ? old('date') : $brokenDaysBill->date ?? null;
                            $fr_no = $is_old ? old('fr_no') : $brokenDaysBill->fr_no ?? null;
                            $bill_no = $is_old ? old('bill_no') : $brokenDaysBill->bill_no ?? null;
                            $type = $is_old ? old('type') : $brokenDaysBill->type ?? null;
                            $days = $is_old ? old('days') : $brokenDaysBill->days ?? null;
                            $total_amount = $is_old ? old('total_amount') : $brokenDaysBill->total_amount ?? null;
                            $total_net_amount = $is_old ? old('total_net_amount') : $brokenDaysBill->total_net_amount ?? null;
                            $total_receive_amount = $is_old ? old('total_receive_amount') : $brokenDaysBill->total_receive_amount ?? null;
                            $total_due = $is_old ? old('total_due') : $brokenDaysBill->total_due ?? null;
                            $product_data = $is_old ? old('product_data') : $brokenDaysBill->product_data ?? null;
                        @endphp
                        <div class="col-xl-3 col-md-3">
                            <div class="form-item">
                                <input type="text" class="form-control" name="client_no" id="client_no" autocomplete="off" readonly value="{{$client_no}}">
                                <label for="client_no">Client No<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-3">
                            <div class="form-item">
                                <input type="text" class="form-control" name="client_name" id="client_name" autocomplete="off" required value="{{$client_name}}">
                                <label for="client_name">Client Name<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <label for="select2">FR No<span class="text-danger">*</span></label>
                        <div class="col-xl-3 col-md-3">
                            <div class="form-item">
                            <select class="form-control select2" id="fr_no" name="fr_no" >
                                <option value="" selected>Select FR No</option>
                                @if ($form_method == 'POST')
                                    <option value="{{ $fr_no }}" selected>{{ $fr_no }}</option>
                                @endif
                                @if ($form_method == 'PUT')
                                    @foreach ($fr_no as $key => $value)
                                        <option value="{{ $value }}" selected>{{ $value }}>
                                            {{ $value }}</option>
                                    @endforeach
                                @endif
                            </select>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-3">
                            <div class="form-item">
                                <input type="text" class="form-control" name="mr_no" id="mr_no" autocomplete="off" required value="{{$bill_no}}">
                                <label for="mr_no">Bill No<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-3">
                            <select name="type" class="form-control"
                                    autocomplete="off">
                                <option value="">Select Type</option>
                                <option value="new">NEW</option>
                                <option value="existing">EXISTING</option>
                            </select>
                        </div>
                        <div class="col-xl-3 col-md-3">
                            <div class="form-item">
                                <input type="text" class="form-control" name="days" id="days" autocomplete="off" required value="{{$days}}">
                                <label for="days">Days<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-3">
                            <div class="form-item">
                                <input type="date" name="date" id="date" class="form-control"
                                       value="{{ $date ? $date : now()->format('Y-m-d') }}" autocomplete="off" value="{{$date}}">
                                <label for="client_type">Date<span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <hr>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="errTable">
                                <thead>
                                <tr>
                                    <th rowspan="2">Product Name</th>
                                    <th rowspan="2">Quantity</th>
                                    <th rowspan="2">Unit</th>
                                    <th rowspan="2">Rate</th>
                                    <th rowspan="2">Price</th>
                                    <th rowspan="2">Vat Amount</th>
                                    <th rowspan="2">Total Price</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $product_names = old('product_name', !empty($brokenDaysBill) ? $brokenDaysBill->saleProductDetails->pluck('product_name') : []);
                                    $quantities = old('quantity', !empty($brokenDaysBill) ? $brokenDaysBill->saleProductDetails->pluck('quantity') : []);
                                    $rates = old('rate', !empty($brokenDaysBill) ? $brokenDaysBill->saleProductDetails->pluck('rate') : []);
                                    $prices = old('price', !empty($brokenDaysBill) ? $brokenDaysBill->saleProductDetails->pluck('price') : []);
                                    $vat_amounts = old('vat_amount', !empty($brokenDaysBill) ? $brokenDaysBill->saleProductDetails->pluck('vat_amount') : []);
                                    $units = old('unit', !empty($brokenDaysBill) ? $brokenDaysBill->saleProductDetails->pluck('unit') : []);
                                    $total_prices = old('total_price', !empty($brokenDaysBill) ? $brokenDaysBill->saleProductDetails->pluck('total_price') : []);
                                @endphp

                                @foreach ($product_names as $key => $product_name)
                                    <tr>
                                        <td>
                                            <input name="product_name[]" class="form-control product_name" readonly autocomplete="off"
                                                   type="text" value="{{ $product_name }}" readonly>
                                            <input name="product_id[]" class="form-control product_id" readonly autocomplete="off"
                                                   type="hidden" value="{{ $product_ids[$key] }}">
                                        </td>
                                        <td>
                                            <input name="quantity[]" class="form-control quantity" autocomplete="off" type="text"
                                                   value="{{ $quantities[$key] }}">
                                        </td>
                                        <td>
                                            <input name="unit[]" class="form-control unit" autocomplete="off" type="text"
                                                   value="{{ $units[$key] }}" readonly>
                                        </td>
                                        <td>
                                            <input name="rate[]" class="form-control rate" autocomplete="off"
                                                   type="text" value="{{ $rates[$key] }}" readonl>
                                        </td>
                                        <td>
                                            <input name="price[]" class="form-control price" autocomplete="off" type="text"
                                                   value="{{ $prices[$key] }}" readonly>
                                        </td>
                                        <td>
                                            <input name="vat_amount[]" class="form-control vat_amount" autocomplete="off" type="text"
                                                   value="{{ $vat_amounts[$key] }}" readonly>
                                        </td>
                                        <td>
                                            <input name="total_price[]" class="form-control total_price" autocomplete="off" type="text"
                                                   value="{{ $total_prices[$key] }}" readonly>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="offset-md-4 col-md-4 mt-2">
                                    <div class="input-group input-group-sm ">
                                        <button class="btn btn-success btn-round btn-block py-2">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
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

                    <script src="{{ asset('js/get-fr-product.js') }}"></script>
                    <script src="{{ asset('js/get-client.js') }}"></script>
@endsection
