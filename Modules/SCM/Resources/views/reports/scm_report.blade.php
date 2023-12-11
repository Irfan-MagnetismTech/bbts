@extends('layouts.backend-layout')
@section('title', 'SCM Report')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    SCM Report
@endsection

@section('style')
    <style>
    </style>
@endsection

@section('content')
    <form
        action="{{ url("scm/scm-report") }}"
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
                {{--                <label for="branch">Warehouse:</label>--}}
                <select name="branch_id" class="form-control branch select2" autocomplete="off">
                    <option value="">Select Branch</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}" @selected($branch->id == $branch_id)>
                            {{ $branch->name }}
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
                    <th>Material</th>
                    <th>Unit</th>
                    <th>Opening Stock</th>
                    <th>MRR</th>
                    <th>MIR</th>
                    <th>MUR</th>
                    <th>ERR</th>
                    <th>Transfer</th>
                    <th>Damage</th>
                    <th>Warranty</th>
                    <th>Grand Total</th>
                </tr>
                </thead>
                <tbody>
                @foreach($groupedStocks as $key => $stocks)
                    <tr>
                        <td>{{ $stocks['material_id'] }}</td>
                        <td>{{ $stocks['unit'] }}</td>
                        <td>{{ $stocks['opening_stock_qty'] }}</td>
                        <td>{{ $stocks['scm_mrr_qty'] }}</td>
                        <td>{{ $stocks['scm_mir_qty'] }}</td>
                        <td>{{ $stocks['scm_mur_qty'] }}</td>
                        <td>{{ $stocks['scm_err_qty'] }}</td>
                        <td>{{ $stocks['transfer_qty'] }}</td>
                        <td></td>
                        <td></td>
                        <td><b>{{ $stocks['total'] }}</b></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </form>
@endsection

