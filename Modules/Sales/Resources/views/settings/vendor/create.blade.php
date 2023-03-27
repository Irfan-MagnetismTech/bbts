@extends('layouts.backend-layout')
@section('title', 'Vendors')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title', 'Vendors')

@section('breadcrumb-button')
@endsection

@section('sub-title')
@endsection
@section('content')
    <div class="row">
        <div class="col-md-3 pr-md-1 my-1 my-md-0">
            <input type="text" name="name" id="name" class="form-control form-control-sm"
                placeholder="Enter Vendor Name" autocomplete="off">
            <input type="hidden" name="id" value="">
        </div>
        <div class="col-md-3 pr-md-1 my-1 my-md-0">
            <input type="text" name="address" id="address" class="form-control form-control-sm"
                placeholder="Enter Address" autocomplete="off">
        </div>
        <div class="col-md-3 pr-md-1 my-1 my-md-0">
            <input type="text" name="contact_no" id="contact_no" class="form-control form-control-sm"
                placeholder="Enter Contact No" autocomplete="off">
        </div>
        <div class="col-md-3 pr-md-1 my-1 my-md-0">
            <input type="text" name="email" id="email" class="form-control form-control-sm"
                placeholder="Enter Email" autocomplete="off">
        </div>
    </div><!-- end form row -->
    <div class="row justify-content-end">
        <div class="col-md-2 mt-3 ">
            <div class="input-group input-group-sm">
                <button class="btn btn-success btn-sm btn-block" onclick="CreateOrUpdateVendor()">Submit</button>
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
                    <th>Vendor Name</th>
                    <th>Address</th>
                    <th>Contact No</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Vendor Name</th>
                    <th>Address</th>
                    <th>Contact No</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody id="productList">
                @foreach ($vendors as $key => $vendor)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $vendor->name }}</td>
                        <td class="text-center">{{ $vendor->address }}</td>
                        <td class="text-center">{{ $vendor->contact_no }}</td>
                        <td class="text-center">{{ $vendor->email }}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="#" onclick="editVendor({{ $vendor->id }}, '{{ $vendor->name }}')"
                                        data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i
                                            class="fas fa-pen"></i></a>
                                    <a href="#" onclick="deleteVendor({{ $vendor->id }})" data-toggle="tooltip"
                                        title="Delete" class="btn btn-outline-danger"><i class="fas fa-trash"></i></a>


                                </nobr>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection


@section('script')
    <script src="{{ asset('js/Datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/Datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        function CreateOrUpdateVendor() {
            console.log('create or update vendor')
            var url = "{{ route('vendor.store') }}";
            var method = 'POST';
            var id = $('input[name="id"]').val();
            if (id) {
                url = "{{ route('vendor.update', ':id') }}";
                url = url.replace(':id', id);
                method = 'PUT';
            }
            var name = $('input[name="name"]').val();
            var address = $('input[name="address"]').val();
            var contact_no = $('input[name="contact_no"]').val();
            var email = $('input[name="email"]').val();
            var data = {
                name: name,
                address: address,
                contact_no: contact_no,
                email: email
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
                    console.log(data);
                    if (data.success) {
                        Toast.fire({
                            icon: 'success',
                            title: data.message
                        })
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: data.message
                        })
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        }

        const editVendor = (id, name) => {
            var vendor = @json($vendors);
            var vendor = vendor.find(vendor => vendor.id == id);
            $('input[name="id"]').val(vendor.id);
            $('input[name="name"]').val(vendor.name);
            $('input[name="address"]').val(vendor.address);
            $('input[name="contact_no"]').val(vendor.contact_no);
            $('input[name="email"]').val(vendor.email);
        }

        const deleteVendor = (id) => {
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
                    var url = "{{ route('vendor.destroy', ':id') }}";
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
                                }, 500);
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
