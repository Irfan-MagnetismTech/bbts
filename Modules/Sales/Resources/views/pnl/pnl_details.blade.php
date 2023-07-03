@extends('layouts.backend-layout')
@section('title', 'Planning')

@php
    $is_old = old() ? true : false;
    $form_heading = !empty($planning->id) ? 'Edit' : 'Create';
    $form_url = !empty($planning->id) ? route('planning.update', $planning->id) : route('planning.store');
    $form_method = !empty($planning->id) ? 'PUT' : 'POST';
@endphp

@section('breadcrumb-title')
    {{ ucfirst($form_heading) }} Planning
@endsection

@section('breadcrumb-button')
    <a href="{{ route('planning.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-list"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection



@section('content-grid', null)

@section('content')

    {!! Form::open([
        'url' => $form_url,
        'method' => $form_method,
        'class' => 'custom-form',
    ]) !!}

    <div class="row mb-1">
        <div class="col-2 image-margin">
            <img src="{{ asset('images/bbts_logo_big.png') }}" alt="logo" style="height: 60px; width: 60px;">
        </div>
        <div class="col-8 text-center">
            <h2>Broad Band Telecom Services Limited</h2>
            <h4>Ispahani Building (5th Floor) Argrabad, Chittagong.</h4>
        </div>
        <div class="col-2">
            <p style="font-size: 15px;"><span style="text-bold">Client No:</span> 2023-08 </p>
            <p style="font-size: 15px;"><span style="text-bold">Client Name:</span> Jahirul Islam </p>
            <p style="font-size: 15px;"><span style="text-bold">Month:</span> 12 </p>
        </div>
    </div>
    <div class="row mb-1">
        <div class="col-12 text-center">
            <h2>Profit and Loss Statement</h2>
            <hr />
        </div>
    </div>
    <div>
        <table>
            <thead>
                <tr class="text-center">
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Rate</th>
                    <th>Amount</th>
                    <th>Operation Cost</th>
                    <th>Total Amount</th>
                    <th>Price</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Product One</td>
                    <td>10000</td>
                    <td>mbps</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                </tr>
                <tr>
                    <td>Product Two</td>
                    <td>10000</td>
                    <td>mbps</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                </tr>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right">Total</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>

                </tr>
            </tfoot>
        </table>
    </div>
    <div class="row" style="margin-top: 25px;">
        <table>
            <thead>
                <tr class="text-center">
                    <th>Link Name</th>
                    <th>Equipment Cost</th>
                    <th>Interest</th>
                    <th>VAT</th>
                    <th>Tax</th>
                    <th>Total Inv</th>
                    <th>OTC</th>
                    <th>ROI</th>
                    <th>Capacity</th>
                    <th>Capacity</th>
                    <th>Capacity</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Link 1</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                </tr>
                <tr>
                    <td>Link 2</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                </tr>
            <tfoot>
                <tr>
                    <td colspan="5" class="text-right">Total</td>
                    <td>10000</td>
                    <td colspan="4">Investment Budget Per Month</td>
                    <td>10000</td>
                </tr>
                <tr>
                    <td colspan="5" class="text-right">Revenue Per Month</td>
                    <td>10000</td>
                    <td colspan="4">12 months total Investment Budget</td>
                    <td>10000</td>
                </tr>
                <tr>
                    <td colspan="10" class="text-right">12 months total Revenue</td>
                    <td>10000</td>
                </tr>
                <tr>
                    <td colspan="10" class="text-right">Total PNL</td>
                    <td>10000</td>
                </tr>
                <tr>
                    <td colspan="10" class="text-right">Per Month PNL</td>
                    <td>10000</td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="d-flex justify-content-evenly" style="margin-top: 20px;">
        <button class="btn btn-primary">Details</button>
        <button class="btn btn-primary">Approval Finance</button>
        <button class="btn btn-primary">Approval CMO</button>
</div>@endsection

