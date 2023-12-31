@extends('layouts.backend-layout')
@section('title', 'Internal Feedbacks')

@php
    $form_heading = !empty($feedback->id) ? 'Update' : 'Create';
    $form_url = !empty($feedback->id) ? route('internal-feedbacks.update', $feedback->id) : route('internal-feedbacks.store');
    $form_method = !empty($feedback->id) ? 'PUT' : 'POST';
@endphp

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
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->client_no }}" @selected($client->client_no ==
                                            $client_no)>
                                            {{ $client->client_name }}
                                        </option>
                                    @endforeach
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
                        <th> Remarks</th>
                        <th><i class="btn btn-primary btn-sm fa fa-plus add-stock-row"></i></th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $fr_no = old('fr_no', !empty($feedback) ? $feedback->lines->pluck('fr_no') : []);
                        $contact_person = old('contact_person', !empty($feedback) ? $feedback->lines->pluck('contact_person') : []);
                        $contact_number = old('contact_number', !empty($feedback) ? $feedback->lines->pluck('contact_number') : []);
                        $remarks = old('remarks', !empty($feedback) ? $feedback->lines->pluck('remarks') : []);
                    @endphp
                    @foreach ($fr_no as $key => $detail)
                        <tr>
                            <td>
                                <select name="fr_no[]" class="form-control fr_no select2" autocomplete="off" required>
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
                                <input type="text" name="remarks[]" class="form-control remarks" autocomplete="off"
                                       value="{{ $remarks[$key] }}">
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
                        /* Append row */
                        {{--                        @if (empty($feedback) && empty(old('fr_no')))--}}
                        {{--                        appendCalculationRow();--}}
                        {{--                        @endif--}}
                        function appendCalculationRow() {
                            let row = `<tr>
                        <td>
                             <select name="fr_no[]" class="form-control fr_no select2" autocomplete="off" required>
                                    <option value="">Select Fr No</option>
                                    @foreach ($fr_nos as $fr_no)
                            <option value="{{ $fr_no }}">
                                            {{ $fr_no }}
                            </option>
                                    @endforeach
                            </select>
                        </td>
                   <td>
                       <input type="text" name="contact_person[]" class="form-control contact_person" autocomplete="off">
                       </td>
                       <td>
                           <input type="number" name="contact_number[]" class="form-control contact_number" autocomplete="off">
                       </td>
                       <td>
                           <input type="text" name="remarks[]" class="form-control remarks" autocomplete="off">
                       </td>

                   <td>
                       <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i>
                   </td>
               </tr>`;
                            $('#internal_feedbacks tbody').append(row);
                            $('.select2').select2({});
                        }


                        $("#internal_feedbacks")
                            .on('click', '.add-stock-row', () => {
                                appendCalculationRow();
                                $('#fr_no:last').html('');
                                // getMaterial();
                            })
                            .on('click', '.remove-calculation-row', function () {
                                $(this).closest('tr').remove();
                            });

                        $("#client_no").autocomplete({
                            source: function (request, response) {
                                var client_no = $('#client_no').val();
                                $.ajax({
                                    url: window.location.origin + "/ticketing/get-client-info",
                                    type: "get",
                                    dataType: "json",
                                    data: {
                                        search: client_no,
                                    },
                                    success: function (data) {
                                        response(data);
                                    },
                                });
                            },
                            select: function (event, ui) {
                                $('#internal_feedbacks tbody').empty();
                                $("#fr_no").html("");
                                var link_options = '<option value="">Select Connectivity Point</option>';

                                ui.item.saleDetails.forEach(function (element) {
                                    link_options += `<option value="${element.fr_no}">${element.feasibility_requirement_details.connectivity_point} ( ${element.fr_no} )</option>`;
                                });
                                client_details = ui.item.details;
                                $("#fr_no").html(link_options);

                                return false;
                            },
                        });
                    </script>
@endsection
