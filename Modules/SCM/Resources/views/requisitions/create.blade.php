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

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
    <div class="container">
        <form
            action="{{ $formType == 'edit' ? route('requisitions.update', $requisition->id) : route('requisitions.store') }}"
            method="post" class="custom-form">
            @if ($formType == 'edit')
                @method('PUT')
            @endif
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="typeSection mt-2 mb-2">
                        <div class="form-check-inline">
                            <label class="form-check-label" for="client">
                                <input type="radio" class="form-check-input" id="client" name="type" value="client"
                                    checked> Client
                            </label>
                        </div>

                        <div class="form-check-inline">
                            <label class="form-check-label" for="warehouse">
                                <input type="radio" class="form-check-input" id="warehouse" name="type"
                                    value="warehouse">
                                Warehouse
                            </label>
                        </div>

                        <div class="form-check-inline">
                            <label class="form-check-label" for="pop">
                                <input type="radio" class="form-check-input" id="pop" name="type" value="pop">
                                POP
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group  col-3">
                    <label for="irsNo">IRS No:</label>
                    <input type="text" class="form-control" id="irsNo" aria-describedby="irsNo"
                        value="{{ old('irsNo') ?? ($requisition->irsNo ?? '') }}" placeholder="Search...">
                </div>

                <div class="form-group col-3">
                    <label for="mqId">MQ ID:</label>
                    <input type="text" class="form-control" id="mqId" aria-describedby="mqId"
                        value="{{ old('mqId') ?? ($requisition->mqId ?? '') }}" placeholder="Search...">
                </div>

                <div class="form-group col-3">
                    <label for="frId">FR ID:</label>
                    <input type="text" class="form-control" id="frId" aria-describedby="frId"
                        value="{{ old('frId') ?? ($requisition->frId ?? '') }}" placeholder="Search...">
                </div>

                <div class="form-group col-3">
                    <label for="date">Applied Date:</label>
                    <input type="date" class="form-control" id="date" name="date" aria-describedby="date"
                        value="{{ old('date') ?? ($requisition->date ?? '') }}">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-3">
                    <label for="client_name">Client Name:</label>
                    <input type="text" class="form-control" id="client_name" aria-describedby="client_name"
                        value="{{ old('client_name') ?? ($requisition->client_name ?? '') }}" placeholder="Search...">
                </div>

                <div class="form-group col-3">
                    <label for="select2">Client Links</label>
                    <select class="form-control select2" id="select2">
                        <option>Option 1</option>
                        <option>Option 2</option>
                        <option>Option 3</option>
                    </select>
                </div>

                <div class="form-group col-3">
                    <label for="client_id">Client ID:</label>
                    <input type="text" class="form-control" id="client_id" aria-describedby="client_id" disabled
                        value="{{ old('client_id') ?? ($requisition->client_id ?? '') }}">
                </div>

                <div class="form-group col-3">
                    <label for="address">Address:</label>
                    <input type="text" class="form-control" id="address" aria-describedby="address" disabled
                        value="{{ old('address') ?? ($requisition->address ?? '') }}">
                </div>
            </div>

            <table class="table table-bordered" id="material_requisition">
                <thead>
                    <tr>
                        <th> Material Name <span class="text-danger">*</span></th>
                        <th> Unit <span class="text-danger">*</span></th>
                        <th> Requisition Qty. <span class="text-danger">*</span></th>
                        <th> Brand <span class="text-danger">*</span></th>
                        <th> Model </th>
                        <th> Remarks </th>
                        <th><i class="btn btn-primary btn-sm fa fa-plus add-requisition-row"></i></th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <td> <input type="text" name="material_name[]" class="form-control material_name" required
                                autocomplete="off"> </td>
                        <td>
                            <select class="form-control unit_id" name="unit_id[]" required>
                                <option value="">Select Unit</option>
                            </select>
                        </td>
                        <td> <input type="text" name="quantity[]" class="form-control quantity"
                                autocomplete="off"> </td>
                        <td> <input type="number" name="unit_price[]" class="form-control unit_price"
                                autocomplete="off"> </td>
                        <td> <input type="number" name="unit_price[]" class="form-control unit_price"
                                autocomplete="off"> </td>
                        <td> <input type="text" name="remarks[]" class="form-control remarks" autocomplete="off">
                        </td>
                        <td> <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i> </td>
                    </tr>
                    <tr>
                    </tr>
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

        $(document).ready(function() {
            $('.select2').select2();
        });

        /* Appends re row */
        function appendCalculationRow() {
            let row = `
                        <tr>
                            <td> <input type="text" name="material_name[]" class="form-control material_name"
                                    required autocomplete="off"> </td>
                            <td>
                                <select class="form-control unit_id" name="unit_id[]" required>
                                    <option value="">Select Unit</option>
                                </select>
                            </td>
                            <td> <input type="text" name="quantity[]"
                                    class="form-control quantity" autocomplete="off"> </td>
                            <td> <input type="number" name="unit_price[]" class="form-control unit_price"
                                    autocomplete="off"> </td>
                            <td> <input type="number" name="unit_price[]" class="form-control unit_price"
                                    autocomplete="off"> </td>
                            <td> <input type="text" name="remarks[]" class="form-control remarks"
                                    autocomplete="off"> </td>
                            <td> <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i> </td>
                        </tr>
                    `;

            $('#material_requisition tbody').append(row);
        }

        /* Adds and removes quantity row on click */
        $("#material_requisition")
            .on('click', '.add-requisition-row', () => {
                appendCalculationRow();
            })
            .on('click', '.remove-calculation-row', function() {
                $(this).closest('tr').remove();
            });
    </script>
@endsection
