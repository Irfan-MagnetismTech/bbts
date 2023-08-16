@extends('layouts.backend-layout')
@section('title', 'Client Requirement Modification')

@php
    $mod = !empty($clientRequirementModification) ? $clientRequirementModification : null;
    $is_old = old() ? true : false;
    $form_heading = !empty($mod->id) ? 'Update' : 'Add';
    $form_url = !empty($mod->id) ? route('client-requirement-modification.update', $mod->id) : route('client-requirement-modification.store');
    $form_method = !empty($mod->id) ? 'PUT' : 'POST';
    
    $client_no = !empty($mod) ? $mod->client_no : (old('client_no') ? old('client_no') : '');
    $client_name = !empty($mod) ? $mod->client->client_name : (old('client_name') ? old('client_name') : '');
    $date = !empty($mod) ? $mod->date : (old('date') ? old('date') : today()->format('d-m-Y'));
    $activation_date = !empty($mod) ? $mod->activation_date : (old('activation_date') ? old('activation_date') : today()->format('d-m-Y'));
    $fr_no = !empty($mod) ? $mod->fr_no : (old('fr_no') ? old('fr_no') : '');
    $connectivity_remarks = !empty($mod) ? $mod->connectivity_remarks : (old('connectivity_remarks') ? old('connectivity_remarks') : '');
    $change_types = !empty($mod) ? json_decode($mod->change_type) : [];
    $from_date = !empty($mod) ? $mod->from_date : (old('from_date') ? old('from_date') : today()->format('d-m-Y'));
    $to_date = !empty($mod) ? $mod->to_date : (old('to_date') ? old('to_date') : today()->format('d-m-Y'));
    $existing_mrc = !empty($mod) ? $mod->existing_mrc : (old('existing_mrc') ? old('existing_mrc') : '');
    $decrease_mrc = !empty($mod) ? $mod->decrease_mrc : (old('decrease_mrc') ? old('decrease_mrc') : '');
    
@endphp

@section('breadcrumb-title')
    {{ ucfirst($form_heading) }} Client Requirement Modification
@endsection

@section('breadcrumb-button')
    <a href="{{ route('client-requirement-modification.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-list"></i></a>

@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('style')
    <style>
        .custom-loader {
            border: 20px solid #f3f3f3;
            border-top: 20px solid #3498db;
            border-radius: 50%;
            width: 100px;
            height: 100px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
            margin-top: 100px;
            display: none;
            /* Hide the loader by default */
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endsection

@section('content')

    {!! Form::open([
        'url' => $form_url,
        'method' => $form_method,
        'encType' => 'multipart/form-data',
        'class' => 'custom-form',
    ]) !!}

    {{-- Comparative Statement --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="tableHeading">
                    <h5> <span> &#10070; </span> Client Requirement Modification <span>&#10070;</span> </h5>
                </div>
                <div class="card-body">
                    @include('changes::client_requirement.parent_data')
                    @include('changes::client_requirement.checkboxes')
                    {{-- create a responsive table --}}
                    {{-- jquery loader --}}
                    <div id="loader" class="custom-loader"></div>
                    <div id="main-content">
                        @include('changes::client_requirement.products')
                        @include('changes::client_requirement.links')
                    </div>
                    <button class="py-2 btn btn-success float-right">
                        {{ !empty($client_request->id) ? 'Update' : 'Save' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section('script')
    @include('changes::client_requirement.js')
@endsection
