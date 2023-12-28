@extends('layouts.backend-layout')
@section('title', 'Internal Feedbacks')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Internal Feedbacks
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('internal-feedbacks.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-plus"></i></a>
@endsection
@section('sub-title')
    {{-- Total: {{ @count($branchs) }} --}}
@endsection

@section('content')
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>Client No</th>
                    <th>Client Name</th>
                    <th>Date</th>
                    <th>Remarks</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#SL</th>
                    <th>Client No</th>
                    <th>Client Name</th>
                    <th>Date</th>
                    <th>Remarks</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($feedbacks as $key => $value)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $value->client->client_no }}</td>
                        <td class="text-center">{{ $value->client->client_name }}</td>
                        <td class="text-center">{{ $value->date }}</td>
                        <td class="text-center">{{ $value->remarks }}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
{{--                                    <a href="{{ route('gate-pass-pdf', $gate_pass->id) }}" data-toggle="tooltip" title="PDF" class="btn btn-outline-primary"><i class="fas fa-file-pdf"></i></a>--}}
{{--                                    <a href="{{ route('gate-passes.show', $gate_pass->id) }}" data-toggle="tooltip"--}}
{{--                                       title="Show" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>--}}
                                    <a href="{{ route('internal-feedbacks.edit', $value->id) }}" data-toggle="tooltip" title="Edit"
                                       class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    <form action="{{ route('internal-feedbacks.destroy',$value->id) }}" method="POST" data-toggle="tooltip"
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
@endsection
