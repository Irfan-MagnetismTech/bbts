@extends('layouts.backend-layout')
@section('title', 'Connectivity Requirement')


@section('breadcrumb-title')
    Connectivity Requirement
@endsection

@section('breadcrumb-button')
    <a href="{{ route('connectivity-requirement.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-list"></i></a>

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
                            
                            $client_name = $connectivity_requirement->lead_generation->client_name ?? $fr_detail->feasibilityRequirement->lead_generation->client_name;
                            $client_id = $connectivity_requirement->lead_generation->client_id ?? $fr_detail->feasibilityRequirement->lead_generation->client_id;
                            $date = $connectivity_requirement->date ?? null;
                            $mq_no = $connectivity_requirement->mq_no ?? $fr_detail->feasibilityRequirement->mq_no;
                            $category_data = $category_data ?? [];
                            $aggregation_type = $connectivity_requirement->aggregation_type ?? null;
                            $from_location = $connectivity_requirement->fromLocation->fr_no ?? null;
                            $link_name = $connectivity_requirement->fromLocation->link_name ?? $fr_detail->link_name;
                            $fr_no = $connectivity_requirement->fr_no ?? $fr_detail->fr_no;
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
                        <div class="md-col-3 col-3">
                            <label for="client_id">Client ID <span class="text-danger">*</span></label>
                            <span class="form-control">{{ $client_id }}</span>
                        </div>
                        <div class="md-col-3 col-3">
                            <label for="client_name">Client Name <span class="text-danger">*</span></label>
                            <span class="form-control">{{ $client_name }}</span>
                        </div>
                        <div class="md-col-3 col-3">
                            <label for="date">Date <span class="text-danger">*</span></label>
                            <span class="form-control">{{ $date }}</span>
                        </div>
                        <div class="md-col-3 col-3">
                            <label for="from_location">From Location <span class="text-danger">*</span></label>
                            <span class="form-control">{{ $from_location }}</span>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="md-col-3 col-3">
                            <label for="aggregation_type">Aggregation Type <span class="text-danger">*</span></label>
                            <span class="form-control">{{ $aggregation_type }}</span>
                        </div>
                        <div class="md-col-3 col-3">
                            <label for="link_name">Link Name <span class="text-danger">*</span></label>
                            <span class="form-control">{{ $link_name }}</span>
                        </div>
                        <div class="md-col-3 col-3">
                            <label for="fr_no">FR No <span class="text-danger">*</span></label>
                            <span class="form-control">{{ $fr_no }}</span>
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
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th colspan="5">Product Details</th>
                                        </tr>
                                        <tr>
                                            <th>Category</th>
                                            <th>Product</th>
                                            <th>Capacity</th>
                                            <th>Unit</th>
                                        </tr>
                                    </thead>
                                    <tbody class="productBody">
                                        @foreach ($connectivity_requirement->connectivityProductRequirementDetails as $connectivityProductRequirementDetail)
                                            <tr class="product_details_row">
                                                <td>
                                                    <span class="form-control">
                                                        {{ $connectivityProductRequirementDetail->category->name }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="form-control">
                                                        {{ $connectivityProductRequirementDetail->product->name }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="form-control">
                                                        {{ $connectivityProductRequirementDetail->capacity }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="form-control">
                                                        {{ $connectivityProductRequirementDetail->product->unit }}
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
                                        </tr>
                                    </thead>
                                    <tbody class="connectivityBody">
                                        @foreach ($connectivity_requirement->connectivityRequirementDetails as $connectivityRequirementDetail)
                                            <tr class="connectivity_details_row">
                                                <td>
                                                    <span class="form-control">
                                                        {{ $connectivityRequirementDetail->link_type }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="form-control">
                                                        {{ $connectivityRequirementDetail->method }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="form-control">
                                                        {{ $connectivityRequirementDetail->connectivity_capacity }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="form-control">
                                                        {{ $connectivityRequirementDetail->sla }}
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