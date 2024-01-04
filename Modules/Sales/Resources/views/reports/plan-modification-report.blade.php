@extends('layouts.backend-layout')
@section('title', 'Plan Reports')

@section('style')

@endsection

@section('breadcrumb-title')
    Plan Modification Reports
@endsection

@section('style')
    <style>
    </style>
@endsection

@section('sub-title')
    Total Tickets: {{ $plan_reports->count() }} <br>
    <small>(Last 30 Days)</small>

@endsection


@section('content')
    <form action="" method="get" class="my-4">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="ticket_no" class="font-weight-bold">Client Name:</label>
                    <select name="client_no" id="client_no" class="form-control select2">
                        <option value="">Select Client</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->client_no }}" @if (request()->client_no == $client->client_no) selected @endif>
                                {{ $client->client_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="date_from" class="font-weight-bold">From Date:</label>
                    <input type="text" class="form-control date" id="date_from" name="date_from"
                        aria-describedby="date_from" value="{{ old('date_from') ?? (request()?->date_from ?? null) }}"
                        readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="date_to" class="font-weight-bold">To Date:</label>
                    <input type="text" class="form-control date" id="date_to" name="date_to" aria-describedby="date_to"
                        value="{{ old('date_to') ?? (request()?->date_to ?? null) }}" readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="date_to" class="font-weight-bold">Select Type:</label>
                    <select name="type" id="type" class="form-control">
                        <option value="">Select Type</option>
                        <option value="Report">Report</option>
                        <option value="PDF">PDF</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group my-4 row">
                    <div class="col-md-6">
                        <input type="button" onclick="resetForm()" value="Reset"
                            class="btn btn-outline-warning btn-sm col-12">
                    </div>
                    <div class="col-md-6">
                        <input type="submit" value="Search" class="btn btn-outline-primary btn-sm col-12">
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>Client ID</th>
                    <th>Client Name</th>
                    <th>Connectivity Point</th>
                    <th>Asked for plan note</th>
                    <th>Plan Provided</th>
                    <th>Remarks (Plan for)</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($plan_reports as $key => $plan_report)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $plan_report->client_no }}</td>
                        <td>{{ $plan_report?->lead_generation?->client_name }}</td>
                        <td>{{ $plan_report?->feasibilityRequirementDetail?->connectivity_point }}</td>
                        <td>{{ date('d-m-Y h:m A', strtotime($plan_report->ConnectivityRequirement->created_at)) }}</td>
                        <td>{{ date('d-m-Y h:m A', strtotime($plan_report->created_at)) }}</td>
                        <td>{{ $plan_report->remarks }}</td>
                        <td>
                            <a href="{{ route('client-plan-modification.show', $plan_report->id) }}"
                                class="btn btn-outline-primary btn-sm"><i class="fa fa-eye"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.date').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true,
            });

            select2Ajax("{{ route('search-support-ticket') }}", '#ticket_no')
        })

        function resetForm() {
            $('#date_from').val('');
            $('#date_to').val('');
            $('#client_no').val('').trigger("change");
            // $('#ticket_no').prop('selectedIndex',0);
        }
    </script>
@endsection
