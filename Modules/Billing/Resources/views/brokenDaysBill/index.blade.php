@extends('layouts.backend-layout')
@section('title', 'Broken Days Bill')

@section('breadcrumb-title')
    @if (!empty($brokenDaysBill))
        Edit
    @else
    @endif
   Broken Days Bill Generate
@endsection

@section('breadcrumb-button')
    <a href="{{ route('broken-days-bills.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
    <div class="container">
        <form action="{{ !empty($brokenDaysBill) ? route('broken-days-bills.update', $branch->id) : route('broken-days-bills.store') }}"
            method="post" class="custom-form">
            @if (!empty($brokenDaysBill))
                @method('PUT')
            @endif
            @csrf
            <div class="row" style="padding:30px 0 30px">
                <x-input-box colGrid="3" name="client_no" value="" label="Client ID" attr="" value=""/>
                <x-input-box colGrid="3" name="client_name" value="" label="Client Name" attr="" value=""/>
                <x-input-box colGrid="3" name="date" value="" label="Date" attr="" value={{now()}}/>
                <input type="hidden" class="form-control bill_type" name="bill_type"
                value="{{ 'Broken Days' }}">
                <div class="col-3">
                    <fieldset>
                        <legend>Link Type</legend>

                     <label class="mr-2" for="yes">Signboard</label>
                        <div class="form-check-inline pt-0 mt-0">
                            <label class="form-check-label" for="new">
                                <input type="radio" class="form-check-input link_type" id="new" name="link_type" value="new">
                                NEW
                            </label>
                        </div>
                        <div class="form-check-inline mt-0 pt-0">
                            <label class="form-check-label" for="existing">
                                <input type="radio" class="form-check-input link_type" id="existing" name="link_type" value="existing">
                                EXISTING
                            </label>
                        </div>
                    </fieldset>
                </div>
                 <x-input-box colGrid="3" name="billing_date" value="" label="Billing Date" attr="" value={{now()}}/>
                 <x-input-box colGrid="3" name="last_mod_date" value="" label="Last Modify Date" attr="" value={{now()}}/>
                 <x-input-box colGrid="3" name="days" value="" label="Days" attr="" value={{now()}}/>
            </div>
    <div class="row">
        <div class="offset-md-2 col-md-7 mt-1">
            <table class="table table-bordered" id="service_table">
                <thead>
                    <tr>
                        <th>Particulars</th>
                        <th>Description</th>
                        <th>Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                            <tr>
                                <td>
                                    <input type="text" class="form-control connectivity_point" name="connectivity_point[]"
                                        value="" >
                                </td>
                                <td>
                                    <input type="text" class="form-control contact" name="contact[]"
                                        value="" >
                                </td>
                                <td>
                                    <input type="text" class="form-control billing_address" name="child_billing_address[]"
                                        value="" >
                                </td>
                            </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="text-right" style="text-align: right;">Total Amount</td>
                        <td>
                            <input type="number" class="form-control total" name="amount"
                                value="" >
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="offset-md-2 col-md-7 mt-1">
            <table class="table table-bordered" id="service_table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Rate</th>
                        <th>Amount</th>
                        <th>VAT</th>
                        <th>Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                            <tr>
                                <td>
                                    <input type="text" class="form-control connectivity_point" name="connectivity_point[]"
                                        value="" >
                                </td>
                                <td>
                                    <input type="text" class="form-control contact" name="contact[]"
                                        value="" >
                                </td>
                                <td>
                                    <input type="text" class="form-control billing_address" name="child_billing_address[]"
                                        value="" >
                                </td>
                                <td>
                                    <input type="text" class="form-control connectivity_point" name="connectivity_point[]"
                                        value="" >
                                </td>
                                <td>
                                    <input type="text" class="form-control contact" name="contact[]"
                                        value="" >
                                </td>
                                <td>
                                    <input type="text" class="form-control billing_address" name="child_billing_address[]"
                                        value="" >
                                </td>
                            </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="text-right" style="text-align: right;">Total Amount</td>
                        <td>
                            <input type="number" class="form-control total" name="amount"
                                value="" >
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-right" style="text-align: right;">Receivable</td>
                        <td>
                            <input type="number" class="form-control total" name="amount"
                                value="" >
                        </td>
                    </tr>
                </tfoot>
            </table>
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


{{--@extends('layouts.backend-layout')--}}
{{--@section('title', 'Branch')--}}

{{--@section('style')--}}
{{--    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">--}}
{{--@endsection--}}

{{--@section('breadcrumb-title')--}}
{{--    List of Branch Info--}}
{{--@endsection--}}

{{--@section('style')--}}
{{--    <style>--}}
{{--    </style>--}}
{{--@endsection--}}
{{--@section('breadcrumb-button')--}}
{{--    <a href="{{ route('branchs.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-plus"></i></a>--}}
{{--@endsection--}}
{{--@section('sub-title')--}}
{{--    --}}{{-- Total: {{ @count($branchs) }} --}}
{{--@endsection--}}


{{--@section('content')--}}
{{--    <div class="dt-responsive table-responsive">--}}
{{--        <table id="dataTable" class="table table-striped table-bordered">--}}
{{--            <thead>--}}
{{--                <tr>--}}
{{--                    <th>#SL</th>--}}
{{--                    <th>Name</th>--}}
{{--                    <th>Division</th>--}}
{{--                    <th>District</th>--}}
{{--                    <th>Thana</th>--}}
{{--                    <th>Location</th>--}}
{{--                    <th>Action</th>--}}
{{--                </tr>--}}
{{--            </thead>--}}
{{--            <tfoot>--}}
{{--                <tr>--}}
{{--                    <th>#SL</th>--}}
{{--                    <th>Name</th>--}}
{{--                    <th>Division</th>--}}
{{--                    <th>District</th>--}}
{{--                    <th>Thana</th>--}}
{{--                    <th>Location</th>--}}
{{--                    <th>Action</th>--}}
{{--                </tr>--}}
{{--            </tfoot>--}}
{{--            <tbody>--}}
{{--                @foreach ($branchs as $key => $branch)--}}
{{--                    <tr>--}}
{{--                        <td>{{ $key + 1 }}</td>--}}
{{--                        <td class="text-center">{{ $branch->name }}</td>--}}
{{--                        <td class="text-center">{{ $branch->division->name }}</td>--}}
{{--                        <td class="text-center">{{ $branch->district->name }}</td>--}}
{{--                        <td class="text-center">{{ $branch->thana->name }}</td> --}}
{{--                        <td class="text-center">{{ $branch->location }}</td> --}}
{{--                        <td>--}}
{{--                            <div class="icon-btn">--}}
{{--                                <nobr>--}}
{{--                                    <a href="{{ route('branchs.edit', $branch->id) }}" data-toggle="tooltip" title="Edit"--}}
{{--                                        class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>--}}
{{--                                    <form action="{{ url("admin/branchs/$branch->id") }}" method="POST"--}}
{{--                                        data-toggle="tooltip" title="Delete" class="d-inline">--}}
{{--                                        @csrf--}}
{{--                                        @method('DELETE')--}}
{{--                                        <button type="submit" class="btn btn-outline-danger btn-sm delete"><i--}}
{{--                                                class="fas fa-trash"></i></button>--}}
{{--                                    </form>--}}
{{--                                </nobr>--}}
{{--                            </div>--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                @endforeach--}}
{{--            </tbody>--}}
{{--        </table>--}}
{{--    </div>--}}
{{--@endsection--}}

{{--@section('script')--}}
{{--@endsection--}}
