@extends('layouts.backend-layout')
@section('title', 'Products')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title', 'Products')

@section('breadcrumb-button')
@endsection

@section('sub-title')
@endsection
@section('content')
    <div class="row">
        <div class="col-md-3 pr-md-1 my-1 my-md-0">
            {{ Form::text('name', old('name') ? old('name') : (!empty($product->name) ? $product->name : null), ['class' => 'form-control form-control-sm', 'id' => 'name', 'placeholder' => 'Enter Product Name', 'autocomplete' => 'off']) }}
            <input type="hidden" name="id" value="">
        </div>
        <div class="col-md-3 pr-md-1 my-1 my-md-0">
            {{ Form::text('code', old('code') ? old('code') : (!empty($product->code) ? $product->code : null), ['class' => 'form-control form-control-sm', 'id' => 'code', 'placeholder' => 'Enter Product Code', 'autocomplete' => 'off']) }}
        </div>
        <div class="col-md-3 pr-md-1 my-1 my-md-0">
            <select name="category_id" id="category_id" class="form-control form-control-sm">
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 pr-md-1 my-1 my-md-0">
            <select name="unit" id="unit" class="form-control form-control-sm">
                <option value="">Select Unit</option>
                @foreach ($units as $unit)
                    <option value="{{ $unit }}">{{ $unit }}</option>
                @endforeach
            </select>
        </div>
    </div><!-- end form row -->
    <div class="row justify-content-end">
        <div class="col-md-2 mt-3 ">
            <div class="input-group input-group-sm">
                <button class="btn btn-success btn-sm btn-block" onclick="CreateOrUpdateProduct()">Submit</button>
            </div>
        </div>
    </div>

    {!! Form::close() !!}
    <hr class="my-2 bg-success">
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Product Name</th>
                    <th>Code</th>
                    <th>Category</th>
                    <th>Unit</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Product Name</th>
                    <th>Code</th>
                    <th>Category</th>
                    <th>Unit</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody id="productList">
                @forelse ($products as $key => $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $data->name }}</td>
                        <td class="text-center">{{ $data->code }}</td>
                        <td class="text-center">{{ $data->category->name }}</td>
                        <td class="text-center">{{ $data->unit }}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="#" onclick="editProduct({{ $data->id }}, '{{ $data->name }}')"
                                        data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i
                                            class="fas fa-pen"></i></a>
                                    <a href="#" onclick="deleteProduct({{ $data->id }})" data-toggle="tooltip"
                                        title="Delete" class="btn btn-outline-danger"><i class="fas fa-trash"></i></a>


                                </nobr>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No data found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection


@section('script')
    <script src="{{ asset('js/Datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/Datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function CreateOrUpdateProduct() {
            //create or update with fetch
            var url = "{{ route('product.store') }}";
            var method = 'POST';
            var id = $('input[name="id"]').val();
            if (id) {
                url = "{{ route('product.update', ':id') }}";
                url = url.replace(':id', id);
                method = 'PUT';
            }
            var name = $('input[name="name"]').val();
            var code = $('input[name="code"]').val();
            var category_id = $('select[name="category_id"]').val();
            var unit = $('select[name="unit"]').val();

            var data = {
                name: name,
                code: code,
                category_id: category_id,
                unit: unit,
            };
            fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Toast.fire({
                            icon: 'success',
                            title: data.message
                        })
                        if (id == '') {
                            console.log(data.product)
                            var totalRow = $('#dataTable tbody tr').length;
                            var sl = totalRow + 1;
                            var appendRow = `<tr>
                            <td>${sl}</td>
                            <td class="text-center">${data.product.name ? data.product.name : ''}</td>
                            <td class="text-center">${data.product.code ? data.product.code : '' }</td>
                            <td class="text-center">${data.product.category.name ? data.product.category.name : ''}</td>
                            <td class="text-center">${data.product.unit ? data.product.unit : ''}</td>
                            <td>
                                <div class="icon-btn">
                                    <nobr>
                                        <a href="#" onclick="editProduct(${data.product.id ?? '' })" data-toggle="tooltip" title="Edit"
                                        class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                        <a href="#" onclick="deleteProduct(${data.product.id})" data-toggle="tooltip" title="Delete"
                                        class="btn btn-outline-danger"><i class="fas fa-trash"></i></a>
                                    </nobr>
                                </div>
                            </td>
                            </tr>`;
                            $('#productList').append(appendRow);
                            //insert value in products array
                            var product = {
                                id: data.product.id,
                                name: data.product.name,
                                code: data.product.code,
                                category: data.product.category.name,
                                unit: data.product.unit,
                            };
                            setTimeout(() => {
                                location.reload()
                            }, 200);
                        } else {
                            setTimeout(() => {
                                location.reload()
                            }, 200);

                        }
                    } else {
                        toastr.error(data.message);
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        }

        const editCategory = (id, name) => {
            $('input[name="id"]').val(id);
            $('input[name="name"]').val(name);
        }

        const deleteProduct = (id) => {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    //delete with fetch
                    var url = "{{ route('product.destroy', ':id') }}";
                    url = url.replace(':id', id);
                    fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Toast.fire({
                                    icon: 'success',
                                    title: data.message
                                })
                                setTimeout(() => {
                                    location.reload();
                                }, 300);
                            } else {
                                toastr.error(data.message);
                            }
                        })
                        .catch((error) => {
                            console.error('Error:', error);
                        });
                }
            })
        }

        function editProduct(id) {
            var products = @json($products);
            var product = products.find(product => product.id == id);
            $('input[name="id"]').val(product.id);
            $('input[name="name"]').val(product.name);
            $('input[name="code"]').val(product.code);
            //select category
            $('select[name="category_id"]').val(product.category_id);
            $('select[name="unit"]').val(product.unit);
        }

        $(window).scroll(function() {
            //set scroll position in session storage
            sessionStorage.scrollPos = $(window).scrollTop();
        });
        var init = function() {
            //get scroll position in session storage
            $(window).scrollTop(sessionStorage.scrollPos || 0)
        };
        window.onload = init;
    </script>
@endsection
