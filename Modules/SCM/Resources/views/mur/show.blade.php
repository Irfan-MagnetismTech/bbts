@extends('layouts.backend-layout')
@section('title', 'MUR Show')

@section('breadcrumb-title')
    MUR Show
@endsection

@section('breadcrumb-button')
    <a href="{{ route('material-utilizations.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
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
                            <td> <strong>MUR No.</strong> </td>
                            <td> <strong>{{ $material_utilization->mur_no }}</strong></td>
                        </tr>
                        <tr>
                            <td> <strong>Type</strong> </td>
                            <td> {{ ucfirst($material_utilization->type) }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Challan No</strong> </td>
                            <td> {{ ucfirst($material_utilization->challan->challan_no) }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Purpose</strong> </td>
                            <td> {{ $material_utilization->purpose }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Client Name</strong> </td>
                            <td> {{ $material_utilization?->client?->client_name ?? '' }}</td>
                        </tr>
                        <tr>
                            <td> <strong>FR No</strong> </td>
                            <td> {{ $material_utilization->fr_no }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Link No</strong> </td>
                            <td> {{ $material_utilization->link_no }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Equipment Type</strong> </td>
                            <td> {{ $material_utilization->equipment_type }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Branch</strong> </td>
                            <td> {{ $material_utilization->branch->name }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Pop</strong> </td>
                            <td> {{ $material_utilization?->pop?->name ?? '' }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Date</strong> </td>
                            <td> {{ $material_utilization->date }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Created By</strong> </td>
                            <td> {{ ucfirst($material_utilization->createdBy->name) }}</td>
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
                    <th>Quantity</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Serial Code</th>
                    <th>Utilized Quantity</th>
                    <th>BBTS Ownership</th>
                    <th>Client Ownership</th>
                    <th>Purpose</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($material_utilization->lines as $key => $line)
                    <tr>
                        <td> {{ $line->material->name }} </td>
                        <td> {{ $line->description }} </td>
                        <td> {{ $line->material->unit }} </td>
                        <td> {{ $line->quantity }} </td>
                        <td> {{ $line->brand->name }} </td>
                        <td> {{ $line->model }} </td>
                        <td> {{ $line->serial_code }} </td>
                        <td> {{ $line->utilized_quantity }} </td>
                        <td> {{ $line->bbts_ownership }} </td>
                        <td> {{ $line->client_ownership }} </td>
                        <td> {{ $line->purpose }} </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="col-md-2 offset-5">
            @if (
                $material_utilization->is_approved == 'Pending' &&
                    auth()->user()->can('MUR-Approval'))
                {{-- @can('MUR-Approval') --}}
                <a class="btn btn-outline-info" href="{{ route('mur-approval', $material_utilization->id) }}" title="Approved By "
                    style="transition: 0.5s"> Approval</a>
                {{-- @endcan --}}
            @elseif($material_utilization->is_approved != 'Pending')
                <a class="btn  btn-secondary" href="#"
                    title="Approved By {{ $material_utilization->approvedBy?->name }}" style="transition: 0.5s">
                    Approved</a>
            @else
                <a class="btn  btn-success" style="transition: 0.5s">{{ $material_utilization->is_approved }} </a>
            @endif
        </div>
    </div>
@endsection
