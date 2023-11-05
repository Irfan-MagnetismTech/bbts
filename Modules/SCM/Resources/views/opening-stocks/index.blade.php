@extends('layouts.backend-layout')
@section('title', 'Opening Stock')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Opening Stock
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('opening-stocks.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-plus"></i></a>
@endsection
@section('sub-title')
    Total: {{ count($openingStocks) }}
@endsection


@section('content')
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>#SL</th>
                <th>ID</th>
                <th>Date</th>
                <th>Branch</th>
                <th> Material Name</th>
                <th> Unit</th>
                <th> Brand</th>
                <th> Model</th>
                <th>Serial Code</th>
                <th> Unit Price</th>
                <th> Quantity</th>
                <th> Amount</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>#SL</th>
                <th>ID</th>
                <th>Date</th>
                <th>Branch</th>
                <th> Material Name</th>
                <th> Unit</th>
                <th> Brand</th>
                <th> Model</th>
                <th>Serial Code</th>
                <th> Unit Price</th>
                <th> Quantity</th>
                <th> Amount</th>
                <th>Action</th>
            </tr>
            </tfoot>
            <tbody>
                @php($i=1);
            @foreach ($openingStocks as $key => $openingStock)
                @foreach ($openingStock->lines as $key => $data)
                    <tr>
                        {{-- @if ($loop->first) --}}
                            {{-- <td rowspan="{{ count($openingStock->lines) }}">{{ $loop->parent->iteration }}</td> --}}
                            <td rowspan="">{{ $i++ }}</td>
                        {{-- @endif --}}
                        <td class="text-center">{{ $openingStock->id }}</td>
                        <td class="text-center">{{ $openingStock->date }}</td>
                        <td class="text-center">{{ $openingStock->branch->name ?? ''}}</td>
                        <td class="text-center">{{ $data->material->name }}</td>
                        <td class="text-center">{{ $data->material->unit }}</td>
                        <td class="text-center">{{ $data->brand->name }}</td>
                        <td class="text-center">{{ $data->model }}</td>
                        <td>{{ $data->serialCodeLines->first()->serial_or_drum_code ?? '' }}</td>
                        <td class="text-center">{{ $data->unit_price }}</td>
                        <td class="text-center">{{ $data->quantity }}</td>
                        <td class="text-center">{{ $data->total_amount }}</td>
                        {{-- @if ($loop->first) --}}
                            {{-- <td rowspan="{{ count($openingStock->lines) }}"> --}}
                            <td rowspan="">
                                <div class="icon-btn">
                                    <nobr>
                                        <a href="{{ url("scm/opening-stocks/$openingStock->id") }}"
                                           data-toggle="tooltip"
                                           title="Details" class="btn btn-outline-primary"><i
                                                class="fas fa-eye"></i></a>

                                        <a href="{{ route('opening-stocks.edit', $openingStock->id) }}"
                                           data-toggle="tooltip"
                                           title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>

                                        <form action="{{ url("scm/opening-stocks/$openingStock->id") }}" method="POST"
                                              data-toggle="tooltip" title="Delete" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm delete"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    </nobr>
                                </div>
                            </td>
                        {{-- @endif --}}
                    </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script>
    </script>
@endsection
