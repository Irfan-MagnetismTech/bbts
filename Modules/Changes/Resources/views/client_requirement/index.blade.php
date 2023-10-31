@extends('layouts.backend-layout')
@section('title', 'Client Requirement Modification List')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    Client Requirement Modification List
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
@endsection
@section('sub-title')
    Total: {{ count($client_requirements) }}
@endsection


@section('content')
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>Client Name</th>
                    <th>Client No</th>
                    <th>FR No</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#SL</th>
                    <th>Client Name</th>
                    <th>Client No</th>
                    <th>FR No</th>
                    <th>Date</th>
                    <th>Reason</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($client_requirements as $key => $client_requirement)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $client_requirement->lead_generation->client_name }}</td>
                        <td>{{ $client_requirement->client_no }}</td>
                        <td>{{ $client_requirement->fr_no }}</td>
                        <td>{{ $client_requirement->date }}</td>
                        <td>{{ $client_requirement->change_type ?? '' }}</td>
                        <td>
                            <div class="icon-btn">
                                {{-- @dd(!empty($client_requirement->modificationSurvey)); --}}
                                <nobr>
                                    @if (empty($client_requirement->costingByConnectivity) &&
                                            !empty($client_requirement->modificationPlan) &&
                                            !empty($client_requirement->modificationSurvey))
                                        <a href="{{ url("changes/costing-modification/$client_requirement->id/create") }}"
                                            class="btn btn-sm btn-success">Add Costing</a>
                                    @elseif (!empty($client_requirement->modificationSurvey && empty($client_requirement->modificationPlan)))
                                        <a href="{{ url("changes/client-plan-modification/$client_requirement->id/create") }}"
                                            class="btn btn-sm btn-success">Add Planning</a>
                                    @elseif(!empty($client_requirement->offerByConnectivity) && empty($client_requirement->modificationSurvey))
                                        <a href="{{ route('add-modified-survey', $client_requirement->id) }}"
                                            class="btn btn-sm btn-success">Add Survey</a>
                                    @elseif(empty($client_requirement->offerByConnectivity))
                                        <a href="{{ url("changes/add-modified-offer/$client_requirement->id/create") }}"
                                            class="btn btn-sm btn-success">Add Offer</a>
                                    @elseif(!empty($client_requirement->offerByConnectivity) && empty($client_requirement->modificationSale))
                                        <a href="{{ url("changes/sales-modification/$client_requirement->id/create") }}"
                                            class="btn btn-sm btn-success">Add Sale</a>
                                    @else
                                    @endif
                                    <a href="{{ route('connectivity-requirement.show', $client_requirement->id) }}"
                                        data-toggle="tooltip" title="Details" class="btn btn-outline-primary"><i
                                            class="fas fa-eye"></i></a>

                                    <a href="{{ route('client-requirement-modification.edit', $client_requirement->id) }}"
                                        data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i
                                            class="fas fa-pen"></i></a>

                                    <form action="{{ route('connectivity-requirement.destroy', $client_requirement->id) }}"
                                        method="POST" class="d-inline" id="deleteClientProfile">
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
