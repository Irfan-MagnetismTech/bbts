@extends('layouts.backend-layout')
@section('title', 'ERR')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of ERR
@endsection


@section('breadcrumb-button')
    <a href="{{ route('errs.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($popEquipments) }}
    <x-warning-paragraph name="ERR" />
@endsection

@section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>POP Name</th>
                    <th>Material</th>
                    <th>IP</th>
                    <th>Subnet Mask</th>
                    <th> Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($popEquipments as $key => $popEquipment)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $popEquipment->err_no }}</strong></td>
                        <td>{{ $popEquipment->type }}</td>
                        <td>{{ $popEquipment->date }}</td>
                        <td>{{ $popEquipment->purpose }}</td>
                        <td>{{ $popEquipment->inactive_date }}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ route('errs.show', $err->id) }}" data-toggle="tooltip" title="Show"
                                        class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                    @if (!$scmMur->isDeleteable())
                                        <a href="{{ route('errs.edit', $err->id) }}" data-toggle="tooltip" title="Edit"
                                            class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                        {!! Form::open([
                                            'url' => route('errs.destroy', $err->id),
                                            'method' => 'delete',
                                            'class' => 'd-inline',
                                            'data-toggle' => 'tooltip',
                                            'title' => 'Delete',
                                        ]) !!}
                                        {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete']) }}
                                        {!! Form::close() !!}
                                    @endif
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
