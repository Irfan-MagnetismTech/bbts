@extends('layouts.backend-layout')
@section('title', 'Categories')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title', 'Categories')

@section('breadcrumb-button')
@endsection

@section('sub-title')
@endsection
@section('content')
    <div class="row">
        <div class="col-md-5 pr-md-1 my-1 my-md-0">
            {{ Form::text('name', old('name') ? old('name') : (!empty($category->name) ? $category->name : null), ['class' => 'form-control form-control-sm', 'id' => 'name', 'placeholder' => 'Enter category Name', 'autocomplete' => 'off']) }}
            <input type="hidden" name="old_name" id="old_name" value="">
            <input type="hidden" name="id" value="">
        </div>
        <div class="col-md-2 pl-md-1 my-1 my-md-0">
            <div class="input-group input-group-sm">
                <button class="btn btn-success btn-sm btn-block" onclick="CreateOrUpdateCategory()">Submit</button>
            </div>
        </div>
    </div><!-- end form row -->

    {!! Form::close() !!}
    <hr class="my-2 bg-success">
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Category Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Category Name</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody id="categoryList">
                @forelse ($categories as $key => $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $data->name }}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="#" onclick="editCategory({{ $data->id }}, '{{ $data->name }}')"
                                        data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i
                                            class="fas fa-pen"></i></a>
                                    <a href="#" onclick="deleteCategory({{ $data->id }})" data-toggle="tooltip"
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
    <script>
        function CreateOrUpdateCategory() {
            //create or update with fetch
            var old_name = $('input[name="old_name"]').val();
            var url = "{{ route('category.store') }}";
            var method = 'POST';
            var id = $('input[name="id"]').val();
            if (id) {
                url = "{{ route('category.update', ':id') }}";
                url = url.replace(':id', id);
                method = 'PUT';
            }
            var name = $('input[name="name"]').val();
            var data = {
                name: name,
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
                            var totalRow = $('#dataTable tbody tr').length;
                            var sl = totalRow + 1;
                            var appendRow = `<tr>
                            <td>${sl}</td>
                            <td class="text-center">${data.category.name}</td>
                            <td>
                                <div class="icon-btn">
                                    <nobr>
                                        <a href="#" onclick="editCategory(${data.category.id}, ${data.category.name})" data-toggle="tooltip" title="Edit"
                                        class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                        {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete']) }}
                                    </nobr>
                                </div>
                            </td>
                            </tr>`;
                            $('#categoryList').append(appendRow);
                            $('input[name="name"]').val('');
                            $('input[name="id"]').val('');
                        } else {
                            var row = $(`#categoryList tr td:contains(${old_name})`).parent();
                            row.find('td:eq(1)').text('');
                            row.find('td:eq(1)').text(data.category.name);
                            row.find('td:eq(2) a:eq(0)').attr('onclick',
                                `editCategory(${data.category.id}, '${data.category.name}')`);
                            $('input[name="name"]').val('');
                            $('input[name="id"]').val('');
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
            $('input[name="old_name"]').val(name);
        }

        const deleteCategory = (id) => {
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
                    var url = "{{ route('category.destroy', ':id') }}";
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
                                var row = $(`#categoryList tr td:contains(${id})`).parent();
                                row.remove();
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