@section('script')
    <script>
        $('#addEquipmentRow').on('click', function() {
            addEquipmentRow();
        });

        function addEquipmentRow() {
            $('.equipment_row').first().clone().appendTo('#equipment_body');
            $('.equipment_row').last().find('input').val('');
            $('.equipment_row').last().find('select').val('');
        };

        $(document).on('click', '.removeEquipmentRow', function() {
            let count = $('.equipment_row').length;
            if (count > 1) {
                $(this).closest('tr').remove();
                //get attr_one value 
                var attr_one = $(this).attr('connectivity_attr');
                //if attr_one value is not empty then delete from database
                if (attr_one != '') {
                    $.ajax({
                        url: "{{ route('delete-connectivity-requirement-details') }}",
                        data: {
                            id: attr_one,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            console.log(data);
                        }
                    });
                }
            }
        });

        $('#date').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true,
            showOtherMonths: true
        }).datepicker("setDate", new Date());

        function optionChange(event) {
            let option = $(event.target).val();
            var link_type = $(event.target).closest('.main_link').find('.link_type').val();
            let client_id = $('#client_no').val();
            let fr_no = $('#fr_no').val();
            $.ajax({
                url: "{{ route('get-survey-details') }}",
                data: {
                    option: option,
                    link_type: link_type,
                    client_id: client_id,
                    fr_no: fr_no,
                },
                success: function(data) {
                    console.log(data);
                    $(event.target).closest('.main_link').find('input[name^="link_vendor_"]').val(data.vendor);
                    $(event.target).closest('.main_link').find('input[name^="availability_status_"]').val(data
                        .status);
                    $(event.target).closest('.main_link').find('input[name^="link_connecting_pop_"]').val(data
                        .bts_pop_ldp);
                    $(event.target).closest('.main_link').find('input[name^="last_mile_connectivity_method_"]')
                        .val(data
                            .method);
                    $(event.target).closest('.main_link').find('input[name^="connectivity_lat_long_"]').val(data
                        .gps);
                    $(event.target).closest('.main_link').find('input[name^="distance_"]').val(data.distance);
                    $(event.target).closest('.main_link').find('input[name^="gps_"]').val(data.gps);
                    $(event.target).closest('.main_link').find('input[name^="connectivity_point_"]').val(data
                        .bts_pop_ldp)
                    // $(event.target).closest('.main_link').find('.link_vendor').html(data.vendor);
                    // $(event.target).closest('.main_link').find('.availability_status').html(data.status);
                    // $(event.target).closest('.main_link').find('.link_connecting_pop').html(data.bts_pop_ldp);
                    // $(event.target).closest('.main_link').find('.last_mile_connectivity_method').html(data
                    //     .method);
                    // $(event.target).closest('.main_link').find('.connectivity_lat_long').html(data.gps);
                    // $(event.target).closest('.main_link').find('.distance').val(data.distance);
                    // $(event.target).closest('.main_link').find('.gps').val(data.gps);
                    // $(event.target).closest('.main_link').find('.connectivity_point').val(data.bts_pop_ldp)
                }
            });
        }

        function addLinkEquipmentRow(event) {
            var $table = $(event).closest('.table-bordered');
            var $clone = $table.find('tbody tr:first').clone();
            $clone.find('input').val('');
            $table.find('tbody').append($clone);
        }

        function removeLinkEquipmentRow(event) {
            var $table = $(event).closest('.table-bordered');
            var $tr = $table.find('tbody tr');
            if ($tr.length > 1) {
                $(event).closest('tr').remove();
            }
        }
        $('#addLinkRow').on('click', function() {
            addLinkRow();
        });

        function addLinkRow() {
            var clonedRow = $('.main_link').first().clone();
            var count_row = $('.main_link').length;
            var link_no = parseInt(count_row) + 1;
            $('#total_key').val(link_no);

            clonedRow.find('input, select').val('').attr('name', function(index, name) {
                var underscoreIndex = name.lastIndexOf('_');
                if (underscoreIndex !== -1) {
                    var baseName = name.substring(0, underscoreIndex);
                    var fieldName = name.substring(underscoreIndex + 1);
                    if (fieldName.includes('[]')) {
                        return baseName + '_' + link_no + '[]';
                    } else {
                        return baseName + '_' + link_no;
                    }
                }
            });
            clonedRow.find('#addLinkEquipmentRow').attr('id', 'addLinkEquipmentRow_' + link_no);
            clonedRow.find('#removeLinkEquipmentRow').attr('id', 'removeLinkEquipmentRow_' + link_no);
            clonedRow.find('.link_no').html(link_no);
            clonedRow.appendTo('#link_container');
            var $equipmentRow = clonedRow.find('.link_equipment_table').children('tr').length;
            console.log($equipmentRow);
            if ($equipmentRow > 1) {
                clonedRow.find('.link_equipment_table tr').not(':first').remove();
            }
        }
    </script>
@endsection
