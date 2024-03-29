@extends('layouts.backend-layout')
@section('title', 'WCRR Show')

@section('breadcrumb-title')
    WCRR Show
@endsection

@section('breadcrumb-button')
    <a href="{{ route('requisitions.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection

@section('content-grid', null)

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered">
                    <tbody class="text-left">
                        <tr style="background-color: #0C4A77;color: white">
                            <td> <strong>WCRR No.</strong> </td>
                            <td> <strong>{{ $warranty_claims_receife->wcrr_no }}</strong></td>
                        </tr>
                        <tr>
                            <td> <strong>WCR No</strong> </td>
                            <td> {{ ucfirst($warranty_claims_receife->wcr->wcr_no) }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Date</strong> </td>
                            <td> {{ ucfirst($warranty_claims_receife->date) }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Branch</strong> </td>
                            <td> {{ ucfirst($warranty_claims_receife->branch->name) }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Date</strong> </td>
                            <td> {{ $warranty_claims_receife->date }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Created By</strong> </td>
                            <td> {{ ucfirst($warranty_claims_receife->createdBy->name) }}</td>
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
                    <th>Description</th>
                    <th>Unit</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Item Code</th>
                    <th>Serial Code</th>
                    <th>Material Type</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($warranty_claims_receife->lines as $key => $line)
                    <tr>
                        <td> {{ $line->material->name }} </td>
                        <td> {{ $line->description }} </td>
                        <td> {{ $line->material->unit }} </td>
                        <td> {{ $line->brand->name }} </td>
                        <td> {{ $line->model }} </td>
                        <td> {{ $line->item_code }} </td>
                        <td> {{ $line->serial_code }} </td>
                        <td> {{ $line->material_type }} </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
