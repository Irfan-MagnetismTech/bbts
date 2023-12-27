@extends('layouts.backend-layout')
@section('title', 'Challan Show')

@section('breadcrumb-title')
    Challan Show
@endsection

@section('breadcrumb-button')
    <a href="{{ route('challans.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('content-grid', null)

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered">
                    <tbody class="text-left">
                        <tr style="background-color: #0C4A77;color: white">
                            <td> <strong>Challan No.</strong> </td>
                            <td> <strong>{{ $challan->challan_no }}</strong></td>
                        </tr>
                        <tr>
                            <td> <strong>Type</strong> </td>
                            <td> {{ ucfirst($challan->type) }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Date</strong> </td>
                            <td> {{ $challan->date }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Requisition No</strong> </td>
                            <td> {{ $challan->scmRequisition->mrs_no }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Purpose</strong> </td>
                            <td> {{ $challan->purpose }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Client</strong> </td>
                            <td> {{ $challan?->client?->client_name ?? '' }}</td>
                        </tr>
                        <tr>
                            <td> <strong>FR No</strong> </td>
                            <td> {{ $challan->fr_no }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Link No</strong> </td>
                            <td> {{ $challan->link_no }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Branch No</strong> </td>
                            <td> {{ $challan?->branch?->name ?? '' }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Equipment Type</strong> </td>
                            <td> {{ $challan->equipment_type }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Pop No</strong> </td>
                            <td> {{ $challan?->pop?->name ?? '' }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Challan By</strong> </td>
                            <td> {{ ucfirst($challan->challanBy->name) }}</td>
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
                    <th>Item Code</th>
                    <th>Unit</th>
                    <th>Quantity</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Serial Code</th>
                    <th>Purpose</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($challan->mur))
                    @foreach ($challanLines as $key => $scmChallanLine)
                        <tr>
                            <td> {{ $scmChallanLine['material_name'] }} </td>
                            <td> {{ $scmChallanLine['code'] }} </td>
                            <td> {{ $scmChallanLine['unit'] }} </td>
                            <td> {{ $scmChallanLine['quantity'] }} </td>
                            <td> {{ $scmChallanLine['brand_name'] }} </td>
                            <td> {{ $scmChallanLine['model'] }} </td>
                            <td> {{ $scmChallanLine['serial_code'] }} </td>
                            <td> {{ $scmChallanLine['purpose'] }} </td>
                            <td> {{ $scmChallanLine['remarks'] }} </td>
                        </tr>
                    @endforeach
                @else
                    @foreach ($challan->scmChallanLines as $key => $scmChallanLine)
                        <tr>
                            <td> {{ $scmChallanLine->material->name }} </td>
                            <td> {{ $scmChallanLine->item_code }} </td>
                            <td> {{ $scmChallanLine->material->unit }} </td>
                            <td> {{ $scmChallanLine->quantity }}</td>
                            <td> {{ $scmChallanLine->brand->name }} </td>
                            <td> {{ $scmChallanLine->model }} </td>
                            <td> {{ $scmChallanLine->serial_code }} </td>
                            <td> {{ $scmChallanLine->purpose }} </td>
                            <td> {{ $scmChallanLine->remarks }} </td>
                        </tr>
                    @endforeach

                @endif
            </tbody>
        </table>
    </div>
@endsection
