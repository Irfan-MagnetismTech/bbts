@extends('layouts.backend-layout')
@section('title', 'Connectivity Requirement')


@section('breadcrumb-title')
    Connectivity Requirement
@endsection

@section('breadcrumb-button')
    <a href="{{ route('connectivity-requirement.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-list"></i></a>
@endsection
@section('style')
    <style>
        .input-group-addon {
            width: 115px !important;
        }
    </style>
@endsection
@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="tableHeading">
                    <h5> <span> &#10070; </span> Connectivity Requirement <span>&#10070;</span> </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @php
                            if (!empty($connectivity_requirement)) {
                                $category_data = $connectivity_requirement->connectivityProductRequirementDetails->pluck('category_id')->toArray();
                                $product_id = $connectivity_requirement->connectivityProductRequirementDetails->pluck('product_id')->toArray();
                                $capacity = $connectivity_requirement->connectivityProductRequirementDetails->pluck('capacity')->toArray();
                                $link_type = $connectivity_requirement->connectivityRequirementDetails->pluck('link_type')->toArray();
                                $connectivity_capacity = $connectivity_requirement->connectivityRequirementDetails->pluck('connectivity_capacity')->toArray();
                                $method = $connectivity_requirement->connectivityRequirementDetails->pluck('method')->toArray();
                                $uptime_req = $connectivity_requirement->connectivityRequirementDetails->pluck('sla')->toArray();
                            }
                            
                            $client_name = $connectivity_requirement->lead_generation->client_name;
                            $client_no = $connectivity_requirement->lead_generation->client_no;
                            $date = $connectivity_requirement->date ?? null;
                            $mq_no = $connectivity_requirement->mq_no;
                            $category_data = $category_data ?? [];
                            $aggregation_type = $connectivity_requirement->aggregation_type ?? null;
                            $from_location = $connectivity_requirement->fromLocation->fr_no ?? null;
                            $connectivity_point = $connectivity_requirement->fromLocation->connectivity_point ?? null;
                            $fr_no = $connectivity_requirement->fr_no;
                            $product_id = $product_id ?? null;
                            $capacity = $capacity ?? null;
                            $unit = $connectivity_requirement->product_unit ?? null;
                            $link_type = $link_type ?? null;
                            $connectivity_capacity = $connectivity_capacity ?? null;
                            $method = $method ?? null;
                            $uptime_req = $uptime_req ?? null;
                            $product_select = $connectivity_requirement->product_select ?? null;
                        @endphp
                    </div>
                    <div class="row">
                        <div class="md-col-4 col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="fr_id">Client ID</label>
                                <span class="form-control">{{ $client_no }}</span>
                            </div>
                        </div>
                        <div class="md-col-4 col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="fr_id">Client Name</label>
                                <span class="form-control">{{ $client_name }}</span>
                            </div>
                        </div>
                        <div class="md-col-4 col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="fr_id">Date</label>
                                <span class="form-control">{{ $date }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="md-col-4 col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="fr_id">From Location</label>
                                <span class="form-control">{{ $from_location }}</span>
                            </div>
                        </div>
                        <div class="md-col-4 col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="fr_id">Aggregation Type</label>
                                <span class="form-control">{{ $aggregation_type }}</span>
                            </div>
                        </div>
                        <div class="md-col-4 col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="fr_id">Connectivity Point</label>
                                <span class="form-control">{{ $connectivity_point }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="md-col-4 col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="fr_id">FR No</label>
                                <span class="form-control">{{ $fr_no }}</span>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="text-center">
                        <h5> <span> &#10070; </span> Connectivity Details <span>&#10070;</span> </h5>
                    </div>
                    <hr />
                    {{-- create a responsive table --}}
                    <div class="row">
                        <div class="md-col-6 col-6">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th colspan="5">Product Details</th>
                                        </tr>
                                        <tr>
                                            <th>Category</th>
                                            <th>Product</th>
                                            <th>Capacity</th>
                                            <th>Unit</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody class="productBody">
                                        @foreach ($connectivity_requirement->connectivityProductRequirementDetails as $connectivityProductRequirementDetail)
                                            <tr class="product_details_row">
                                                <td>
                                                    <span>
                                                        {{ $connectivityProductRequirementDetail->category->name }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        {{ $connectivityProductRequirementDetail->product->name }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        {{ $connectivityProductRequirementDetail->capacity }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        {{ $connectivityProductRequirementDetail->product->unit }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        {{ $connectivityProductRequirementDetail->remarks ?? '' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="md-col-6 col-6">
                            {{-- Connectivity Details --}}
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th colspan="5">Connectivity Details</th>
                                        </tr>
                                        <tr>
                                            <th>Link Type</th>
                                            <th>Method</th>
                                            <th>Capacity %</th>
                                            <th>Uptime Reg/SLA</th>
                                            <th>Vendor</th>
                                        </tr>
                                    </thead>
                                    <tbody class="connectivityBody">
                                        @foreach ($connectivity_requirement->connectivityRequirementDetails as $connectivityRequirementDetail)
                                            <tr class="connectivity_details_row">
                                                <td>
                                                    <span>
                                                        {{ $connectivityRequirementDetail->link_type }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        {{ $connectivityRequirementDetail->method }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        {{ $connectivityRequirementDetail->connectivity_capacity }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        {{ $connectivityRequirementDetail->sla }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        {{ $connectivityRequirementDetail->vendor->name ?? '' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
