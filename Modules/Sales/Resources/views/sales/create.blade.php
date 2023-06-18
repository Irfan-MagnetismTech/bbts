@extends('layouts.backend-layout')
@section('title', 'Sales')

@php
    $is_old = old('client_no') ? true : false;
    $form_heading = !empty($feasibility_requirement->id) ? 'Update' : 'Add';
    $form_url = !empty($feasibility_requirement->id) ? route('sales.update', $feasibility_requirement->id) : route('sales.store');
    $form_method = !empty($feasibility_requirement->id) ? 'PUT' : 'POST';
@endphp

@section('breadcrumb-title')
    {{ ucfirst($form_heading) }} Sales
@endsection

@section('breadcrumb-button')
    <a href="{{ route('sales.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
<style>
/* #calculation_table.table-bordered td, .table-bordered th{
    border: 1px solid gainsboro!important;
} */
#dv{
    background-color: #f6f9f9!important;
    color: #191818!important;
    height: 100vh!important;
}
</style>

    {!! Form::open([
        'url' => $form_url,
        'method' => $form_method,
        'encType' => 'multipart/form-data',
        'class' => 'custom-form',
    ]) !!}

    <div class="row pt-5" id="dv">
        <div class="col-md-12">
            <div class="card">
                <div class="tableHeading">
                    <h5> <span> &#10070; </span> Sales <span>&#10070;</span> </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @php
                            $client_name = $is_old ? old('client_name') : $feasibility_requirement->client_name ?? null;
                            $client_no = $is_old ? old('client_no') : $feasibility_requirement->client_no ?? null;
                            $effective_date = $is_old ? old('effective_date') : $feasibility_requirement->effective_date ?? today()->format('d-m-Y');
                            $account_holder = $is_old ? old('account_holder') : $feasibility_requirement->account_holder ?? null;
                            $offer_id = $is_old ? old('offer_id') : $feasibility_requirement->offer_id ?? null;
                            $remarks = $is_old ? old('remarks') : $feasibility_requirement->remarks ?? null;
                            $mq_id = $is_old ? old('mq_id') : $feasibility_requirement->mq_id ?? null;
                            $contract_duration = $is_old ? old('contract_duration') : $feasibility_requirement->contract_duration ?? null;
                            $work_order = $is_old ? old('work_order') : $feasibility_requirement->work_order ?? null;
                            $sla = $is_old ? old('sla') : $feasibility_requirement->sla ?? null;
                            $wo_no = $is_old ? old('wo_no') : $feasibility_requirement->wo_no ?? null;
                        @endphp
                        <x-input-box colGrid="4" name="client_no" value="{{ $client_no }}" label="Client Id" />
                        <x-input-box colGrid="4" name="client_name" value="{{ $client_name }}" label="Client Name" />
                        <x-input-box colGrid="4" name="account_holder" value="{{ $account_holder }}" label="Account Holder" />
                        <x-input-box colGrid="4" name="offer_id" value="{{ $offer_id }}" label="Offer Id" />
                        <x-input-box colGrid="4" name="remarks" value="{{ $remarks }}" label="Remarks" />
                        <x-input-box colGrid="4" name="mq_id" value="{{ $mq_id }}" label="MQ Id" />
                        <x-input-box colGrid="4" name="contract_duration" value="{{ $contract_duration }}" label="Contract Duration" />
                        <x-input-box colGrid="4" name="effective_date" class="date" value="{{ $effective_date }}" label="Effective Date" />
                        <x-input-box colGrid="4" name="work_order" value="{{ $work_order }}" label="Work Order" />
                        <x-input-box colGrid="4" name="sla" value="{{ $sla }}" label="SLA" />
                        <x-input-box colGrid="4" name="wo_no" value="{{ $wo_no }}" label="WO No" />

                        
                    </div>
                </div>
            </div>
            <div class="card">
                
                <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <th>FR</th>
                                            <th>Link Info</th>
                                            <th>Delvery Date</th>
                                            <th>Offer OTC</th>
                                            <th>Offer MRC</th>
                                            <th>Billing Information</th>
                                            <th>Collection Information</th>
                                            <th>Prepaid / Postpaid</th>
                                            <th>Bill Payment Date</th>
                                            <th>Remarks</th>
                                        </thead>
                                        <tbody>
                                            <tr class="offer_details_row">
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
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label" for="bbts">
                                                            <input type="radio" class="form-check-input link_from" id="bbts" name="link_from"
                                                                value="bbts" @checked(@$link_from == 'bbts' || ($form_method == 'POST' && !old()))>
                                                            BBTS
                                                        </label>
                                                    </div>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label" for="vendor">
                                                            <input type="radio" class="form-check-input link_from" id="vendor" name="link_from"
                                                                value="vendor" @checked(@$link_from == 'vendor')>
                                                                VENDOR
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="payment_date[]" class="form-control date"
                                                            id="payment_date" readonly>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="otc[]" class="form-control"
                                                            id="otc" readonly>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>

                                        <tr>
                                            <td colspan="2" style="text-align: left;"></td>
                                            <td style="text-align: center;">Total</td>
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
                                            <td></td>
                                            <td></td>
                                            <td></td>
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
    </div>
    {!! Form::close() !!}

@endsection
@section('script')
    @include('sales::offers.js')
@endsection
