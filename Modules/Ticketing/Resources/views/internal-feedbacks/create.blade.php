@extends('layouts.backend-layout')
@section('title', 'Internal Feedbacks')

@php
    $form_heading = !empty($billRegister->id) ? 'Update' : 'Register';
    $form_url = !empty($billRegister->id) ? route('bill-register.update', $billRegister->id) : route('bill-register.store');
    $form_method = !empty($billRegister->id) ? 'PUT' : 'POST';
@endphp

@section('breadcrumb-title')
    Internal Feedbacks
@endsection

{{--@section('breadcrumb-button')--}}
{{--    <a href="{{ route('bill-register.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i--}}
{{--            class="fas fa-database"></i></a>--}}
{{--@endsection--}}

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection
@section('content-grid', null)

@section('content')

    {!! Form::open([
        'url' => route('internal-feedback'),
        'method' => 'POST',
        'encType' => 'multipart/form-data',
        'class' => 'custom-form',
    ]) !!}

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        @php
                            $is_old = old('supplier_name') ? true : false;
                            $supplier_name = $is_old ? old('supplier_name') : $billRegister->supplier->name ?? null;
                            $supplier_id = $is_old ? old('supplier_id') : $billRegister->supplier_id ?? null;
                            $bill_no = $is_old ? old('bill_no') : $billRegister->bill_no ?? null;
                            $amount = $is_old ? old('amount') : $billRegister->amount ?? null;
                            $date = $is_old ? old('date') : $billRegister->date ?? null;
                        @endphp
                        <div class="col-xl-4 col-md-4">
                            <div style="width: 200px; margin-left: 20px">
                                <select name="client_no" class="form-control client select2" autocomplete="off">
                                    <option value="">Select Client</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->client_no }}" @selected($client->client_no == $client_no)>
                                            {{ $client->client_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4">
                            <div class="form-item">
                                <input type="date" name="date" id="date" class="form-control"
                                       value="{{ $date ? $date : now()->format('Y-m-d') }}" autocomplete="off"
                                       value="{{$date}}">
                                <label for="date">Date<span class="text-danger"> *</span></label>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4">
                            <div class="form-item">
                                <input type="text" class="form-control" name="remarks" id="remarks" autocomplete="off" value="{{$remarks}}">
                                <label for="remarks">Remarks</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="offset-md-4 col-md-4 mt-2">
                            <div class="input-group input-group-sm ">
                                <button class="btn btn-success btn-round btn-block py-2">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
                @endsection

