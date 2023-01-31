@extends('layouts.backend-layout')
@section('title', 'Branch')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Branch Info
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('branchs.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-plus"></i></a>
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
                    <th>Name</th>
                    <th>Division</th>
                    <th>District</th>
                    <th>Thana</th>
                    <th>Location</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#SL</th>
                    <th>Name</th>
                    <th>Division</th>
                    <th>District</th>
                    <th>Thana</th>
                    <th>Location</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($branchs as $key => $branch)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="text-center">{{ $branch->name }}</td>
                        <td class="text-center">{{ $branch->division->name }}</td>
                        <td class="text-center">{{ $branch->district->name }}</td>
                        <td class="text-center">{{ $branch->thana->name }}</td> 
                        <td class="text-center">{{ $branch->location }}</td> 
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ route('branchs.edit', $branch->id) }}" data-toggle="tooltip" title="Edit"
                                        class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    <form action="{{ url("admin/branchs/$branch->id") }}" method="POST"
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
    <script src="{{ asset('js/Datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/Datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(window).scroll(function() {
            //set scroll position in session storage
            sessionStorage.scrollPos = $(window).scrollTop();
        });
        var init = function() {
            //get scroll position in session storage
            $(window).scrollTop(sessionStorage.scrollPos || 0)
        };
        window.onload = init;

        $(document).ready(function() {
            $('#dataTable').DataTable({
                stateSave: true
            });
        });
    </script>
@endsection
