@extends('layouts.backend-layout')
@section('title', 'Opening Stock Details')

@section('breadcrumb-title')
    Opening Stock Details
@endsection

@section('breadcrumb-button')
    <a href="{{ route('opening-stocks.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection

@section('content-grid', null)

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered">
                    <tbody class="text-left">
                        <tr>
                            <td> <strong>Date</strong> </td>
                            <td> {{ $openingStock->date }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Material Name</th>
                    <th>Unit</th>
                    <th>Quantity</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($openingStock->lines as $key => $detail)
                    <tr>
                        <td> {{ $detail->material->name }} </td>
                        <td> {{ $detail->material->unit }} </td>
                        <td> {{ $detail->quantity }} </td>
                        <td> {{ $detail->brand->name }} </td>
                        <td> {{ $detail->model }} </td>
                        <td> {{ $detail->total_amount }} </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
