@extends('layouts.backend-layout')
@section('title', 'Indent')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Indent
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('indents.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-plus"></i></a>
@endsection
@section('sub-title')
    Total: {{ count($indents) }}
@endsection

@section('content')
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>Indent No.</th>
                    <th>Date</th>
                    <th>PRS No</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#SL</th>
                    <th>Indent No.</th>
                    <th>Date</th>
                    <th>PRS No</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($indents as $key => $indent)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="text-center">{{ $indent->indent_no }}</td>
                        <td class="text-center">{{ $indent->date }}</td>
                        <td class="text-center">
                            @foreach ($indent->indentLines as $line)
                                <p>{{ $line->scmPurchaseRequisition->prs_no }}</p>
                            @endforeach
                        </td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ route("indent-pdf", $indent->id) }}" data-toggle="tooltip" title="PDF" class="btn btn-outline-primary"><i class="fas fa-file-pdf"></i></a>
                                    <a href="{{ route('indents.show', $indent->id) }}" data-toggle="tooltip"
                                        title="Show" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('indents.edit', $indent->id) }}" data-toggle="tooltip" title="Edit"
                                        class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    <form action="{{ url("scm/indents/$indent->id") }}" method="POST" data-toggle="tooltip"
                                        title="Delete" class="d-inline">
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
        $(document).ready(function() {
        });
    </script>
@endsection
