@extends('layouts.backend-layout')
@section('title', 'Indent Show')

@section('breadcrumb-title')
    Indent Show
@endsection

@section('breadcrumb-button')
    <a href="{{ route('indents.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('content-grid', null)

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered">
                    <tbody class="text-left">
                        <tr style="background-color: #0C4A77;color: white">
                            <td> <strong>Indent No.</strong> </td>
                            <td> <strong>{{ $indent->indent_no }}</strong></td>
                        </tr>
                        <tr>
                            <td> <strong>Date</strong> </td>
                            <td> {{ $indent->date }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Created By</strong> </td>
                            <td> {{ ucfirst($indent->user->name ?? '') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table id="example" class="table table-bordered">
            <thead>
                <tr>
                    <th>PRS</th>
                    <th>Material Name</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($indent->indentLines as $key => $value)
                    <tr class="text-left">
                        <td> {{ $value->scmPurchaseRequisition->prs_no }} </td>
                    </tr>
                    @foreach ($value->scmPurchaseRequisition->scmPurchaseRequisitionDetails as $key => $scmPurchaseRequisitionDetail)
                        <tr class="text-left">
                            <td></td>
                            <td> {{ $scmPurchaseRequisitionDetail->material->name }} </td>
                            <td> {{ $scmPurchaseRequisitionDetail->quantity }} </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
