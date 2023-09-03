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
                    <th>Billing Date</th>
                    <th>Commissioning Date</th>
                    <th>PNL Approved</th>
                    <th>Connectivity Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($salesDetails as $key => $details)
                    {{-- @dd($details->ccSchedule->approved_type) --}}
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $details->client->client_name }}</td>
                        <td>{{ $details->fr_no }}</td>
                        <td class="noWrapStyle">{{ $details->frDetails->connectivity_point }}</td>
                        <td></td>
                        <td>{{ date('d-m-Y', strtotime($details->delivery_date)) }}</td>
                        <td class="billing_date">{{ date('d-m-Y', strtotime($details->billing_date)) }}</td>
                        <td>{{ date('d-m-Y', strtotime($details->commissioning_date)) }}</td>
                        <td class="noWrapStyle">
                            {{ date('d-m-Y', strtotime($details->sale->approval_date)) }}
                            {{-- <span class="checkbox-fade">
                                <label>
                                    <input type="checkbox" disabled @checked($details->sale->management_approval == 'Approved')>
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span class="font-weight-bold">PNL</span>
                                </label>
                            </span> --}}

                            {{-- <x-checkbox arrayValue="nttn" label="NTTN/Service" :sale="$details" />
                            <x-checkbox arrayValue="cr" label="Client" :sale="$details" />
                            <x-checkbox arrayValue="er" label="Equipment" :sale="$details" />
                            <x-checkbox arrayValue="fo" label="Field Ops" :sale="$details" />
                            <x-checkbox arrayValue="schedule" label="Schedule" :sale="$details" /> --}}
                        </td>
                        <td class="noWrapStyle text-left">
                            <span class="checkbox-fade">
                                <label>
                                    <input type="checkbox" @checked($details->physical_connectivity == true ? true : false)>
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span class="font-weight-bold">Physical Link</span>
                                </label>
                            </span> <br />
                            <span class="checkbox-fade">
                                <label>
                                    <input type="checkbox" @checked($details->logical_connectivity == true ? true : false)>
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span class="font-weight-bold">Logical Connectivity</span>
                                </label>
                            </span><br />
                            <span class="checkbox-fade">
                                <label>
                                    <input type="checkbox" @checked(!empty($details->commissioning_date) ? true : false)>
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span class="font-weight-bold">Commissioning Date</span>
                                </label>
                            </span><br />
                            <span class="checkbox-fade">
                                <label>
                                    <input type="checkbox" @checked(!empty($details->billing_date) ? true : false)>
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span class="font-weight-bold">Biling Date</span>
                                </label>
                            </span>
                        </td>

                        <td>
                            @if ($details->sale->management_approval == 'Approved')
                                <span class="badge badge-info">
                                    <a href="{{ route('cc-schedules.create', ['fr_no' => $details->fr_no]) }}"
                                        class="text-white" target="_blank">Scheduling</a>
                                </span>
                            @endif
                            <span class="badge badge-info">
                                <a href="{{ route('cc-schedules.create', ['physical_connectivity_id' => $details->id]) }}"
                                    class="text-white" target="_blank">Plan</a>
                            </span>
                            @if (!empty($details?->connectivities?->id))
                                <span class="badge badge-info">
                                    <a href="#" style="color: white"
                                        onclick="updateBillingDate({{ $details?->connectivities?->id }}, {{ $details->sale_id }}, '{{ $details->fr_no }}')">Billing</a>
                                </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Button trigger modal -->
    {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Launch demo modal
  </button> --}}

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" id="billingModal" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input id="billingDate" type="date" class="form-control" name="billing_date" required>
                    <input type="hidden" name="connectivity_id" id="connectivity_id">
                    <input type="hidden" name="sale_id" id="sale_id">
                    <input type="hidden" name="fr_no" id="fr_no">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateBilling">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function updateBillingDate(connectivity_id, sale_id, fr_no) {
            $('#exampleModal').modal('show');
            $('#connectivity_id').val(connectivity_id);
            $('#sale_id').val(sale_id);
            $('#fr_no').val(fr_no);

        }

        $('#updateBilling').click(function(e) {
            var billingDate = $('#billingDate').val();
            var connectivityId = $('#connectivity_id').val();
            var saleId = $('#sale_id').val();
            var frNo = $('#fr_no').val();
            $.ajax({
                url: "{{ route('connectivities.billing.date.update', '') }}",
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "billing_date": billingDate,
                    "connectivity_id": connectivityId,
                    "sale_id": saleId,
                    "fr_no": frNo
                },
                success: function(data) {
                    $('#exampleModal').modal('hide');
                    // location.reload();
                }
            });
        });
    </script>
@endsection
