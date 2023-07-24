@extends('layouts.backend-layout')
@section('title', 'PNL')

@section('breadcrumb-title')
    PNL Summary
@endsection

@section('content-grid', null)

@section('content')
    <div class="row mb-1">
        <div class="col-12 text-center">
            <h2>PNL Summary</h2>
            <hr />
        </div>
    </div>
    <div>
        <table class="table table-bordered table-hover">
            <thead>
                <tr class="text-center">
                    <th>Connectivity Point Name</th>
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
                        <tr>
                            <td class="text-left">{{ $details->connectivity_point }} ({{ $details->fr_no }})</td>
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
                        @foreach ($details->costing->costingProducts as $product)
                            {{-- <tr>
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
                            </tr> --}}
                        @endforeach
                    @endif
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-right">Total </td>
                    {{-- <td class="text-center">{{ $details->costing->sum('total_otc_with_client_equipment') }}</td> --}}
                    <td colspan="2"></td>
                    {{-- <td class="text-center">{{ $details->costing->sum('management_cost_amount') }}</td> --}}

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
            @if ($sale->management_approval == 'Not Approved') href="{{ route('pnl-approve-by-management', $mq_no) }}" @else href="{{ route('pnl-approve-by-management', $mq_no) }}" title="Approved By {{ $sale?->managementApprovedBy?->name }}" @endif
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
@endsection
