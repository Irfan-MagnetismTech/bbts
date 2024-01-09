@extends('layouts.backend-layout')
@section('title', 'Internal Feedbacks')

@php
    $form_heading = !empty($feedback->id) ? 'Update' : 'Create';
    $form_url = !empty($feedback->id) ? route('internal-feedbacks.update', $feedback->id) : route('internal-feedbacks.store');
    $form_method = !empty($feedback->id) ? 'PUT' : 'POST';
@endphp

@section('style')
    <style>
        .input-group-addon {
            min-width: 120px;
        }

        .input-group-info .input-group-addon {
            /*background-color: #04748a!important;*/
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice span {
            color: #b10000;
        }

        .select2_container {
            max-width: 200px;
            white-space: inherit;
        }

        .custom-spinner-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 40vh;
        }

        .custom-spinner {
            width: 4rem;
            height: 4rem;
            border: .5em solid transparent;
            border-top-color: currentColor;
            border-radius: 50%;
            animation: spinner-animation 1s linear infinite;
        }

        @keyframes spinner-animation {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
@endsection

@section('breadcrumb-title')
    Internal Feedbacks {{$form_heading}}
@endsection

@section('breadcrumb-button')
    <a href="{{ route('internal-feedbacks.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection
@section('content-grid', null)

@section('content')

    {!! Form::open([
        'url' => $form_url,
        'method' => $form_method,
        'encType' => 'multipart/form-data',
        'class' => 'custom-form',
    ]) !!}

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        @php
                            $is_old = old('client_no') ? true : false;
                            $client_no = $is_old ? old('client_no') : $feedback->client_no ?? null;
                            $remarks = $is_old ? old('remarks') : $feedback->remarks ?? null;
                            $date = $is_old ? old('date') : $feedback->date ?? null;
                        @endphp
                        <div class="col-xl-4 col-md-4">
                            <div class="form-item">
                                <select name="client_no" class="form-control client_no select2" id="client_no"
                                        autocomplete="off"
                                        required>
                                    <option value="">Select Client</option>
                                    @if($client_no != null)
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->client_no }}" @selected($client->client_no ==
                                                $client_no)>
                                                {{ $client->client_name }}
                                            </option>
                                        @endforeach
                                    @else
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->client_no }}">
                                                {{ $client->client_name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4">
                            <div class="form-item">
                                <input type="date" name="date" id="date" class="form-control"
                                       value="{{ $date ? $date : now()->format('Y-m-d') }}" autocomplete="off"
                                       value="{{$date}}">
                                <label for="date">Date<span class="text-danger"> *</span></label>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4">
                            <div class="form-item">
                                <input type="text" class="form-control" name="remarks" id="remarks" autocomplete="off"
                                       value="{{$remarks}}">
                                <label for="remarks">Remarks</label>
                            </div>
                        </div>
                    </div>
                </div>

                <table class="table table-bordered" id="internal_feedbacks">
                    <thead>
                    <tr>
                        <th> Connectivity Point <span class="text-danger">*</span></th>
                        <th> Contact Person</th>
                        <th> Contact Number</th>
                        <th> Feedback</th>
                        <th> Time</th>
                        <th> Status</th>
                        <th><i class="btn btn-primary btn-sm fa fa-plus add-stock-row"></i></th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $fr_no = old('fr_no', !empty($feedback) ? $feedback->lines->pluck('fr_no') : []);
                        $contact_person = old('contact_person', !empty($feedback) ? $feedback->lines->pluck('contact_person') : []);
                        $contact_number = old('contact_number', !empty($feedback) ? $feedback->lines->pluck('contact_number') : []);
                        $client_feedback = old('client_feedback', !empty($feedback) ? $feedback->lines->pluck('client_feedback') : []);
                        $time_duration = old('time_duration', !empty($feedback) ? $feedback->lines->pluck('time_duration') : []);
                        $status = old('status', !empty($feedback) ? $feedback->lines->pluck('status') : []);
                    @endphp
                    @foreach ($fr_no as $key => $detail)
                        <tr>
                            <td>
                                <select name="fr_no[]" class="form-control fr_no select2" id="fr_no" autocomplete="off"
                                        required>
                                    <option value="">Select Fr No</option>
                                    @foreach ($fr_nos as $fr_no)
                                        <option value="{{ $fr_no }}" @selected($fr_no== $fr_no[$key])>
                                            {{ $fr_no }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" name="contact_person[]" class="form-control contact_person"
                                       autocomplete="off" value="{{ $contact_person[$key] }}">
                            </td>
                            <td>
                                <input type="number" name="contact_number[]" class="form-control contact_number"
                                       autocomplete="off" value="{{ $contact_number[$key] }}">
                            </td>
                            <td>
                                <input type="text" name="client_feedback[]" class="form-control client_feedback"
                                       autocomplete="off" value="{{ $client_feedback[$key] }}">
                            </td>
                            <td>
                                <input type="text" name="time_duration[]" id="time_duration" placeholder="HH:MM format" pattern="[0-9]{2}:[0-9]{2}" required class="form-control time_duration" autocomplete="off" value="{{ $time_duration[$key] }}">
                            </td>
                            <td>
                                <select class="form-control status select2" id="status" name="status[]">
                                    <option value="Pending">Pending</option>
                                    <option value="Accepted">Accepted</option>
                                    <option value="Processing">Processing</option>
                                    <option value="Closed">Closed</option>
                                </select>
                            </td>
                            <td>
                                <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="row">
                    <div class="offset-md-4 col-md-4 mt-2">
                        <div class="input-group input-group-sm ">
                            <button class="btn btn-success btn-round btn-block py-2">Submit</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
                @endsection

                @section('script')
                    <script>
                        let indx = 0;
                        @if($form_method == 'PUT')
                            indx = {{ count($fr_no) }};
                        @endif
                        function appendCalculationRow() {
                            let row = `<tr>
                                            <td>
                                                 <select name="fr_no[${indx}]" class="form-control fr_no select2" id="fr_no" autocomplete="off" required>
                                                        <option value="fr_no[${indx}]" readonly selected>Select Fr No</option>
                                                </select>
                                            </td>
                                            <td>
                                           <input type="text" name="contact_person[]" class="form-control contact_person" id="contact_person" autocomplete="off">
                                           </td>
                                           <td>
                                               <input type="number" name="contact_number[]" class="form-control contact_number" id="contact_number" autocomplete="off">
                                           </td>
                                           <td>
                                               <input type="text" name="client_feedback[]" class="form-control client_feedback" autocomplete="off">
                                           </td>
                                           <td>
                                                <input type="text" name="time_duration[]" id="time_duration" placeholder="HH:MM format" pattern="[0-9]{2}:[0-9]{2}" required class="form-control time_duration" autocomplete="off">
                                           </td>
                                           <td>
                                              <select class="form-control status select2" id="status" name="status[]">
                                                <option value="Pending">Pending</option>
                                                <option value="Accepted">Accepted</option>
                                                <option value="Processing">Processing</option>
                                                <option value="Closed">Closed</option>
                                              </select>
                                           </td>
                                           <td>
                                               <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i>
                                           </td>
                                      </tr>`;
                            let fr_values = $('#internal_feedbacks').first().find('.fr_no:last').html();
                            row = row.replace('Select Fr No', fr_values);
                            indx++;
                            $('#internal_feedbacks tbody').append(row);
                            $('.select2').select2({});
                        }

                        $("#internal_feedbacks")
                            .on('click', '.add-stock-row', () => {
                                appendCalculationRow();
                                getFrNo();
                            })
                            .on('click', '.remove-calculation-row', function () {
                                $(this).closest('tr').remove();
                            });

                        function getFrNo() {
                            var client_no = $('#client_no').val();
                            $.ajax({
                                url: window.location.origin + "/ticketing/get-client-info",
                                type: "GET",
                                dataType: "json",
                                data: {
                                    search: client_no,
                                },
                                success: function (data) {
                                    var fr_values = '<option value="">Select Fr No</option>';
                                    $.each(data, function (index, item) {
                                        $.each(item.saleDetails, function (key, value) {
                                            fr_values += `<option value="${value.feasibility_requirement_details.fr_no}">${value.feasibility_requirement_details.connectivity_point} ( ${value.feasibility_requirement_details.fr_no} )</option>`;
                                        });
                                    });
                                    $(".fr_no:last").html(fr_values);
                                },
                                error: function (error) {
                                    console.error("Error fetching data:", error);
                                },
                            });
                        }

                        // $(document).on('change', '.fr_no', function () {
                        //     $(this).autocomplete({
                        //         source: function (request, response) {
                        //             var fr_no = $('#fr_no').val();
                        //             $.ajax({
                        //                 url: window.location.origin + "/ticketing/get-fr-info",
                        //                 type: "GET",
                        //                 dataType: "json",
                        //                 data: {
                        //                     search: fr_no
                        //                 },
                        //                 success: function (data) {
                        //                     response(data);
                        //                 }
                        //             });
                        //         },
                        //         select: function (event, ui) {
                        //             $(this).closest('tr').find('.contact_person').val(ui.item.contact_name);
                        //             $(this).closest('tr').find('.contact_number').val(ui.item.contact_number);
                        //
                        //         }
                        //     })
                        // });

                    </script>
@endsection
