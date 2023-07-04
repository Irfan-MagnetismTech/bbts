@extends('layouts.backend-layout')
@section('title', 'Survey')

@section('breadcrumb-title')
    Survey Details
@endsection

@section('breadcrumb-button')
    <a href="{{ route('survey.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection


@section('content-grid', null)

@section('content')
    <style>
        .input-group-addon {
            min-width: 105px;
        }
    </style>
    {{-- Comparative Statement --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="tableHeading">
                    <h5> <span> &#10070; </span> Survey <span>&#10070;</span> </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        {{-- exiting or new radio button --}}
                        <div class="col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="client_type">Date<span
                                        class="text-danger">*</span></label>
                                <span class="form-control">{{ $survey->date }}</span>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="client_id">Client ID<span
                                        class="text-danger">*</span></label>
                                <span class="form-control">{{ $survey->lead_generation->client_no }}</span>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="client_name">Client Name<span
                                        class="text-danger">*</span></label>
                                <span class="form-control">{{ $survey->lead_generation->client_name }}</span>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="link_name">Connect: Point</label>
                                <span
                                    class="form-control">{{ $survey->feasibilityRequirementDetails->connectivity_point }}</span>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="fr_id">FR No</label>
                                <span class="form-control">{{ $survey->fr_no }}</span>
                            </div>
                        </div>
                        {{-- gps --}}
                        <div class="col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="gps">Latitude</label>
                                <span class="form-control">{{ $survey->feasibilityRequirementDetails->lat ?? '' }}</span>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="gps">Longitude</label>
                                <span class="form-control">{{ $survey->feasibilityRequirementDetails->long ?? '' }}</span>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="mq_id">MQ ID</label>
                                <span class="form-control">{{ $survey->mq_no }}</span>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="surveyor_name">Contact Person</label>
                                <span class="form-control">{{ $survey->feasibilityRequirementDetails->contact_name }}</span>
                            </div>
                        </div>

                        {{-- contact number --}}
                        <div class="col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="surveyor_contact">Contact Number</label>
                                <span
                                    class="form-control">{{ $survey->feasibilityRequirementDetails->contact_number }}</span>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="surveyor_email">Email</label>
                                <span
                                    class="form-control">{{ $survey->feasibilityRequirementDetails->contact_email }}</span>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="surveyor_address">Designation</label>
                                <span
                                    class="form-control">{{ $survey->feasibilityRequirementDetails->contact_designation }}</span>
                            </div>
                        </div>

                        <div class="col-xl-8 col-md-8">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="surveyor_address">Remarks</label>
                                <span class="form-control">{{ $survey->remarks }}</span>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="text-center">
                        <h5> <span> &#10070; </span> Connectivity Details <span>&#10070;</span> </h5>
                    </div>
                    <hr />
                    {{-- create a responsive table --}}
                    <div class="row">
                        <div class="md-col-6 col-6">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th colspan="5">Product Details</th>
                                        </tr>
                                        <tr>
                                            <th>Category</th>
                                            <th>Product</th>
                                            <th>Capacity</th>
                                            <th>Unit</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody class="productBody">
                                        @foreach ($connectivity_requirement->connectivityProductRequirementDetails as $connectivityProductRequirementDetail)
                                            <tr class="product_details_row">
                                                <td>
                                                    <span>
                                                        {{ $connectivityProductRequirementDetail->category->name }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        {{ $connectivityProductRequirementDetail->product->name }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        {{ $connectivityProductRequirementDetail->capacity }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        {{ $connectivityProductRequirementDetail->product->unit }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        {{ $connectivityProductRequirementDetail->remarks ?? '' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="md-col-6 col-6">
                            {{-- Connectivity Details --}}
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th colspan="5">Connectivity Details</th>
                                        </tr>
                                        <tr>
                                            <th>Link Type</th>
                                            <th>Method</th>
                                            <th>Capacity %</th>
                                            <th>Uptime Reg/SLA</th>
                                            <th>Vendor</th>
                                        </tr>
                                    </thead>
                                    <tbody class="connectivityBody">
                                        @foreach ($connectivity_requirement->connectivityRequirementDetails as $connectivityRequirementDetail)
                                            <tr class="connectivity_details_row">
                                                <td>
                                                    <span>
                                                        {{ $connectivityRequirementDetail->link_type }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        {{ $connectivityRequirementDetail->method }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        {{ $connectivityRequirementDetail->connectivity_capacity }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        {{ $connectivityRequirementDetail->sla }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        {{ $connectivityRequirementDetail->vendor->name ?? '' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="text-center">
                        <h5> <span> &#10070; </span> Survey Details <span>&#10070;</span> </h5>
                    </div>
                    <hr />
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Link Type</th>
                                    <th>Option</th>
                                    <th>Status</th>
                                    <th>Method</th>
                                    <th>Vendor</th>
                                    <th>BTS/POP</th>
                                    <th>LDP</th>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                    <th>Distance</th>
                                    <th>Current Capacity</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($survey->surveyDetails as $detail)
                                    <tr class="feasibility_details_row">
                                        <td>
                                            <span>{{ $detail->link_type }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $detail->option }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $detail->status }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $detail->method }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $detail->vendor->name }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $detail->pop->name }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $detail->ldp }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $detail->lat }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $detail->long }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $detail->distance }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $detail->current_capacity }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $detail->remarks }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('script')
        <script>
            $('#addRow').on('click', function() {
                addRow();
            });

            function addRow() {
                $('.feasibility_details_row').first().clone().appendTo('tbody');
                $('.feasibility_details_row').last().find('input').val('');
                $('.feasibility_details_row').last().find('select').val('');
            };

            $(document).on('click', '.removeRow', function() {
                let count = $('.feasibility_details_row').length;
                if (count > 1) {

                    //get attr_one value 
                    var attr_one = $(this).attr('attr_one');
                    //if attr_one value is not empty then delete from database
                    if (attr_one != '') {
                        $.ajax({
                            url: "{{ route('delete-feasibility-requirement-details') }}",
                            data: {
                                id: attr_one,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(data) {
                                console.log(data);
                            }
                        });
                    }
                    $(this).closest('tr').remove();
                }
            });

            $('#client_id').on('input', function() {
                var client_id = $(this).val();
                console.log(client_id)
                $(this).autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: "{{ route('get-client') }}",
                            data: {
                                client_id: client_id,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(data) {
                                response(data);
                            }
                        });
                    },
                    select: function(event, ui) {
                        $('#client_id').val(ui.item.label);
                        $('#client_name').val(ui.item.value);
                        $('#lead_generation_id').val(ui.item.lead_generation_id);
                        return false;
                    }
                });
            });
            $('#date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            }).datepicker("setDate", new Date());
        </script>
    @endsection
