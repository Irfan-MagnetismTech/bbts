@extends('layouts.backend-layout')
@section('title', 'Supplier')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Supplier
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('suppliers.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-plus"></i></a>
@endsection
@section('sub-title')
    Total: {{ count($suppliers) }}
@endsection

@section('content')
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>Name</th>
{{--                    <th>Category</th>--}}
                    <th>Contact Person</th>
                    <th>Email</th>
                    <th>Address-1</th>
                    <th>Address-2</th>
                    <th>Bin No</th>
                    <th>Tin No</th>
                    <th>Mobile No</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#SL</th>
                    <th>Name</th>
{{--                    <th>Category</th>--}}
                    <th>Contact Person</th>
                    <th>Email</th>
                    <th>Address-1</th>
                    <th>Address-2</th>
                    <th>Bin No</th>
                    <th>Tin No</th>
                    <th>Mobile No</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($suppliers as $key => $supplier)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="text-center">{{ $supplier->name }}</td>
{{--                        <td class="text-center">{{ $supplier->category->name ?? ''}}</td>--}}
                        <td class="text-center">{{ $supplier->contact_person ?? '' }}</td>
                        <td class="text-center">{{ $supplier->email }}</td>
                        <td class="text-center">{{ $supplier->address_1 }}</td>
                        <td class="text-center">{{ $supplier->address_2}}</td>
                        <td class="text-center">{{ $supplier->bin_no}}</td>
                        <td class="text-center">{{ $supplier->tin_no}}</td>
                        <td class="text-center">{{ $supplier->mobile_no}}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ route('suppliers.edit', $supplier->id) }}" data-toggle="tooltip"
                                        title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    <form action="{{ url("scm/suppliers/$supplier->id") }}" method="POST"
                                        data-toggle="tooltip" title="Delete" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm delete"><i class="fas fa-trash"></i></button>
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
