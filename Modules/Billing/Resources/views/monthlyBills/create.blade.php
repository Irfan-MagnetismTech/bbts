@extends('layouts.backend-layout')
@section('title', 'Monthly Bill')

@section('breadcrumb-title')
    @if (!empty($monthlyBill))
        Edit
    @else
    @endif
    Monthly Bill Generate
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
<a href="{{ route('monthly-bills.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-plus"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
    <div class="container">
        <form action="{{ !empty($monthlyBill) ? route('monthly-bills.update', $branch->id) : route('monthly-bills.store') }}"
            method="post" class="custom-form">
            @if (!empty($monthlyBill))
                @method('PUT')
            @endif
            @csrf
            <div class="row" style="padding:30px 0 30px">
                <div class="col-6">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="month">Month <span class="text-danger">*</span></label>
                        <input type="month" class="form-control" id="month" name="month" placeholder="Enter  Month"
                            value="{{ old('month') ?? ($branch->month ?? '') }}" required>
                    </div>
                </div>
                <div class="col-6">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="date">Date <span class="text-danger">*</span></label>
                        <input class="form-control" id="date" name="date" aria-describedby="date"
                            placeholder="Enter date" value="{{ old('date') ?? ($branch->date ?? '') }}" required>
                    </div>
                </div>
            </div>
    </div>

    <div class="row">
        <div class="offset-md-4 col-md-4 mt-2">
            <div class="input-group input-group-sm ">
                <button class="btn btn-success btn-round btn-block py-2">Generate</button>
            </div>
        </div>
    </div>
    </form>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/custom-function.js') }}"></script>
    <script>
        $('#date').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true,
            showOtherMonths: true
        }).datepicker("setDate", new Date());
    </script>
@endsection
