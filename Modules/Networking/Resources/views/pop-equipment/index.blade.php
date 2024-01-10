@extends('layouts.backend-layout')
@section('title', 'POP Wise Equipment')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of POP Wise Equipment
@endsection


@section('breadcrumb-button')
    <a href="{{ route('pop-equipments.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($popEquipments) }}
@endsection

@section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>POP/Office Name</th>
                    <th>Type</th>
                    <th>Material</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Serial Code</th>
                    <th>Qty</th>
                    <th>Capacity</th>
                    <th>Ports</th>
                    <th>Tower Type</th>
                    <th>Tower Height (Ft)</th>
                    <th>Installation Date</th>
                    <th>Maintenance Date</th>
                    <th>Made By</th>
                    <th>Status</th>
                    <th>Remarks</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($popEquipments as $key => $popEquipment)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $popEquipment->pop->name ?? ''}}</strong></td>
                        <td>{{ $popEquipment->equipment_type ?? ''}}</td>
                        <td>{{ $popEquipment->material->name ?? ''}}</td>
                        <td>{{ $popEquipment->brand ?? ''}}</td>
                        <td>{{ $popEquipment->model ?? ''}}</td>
                        <td>{{ $popEquipment->serial_code ?? ''}}</td>
                        <td>{{ $popEquipment->quantity ?? ''}}</td>
                        <td>{{ $popEquipment->capacity ?? ''}}</td>
                        <td>{{ $popEquipment->port_no ?? ''}}</td>
                        <td>{{ $popEquipment->tower_type ?? ''}}</td>
                        <td>{{ $popEquipment->tower_height ?? ''}}</td>
                        <td>{{ $popEquipment->installation_date ?? ''}}</td>
                        <td>{{ $popEquipment->maintenance_date ?? ''}}</td>
                        <td>{{ $popEquipment->made_by ?? ''}}</td>
                        <td>{{ $popEquipment->status ?? ''}}</td>
                        <td>{{ $popEquipment->remarks ?? ''}}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ route('pop-equipments.show', $popEquipment->id) }}" data-toggle="tooltip" title="Show"
                                        class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('pop-equipments.edit', $popEquipment->id) }}" data-toggle="tooltip" title="Edit"
                                        class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    {!! Form::open([
                                        'url' => route('pop-equipments.destroy', $popEquipment->id),
                                        'method' => 'delete',
                                        'class' => 'd-inline',
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Delete',
                                    ]) !!}
                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete']) }}
                                    {!! Form::close() !!}
                                </nobr>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {});
    </script>
@endsection
