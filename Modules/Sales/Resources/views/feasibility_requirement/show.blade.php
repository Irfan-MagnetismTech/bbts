@extends('layouts.backend-layout')
@section('title', 'Feasibility Requirement Details')

@php
    $is_old = old('client_id') ? true : false;
    $form_heading = !empty($feasibility_requirement->id) ? 'Update' : 'Add';
    $form_url = !empty($feasibility_requirement->id) ? route('feasibility-requirement.update', $feasibility_requirement->id) : route('feasibility-requirement.store');
    $form_method = !empty($feasibility_requirement->id) ? 'PUT' : 'POST';
@endphp

@section('breadcrumb-title')
    {{ ucfirst($form_heading) }} Feasibility Requirement Details
@endsection

@section('breadcrumb-button')
    <a href="{{ route('feasibility-requirement.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')



    {{-- Comparative Statement --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="tableHeading">
                    <h5> <span> &#10070; </span> Feasibility Requirement <span>&#10070;</span> </h5>
                </div>
                <div class="card-body">
                    <div class="row">

                        {{-- exiting or new radio button --}}
                        <div class="col-xl-3 col-md-3">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="client_id">Status<span
                                        class="text-danger">*</span></label>
                                <span class="form-control">{{ $feasibility_requirement->is_existing }}</span>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-3">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="client_id">Client ID<span
                                        class="text-danger">*</span></label>
                                <span class="form-control">{{ $feasibility_requirement->client_id }}</span>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-3">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="client_name">Client Name<span
                                        class="text-danger">*</span></label>
                                <span
                                    class="form-control">{{ $feasibility_requirement->lead_generation->client_name }}</span>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-3">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="client_type">Date<span
                                        class="text-danger">*</span></label>
                                <span class="form-control">{{ $feasibility_requirement->date }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- create a responsive table --}}
                    <hr />
                    <div class="text-center">
                        <h5> <span> &#10070; </span> Feasibility Requirement Details <span>&#10070;</span> </h5>
                    </div>
                    <hr />
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th rowspan="2">FR No</th>
                                    <th rowspan="2">Name of the Link</th>
                                    <th colspan="5">Connectivity Address</th>
                                    <th colspan="5">Local Contact Details</th>
                                </tr>
                                <tr>
                                    <th>Division</th>
                                    <th>District</th>
                                    <th>Thana</th>
                                    <th>Location</th>
                                    <th>LatLong</th>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th>Con. No.</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($feasibility_requirement))
                                    @foreach ($feasibility_requirement->feasibilityRequirementDetails as $item)
                                        <tr class="feasibility_details_row">
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <span class="form-control">{{ $item->fr_no }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <span class="form-control">{{ $item->link_name }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <span class="form-control">{{ $item->division->name }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <span class="form-control">{{ $item->district->name }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <span class="form-control">{{ $item->thana->name }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <span class="form-control">{{ $item->location }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <span class="form-control">{{ $item->lat_long }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <span class="form-control">{{ $item->contact_name }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <span class="form-control">{{ $item->contact_designation }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <span class="form-control">{{ $item->contact_number }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <span class="form-control">{{ $item->contact_email }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                @if (!empty($item->survey))
                                                    <div class="input-group input-group-sm input-group-success">
                                                        <a href="{{ route('add-planning', $item->id) }}"
                                                            class="btn btn-sm btn-success">Add Planning</a>
                                                    </div>
                                                @elseif (!empty($item->connectivityRequirement))
                                                    <div class="input-group input-group-sm input-group-success">
                                                        <a href="{{ route('add-survey', $item->id) }}"
                                                            class="btn btn-sm btn-success">Add Survey</a>
                                                    </div>
                                                @else
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <a href="{{ route('connectivity-requirement-add', $item->id) }}"
                                                            class="btn btn-sm btn-success">Add Req</a>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endsection
