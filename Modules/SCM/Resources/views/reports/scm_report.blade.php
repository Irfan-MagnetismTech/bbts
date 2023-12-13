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
            <div style="width: 150px; margin-left: 20px">
                <input class="form-control" id="from_date" name="from_date" aria-describedby="from_date"
                       value="{{ $from_date }}" readonly
                       placeholder="From Date">
            </div>
            <div style="width: 150px; margin-left: 20px">
                <input class="form-control" id="to_date" name="to_date" aria-describedby="to_date"
                       value="{{ $to_date }}" readonly
                       placeholder="To Date">
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
                @if($from_date == null && $to_date == null)
                    @foreach($groupedStocks as $key => $stock)
                        <tr>
                            <td>{{ $stock['material_id'] }}</td>
                            <td>{{ $stock['unit'] }}</td>
                            <td>{{ $stock['opening_stock_qty'] }}</td>
                            <td>{{ $stock['scm_mrr_qty'] }}</td>
                            <td>{{ $stock['scm_mir_qty'] }}</td>
                            <td>{{ $stock['scm_mur_qty'] }}</td>
                            <td>{{ $stock['scm_err_qty'] }}</td>
                            <td>{{ $stock['transfer_qty'] }}</td>
                            <td></td>
                            <td></td>
                            <td><b>{{ $stock['total'] }}</b></td>
                        </tr>
                    @endforeach
                @else
                    @foreach($groupedStocks as $key => $stock)
                        @foreach($openingStocks as $openingKey => $openingStock)
                            @if($stock['material_id'] === $openingStock['material_id'])
                            <tr>
                                <td>{{ $stock['material_id'] }}</td>
                                <td>{{ $stock['unit'] }}</td>
                                <td>{{ $openingStock['opening_stock_qty'] }}</td>
                                <td>{{ $stock['scm_mrr_qty'] }}</td>
                                <td>{{ $stock['scm_mir_qty'] }}</td>
                                <td>{{ $stock['scm_mur_qty'] }}</td>
                                <td>{{ $stock['scm_err_qty'] }}</td>
                                <td>{{ $stock['transfer_qty'] }}</td>
                                <td></td>
                                <td></td>
                                <td><b>{{ $stock['total'] }}</b></td>
                            </tr>
                            @endif
                        @endforeach
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </form>
@endsection

@section('script')
    <script>
        if ($('#from_date').val() != null) {
            $('#from_date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            });
        } else {
            $('#from_date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            }).datepicker("setDate", new Date());
        }

        if ($('#to_date').val() != null) {
            $('#to_date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            });
        } else {
            $('#to_date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            }).datepicker("setDate", new Date());
        }
    </script>
@endsection

