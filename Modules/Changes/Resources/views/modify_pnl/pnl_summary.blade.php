@extends('layouts.backend-layout')
@section('title', 'PNL')

@section('breadcrumb-title')
    PNL Summary
    <span style="position: fixed; right:20px"></span>
@endsection

@section('style')
    <style>
        td {
            border: 1px solid rgb(183, 186, 187) !important;
        }
    </style>
@endsection

@section('content-grid', null)

@section('content')
    <div class="row mb-1">
        <div class="col-10 text-center">
            <h3>{{ $connectivity_requirement->lead_generation->client_name }}</h3>
        </div>
        <div class="col-2 text-right">
            <a class="btn btn-outline-success" style="transition: 0.5s"
                href="{{ route('generate_pnl_summary_pdf', $connectivity_requirement_id) }}">Generate Pdf</a>
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
                    <th>Yearly Revenue</th>
                    <th>Monthly PNL</th>
                    <th>Yearly PNL</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total_investment = 0;
                $total_budget = 0;
                $total_revenue = 0;
                $total_monthly_pnl = 0;
                $total_pnl = 0;
                $grand_total_monthly_cost = 0;
                $total_yearly_pnl = 0;
                $grand_total_otc = 0;
                $total_product_cost = 0;
                $sum_of_monthly_cost = 0;
                ?>
                @if ($connectivity_requirement->costingByConnectivity)
                    @php
                        $month = $connectivity_requirement->costingByConnectivity->month;
                        $total_otc = $connectivity_requirement->offerByConnectivity->offerDetails->first()->total_offer_otc;
                        $investment = $connectivity_requirement->costingByConnectivity->costingLinks->sum('investment');
                        $product_cost = $connectivity_requirement->costingByConnectivity->product_total_cost + $connectivity_requirement->costingByConnectivity->total_operation_cost;
                        $monthly_cost = ($investment - $total_otc) / $month + $connectivity_requirement->costingByConnectivity->costingLinks->sum('capacity_amount') + $connectivity_requirement->offerByConnectivity->offerDetails->first()->equipment_total_mrc;
                        $total_monthly_cost = $monthly_cost + $product_cost;
                        $monthly_revenue = $connectivity_requirement->offerByConnectivity->offerDetails->first()->grand_total;
                        $total_investment += $investment;
                        $grand_total_otc += $total_otc;
                        $total_product_cost += $product_cost;
                        $sum_of_monthly_cost += $monthly_cost;
                        $total_budget += $total_monthly_cost;
                        $grand_total_monthly_cost += $total_monthly_cost * $month;
                        $total_revenue += $monthly_revenue;
                        $monthly_pnl = $monthly_revenue - $total_monthly_cost;
                        $total_monthly_pnl += $monthly_pnl;
                        $total_yearly_pnl += $monthly_pnl * $month;
                    @endphp
                    <tr>
                        <td class="text-left">{{ $connectivity_requirement->connectivity_point }}
                            ({{ $connectivity_requirement->fr_no }}) </td>
                        <td class="text-right">@formatFloat($investment + ($connectivity_requirement->costingByConnectivity->equipment_grand_total - $connectivity_requirement->costingByConnectivity->equipment_price_for_client))</td>
                        <td class="text-right">{{ $total_otc }}</td>
                        <td class="text-right">
                            {{ $connectivity_requirement->costingByConnectivity->equipment_price_for_client }}</td>
                        <td class="text-right">
                            {{ $connectivity_requirement->costingByConnectivity->equipment_price_for_client + $connectivity_requirement->offerByConnectivity->offerDetails->first()->total_offer_otc }}
                        </td>
                        <td class="text-right">@formatFloat($product_cost)</td>
                        <td class="text-right">@formatFloat($monthly_cost)</td>
                        <td class="text-right">@formatFloat($total_monthly_cost)</td>
                        <td class="text-right">@formatFloat($total_monthly_cost * $month)</td>
                        <td class="text-right">@formatFloat($monthly_revenue)</td>
                        <td class="text-right">@formatFloat($monthly_revenue * $month)</td>
                        <td class="text-right">@formatFloat($monthly_pnl)</td>
                        <td class="text-right">@formatFloat($monthly_pnl * $month)</td>
                        </td>
                    </tr>
                @endif
            </tbody>
            <tfoot>
                <tr style="font-weight: bold!important; background-color: #e3ecf6d8!important; ">
                    <td colspan="" class="text-right"> <b>Total</b> </td>
                    <td class="text-right"><b>@formatFloat($total_investment)</b></td>
                    <td></td>
                    <td></td>
                    <td class="text-right"><b>@formatFloat($grand_total_otc)</b></td>
                    <td class="text-right"><b>@formatFloat($total_product_cost)</b></td>
                    <td class="text-right"><b>@formatFloat($sum_of_monthly_cost)</b></td>
                    <td class="text-right"><b>@formatFloat($total_budget)</b></td>
                    <td class="text-right"><b>@formatFloat($grand_total_monthly_cost)</b></td>
                    <td class="text-right"><b>@formatFloat($total_revenue)</b></td>
                    <td class="text-right"><b>@formatFloat($total_monthly_pnl)</b></td>
                    <td class="text-right"><b>@formatFloat($total_monthly_pnl)</b></td>
                    <td class="text-right"><b>@formatFloat($total_yearly_pnl)</b></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="d-flex" style="margin-top: 20px; justify-content: space-around">
        <a class="btn btn-outline-success" style="transition: 0.5s"
            href="{{ route('modify-pnl-details', $connectivity_requirement_id) }}">Details</a>
        <a class="btn btn-outline-success"
            @if ($sale->finance_approval == 'Not Approved') href="{{ route('modify-pnl-approve-by-finance', $connectivity_requirement_id) }}" @else href="#" title="Approved By {{ $sale?->financeApprovedBy?->name }}" @endif
            style="transition: 0.5s">Finance {{ $sale->finance_approval == 'Not Approved' ? 'Approval' : 'Approved' }}</a>
        <a class="btn btn-outline-success"
            @if ($sale->cmo_approval == 'Not Approved') href="{{ route('modify-pnl-approve-by-cmo', $connectivity_requirement_id) }}" @else href="#" title="Approved By {{ $sale?->cmoApprovedBy?->name }}" @endif
            style="transition: 0.5s" href="{{ route('modify-pnl-approve-by-cmo', $connectivity_requirement_id) }}">CMO
            {{ $sale->finance_approval == 'Not Approved' ? 'Approval' : 'Approved' }}</a>
        <a class="btn btn-outline-success"
            @if ($sale->management_approval == 'Not Approved') href="{{ route('modify-pnl-approve-by-management', $connectivity_requirement_id) }}" @else href="{{ route('pnl-approve-by-management', $connectivity_requirement_id) }}" title="Approved By {{ $sale?->managementApprovedBy?->name }}" @endif
            style="transition: 0.5s"
            href="{{ route('modify-pnl-approve-by-management', $connectivity_requirement_id) }}">Management
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
