@extends('layouts.backend-layout')
@section('title', 'Active Clients Report')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    Active Clients Report
@endsection

@section('style')
    <style>
    </style>
@endsection

@section('content')
    <form
        action="{{ url("scm/scm-material-stock-report") }}"
        method="get" class="custom-form">
        @csrf
{{--        <div class="form-group col-3" style="display: flex">--}}
{{--            <div>--}}
{{--                <label for="branch">Warehouse:</label>--}}
{{--                <select name="branch_id" class="form-control branch select2" autocomplete="off">--}}
{{--                    <option value="">Select Branch</option>--}}
{{--                    @foreach ($branches as $branch)--}}
{{--                        <option value="{{ $branch->id }}" @selected($branch->id == $branch_id)>--}}
{{--                            {{ $branch->name }}--}}
{{--                        </option>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
{{--            </div>--}}
{{--            <div class="icon-btn" style="margin: 30px">--}}
{{--                <button data-toggle="tooltip" title="Search" class="btn btn-outline-primary"><i--}}
{{--                        class="fas fa-search"></i></button>--}}
{{--            </div>--}}
{{--        </div>--}}

        <div class="dt-responsive table-responsive">
            <table id="dataTable" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Client</th>
                    <th>Connectivity Point</th>
                    <th>Commission Date</th>
                    <th>Products</th>
                </tr>
                </thead>
                <tbody>
                @foreach($activations as $activationKey => $activation)
                            <tr>
                                <td>{{ $activation->client->client_name ?? ''}}</td>

                                <td>{{ $activation->frDetails->connectivity_point ?? ''}} ({{$activation->frDetails->fr_no ?? ''}})</td>

                                <td>{{ $activation->connectivities->commissioning_date ?? '' }}</td>

                                <td>
{{--                                        @foreach ($activation->connectivities->saleProductDetails as $product)--}}
{{--                                            {{ $product->product_name ?? '' }}--}}
{{--                                            @unless($loop->last)--}}
{{--                                                ,--}}
{{--                                            @endunless--}}
{{--                                        @endforeach--}}

                                    @foreach ($products as $product)
                                        {{ $product ?? '' }}
                                        @unless($loop->last)
                                            ,
                                        @endunless
                                    @endforeach
                                </td>
                            </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </form>
@endsection

