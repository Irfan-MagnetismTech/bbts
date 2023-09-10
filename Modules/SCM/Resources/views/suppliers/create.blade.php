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
                        <label class="input-group-addon" for="contact_person">Contact Person <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="contact_person" name="contact_person"
                            placeholder="Enter contact person" value="{{ old('contact_person') ?? ($supplier->contact_person ?? '') }}" required>
                    </div>
                </div>

                <div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="email">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="Enter supplier email" value="{{ old('email') ?? ($supplier->email ?? '') }}" required>
                    </div>
                </div>

                <div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="address-1">Supplier Address-1 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="address-1" name="address_1"
                            placeholder="Enter supplier address-1" value="{{ old('address_1') ?? ($supplier->address_1 ?? '') }}" required>
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="address-2">Supplier Address-2 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="address-1" name="address_2"
                            placeholder="Enter supplier address-2" value="{{ old('address_2') ?? ($supplier->address_2 ?? '') }}" required>
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="bin-no">Bin No<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="bin-no" name="bin_no"
                            placeholder="Enter bin no" value="{{ old('bin_no') ?? ($supplier->bin_no ?? '') }}" required>
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="tin-no">Tin No<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="tin-no" name="tin_no"
                            placeholder="Enter tin no" value="{{ old('tin_no') ?? ($supplier->tin_no ?? '') }}" required>
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="mobile-no">Mobile No<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="mobile-no" name="mobile_no"
                            placeholder="Enter mobile no" value="{{ old('mobile_no') ?? ($supplier->mobile_no ?? '') }}" required>
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
