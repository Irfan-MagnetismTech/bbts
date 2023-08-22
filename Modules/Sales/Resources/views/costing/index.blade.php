@extends('layouts.backend-layout')
@section('title', 'Costing List')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    Costing List
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    {{-- <a href="{{ route('connectivity-requirement.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-plus"></i></a> --}}
@endsection
@section('sub-title')
    Total: {{ count($costings) }}
@endsection


@section('content')
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>Client Name</th>
                    <th>Client id</th>
                    <th>MQ No</th>
                    <th>FR No</th>
                    <th>Per month Investment</th>
                    <th>Per month Revenue</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#SL</th>
                    <th>Client Name</th>
                    <th>Client id</th>
                    <th>FR No</th>
                    <th>Per month Investment</th>
                    <th>Per month Revenue</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($costings as $key => $costing)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $costing->lead_generation->client_name }}</td>
                        <td>{{ $costing->client_no }}</td>
                        <td>{{ $costing->planning->feasibilityRequirementDetail->connectivity_point }}
                            ({{ $costing->fr_no }})
                        </td>
                        <td>{{ number_format($costing->total_investment / $costing->month, 2) }}</td>
                        <td>{{ $costing->total_mrc }}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ route('costing.show', $costing->id) }}" data-toggle="tooltip"
                                        title="Details" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>

                                    <a href="{{ route('costing.edit', $costing->id) }}" data-toggle="tooltip"
                                        title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>

                                    <form action="{{ route('costing.destroy', $costing->id) }}" method="POST"
                                        class="d-inline" id="deleteClientProfile">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
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
