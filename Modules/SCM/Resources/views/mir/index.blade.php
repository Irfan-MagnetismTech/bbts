@extends('layouts.backend-layout')
@section('title', 'Material Issue Report')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Material Issue Report
@endsection


@section('breadcrumb-button')
    <a href="{{ route('material-issues.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i
            class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($mirs) }}
    <x-warning-paragraph name="MIR" />
@endsection

@section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>#MIR No.</th>
                    <th>#MRS No.</th>
                    <th>Courier Code</th>
                    <th>From Branch</th>
                    <th>To Branch</th>
                    <th>Appiled Date</th>
                    <th>Submitted By</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>#MIR No.</th>
                    <th>#MRS No.</th>
                    <th>Courier Code</th>
                    <th>From Branch</th>
                    <th>To Branch</th>
                    <th>Appiled Date</th>
                    <th>Submitted By</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($mirs as $key => $mir)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $mir->mir_no }}</td>
                        <td>{{ $mir->scmRequisition->mrs_no }}</td>
                        <td>{{ $mir?->courier?->name }}</td>
                        <td>{{ $mir->fromBranch->name }}</td>
                        <td>{{ $mir->toBranch->name }}</td>
                        <td>{{ $mir->date }}</td>
                        <td>{{ $mir->createdBy->name }}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ route('material-issues.show', $mir->id) }}" data-toggle="tooltip"
                                        title="Show" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>

                                @if (!$mir->isDeleteable())
                                    <a href="{{ route('material-issues.edit', $mir->id) }}" data-toggle="tooltip"
                                        title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    {!! Form::open([
                                        'url' => route('material-issues.destroy', $mir->id),
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
    </script>
@endsection
