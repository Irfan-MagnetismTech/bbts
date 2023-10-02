@extends('layouts.backend-layout')
@section('title', 'Broken Days Bill')

@php
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

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        @php
                            $is_old = (bool)old('client_no');
                            $client_name = $is_old ? old('client_name') : $brokenDaysBill->client->client_name ?? null;
                            $client_no = $is_old ? old('client_no') : $brokenDaysBill->client_no ?? null;
                            $date = $is_old ? old('date') : $brokenDaysBill->date ?? null;
                            $fr_no = $is_old ? old('fr_no') : $brokenDaysBill->fr_no ?? null;
                            $bill_no = $is_old ? old('bill_no') : $brokenDaysBill->bill_no ?? null;
                            $billing_date = $is_old ? old('billing_date') : $brokenDaysBill->billing_date ?? null;
                            $days = $is_old ? old('days') : $brokenDaysBill->days ?? null;
                            $total_amount = $is_old ? old('total_amount') : $brokenDaysBill->total_amount ?? null;
                        @endphp
                        <div class="col-xl-3 col-md-3">
                            <div class="form-item">
                                <input type="text" class="form-control" name="client_no" id="client_no"
                                       autocomplete="off" readonly value="{{$client_no}}">
                                <label for="client_no">Client No<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-3">
                            <div class="form-item">
                                <input type="text" class="form-control" name="client_name" id="client_name"
                                       autocomplete="off" required value="{{$client_name}}">
                                <label for="client_name">Client Name<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <label for="select2">FR No<span class="text-danger">*</span></label>
                        <div class="col-xl-3 col-md-3">
                            <div class="form-item">
                                <select class="form-control select2" id="fr_no" name="fr_no">
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
                                <input type="text" class="form-control" name="billing_date" id="billing_date"
                                       autocomplete="off" readonly required value="{{$billing_date}}">
                                <label for="billing_date">Billing Date<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-3">
                            <div class="form-item">
                                <input type="number" class="form-control" name="days" id="days" autocomplete="off"
                                       readonly required value="{{$days}}">
                                <label for="days">Days<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-3">
                            <div class="form-item">
                                <input type="date" name="date" id="date" class="form-control"
                                       value="{{ $date ? $date : now()->format('Y-m-d') }}" autocomplete="off"
                                       value="{{$date}}">
                                <label for="date">Date<span class="text-danger">*</span></label>
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
                                    <th rowspan="2">Unit Price</th>
                                    <th rowspan="2">Total Price</th>
                                    <th rowspan="2">Vat Amount</th>
                                    <th rowspan="2">Total Amount</th>
                                </tr>
                                </thead>
                                <tbody>

                                @php
                                    $product_ids = old('product_id', !empty($brokenDaysBill) ? $brokenDaysBill->BrokenDaysBillDetails->pluck('product_id') : []);
                                    $product_names = old('product_name', !empty($brokenDaysBill) ? $brokenDaysBill->BrokenDaysBillDetails->pluck('product_name') : []);
                                    $quantities = old('quantity', !empty($brokenDaysBill) ? $brokenDaysBill->BrokenDaysBillDetails->pluck('quantity') : []);
                                    $units = old('unit', !empty($brokenDaysBill) ? $brokenDaysBill->BrokenDaysBillDetails->pluck('unit') : []);
                                    $unit_prices = old('unit_price', !empty($brokenDaysBill) ? $brokenDaysBill->BrokenDaysBillDetails->pluck('unit_price') : []);
                                    $vats = old('vat', !empty($brokenDaysBill) ? $brokenDaysBill->BrokenDaysBillDetails->pluck('vat') : []);
                                    $total_prices = old('total_price', !empty($brokenDaysBill) ? $brokenDaysBill->BrokenDaysBillDetails->pluck('total_price') : []);
                                    $total_amounts = old('total_amount', !empty($brokenDaysBill) ? $brokenDaysBill->BrokenDaysBillDetails->pluck('total_amount') : []);
                                    $net_total_amount=0;
                                    $payable_amount=0;
                                @endphp

                                @foreach ($product_names as $key => $product_name)
                                    <tr>
                                        <td>
                                            <input name="product_name[]" class="form-control product_name" readonly
                                                   autocomplete="off"
                                                   type="text" value="{{ $product_name }}" readonly>
                                            <input name="product_id[]" class="form-control product_id" readonly
                                                   autocomplete="off"
                                                   type="hidden" value="{{ $product_ids[$key] }}">
                                        </td>
                                        <td>
                                            <input name="quantity[]" class="form-control quantity" autocomplete="off"
                                                   type="text"
                                                   value="{{ $quantities[$key] }}">
                                        </td>
                                        <td>
                                            <input name="unit[]" class="form-control unit" autocomplete="off"
                                                   type="text"
                                                   value="{{ $units[$key] }}" readonly>
                                        </td>
                                        <td>
                                            <input name="unit_price[]" class="form-control unit_price"
                                                   autocomplete="off" type="text"
                                                   value="{{ $unit_prices[$key] }}" readonly>
                                        </td>
                                        <td>
                                            <input name="total_price[]" class="form-control total_price"
                                                   autocomplete="off" type="text"
                                                   value="{{ $total_prices[$key] }}" readonly>
                                        </td>
                                        <td>
                                            <input name="vat[]" class="form-control vat" autocomplete="off" type="text"
                                                   value="{{ $vats[$key] }}" readonly>
                                        </td>
                                        <td>
                                            <input name="total_amount[]" class="form-control total_amount"
                                                   autocomplete="off" type="text"
                                                   value="{{ $total_amounts[$key] }}" readonly>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="6" class="text-right">Net Total Amount</td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="net_total_amount" class="form-control"
                                                   id="net_total_amount" autocomplete="off"
                                                   placeholder="Net Total Amount" readonly
                                                   value="{{$net_total_amount}}">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="text-right">Payable Amount</td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="payable_amount" class="form-control"
                                                   id="payable_amount" autocomplete="off" placeholder="Payable Amount"
                                                   readonly value="{{$payable_amount}}">
                                        </div>
                                    </td>
                                </tr>
                                </tfoot>
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
                    <script src="{{ asset('js/get-fr-product.js') }}"></script>
                    <script src="{{ asset('js/get-fr-bill-date.js') }}"></script>
                    <script src="{{ asset('js/get-client.js') }}"></script>
@endsection
