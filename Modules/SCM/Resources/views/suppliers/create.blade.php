@extends('layouts.backend-layout')
@section('title', 'Suppliers')

@section('breadcrumb-title')
    @if($formType == 'edit')  Edit  @else  Create  @endif
    Suppliers Info
@endsection

@section('style')
    <style>
        .input-group-addon{
            min-width: 120px;
        }
        .input-group-info .input-group-addon{
            /*background-color: #04748a!important;*/
        }
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('suppliers.index')}}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
    <div class="container">
        <form action="{{ $formType == 'edit' ? route('suppliers.update', $supplier->id) : route('suppliers.store') }}"
            method="post" class="custom-form">
            @if ($formType == 'edit')
                @method('PUT')
            @endif
            @csrf
            <div class="row">

                <div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="name">Supplier Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Enter supplier name" value="{{ old('name') ?? ($supplier->name ?? '') }}" required>
                    </div>
                </div>

                <div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="unit_id">Unit <span class="text-danger">*</span></label>
                        <select class="form-control" id="unit_id" name="unit_id" required>
                            <option value="">Select Unit</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}"
                                    {{ (old('unit_id') ?? ($supplier->unit_id ?? '')) == $unit->id ? 'selected' : '' }}>
                                    {{ $unit->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="type">Type <span class="text-danger">*</span></label>
                        <select class="form-control" id="type" name="type" required>
                            <option value="">Select Type</option>
                            @foreach ($types as $type)
                                <option value="{{ $type }}"
                                    {{ (old('type') ?? ($supplier->type ?? '')) == $type ? 'selected' : '' }}>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="code">Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="code" name="code"
                            placeholder="Enter supplier code" value="{{ old('code') ?? ($supplier->code ?? '') }}"
                            required>
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
        </form>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/Datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/Datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(window).scroll(function() {
            //set scroll position in session storage
            sessionStorage.scrollPos = $(window).scrollTop();
        });
        var init = function() {
            //get scroll position in session storage
            $(window).scrollTop(sessionStorage.scrollPos || 0)
        };
        window.onload = init;

        $(document).ready(function() {
            $('#dataTable').DataTable({
                stateSave: true
            });
        });
    </script>
@endsection
