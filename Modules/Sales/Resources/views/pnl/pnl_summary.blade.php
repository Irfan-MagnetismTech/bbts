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
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr class="text-center">
                    <th>Connectivity Point Name</th>
                    <th>Total Inv</th>
                    <th>OTC</th>
                    <th>Client Equipment</th>
                    <th>Total OTC</th>
                    <th>Product Cost</th>
                    <th>Monthly Cost</th>
                    <th>Total Monthly Cost</th>
                    <th>Yearly Cost</th>
                    <th>Monthly Revenue</th>
                    <th>Total Revenue</th>
                    <th>Monthly PNL</th>
                    <th>Total PNL</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total_budget = 0;
                $total_revenue = 0;
                $total_monthly_pnl = 0;
                $total_pnl = 0;
                $grand_total_monthly_cost = 0;
                ?>
                @foreach ($feasibility_requirement->feasibilityRequirementDetails as $details)
                    @if ($details->costing)
                        @php
                            $month = $details->costing->month;
                            $total_otc = $details->offerDetail->total_offer_otc;
                            $total_monthly_pnl += $details->offerDetail->grand_total - $details->costing->management_cost_amount;
                            $total_pnl += ($details->offerDetail->grand_total - $details->costing->management_cost_amount) * $month;
                            $total_inv = $details->costing->costingLinks->sum('investment');
                            $product_cost = $details->costing->product_total_cost + $details->costing->total_operation_cost;
                            $monthly_cost = ($total_inv - $total_otc) / $month + $details->costing->costingLinks->sum('capacity_amount');
                            $total_monthly_cost = $monthly_cost + $product_cost; 
                            $total_budget += $total_monthly_cost;
                            $grand_total_monthly_cost += $total_monthly_cost * $month;
                            $monthly_revenue = $details->offerDetail->grand_total;
                            $total_revenue += $monthly_revenue ;
                        @endphp
                        <tr> 
                            <td class="text-left">{{ $details->connectivity_point }} ({{ $details->fr_no }}) </td>
                            <td class="text-right">@formatFloat($total_inv + ($details->costing->equipment_grand_total - $details->costing->equipment_price_for_client))</td>
                            <td>{{ $total_otc }}</td>
                            <td>{{ $details->costing->equipment_price_for_client }}</td>
                            <td>{{ $details->costing->equipment_price_for_client + $details->offerDetail->total_offer_otc }}
                            </td>
                            <td class="text-right">@formatFloat($product_cost)</td>
                            <td class="text-right">@formatFloat($monthly_cost)</td>
                            <td class="text-right">@formatFloat($total_monthly_cost)</td>
                            <td class="text-right">@formatFloat($total_monthly_cost * $month)</td> 
                            <td class="text-right">@formatFloat($monthly_revenue)</td> 
                            <td class="text-right">@formatFloat($monthly_revenue * $month)</td>  
                            <td>{{ $details->offerDetail->grand_total - $details->costing->management_cost_amount }} </td>
                            <td>{{ ($details->offerDetail->grand_total - $details->costing->management_cost_amount) * $month }}
                            </td>
                        </tr> 
                    @endif
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-right"> <b>Total</b> </td>
                    {{-- <td class="text-center">{{ $details->costing->sum('total_otc_with_client_equipment') }}</td> --}}
                    <td colspan="2"></td>
                    {{-- <td class="text-center">{{ $details->costing->sum('management_cost_amount') }}</td> --}}

                    <td></td>
                    <td class="text-right"><b>@formatFloat($total_budget)</b></td>
                    <td class="text-right"><b>@formatFloat($grand_total_monthly_cost)</b></td> 
                    <td class="text-right"><b>@formatFloat($total_revenue)</b></td>
                    <td class="text-right"><b>@formatFloat($total_monthly_pnl)</b></td>
                    <td class="text-right"><b>@formatFloat($total_pnl)</b></td> 
                    <td class="text-right"><b>@formatFloat($total_pnl)</b></td> 

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
