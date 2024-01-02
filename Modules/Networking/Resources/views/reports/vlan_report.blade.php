@extends('layouts.backend-layout')
@section('title', 'VLAN Report')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    VLAN Information
@endsection

@section('content')
    <form
        action="{{ url("networking/vlan-report") }}"
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
                <input type="text" class="form-control" name="vlan_address" placeholder="VLAN Address"
                       value="{{ $vlan_address }}">
            </div>
            <div class="icon-btn" style="margin-left: 30px; margin-top: 5px">
                <button data-toggle="tooltip" title="Search" class="btn btn-outline-primary"><i
                        class="fas fa-search"></i></button>
            </div>
        </div>
        <div class="dt-responsive table-responsive" style="margin-top: 20px">
            <table id="dataTable" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Sl No</th>
                    <th>Description</th>
                    <th>Vlan ID</th>
                    <th>Zone Name</th>
                    <th>Remarks</th>
                </tr>
                </thead>
                <tbody>
                @php($i=1)
                @foreach($logical_connectivities as $key => $connectivity)
                    @foreach($connectivity->lines as $subKey => $value)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{ $value->product_category ?? ''}}</td>
                            <td>{{ $value->vlan ?? ''}}</td>
                            <td>{{$connectivity->feasibilityRequirementDetails->branch->name ?? ''}}</td>
                            <td>{{ $value->remarks ?? ''}}</td>
                        </tr>
                    @endforeach
                @endforeach
                </tbody>
            </table>
        </div>
    </form>
@endsection

