@extends('layouts.backend-layout')
@section('title', 'Material')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Material
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('materials.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-plus"></i></a>
@endsection
@section('sub-title')
    Total: {{ count($materials) }}
@endsection


@section('content')
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>Name</th>
                    <th>Unit</th>
                    <th>Type</th>
                    <th>Code</th>
                    <th>Brands</th>
                    <th>Min Quantity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#SL</th>
                    <th>Name</th>
                    <th>Unit</th>
                    <th>Type</th>
                    <th>Code</th>
                    <th>Brands</th>
                    <th>Min Quantity</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($materials as $key => $material)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="text-center">{{ $material->name ?? '' }}</td>
                        <td class="text-center">{{ $material->unit ?? '' }}</td>
                        <td class="text-center">{{ $material->type ?? '' }}</td>
                        <td class="text-center">{{ $material->code ?? '' }}</td>
                        <td class="text-center">
                            @if (!empty($material->material_brand))
                                @foreach ($material->material_brand as $brand)
                                    {{ $brand->brands->name ?? '' }}
                                    {{-- You can add a separator if needed, e.g., comma --}}
                                    @unless($loop->last)
                                        ,
                                    @endunless
                                @endforeach
                            @endif
                        </td>

                        <td class="text-center">{{ $material->min_qty ?? '' }}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ route('materials.edit', $material->id) }}" data-toggle="tooltip"
                                        title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    <form action="{{ url("scm/materials/$material->id") }}" method="POST"
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
@endsection
