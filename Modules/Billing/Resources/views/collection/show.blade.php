@extends('layouts.backend-layout')
@section('title', 'Collection Show')
@php
    $is_old = old('client_no') ? true : false;
    // $form_heading = !empty($collection->id) ? 'Update' : 'Add';
    // $form_url = !empty($collection->id) ? route('collections.update', $collection->id) : route('collections.store');
    // $form_method = !empty($collection->id) ? 'PUT' : 'POST';
@endphp

@section('breadcrumb-title')
    Collection Show
@endsection

@section('breadcrumb-button')
    <a href="{{ route('collections.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection

@section('content-grid', null)

@section('content')
    <div class="row">
        @php
            $grand_total = $is_old ? old('grand_total') : $collection->grand_total ?? null;
            $total_bill_amount = $is_old ? old('total_bill_amount') : $collection->total_bill_amount ?? null;
            $total_previous_due = $is_old ? old('total_previous_due') : $collection->total_previous_due ?? null;
        @endphp
        <div class="col-lg-12">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered">
                    <tbody class="text-left">
                        <tr style="background-color: #0C4A77;color: white">
                            <td> <strong>Client Name</strong> </td>
                            <td> <strong>{{ $collection->client->client_name }}</strong></td>
                        </tr>
                        <tr>
                            <td> <strong>Client No</strong> </td>
                            <td> {{ $collection->client_no }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Date</strong> </td>
                            <td> {{ $collection->date }}</td>
                        </tr>
                        <tr>
                            <td> <strong>MR No</strong> </td>

                            <td>{{ $collection->mr_no }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Remarks</strong> </td>
                            <td> {{ $collection->remarks }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <hr>
        <table id="example" class="table table-striped table-bordered">
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
                </tr>
            </thead>
            <tbody>
                @foreach ($collection->lines as $item)
                    <tr class="payment_details_row">
                        <td>{{ strtoupper($item->payment_method) }}</td>
                        <td>{{ $item->bank_name }}</td>
                        <td>{{ $item->instrument_no }}</td>
                        <td>{{ $item->instrument_date }}</td>
                        <td>{{ $item->amount }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-right"> Total Amount </td>
                    <td class="text-center">{{ $grand_total }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="table-responsive">
        <hr>
        <table id="example" class="table table-striped table-bordered">
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
                </tr>
            </thead>
            <tbody>
                @foreach ($collection->collectionBills as $item)
                    <tr class="bill_details_row">
                        <td>{{ $item->bill_no }}</td>
                        <td>{{ $item->amount }}</td>
                        <td>{{ $item->previous_due }}</td>
                        <td>{{ $item->discount }}</td>
                        <td>{{ $item->penalty }}</td>
                        <td>{{ $item->net_amount }}</td>
                        <td>{{ $item->vat }}</td>
                        <td>{{ $item->tax }}</td>
                        <td>{{ $item->receive_amount }}</td>
                        <td>{{ $item->total }}</td>
                        <td>{{ $item->due }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="1" class="text-right">Total</td>
                    <td class="text-center">{{ $total_bill_amount }}</td>
                    <td class="text-center">{{ $total_previous_due }}</td>
                    <td colspan="2" class="text-right"></td>
                    <td class="text-center">{{ $collection->total_net_amount }}</td>
                    <td class="text-center">{{ $collection->total_vat }}</td>
                    <td class="text-center">{{ $collection->total_tax }}</td>
                    <td class="text-center">{{ $collection->total_receive_amount }}</td>
                    <td class="text-center">{{ $collection->grand_total }}</td>
                    <td class="text-center">{{ $collection->total_due }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection
