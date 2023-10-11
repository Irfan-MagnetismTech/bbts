@extends('layouts.backend-layout')
@section('title', 'Client Profile List')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    Client Profile List
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('client-profile.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-plus"></i></a>
@endsection
@section('sub-title')
    Total: {{ count($client_profiles) }}
@endsection


@section('content')
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>Date</th>
                    <th>Client id</th>
                    <th>Client Name</th>
                    <th>Contact Person</th>
                    <th>Designation</th>
                    <th>Contact No</th>
                    <th>Created By</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#SL</th>
                    <th>Date</th>
                    <th>Client id</th>
                    <th>Client Name</th>
                    <th>Contact Person</th>
                    <th>Designation</th>
                    <th>Contact No</th>
                    <th>Created By</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($client_profiles as $key => $client_profile)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $client_profile->created_at->format('d-m-Y') }}</td>
                        <td>{{ $client_profile->client_no }}</td>
                        <td>{{ $client_profile->client_name }}</td>
                        <td>{{ $client_profile->contact_person }}</td>
                        <td>{{ $client_profile->designation }}</td>
                        <td>{{ $client_profile->contact_no }}</td>
                        <td>{{ $client_profile->createdBy->name }}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    @can('client-edit')
                                        <a href="{{ route('client-profile.show', $client_profile->id) }}" data-toggle="tooltip"
                                            title="Details" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                    @endcan
                                    @can('client-edit')
                                        <a href="{{ route('client-profile.edit', $client_profile->id) }}" data-toggle="tooltip"
                                            title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    @endcan
                                    @can('client-delete')
                                        <form action="{{ route('client-profile.destroy', $client_profile->id) }}"
                                            method="POST" class="d-inline" id="deleteClientProfile">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    @endcan
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
    @if (Session::has('success'))
        <script type="text/javascript">
            Toast.fire({
                icon: 'success',
                title: '{!! Session::get('success') !!}',
            })
        </script>
    @endif
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

        $(document).on('click', '#deleteClientProfile', function(e) {
            e.preventDefault();
            var form = this;
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
                    form.submit();
                }
            })
        });
    </script>
@endsection
