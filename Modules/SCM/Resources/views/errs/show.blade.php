@extends('layouts.backend-layout')
@section('title', 'ERR Show')

@section('breadcrumb-title')
    ERR Show
@endsection

@section('breadcrumb-button')
    <a href="{{ route('errs.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('content-grid', null)

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered">
                    <tbody class="text-left">
                        <tr style="background-color: #0C4A77;color: white">
                            <td> <strong>ERR No.</strong> </td>
                            <td> <strong>{{ $err->err_no }}</strong></td>
                        </tr>
                        <tr>
                            <td> <strong>Type</strong> </td>
                            <td> {{ $err->type }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Date</strong> </td>
                            <td> {{ $err->date }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Client Name</strong> </td>
                            <td>{{ $err->client->name }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Purpose</strong> </td>
                            <td> {{ $err->purpose }}</td>
                        </tr>
                        <tr>
                            <td> <strong>FR No</strong> </td>
                            <td> {{ $err->fr_no }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Link No</strong> </td>
                            <td> {{ $err->link_no }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Inactive Date</strong> </td>
                            <td> {{ $err->inactive_date }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Equipment Type</strong> </td>
                            <td> {{ $err->equipment_type }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Assigned Person</strong> </td>
                            <td> {{ $err->assigned_person }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Created By</strong> </td>
                            <td> {{ $err->createdBy->name }}</td>
                        </tr>
                        <tr>
                            <td> <strong>POP</strong> </td>
                            <td> {{ $err?->pop?->name ?? ''}}</td>
                        </tr>
                        <tr>
                            <td> <strong>Branch</strong> </td>
                            <td> {{ $err->branch->name }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Remarks</strong> </td>
                            <td> {{ $err->remarks }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <h6 class="text-center">Material Details</h6>
        <table id="example" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL.No</th>
                    <th>Material</th>
                    <th>Description</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Item Code</th>
                    <th>Serial Code</th>
                    <th>BBTS Ownership</th>
                    <th>Client Ownership</th>
                    <th>BBTS Damaged</th>
                    <th>Client Damaged</th>
                    <th>BBTS Useable</th>
                    <th>Client Useable</th>
                    <th>Utilized Quantity</th>
                    <th>Quantity</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($err->scmErrLines as $line)
                    <tr>
                        <td> {{ $loop->iteration }}</td>
                        <td>{{ $line->material->name ?? '---' }}</td>
                        <td>{{ $line->description ?? '---' }}</td>
                        <td>{{ $line->brand->name ?? '---' }}</td>
                        <td>{{ $line->model ?? '---' }}</td>
                        <td>{{ $line->item_code ?? null }}</td>
                        <td>{{ $line->serial_code ?? null }}</td>
                        <td>{{ $line->bbts_ownership ?? null }}</td>
                        <td>{{ $line->client_ownership ?? null }}</td>
                        <td>{{ $line->bbts_damaged ?? null }}</td>
                        <td>{{ $line->client_damaged ?? null }}</td>
                        <td>{{ $line->bbts_useable ?? null }}</td>
                        <td>{{ $line->client_useable ?? null }}</td>
                        <td>{{ $line->utilized_quantity ?? null }}</td>
                        <td> {{ $line->quantity }}</td>
                        <td> {{ $line->remarks }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
