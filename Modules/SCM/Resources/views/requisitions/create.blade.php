@extends('layouts.backend-layout')
@section('title', 'Requisitions')

@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit
    @else
        Create
    @endif
    MRS (Material Requisition Slip)
@endsection

@section('style')
    <style>
        .input-group-addon {
            min-width: 120px;
        }

        .input-group-info .input-group-addon {
            /*background-color: #04748a!important;*/
        }
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('requisitions.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'col-12')

@section('content')
    <form action="{{ $formType == 'edit' ? route('requisitions.update', @$requisition->id) : route('requisitions.store') }}"
        method="post" class="custom-form">
        @if ($formType == 'edit')
            @method('PUT')
        @endif
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="typeSection mt-2 mb-4">
                    <div class="form-check-inline">
                        <label class="form-check-label" for="client">
                            <input type="radio" class="form-check-input radioButton" id="client" name="type"
                                value="client" @checked(@$requisition->type == 'client' || old('type') == 'client')> Client
                        </label>
                    </div>

                    <div class="form-check-inline">
                        <label class="form-check-label" for="warehouse">
                            <input type="radio" class="form-check-input radioButton" id="warehouse" name="type"
                                @checked(@$requisition->type == 'warehouse' || old('type') == 'warehouse') value="warehouse">
                            Warehouse
                        </label>
                    </div>

                    <div class="form-check-inline">
                        <label class="form-check-label" for="pop">
                            <input type="radio" class="form-check-input radioButton" id="pop" name="type"
                                value="pop" @checked(@$requisition->type == 'pop' || old('type') == 'pop')>
                            POP
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-3">
                <label for="select2">Branch Name</label>
                <select class="form-control select2" id="branch_id" name="branch_id">
                    <option value="20" selected>Select Branch</option>
                    @foreach ($branchs as $option)
                        <option value="{{ $option->id }}"
                            {{ old('branch_id', @$requisition->branch_id) == $option->id ? 'selected' : '' }}>
                            {{ $option->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            
            <div class="form-group col-3 client_name">
                <label for="client_name">Client Name:</label>
                <input type="text" class="form-control" id="client_name" aria-describedby="client_name"
                    name="client_name" value="{{ old('client_name') ?? ($client_name ?? '') }}" placeholder="Search...">
            </div>

            <div class="form-group col-3 fr_no">
                <label for="select2">FR No</label>
                <select class="form-control select2" id="fr_no" name="fr_no">
                    <option value="" readonly selected>Select FR No</option>
                    @if ($formType == 'create')
                        <option value="{{ old('fr_no') }}" selected>{{ old('fr_no') }}</option>
                    @elseif($formType == 'edit')
                        @forelse ($fr_nos as $key => $value)
                            <option value="{{ $value->fr_no }}" @if ($fr_no == $value->fr_no) selected @endif>
                                {{ $value->fr_no }}
                            </option>
                        @empty
                        @endforelse
                    @endif
                </select>
            </div>

            <div class="form-group col-3 link_no">
                <label for="link_no">Link No:</label>
                <select class="form-control select2" id="link_no" name="link_no">
                    <option value="" readonly selected>Select Link No</option>
                    @if ($formType == 'create')
                        <option value="{{ old('link_no') }}" selected>{{ old('link_no') }}</option>
                    @elseif($formType == 'edit')
                        @forelse ($client_links as $key => $value)
                            <option value="{{ $value->link_no }}" @if ($client_link_no == $value->link_no) selected @endif>
                                {{ $value->link_no }}
                            </option>
                        @empty
                        @endforelse
                    @endif
                </select>
            </div>

            <div class="form-group col-3 client_no">
                <label for="client_no">Client No:</label>
                <input type="text" class="form-control" id="client_no" aria-describedby="client_no" name="client_no"
                    readonly value="{{ old('client_no') ?? (@$client_no ?? '') }}">
            </div>

            <div class="form-group col-3 client_address">
                <label for="client_address">Client Address:</label>
                <input type="text" class="form-control" id="client_address" name="client_address"
                    aria-describedby="client_address" readonly
                    value="{{ old('client_address') ?? (@$client_address ?? '') }}">
            </div>

            <div class="form-group col-3">
                <label for="date">Applied Date:</label>
                <input class="form-control" id="date" name="date" aria-describedby="date"
                    value="{{ old('date') ?? (@$requisition->date ?? '') }}" readonly placeholder="Select a Date">
            </div>

            <div class="form-group col-3 pop_id" style="display: none">
                <label for="select2">Pop Name</label>
                <select class="form-control select2" id="pop_id" name="pop_id">
                    <option value="" readonly selected>Select Pop</option>
                    @if ($formType == 'edit')
                        @foreach ($branchwisePops as $branchwisePop)
                            <option value="{{ $branchwisePop->id }}" @selected($branchwisePop->id == @$requisition->pop_id)>
                                {{ $branchwisePop->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>

        <table class="table table-bordered" id="material_requisition">
            <thead>
                <tr>
                    <th> Material Name</th>
                    <th> Unit</th>
                    <th> Description</th>
                    <th class="current_stock" style="display: none"> Current Stock</th>
                    <th> Requisition Qty.</th>
                    <th> Brand</th>
                    <th> Model </th>
                    <th> Purpose </th>
                    <th><i class="btn btn-primary btn-sm fa fa-plus add-requisition-row"></i></th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
                @php
                    $material_name_with_code = old('material_name', !empty($requisition) ? $requisition->scmRequisitiondetails->pluck('material.materialNameWithCode') : []);
                    $material_id = old('material_id', !empty($requisition) ? $requisition->scmRequisitiondetails->pluck('material_id') : []);
                    $item_code = old('item_code', !empty($requisition) ? $requisition->scmRequisitiondetails->pluck('material.code') : []);
                    $unit = old('unit', !empty($requisition) ? $requisition->scmRequisitiondetails->pluck('material.unit') : []);
                    $description = old('description', !empty($requisition) ? $requisition->scmRequisitiondetails->pluck('description') : []);
                    $current_stock = old('current_stock', !empty($requisition) ? $requisition->scmRequisitiondetails->pluck('material.current_stock') : []);
                    $quantity = old('quantity', !empty($requisition) ? $requisition->scmRequisitiondetails->pluck('quantity') : []);
                    $brand_id = old('brand_id', !empty($requisition) ? $requisition->scmRequisitiondetails->pluck('brand_id') : []);
                    $model = old('model', !empty($requisition) ? $requisition->scmRequisitiondetails->pluck('model') : []);
                    $purpose = old('purpose', !empty($requisition) ? $requisition->scmRequisitiondetails->pluck('purpose') : []);
                @endphp
                @foreach ($material_name_with_code as $key => $requisitionDetail)
                    <tr>
                        <td>
                            <input type="text" name="material_name[]" class="form-control material_name" required
                                autocomplete="off" value="{{ $material_name_with_code[$key] }}">
                            <input type="hidden" name="material_id[]" class="form-control material_id"
                                value="{{ $material_id[$key] }}">
                            <input type="hidden" name="item_code[]" class="form-control item_code"
                                value="{{ $item_code[$key] }}">
                        </td>
                        <td>
                            <input type="text" name="unit[]" class="form-control unit" autocomplete="off" readonly
                                value="{{ $unit[$key] }}">
                        </td>
                        <td>
                            <input type="text" name="description[]" class="form-control description"
                                autocomplete="off" value="{{ $description[$key] }}">
                        </td>
                        <td class="current_stock" style="display: none">
                            <input type="text" class="form-control current_stock" autocomplete="off" readonly
                                value="{{ @$current_stock[$key] }}">
                        </td>

                        <td>
                            <input type="text" name="quantity[]" class="form-control quantity" autocomplete="off"
                                value="{{ $quantity[$key] }}">
                        </td>
                        <td>
                            <select name="brand_id[]" class="form-control brand" autocomplete="off">
                                <option value="">Select Brand</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}" @selected($brand->id == $brand_id[$key])>
                                        {{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="text" name="model[]" class="form-control model" autocomplete="off"
                                value="{{ $model[$key] }}">
                        </td>
                        <td>
                            <input type="text" name="purpose[]" class="form-control purpose" autocomplete="off"
                                value="{{ $purpose[$key] }}">
                        </td>
                        <td>
                            <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i>
                        </td>
                    </tr>
                @endforeach
            </tfoot>
        </table>

        <div class="row">
            <div class="offset-md-4 col-md-4 mt-2">
                <div class="input-group input-group-sm ">
                    <button class="btn btn-success btn-round btn-block py-2">Submit</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@include('scm::requisitions.js')
