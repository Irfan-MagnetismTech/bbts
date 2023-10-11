@extends('layouts.backend-layout')
@section('title', 'Connectivity Requirement List')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    Planning List
@endsection

@section('breadcrumb-button')
    {{-- <a href="{{ route('connectivity-requirement.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-plus"></i></a> --}}
@endsection
@section('sub-title')
    Total: {{ count($plans) }}
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
                    <th>Connectivity Point</th>
                    <th>Method</th>
                    <th>Type</th>
                    <th>Option</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#SL</th>
                    <th>Client Name</th>
                    <th>Client id</th>
                    <th>MQ No</th>
                    <th>FR No</th>
                    <th>Connectivity Point</th>
                    <th>Method</th>
                    <th>Type</th>
                    <th>Option</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($plans as $key => $plan)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $plan->lead_generation->client_name }}</td>
                        <td>{{ $plan->client_no }}</td>
                        <td>{{ $plan->mq_no }}</td>
                        <td>{{ $plan->fr_no }}</td>
                        <td>{{ $plan->feasibilityRequirementDetail->connectivity_point ?? '' }}</td>
                        <td>
                            @foreach ($plan->planLinks as $link)
                                {{ $link->method }}<br>
                            @endforeach
                        </td>
                        <td>
                            @foreach ($plan->planLinks as $link)
                                {{ $link->link_type }}<br>
                            @endforeach
                        </td>
                        <td>
                            @foreach ($plan->planLinks as $link)
                                {{ $link->option }}<br>
                            @endforeach
                        </td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    @can('plan-view')
                                        <a href="{{ route('planning.show', $plan->id) }}" data-toggle="tooltip" title="Details"
                                            class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                    @endcan
                                    @can('plan-edit')
                                        <a href="{{ route('planning.edit', $plan->id) }}" data-toggle="tooltip" title="Edit"
                                            class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    @endcan
                                    @can('plan-delete')
                                        <form action="{{ route('planning.destroy', $plan->id) }}" method="POST"
                                            data-toggle="tooltip" title="Delete" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm delete"><i
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
