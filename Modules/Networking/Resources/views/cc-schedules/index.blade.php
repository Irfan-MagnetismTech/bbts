@extends('layouts.backend-layout')
@section('title', 'Client Activation Pre-Process')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">

    <style>
        .checkbox-fade .cr {
            height: 10px;
            width: 10px;
        }

        .noWrapStyle {
            white-space: normal;
            min-width: 12rem;
        }
    </style>
@endsection

@section('breadcrumb-title')
    Client Activation Pre-Process
@endsection


@section('breadcrumb-button')
    <a href="{{ route('physical-connectivities.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i
            class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($salesDetails) }}
@endsection

@section('content')
    <!-- put search form here -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Client Name</th>
                    <th>FR No</th>
                    <th>Connectivity Point</th>
                    <th>New/Existing</th>
                    <th>Delivery Date</th>
                    <th>Commissioning Date</th>
                    <th>Status</th>
                    <th>Connectivity Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($salesDetails as $key => $details)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $details->client->client_name }}</td>
                        <td>{{ $details->fr_no }}</td>
                        <td class="noWrapStyle">{{ $details->frDetails->connectivity_point }}</td>
                        <td></td>
                        <td>{{ $details->delivery_date }}</td>
                        <td></td>
                        <td class="noWrapStyle">
                            <span class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="dns_checkbox" name='dns_checkbox' value="dns"
                                        class="dns_checkbox" @checked($details->sale->management_approval == 'Approved')>
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span class="font-weight-bold">PNL</span>
                                </label>
                            </span>
                            <span class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="dns_checkbox" name='dns_checkbox' value="dns"
                                        class="dns_checkbox">
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span class="font-weight-bold">NTTN/Service</span>
                                </label>
                            </span>
                            <span class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="dns_checkbox" name='dns_checkbox' value="dns"
                                        class="dns_checkbox">
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span class="font-weight-bold">Client</span>
                                </label>
                            </span>
                            <span class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="dns_checkbox" name='dns_checkbox' value="dns"
                                        class="dns_checkbox">
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span class="font-weight-bold">Equipment</span>
                                </label>
                            </span>
                            <span class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="dns_checkbox" name='dns_checkbox' value="dns"
                                        class="dns_checkbox">
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span class="font-weight-bold">Field Ops</span>
                                </label>
                            </span>
                            <span class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="dns_checkbox" name='dns_checkbox' value="dns"
                                        class="dns_checkbox">
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span class="font-weight-bold">Schedule</span>
                                </label>
                            </span>
                        </td>
                        <td class="noWrapStyle">
                            <span class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="dns_checkbox" name='dns_checkbox' value="dns"
                                        class="dns_checkbox">
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span class="font-weight-bold">Physical Link</span>
                                </label>
                            </span>
                            <span class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="dns_checkbox" name='dns_checkbox' value="dns"
                                        class="dns_checkbox">
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span class="font-weight-bold">Logical Connectivity</span>
                                </label>
                            </span>
                            <span class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="dns_checkbox" name='dns_checkbox' value="dns"
                                        class="dns_checkbox">
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span class="font-weight-bold">Commissioning Date</span>
                                </label>
                            </span>
                            <span class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="dns_checkbox" name='dns_checkbox' value="dns"
                                        class="dns_checkbox">
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span class="font-weight-bold">Biling Date</span>
                                </label>
                            </span>
                        </td>

                        <td>
                            @if($details->sale->management_approval == 'Approved')
                            <span class="badge badge-info">
                                <a href="{{ route('cc-schedules.create', ['fr_no' => $details->fr_no]) }}"
                                    class="text-white" target="_blank">Scheduling</a>
                            </span>
                            @endif
                            <span class="badge badge-info">
                                <a href="{{ route('cc-schedules.create', ['physical_connectivity_id' => $details->id]) }}"
                                    class="text-white" target="_blank">Plan</a>
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {});
    </script>
@endsection
