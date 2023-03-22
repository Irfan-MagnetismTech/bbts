@extends('layouts.backend-layout')
@section('title', 'Pre Sale Client List')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    Pre Sale Client List
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('lead-generation.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-plus"></i></a>
@endsection
@section('sub-title')
    Total: {{ count($lead_generations) }}
@endsection


@section('content')
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>Client Name</th>
                    <th>Client id</th>
                    <th>Address</th>
                    <th>Divison</th>
                    <th>District</th>
                    <th>Thana</th>
                    <th>Contact Person</th>
                    <th>Contact No</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#SL</th>
                    <th>Client Name</th>
                    <th>Client id</th>
                    <th>Address</th>
                    <th>Divison</th>
                    <th>District</th>
                    <th>Thana</th>
                    <th>Contact Person</th>
                    <th>Contact No</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($lead_generations as $key => $lead_generation)
                    <tr>
                        <td> {{ $key + 1 }} </td>
                        <td> {{ $lead_generation->client_name }} </td>
                        <td> {{ $lead_generation->client_id }} </td>
                        <td> {{ $lead_generation->address }} </td>
                        <td> {{ $lead_generation->division->name ?? '' }} </td>
                        <td> {{ $lead_generation->district->name ?? '' }} </td>
                        <td> {{ $lead_generation->thana->name ?? '' }} </td>
                        <td> {{ $lead_generation->contact_person }} </td>
                        <td> {{ $lead_generation->contact_no }} </td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ route('lead-generation.show', $lead_generation->id) }}"
                                        data-toggle="tooltip" title="Details" class="btn btn-outline-primary"><i
                                            class="fas fa-eye"></i></a>

                                    <a href="{{ route('lead-generation.edit', $lead_generation->id) }}"
                                        data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i
                                            class="fas fa-pen"></i></a>

                                    <form action="{{ route('lead-generation.destroy', $lead_generation->id) }}"
                                        method="POST" data-toggle="tooltip" title="Delete" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm delete"><i
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
    </script>
@endsection
