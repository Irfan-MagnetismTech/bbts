@extends('layouts.backend-layout')
@section('title', 'Indents')

@php
    $is_old = old('prs_no') ? true : false;
    $form_heading = !empty($indents->id) ? 'Update' : 'Add';
    $form_url = !empty($indents->id) ? route('indents.update', $indents->id) : route('indents.store');
    $form_method = !empty($indents->id) ? 'PUT' : 'POST';
@endphp

@section('breadcrumb-title')
    {{ ucfirst($form_heading) }} Indents
@endsection

@section('breadcrumb-button')
    <a href="{{ route('cs.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    <div class="container">
        {!! Form::open([
            'url' => $form_url,
            'method' => $form_method,
            'encType' => 'multipart/form-data',
            'class' => 'custom-form',
        ]) !!}

        <div class="row">
            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="indent_no">Ident No: <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="indent_no" name="indent_no"
                        placeholder="Enter indent number" value="{{ old('indent_no') ?? ($branch->name ?? '') }}" required>
                </div>
            </div>

            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="name">Date <span class="text-danger">*</span></label>
                    <input class="form-control" id="date" name="date" aria-describedby="date"
                        value="{{ old('date') ?? (@$purchaseRequisition->date ?? '') }}" readonly
                        placeholder="Select a Date">
                </div>
            </div>
            {{-- @dd(old()) --}}

            @php
                $prs_nos = $is_old ? old('prs_no') ?? [] : $indents->prs_no ?? [];
            @endphp

            <div class="col-12" id="prs_no">
                @forelse ($prs_nos as $key => $prs_no)
                    @if ($loop->first)
                        @php
                            $visivilty = 'visible';
                            $button = "<i class='btn btn-primary btn-sm fa fa-plus addMaterial' onclick='addMaterial()'></i>";
                        @endphp
                    @else
                        @php
                            $visivilty = 'invisible';
                            $button = "<i class='btn btn-danger btn-sm fa fa-minus deleteItem' onclick='deleteRow(this)'></i>";

                        @endphp
                    @endif
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon {{ $visivilty }}" for="name">Branch Name <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control prs_no" name="prs_no[]" placeholder="Search Prs No"
                            value="{{ $prs_no }}" required>
                        <input type="hidden" name="prs_id[]" class="prs_id" value="{{ old('prs_id')[$key] ?? '' }}">
                        {!! $button !!}
                    </div>
                @empty
                    <div class="input-group input-group-sm input-group-primary" id="">
                        <label class="input-group-addon" for="prs_no">Prs Np <span class="text-danger">*</span></label>
                        <input type="text" class="form-control prs_no" name="prs_no[]" placeholder="Search Prs No"
                            value="" required>
                        <input type="hidden" name="prs_id[]" class="prs_id" value="">
                        <i class="btn btn-primary btn-sm fa fa-plus addMaterial" onclick="addMaterial()"></i>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="row">
            <div class="offset-md-4 col-md-4 mt-2">
                <div class="input-group input-group-sm ">
                    <button class="btn btn-success btn-round btn-block py-2">Submit</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}

    </div>
@endsection

@section('script')
    <script>
        function addMaterial() {
            $('#prs_no').append(
                `<div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon invisible" for="name">Branch Name <span
                                class="text-danger">*</span></label>
                    <input type="text" class="form-control prs_no" name="prs_no[]" placeholder="Search Prs No" required>
                    <input type="hidden" name="prs_id[]" class="prs_id">
                        <i class="btn btn-danger btn-sm fa fa-minus deleteItem" onclick="deleteRow(this)"></i>    
                </div>`
            );
        }

        function deleteRow(e) {
            $(e).parent().remove();
        }

        $('#date').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true,
            showOtherMonths: true
        }).datepicker("setDate", new Date());

        $(document).on('keyup focus', '.prs_no', function() {
            $(this).autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ url('search-prs-no') }}",
                        type: 'get',
                        dataType: "json",
                        data: {
                            search: request.term
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                select: function(event, ui) {
                    $(this).val(ui.item.label);
                    $(this).parent().find('.prs_id').val(ui.item.value);

                    return false;
                }
            });
        });
    </script>
@endsection
