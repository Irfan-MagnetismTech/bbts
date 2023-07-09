@extends('layouts.backend-layout')
@section('title', 'PNL')

@section('breadcrumb-title')
    PNL Summary
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    <div class="row mb-1">
        <div class="col-12 text-center">
            <h2>Profit and Loss Statement</h2>
            <hr />
        </div>
    </div>
    <div>
        <table class="table table-bordered table-hover">
            <thead>
                <tr class="text-center">
                    <th>Link Name</th>
                    <th>Total Inv</th>
                    <th>OTC</th>
                    <th>Equipment Price</th>
                    <th>Total OTC</th>
                    <th>Product Cost</th>
                    <th>Monthly Cost</th>
                    <th>Mgt Cost</th>
                    <th>Monthly Budget</th>
                    <th>Total Budget</th>
                    <th>Monthly Revenue</th>
                    <th>Total Revenue</th>
                    <th>Monthly PNL</th>
                    <th>Total PNL</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total_budget = 0;
                    $total_revenue = 0;
                    $total_monthly_pnl = 0;
                    $total_pnl = 0;
                @endphp
                @foreach ($feasibility_requirement->feasibilityRequirementDetails as $details)
                    @if ($details->costing)
                        @php
                            $total_budget += $details->costing->management_cost_total * $details->costing->month;
                            $total_revenue += $details->offerDetail->grand_total * $details->costing->month;
                            $total_monthly_pnl += $details->offerDetail->grand_total - $details->costing->management_cost_amount;
                            $total_pnl += ($details->offerDetail->grand_total - $details->costing->management_cost_amount) * $details->costing->month;
                        @endphp
                        @foreach ($details->costing->costingProducts as $product)
                            <tr>
                                <td>{{ $details->fr_no }}</td>
                                <td>{{ $details->costing->total_investment }}</td>
                                <td>{{ $details->costing->total_otc }}</td>
                                <td>{{ $details->costing->equipment_price_for_client }}</td>
                                <td>{{ $details->costing->total_otc_with_client_equipment }}</td>
                                <td>{{ $details->costing->product_total_cost }}</td>
                                <td>{{ $details->costing->total_service_cost }}</td>
                                <td>{{ $details->costing->management_cost_amount }}</td>
                                <td>{{ $details->costing->management_cost_total }}</td>
                                <td>{{ $details->costing->management_cost_total * $details->costing->month }}</td>
                                <td>{{ $details->offerDetail->grand_total }}</td>
                                <td>{{ $details->offerDetail->grand_total * $details->costing->month }}</td>
                                <td>{{ $details->offerDetail->grand_total - $details->costing->management_cost_amount }}
                                </td>
                                <td>{{ ($details->offerDetail->grand_total - $details->costing->management_cost_amount) * $details->costing->month }}
                                </td>
                            </tr>
                        @endforeach
                    @endif
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-right">Total</td>
                    <td class="text-center">{{ $details->costing->sum('total_otc_with_client_equipment') }}</td>
                    <td colspan="2"></td>
                    <td class="text-center">{{ $details->costing->sum('management_cost_amount') }}</td>

                    <td></td>
                    <td class="text-center">{{ $total_budget }}</td>
                    <td></td>
                    <td class="text-center">{{ $total_revenue }}</td>
                    <td class="text-center">{{ $total_monthly_pnl }}</td>
                    <td class="text-center">{{ $total_pnl }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="d-flex" style="margin-top: 20px; justify-content: space-around">
        <a class="btn btn-outline-success" style="transition: 0.5s" href="{{ route('pnl-details', $mq_no) }}">Details</a>
        <a class="btn btn-outline-success"
            @if ($sale->finance_approval == 'Not Approved') href="{{ route('pnl-approve-by-finance', $mq_no) }}" @else href="#" title="Approved By {{ $sale?->financeApprovedBy?->name }}" @endif
            style="transition: 0.5s">Finance {{ $sale->finance_approval == 'Not Approved' ? 'Approval' : 'Approved' }}</a>
        <a class="btn btn-outline-success"
            @if ($sale->cmo_approval == 'Not Approved') href="{{ route('pnl-approve-by-cmo', $mq_no) }}" @else href="#" title="Approved By {{ $sale?->cmoApprovedBy?->name }}" @endif
            style="transition: 0.5s" href="{{ route('pnl-approve-by-cmo', $mq_no) }}">CMO
            {{ $sale->finance_approval == 'Not Approved' ? 'Approval' : 'Approved' }}</a>
        <a class="btn btn-outline-success"
            @if ($sale->management_approval == 'Not Approved') href="{{ route('pnl-approve-by-management', $mq_no) }}" @else href="#" title="Approved By {{ $sale?->managementApprovedBy?->name }}" @endif
            style="transition: 0.5s" href="{{ route('pnl-approve-by-management', $mq_no) }}">Management
            {{ $sale->finance_approval == 'Not Approved' ? 'Approval' : 'Approved' }}</a>
    </div>
@endsection

@section('script')
    @if (Session::has('success'))
        <script type="text/javascript">
            Toast.fire({
                icon: 'success',
                title: '{!! Session::get('success') !!}',
            })
        </script>
    @endif
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
