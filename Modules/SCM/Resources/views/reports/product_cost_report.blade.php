@extends('layouts.backend-layout')
@section('title', 'Product Cost Report')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    Product Cost Report
@endsection

@section('style')
    <style>
    </style>
@endsection

@section('content')
    <form
        action="{{ url("scm/product-cost-report") }}"
        method="get" class="custom-form">
        @csrf
        <div style="display: flex">
            <div style="width: 100px">
                <select name="type" class="form-control type select2" autocomplete="off">
                    <option value="list">List</option>
                    <option value="pdf">PDF</option>
                </select>
            </div>
            <div style="width: 200px; margin-left: 20px">
                <select name="client_no" class="form-control client select2" autocomplete="off">
                    <option value="">Select Client</option>
                    @if($client_no != null)
                        @foreach ($clients as $client)
                            <option value="{{ $client->client_no }}" @selected($client->client_no == $client_no)>
                                {{ $client->client_name }}
                            </option>
                        @endforeach
                    @else
                        @foreach ($clients as $client)
                            <option value="{{ $client->client_no }}">
                                {{ $client->client_name }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div style="width: 200px; margin-left: 20px">
                <select name="material_id" class="form-control material select2" autocomplete="off">
                    <option value="">Select Material</option>
                    @foreach ($materials as $material)
                        <option value="{{ $material->id }}" @selected($material->id == $material_id)>
                            {{ $material->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="icon-btn" style="margin-left: 30px; margin-top: 5px">
                <button data-toggle="tooltip" title="Search" class="btn btn-outline-primary"><i
                        class="fas fa-search"></i></button>
            </div>
        </div>

        <div class="dt-responsive table-responsive" style="margin-top: 10px">
            <table id="dataTable" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Client</th>
                    <th>Item Code</th>
                    <th>Material</th>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Rate</th>
                    <th>Total Price</th>
                    <th>Serial Code</th>
                    <th>Challan No</th>
                    <th>Challan Date</th>
                    <th>Product Ownership</th>
                    <th>Total Cost of Product<br>for this Client</th>
                    <th>Total Cost of Product<br>for this Client (BBTS Ownership)</th>
                    <th>Total Cost of Product<br>for this Client (Client Ownership)</th>
                    <th>Remarks</th>
                </tr>
                </thead>
                <tbody>
                @php $prevConnectivityPoint = null; @endphp
                @foreach($stocks as $key => $material)
                    @if($prevConnectivityPoint !== $material['connectivity_point'])
                        <tr>
                            <td>{{ $material['client'] }}</td>
                            <td>{{ $material['item_code'] }}</td>
                            <td>{{ $material['name'] }}</td>
                            <td>{{ $material['quantity'] }}</td>
                            <td>{{ $material['unit'] }}</td>
                            <td>{{ $material['rate'] }}</td>
                            <td>{{ $material['total_price'] }}</td>
                            <td>{{ $material['serial'] }}</td>
                            <td>{{ $material['challan_no'] }}</td>
                            <td>{{ $material['challan_date'] }}</td>
                            <td></td>
                            <td rowspan="{{ $material['row_span'] }}">{{ $material['total_product_cost'] }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @php $prevConnectivityPoint = $material['connectivity_point']; @endphp
                    @else
                        <tr>
                            <td>{{ $material['client'] }}</td>
                            <td>{{ $material['item_code'] }}</td>
                            <td>{{ $material['name'] }}</td>
                            <td>{{ $material['quantity'] }}</td>
                            <td>{{ $material['unit'] }}</td>
                            <td>{{ $material['rate'] }}</td>
                            <td>{{ $material['total_price'] }}</td>
                            <td>{{ $material['serial'] }}</td>
                            <td>{{ $material['challan_no'] }}</td>
                            <td>{{ $material['challan_date'] }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </form>
@endsection
