@extends('layouts.backend-layout')
@section('title', 'Feasibility Requirement List')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    Feasibility Requirement List
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('feasibility-requirement.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-plus"></i></a>
@endsection
@section('sub-title')
    Total: {{ count($feasibility_requirements) }}
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
                    <th>Total FR </th>
                    <th>Survey/Planing</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#SL</th>
                    <th>Client Name</th>
                    <th>Client id</th>
                    <th>MQ No</th>
                    <th>Total FR </th>
                    <th>Survey/Planing</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($feasibility_requirements as $key => $feasibility_requirement)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $feasibility_requirement->lead_generation->client_name }}</td>
                        <td>{{ $feasibility_requirement->client_id }}</td>
                        <td>{{ $feasibility_requirement->mq_no }}</td>
                        <td>{{ $feasibility_requirement->feasibilityRequirementDetails->count() }}</td>
                        <td>{{ $feasibility_requirement->feasibilityRequirementDetails[0]->surveySum->count() ?? '' }}/0</td>
                        <td>{{ $feasibility_requirement->is_existing }}</td>
                        <td>
                            <a href="{{ route('feasibility-requirement.edit', $feasibility_requirement->id) }}"
                                class="btn btn-sm btn-primary" style="padding: 6px 7px;"><i class="fas fa-edit"></i></a>
                            <a href="{{ route('feasibility-requirement.show', $feasibility_requirement->id) }}"
                                class="btn btn-sm btn-success" style="padding: 6px 7px;"><i class="fas fa-eye"></i></a>
                            <form action="{{ route('feasibility-requirement.destroy', $feasibility_requirement->id) }}"
                                method="POST" class="d-inline-block" id="deleteFeasibility">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
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
