@extends('layouts.backend-layout')
@section('title', 'MRR Show')

@section('breadcrumb-title')
    MRR Show
@endsection

@section('breadcrumb-button')
    <a href="{{ route('material-receives.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i
    class="fa fa-plus"></i></a>
@endsection

@section('content-grid', null)

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered">
                    <tbody class="text-left">
                        <tr style="background-color: #0C4A77;color: white">
                            <td> <strong>MIR No.</strong> </td>
                            <td> <strong>{{ $material_issue->mir_no }}</strong></td>
                        </tr>
                        <tr>
                            <td> <strong>Date</strong> </td>
                            <td> {{ $material_issue->date }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Courier Serial No</strong> </td>
                            <td> {{ $material_issue->courier_serial_no }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Challan Date</strong> </td>

                            <td>{{ $material_issue->challan_date }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Created By</strong> </td>
                            <td> {{ $material_issue->createdBy->name }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Requisition No</strong> </td>
                            <td> {{ $material_issue->scmRequisition->mrs_no }}</td>
                        </tr>
                        <tr>
                            <td> <strong>From Branch</strong> </td>
                            <td> {{ $material_issue->fromBranch->name }}</td>
                        </tr>
                        <tr>
                            <td> <strong>To Branch</strong> </td>
                            <td> {{ $material_issue->toBranch->name }}</td>
                        </tr>
                        <tr>
                            <td> <strong>POP</strong> </td>
                            <td> {{ $material_issue->pop->name }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Courier</strong> </td>
                            <td> {{ $material_issue->courier->name }}</td>
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
                    <th>Serial Code</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @php($total = 0)
                @foreach ($material_issue->lines as $line)
                    <tr>
                        <td> {{ $loop->iteration }}</td>
                        <td>{{ $line->material->name ?? '---' }}</td>
                        <td>{{ $line->serial_code ?? '---' }}</td>
                        <td>{{ $line->brand->name ?? '---' }}</td>
                        <td>{{ $line->model ?? '---' }}</td>
                        <td>{{ $line->description ?? null }}</td>
                        <td> {{ $line->quantity }}</td>
                        <td> {{ $line->remarks }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
