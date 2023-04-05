@extends('layouts.backend-layout')
@section('title', 'Requisition')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Requisition Info
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('requisitions.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-plus"></i></a>
@endsection
@section('sub-title')
    Total: {{ count($requisitions) }}
@endsection


@section('content')
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>MRS No</th>
                    <th>Type</th>
                    <th>Requisition By</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#SL</th>
                    <th>MRS No</th>
                    <th>Type</th>
                    <th>Requisition By</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($requisitions as $key => $requisition)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="text-center">{{ $requisition->mrs_no }}</td>
                        <td class="text-center">{{ ucfirst($requisition->type) }}</td>
                        <td class="text-center">{{ ucfirst($requisition->requisitionBy->name) }}</td>
                        <td class="text-center">{{ $requisition->date }}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ url("scm/requisitions/$requisition->id") }}" data-toggle="tooltip"
                                        title="Details" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>

                                    <a href="{{ route('requisitions.edit', $requisition->id) }}" data-toggle="tooltip"
                                        title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>

                                    <form action="{{ url("scm/requisitions/$requisition->id") }}" method="POST"
                                        data-toggle="tooltip" title="Delete" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm delete"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
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
