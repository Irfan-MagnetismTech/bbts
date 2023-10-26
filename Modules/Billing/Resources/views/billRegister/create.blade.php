@extends('layouts.backend-layout')
@section('title', 'Bill Register')

@php
    $form_heading = !empty($billRegister->id) ? 'Update' : 'Register';
    $form_url = !empty($billRegister->id) ? route('bill-register.update', $billRegister->id) : route('bill-register.store');
    $form_method = !empty($billRegister->id) ? 'PUT' : 'POST';
@endphp

@section('breadcrumb-title')
    Bill {{ ucfirst($form_heading) }}
@endsection

@section('breadcrumb-button')
    <a href="{{ route('bill-register.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
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
                            <div class="form-item">
                                <input type="hidden" id="supplier_id" name="supplier_id" value="{{$supplier_id}}">
                                <input type="text" class="form-control" name="supplier_name" id="supplier_name" autocomplete="off" required value="{{$supplier_name}}">
                                <label for="supplier_name">Supplier Name<span class="text-danger"> *</span></label>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4">
                            <div class="form-item">
                                <input type="text" class="form-control" name="bill_no" id="bill_no" autocomplete="off" value="{{$bill_no}}">
                                <label for="bill_no">Bill No</label>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4">
                            <div class="form-item">
                                <input type="text" class="form-control" name="amount" id="amount" autocomplete="off" required value="{{$amount}}">
                                <label for="amount">Amount<span class="text-danger"> *</span></label>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4">
                            <div class="form-item">
                                <input type="date" name="date" id="date" class="form-control"
                                       value="{{ $date ? $date : now()->format('Y-m-d') }}" autocomplete="off"
                                       value="{{$date}}">
                                <label for="date">Bill Date<span class="text-danger"> *</span></label>
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

                @section('script')
<script>
    $(document).on("keyup focus", "#supplier_name", function () {
        $(this).autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: window.location.origin + "/billing/get_supplier",
                    type: "get",
                    dataType: "json",
                    data: {
                        search: request.term,
                    },
                    success: function (data) {
                        response(data);
                    },
                });
            },
            select: function (event, ui) {
                $("#supplier_name").val(ui.item.label);
                $("#supplier_id").val(ui.item.supplier_id);

                return false;
            },
        });
    });

</script>
@endsection
