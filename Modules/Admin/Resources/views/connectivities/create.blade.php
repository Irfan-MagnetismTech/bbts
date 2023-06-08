@extends('layouts.backend-layout')
@section('title', 'Survey')

@php
    $is_old = old('client_id') ? true : false;
    $form_heading = !empty($survey->id) ? 'Update' : 'Add';
    $form_url = !empty($survey->id) ? route('survey.update', $survey->id) : route('survey.store');
    $form_method = !empty($survey->id) ? 'PUT' : 'POST';
@endphp

@section('breadcrumb-title')
    {{ ucfirst($form_heading) }} Survey Requirement
@endsection

@section('breadcrumb-button')
    <a href="{{ route('survey.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')

    {!! Form::open([
        'url' => $form_url,
        'method' => $form_method,
        'class' => 'custom-form',
    ]) !!}

    {{-- Comparative Statement --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="tableHeading">
                    <h5> <span> &#10070; </span> Connectivity / Link Information <span>&#10070;</span> </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        {{-- exiting or new radio button --}}
                        <div class="col-xl-4 col-md-4">
                            <div class="form-item">
                                <input type="text" class="form-control" id="reference" name="reference" 
                                    placeholder="" value="asd">
                                <label for="reference">Reference</label>
                            </div>
                            <div class="form-item">
                                <input type="text" name="asd" id="asd" class="form-control"
                                    placeholder="" value="">
                                <label for="asd">asd</label>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-4">
                            <div class="form-item">
                                <input class="form-control" id="client_id" name="client_no" 
                                    value="" placeholder="">
                                <label for="client_id">Client ID<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4">
                            <div class="form-item">
                                <input class="form-control" id="client_name" name="client_name"
                                    aria-describedby="client_name" value="" readonly
                                    placeholder="">
                                <label for="client_name">Client Name<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4">
                            <div class="form-item">
                                <input type="text" name="link_name" id="link_name" class="form-control"
                                    placeholder="" value="" required>
                                <label for="link_name">Name of the link</label>
                            </div>
                            <div class="form-item">
                                <input type="text" name="asd" id="asd" class="form-control"
                                    placeholder="" value="" required>
                                <label for="asd">asd</label>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4">
                            <div class="form-item">
                                <input type="text" name="fr_no" id="fr_no" class="form-control" placeholder=""
                                    value="" readonly>
                                <label for="fr_no">FR ID</label>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4">
                            <div class="form-item">
                                <input type="text" name="gps" id="gps" class="form-control" placeholder=""
                                    value="" readonly>
                                <label for="gps">GPS</label>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4">
                            <div class="form-item">
                                <input type="text" name="mq_no" id="mq_no" class="form-control" placeholder=""
                                    value="" readonly>
                                <label for="mq_no">MQ No</label>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4">
                            <div class="form-item">
                                <input type="file" name="document" id="file" class="form-control"
                                    placeholder="">
                            </div>
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
                    
                  
                </div>
                <hr />
                <div class="text-center">
                    <h5> <span> &#10070; </span> Survey Details <span>&#10070;</span> </h5>
                </div>
                <hr />
            </div>
            <button class="py-2 btn btn-success ">{{ !empty($lead_generation->id) ? 'Update' : 'Save' }}</button>
        </div>
    </div>
    </div>
    {!! Form::close() !!}
@endsection

@section('script')
    <script>
     
    </script>
@endsection
