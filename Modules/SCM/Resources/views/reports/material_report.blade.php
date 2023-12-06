@extends('layouts.backend-layout')
@section('title', 'Material Stock Report')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    Material Stock Report
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
                    <th>Material Name</th>
                    <th>Unit</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Quantity</th>
                </tr>
                </thead>
                <tbody>
                @foreach($groupedStocks as $materialName => $brandStocks)
                    @foreach($brandStocks as $brandId => $modelStocks)
                        @foreach($modelStocks as $model => $material)
                            <tr>
                                {{--                                @if ($loop->first)--}}
                                {{--                                    <td rowspan="{{ count($modelStocks) }}">{{ $material['name'] }}</td>--}}
                                {{--                                @endif--}}
                                {{--                                @if ($loop->first)--}}
                                {{--                                    <td rowspan="{{ count($modelStocks) }}">{{ $material['unit'] }}</td>--}}
                                {{--                                @endif--}}
                                {{--                                <td>{{ $material['brand'] }}</td>--}}
                                {{--                                @if($material['model'] == null || $material['model'] == 'null')--}}
                                {{--                                    <td></td>--}}
                                {{--                                @else--}}
                                {{--                                    <td>{{ $material['model'] }}</td>--}}
                                {{--                                @endif--}}
                                {{--                                <td>{{ $material['quantity'] }}</td>--}}

                                <td>{{ $material['name'] }}</td>

                                <td>{{ $material['unit'] }}</td>

                                <td>{{ $material['brand'] }}</td>
                                @if($material['model'] == null || $material['model'] == 'null')
                                    <td></td>
                                @else
                                    <td>{{ $material['model'] }}</td>
                                @endif
                                <td>{{ $material['quantity'] }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                @endforeach
                </tbody>
            </table>
        </div>
    </form>
@endsection

