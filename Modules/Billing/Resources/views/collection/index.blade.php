@extends('layouts.backend-layout')
@section('title', 'Bill Collection List')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    Bill Collection List
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('collections.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-plus"></i></a>
@endsection
@section('sub-title')
    Total: {{ count($datas) }}
@endsection


@section('content')
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>Client Name</th>
                    <th>Date</th>
                    <th>MR No</th>
                    <th>Remarks</th>
                    <th>Total Amount</th>
                    <th>Total Net Amount</th>
                    <th>Total Receive Amount</th>
                    <th>Total Due</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#SL</th>
                    <th>Client Name</th>
                    <th>Date</th>
                    <th>MR No</th>
                    <th>Remarks</th>
                    <th>Total Amount</th>
                    <th>Total Net Amount</th>
                    <th>Total Receive Amount</th>
                    <th>Total Due</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($datas as $key => $data)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $data->client->client_name }}</td>
                        <td>{{ $data->date }}</td>
                        <td>{{ $data->mr_no }}</td>
                        <td>{{ $data->remarks }}</td>
                        <td>{{ $data->total_amount }}</td>
                        <td>{{ $data->total_net_amount }}</td>
                        <td>{{ $data->total_receive_amount }}</td>
                        <td>{{ $data->total_due }}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ route('collections.show', $data->id) }}"
                                        data-toggle="tooltip" title="Details" class="btn btn-outline-primary"><i
                                            class="fas fa-eye"></i></a>

                                    <a href="{{ route('collections.edit', $data->id) }}"
                                        data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i
                                            class="fas fa-pen"></i></a>

                                    <form
                                        action="{{ route('collections.destroy', $data->id) }}"
                                        method="POST" class="d-inline" id="deleteClientProfile">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
                                    {{-- add offer  --}}
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

        // Delete Feasibility Requirement alert message
        $(document).on('click', '#deleteFeasibility', function(e) {
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
