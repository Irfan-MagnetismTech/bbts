@extends('layouts.backend-layout')
@section('title', 'Material-Utilization')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Material Utilization
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')

@endsection
@section('sub-title')
    Total: {{ count($scmMurs) }}
    <x-warning-paragraph name="MUR" />
@endsection


@section('content')
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>Type</th>
                    <th>Purpose</th>
                    <th>Date</th>
                    <th>Mur No</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#SL</th>
                    <th>Type</th>
                    <th>Purpose</th>
                    <th>Date</th>
                    <th>Mur No</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($scmMurs as $key => $scmMur)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="text-center">{{ $scmMur->type }}</td>
                        <td class="text-center">{{ $scmMur->purpose }}</td>
                        <td class="text-center">{{ $scmMur->date }}</td>
                        <td class="text-center">{{ $scmMur->mur_no }}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ url("scm/material-utilizations/$scmMur->id") }}" data-toggle="tooltip"
                                        title="Details" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>

                                    @if (!$scmMur->isDeleteable())
                                        <a href="{{ route('material-utilizations.edit', $scmMur->id) }}"
                                            data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i
                                                class="fas fa-pen"></i></a>

                                        <form action="{{ url("scm/material-utilizations/$scmMur->id") }}" method="POST"
                                            data-toggle="tooltip" title="Delete" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm delete"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
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
    <script></script>
@endsection
