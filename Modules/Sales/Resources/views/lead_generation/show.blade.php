@extends('layouts.backend-layout')
@section('title', 'Pre Sale Client')

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
Pre Sale Client
@endsection

@section('style')
<style>
</style>
@endsection
@section('breadcrumb-button')
<a href="{{ route('lead-generation.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-plus"></i></a>
<a href="{{ route('lead-generation.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection
@section('sub-title')
Client: {{ $lead_generation->client_name }}
@endsection


@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <!-- table  -->
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered" style="font-size: 12px;">
                            <tr>
                                <th>Client Name</th>
                                <td>{{ $lead_generation->client_name }}</td>
                                <th>Address</th>
                                <td>{{ $lead_generation->address }}</td>
                            </tr>
                            <tr>
                                <th>Division</th>
                                <td>{{ $lead_generation->division->name ?? '' }}</td>
                                <th>District</th>
                                <td>{{ $lead_generation->district->name ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Thana</th>
                                <td>{{ $lead_generation->thana->name ?? '' }}</td>
                                <th>Landmark</th>
                                <td>{{ $lead_generation->landmark }}</td>
                            </tr>
                            <tr>
                                <th>Lat-Long</th>
                                <td>{{ $lead_generation->lat_long }}</td>
                                <th>Contact Person</th>
                                <td>{{ $lead_generation->contact_person }}</td>
                            </tr>
                            <tr>
                                <th>Contact No</th>
                                <td>{{ $lead_generation->contact_no }}</td>
                                <th>Email</th>
                                <td>{{ $lead_generation->email }}</td>
                            </tr>
                            <tr>
                                <th>Website</th>
                                <td>{{ $lead_generation->website }}</td>
                                <th>Document</th>
                                <td>
                                    @if($lead_generation->document)
                                    <a href="{{ asset('uploads/lead_generation/'.$lead_generation->document) }}" target="_blank" class="btn btn-sm btn-warning" style="font-size:14px;"><i class="fas fa-eye"></i></a>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('js/Datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/Datatables/dataTables.bootstrap4.min.js') }}"></script>
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

    $(document).ready(function() {
        $('#dataTable').DataTable({
            stateSave: true
        });
    });
</script>
@endsection