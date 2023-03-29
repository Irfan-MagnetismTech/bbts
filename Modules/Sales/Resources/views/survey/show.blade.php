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
                                <span class="form-control">{{ $survey->lead_generation->client_id }}</span>
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
                                <label class="input-group-addon" for="link_name">Name of the link</label>
                                <span class="form-control">{{ $survey->feasibilityRequirementDetails->link_name }}</span>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="fr_id">FR No</label>
                                <span class="form-control">{{ $survey->fr_no }}</span>
                            </div>
                        </div>
                        {{-- create a responsive table --}}
                    </div>
                </div>
                <br>
                <div class="text-center"
                    style="border-top: 1px solid #d2d2d2; padding: 12px; border-bottom: 1px solid #d2d2d2;">
                    <h5> <span> &#10070; </span> Survey Details <span>&#10070;</span> </h5>
                </div>
                <br>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Link Type</th>
                                <th>Option</th>
                                <th>Status</th>
                                <th>Method</th>
                                <th>Vendor</th>
                                <th>BTS/POP/LDP</th>
                                <th>GPS</th>
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
                                        <span>{{ $detail->vendor }}</span>
                                    </td>
                                    <td>
                                        <span>{{ $detail->bts_pop_ldp }}</span>
                                    </td>
                                    <td>
                                        <span>{{ $detail->gps }}</span>
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
