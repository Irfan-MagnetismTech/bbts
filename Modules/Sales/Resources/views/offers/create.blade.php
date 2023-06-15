@extends('layouts.backend-layout')
@section('title', 'Offer')

@php
    $is_old = old('client_no') ? true : false;
    $form_heading = !empty($feasibility_requirement->id) ? 'Update' : 'Add';
    $form_url = !empty($feasibility_requirement->id) ? route('feasibility-requirement.update', $feasibility_requirement->id) : route('feasibility-requirement.store');
    $form_method = !empty($feasibility_requirement->id) ? 'PUT' : 'POST';
@endphp

@section('breadcrumb-title')
    {{ ucfirst($form_heading) }} Offer
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

    {!! Form::open([
        'url' => $form_url,
        'method' => $form_method,
        'encType' => 'multipart/form-data',
        'class' => 'custom-form',
    ]) !!}

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="tableHeading">
                    <h5> <span> &#10070; </span> Offer <span>&#10070;</span> </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @php
                            $client_name = $is_old ? old('client_name') : $feasibility_requirement->lead_generation->client_name ?? null;
                            $client_no = $is_old ? old('client_no') : $feasibility_requirement->client_no ?? null;
                            $is_existing = $is_old ? old('is_existing') : $feasibility_requirement->is_existing ?? null;
                            $date = $is_old ? old('date') : $feasibility_requirement->date ?? today()->format('d-m-Y');
                            $offer_validity = $is_old ? old('offer_validity') : $feasibility_requirement->offer_validity ?? today()->format('d-m-Y');
                        @endphp
                        <div class="col-md-3 col-3">
                            <select class="form-control bankList" name="client_no" id="client_no" required>
                                <option value="">Select Client No</option>
                                @foreach ($client_no_list as $client)
                                    <option value="{{ $client }}" {{ $client == $client_no ? 'selected' : '' }}>
                                        {{ $client }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 col-3">
                            <select class="form-control" name="mq_no" id="mq_no" required>
                                <option value="">Select MQ No</option>
                            </select>
                        </div>
                        <x-input-box colGrid="3" name="client_name" value="{{ $client_name }}" label="Client Name" />
                        <x-input-box colGrid="3" name="offer_validity" class="date" value="{{ $offer_validity }}"
                            label="Offer Validity" />

                        <div class="row">
                            <div class="col-md-12">
                                <div class="tableHeading">
                                    <h5> <span> &#10070; </span> FR-1 <span>&#10070;</span> </h5>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <th>Select</th>
                                            <th>Link Type</th>
                                            <th>Existing/New</th>
                                            <th>Method</th>
                                            <th>Vendor</th>
                                            <th>BBTS/POP/LDP</th>
                                            <th>Distance</th>
                                            <th>Client <br> Equipment</th>
                                            <th>OTC</th>
                                            <th>Mo <br> Cost</th>
                                            <th>Offer <br> OTC</th>
                                            <th>Total <br> OTC</th>
                                            <th>Offer <br> MRC</th>
                                        </thead>
                                        <tbody>
                                            <tr class="offer_details_row">
                                                <td>
                                                    <div class="checkbox-fade fade-in-primary"
                                                        style="margin-top: 6px;margin-left: 5px;margin-right: 0px;">
                                                        <label>
                                                            <input type="checkbox" name="device[]" value="Router"
                                                                class="form-control">
                                                            <span class="cr">
                                                                <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="link_type[]" class="form-control"
                                                            id="link_type" readonly>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="existing_or_new[]" class="form-control"
                                                            id="existingOrNew" readonly>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="method[]" class="form-control"
                                                            id="method" readonly>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="vendor[]" class="form-control"
                                                            id="vendor" readonly>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="bbts_or_pop_or_ldp[]"
                                                            class="form-control" id="bbtsOrPopOrLdp" readonly>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="distance[]" class="form-control"
                                                            id="distance" readonly>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="client_equipment[]" class="form-control"
                                                            id="client_equipment" readonly>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="otc[]" class="form-control"
                                                            id="otc" readonly>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="mo_cost[]" class="form-control"
                                                            id="mo_cost" readonly>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="offer_otc[]" class="form-control"
                                                            id="offer_otc">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="total_cost[]" class="form-control"
                                                            id="total_cost" readonly>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="offer_mrc[]" class="form-control"
                                                            id="offer_mrc">
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>

                                        <tr>
                                            <td colspan="7" style="text-align: right;">Link wise Total</td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="total_mrc" class="form-control"
                                                        id="total_mrc" readonly>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="total_mrc" class="form-control"
                                                        id="total_mrc" readonly>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="total_mrc" class="form-control"
                                                        id="total_mrc" readonly>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="total_mrc" class="form-control"
                                                        id="total_mrc" readonly>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="total_mrc" class="form-control"
                                                        id="total_mrc" readonly>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="total_mrc" class="form-control"
                                                        id="total_mrc" readonly>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="7" style="text-align: right;">Product Equipment</td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="total_mrc" class="form-control"
                                                        id="total_mrc" readonly>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="total_mrc" class="form-control"
                                                        id="total_mrc" readonly>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="total_mrc" class="form-control"
                                                        id="total_mrc" readonly>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="total_mrc" class="form-control"
                                                        id="total_mrc" readonly>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="total_mrc" class="form-control"
                                                        id="total_mrc" readonly>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="total_mrc" class="form-control"
                                                        id="total_mrc" readonly>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="7" style="text-align: right;">Product Price</td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="total_mrc" class="form-control"
                                                        id="total_mrc" readonly>
                                                </div>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="total_mrc" class="form-control"
                                                        id="total_mrc" readonly>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="7" style="text-align: right;">Management Cost</td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="total_mrc" class="form-control"
                                                        id="total_mrc" readonly>
                                                </div>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="total_mrc" class="form-control"
                                                        id="total_mrc" readonly>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="7" style="text-align: right;">Total Price</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="total_mrc" class="form-control"
                                                        id="total_mrc" readonly>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <button class="py-2 btn btn-success">
                                    {{ !empty($lead_generation->id) ? 'Update' : 'Save' }}
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

@endsection
@section('script')
    @include('sales::offers.js')
@endsection
