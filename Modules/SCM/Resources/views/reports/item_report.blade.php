@extends('layouts.backend-layout')
@section('title', 'Item Report')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    Item Report
@endsection

@section('style')
    <style>
    </style>
@endsection

@section('content')
    <form
        action="{{ url("scm/scm-item-report") }}"
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
                <select name="branch_id" class="form-control branch select2" autocomplete="off">
                    <option value="">Select Branch</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}" @selected($branch->id == $branch_id)>
                            {{ $branch->name }}
                        </option>
                    @endforeach
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
                    <th>Material</th>
                    <th>Unit</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Rate</th>
                    <th>Serial Code</th>
                </tr>
                </thead>
                <tbody>
                @foreach($stocks as $key => $material)
                    <tr>
                        <td>{{ $material['name'] }}</td>

                        <td>{{ $material['unit'] }}</td>

                        <td>{{ $material['brand'] }}</td>
                        @if($material['model'] == null || $material['model'] == 'null')
                            <td></td>
                        @else
                            <td>{{ $material['model'] }}</td>
                        @endif
                        @if($material['type'] === 'Modules\SCM\Entities\OpeningStock')
                            <td>OS</td>
                        @elseif($material['type'] === 'Modules\SCM\Entities\ScmMrr')
                            <td>MRR</td>
                        @elseif($material['type'] === 'Modules\SCM\Entities\ScmMir')
                            @if($material['quantity'] < 0)
                                <td>MIR</td>
                            @else
                                <td>Transfer</td>
                            @endif
                        @elseif($material['type'] === 'Modules\SCM\Entities\ScmMur')
                            <td>MUR</td>
                        @elseif($material['type'] === 'Modules\SCM\Entities\ScmErr')
                            <td>ERR</td>
                        @elseif($material['type'] === 'Modules\SCM\Entities\ScmWor')
                            <td>WOR</td>
                        @elseif($material['type'] === 'Modules\SCM\Entities\ScmWcr')
                            <td>WCR</td>
                        @elseif($material['type'] === 'Modules\SCM\Entities\ScmWcrr')
                            <td>WCRR</td>
                        @elseif($material['type'] === 'Modules\SCM\Entities\ScmChallan')
                            <td>CHALLAN</td>
                        @endif
                        <td>{{ $material['quantity'] }}</td>
                        <td>{{ $material['rate'] }}</td>
                        <td>{{ $material['serial'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </form>
@endsection

