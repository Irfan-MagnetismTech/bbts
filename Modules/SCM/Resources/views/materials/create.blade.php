@extends('layouts.backend-layout')
@section('title', 'Materials')

@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit
    @else
        Create
    @endif
    Materials Info
@endsection

@section('style')
    <style>
        .input-group-addon {
            min-width: 120px;
        }

        .input-group-info .input-group-addon {
            /*background-color: #04748a!important;*/
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice span {
            color: #b10000;
        }

        .select2_container {
            max-width: 200px;
            white-space: inherit;
        }
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('materials.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
    <div class="container">
        <form action="{{ $formType == 'edit' ? route('materials.update', $material->id) : route('materials.store') }}"
              method="post" class="custom-form">
            @if ($formType == 'edit')
                @method('PUT')
            @endif
            @csrf
            <input type="hidden" name="id" value="{{ !empty($material) ? $material->id : null }}">
            <div class="row">

                <div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="name">Material Name <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name"
                               placeholder="Enter material name" value="{{ old('name') ?? ($material->name ?? '') }}"
                               required>
                    </div>
                </div>

                <div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="unit">Unit <span class="text-danger">*</span></label>
                        <select class="form-control" id="unit" name="unit" required>
                            <option value="">Select Unit</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->name }}"
                                    {{ (old('unit') ?? ($material->unit ?? '')) == $unit->name ? 'selected' : '' }}>
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
                                    {{ (old('type') ?? ($material->type ?? '')) == $type ? 'selected' : '' }}>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="category-name">Category <span
                                class="text-danger">*</span></label>
                        <select class="form-control" id="category-name" name="category_id" required>
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                @if (!empty($material->category_id)) {{ $category->id == $material->category_id ? 'selected' : '' }} @endif>
                                    {{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        {{--                        <label class="input-group-addon" for="code">Code <span class="text-danger">*</span></label>--}}
                        <input type="hidden" class="form-control" id="code" name="code"
                               placeholder="Enter material code" value="{{ old('code') ?? ($material->code ?? '') }}"
                               required>
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="min_qty">Min Quantity<span
                                class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="min_qty" name="min_qty"
                               placeholder="Enter min quantity"
                               value="{{ old('min_qty') ?? ($material->min_qty ?? '') }}" required>
                    </div>
                </div>
                <div class="col-12">
                    <table class="table table-bordered" id="material_brand">
                        <thead>
                        <tr>
                            <th>Material Brand</th>
                            <th>Material Model</th>
                            <th><i class="btn btn-primary btn-sm fa fa-plus add-stock-row"></i></th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                        @php
                            $material_brands = old('brand_id', !empty($material) ? $material->material_brand->pluck('brand_id') : []);
                            $brand_id = old('brand_id', !empty($material) ? $material->material_brand->pluck('brand_id') : []);
                            $model = old('model', !empty($material) ? $material->material_model->pluck('model') : []);
                        @endphp
                        @foreach ($material_brands as $key => $detail)
                            <tr>
                                <td>
                                    <select name="brand_id[]" class="form-control brand select2" autocomplete="off">
                                        <option value="">Select Brand</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}" @selected($brand->id == $brand_id[$key])>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input list="models" name="model[]" id="model[]" class="form-control model" value="{{ $material_models[$loop->index]}}">
                                    <datalist id="models">
                                        @foreach ($material_models as $material_model)
                                            <option value="{{ $material_model }}">
                                        @endforeach
                                    </datalist>
                                </td>
                                <td>
                                    <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i>
                                </td>
                            </tr>
                        @endforeach
                        </tfoot>
                    </table>
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
        $(window).scroll(function () {
            //set scroll position in session storage
            sessionStorage.scrollPos = $(window).scrollTop();
        });
        var init = function () {
            //get scroll position in session storage
            $(window).scrollTop(sessionStorage.scrollPos || 0)
        };
        window.onload = init;

        $(document).ready(function () {
            $('#dataTable').DataTable({
                stateSave: true
            });
        });
    </script>
    <script>
        function logSelectedCategory(option) {
            console.log(option.value);
        }
    </script>
    <script>
        // Add an event listener using jQuery
        $(document).ready(function () {
            $('#category-name').on('change', function () {
                // Get the selected option's value
                var selectedOption = $(this).val();
                // console.log(selectedOption);
                $.ajax({
                    url: "{{ route('get-unique-code') }}",
                    data: {
                        id: selectedOption,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (data) {
                        console.log(data);
                        $('#code').val(data);
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#brand').select2();
        });
    </script>
    <script>
        @if (empty($material) && empty(old('material_id')))
        appendCalculationRow();
        @endif

        function appendCalculationRow() {
            var type = $("input[name=type]:checked").val()

            let row = `<tr>
        <td>
            <select name="brand_id[]" class="form-control brand select2" autocomplete="off">
                <option value="">Select Brand</option>
                @foreach ($brands as $brand)
            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                @endforeach
            </select>
        </td>
        <td>
        <input list="models" name="model[]" id="model[]" class="form-control model">
            <datalist id="models">
                @foreach ($material_models as $material_model)
            <option value="{{ $material_model }}">
                @endforeach
            </datalist>
        </td>
        <td>
        <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i>
        </td>
        </tr>`;
            $('#material_brand tbody').append(row);
            $('.select2').select2({});
        }

        $(document).ready(function () {
            $("#material_brand")
                .on('click', '.add-stock-row', () => {
                    appendCalculationRow();
                })
                .on('click', '.remove-calculation-row', function () {
                    $(this).closest('tr').remove();
                });
        });
    </script>
@endsection
