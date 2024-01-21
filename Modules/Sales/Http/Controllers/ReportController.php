<?php

namespace Modules\Sales\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Sales\Entities\Client;
use Modules\Sales\Entities\Planning;
use Modules\Sales\Entities\Product;
use Modules\Sales\Entities\Sale;
use PDF;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function planReport()
    {
        $dateFrom = request()->date_from ? date('Y-m-d', strtotime(request()->date_from)) : null;
        $dateTo = request()->date_to ? date('Y-m-d', strtotime(request()->date_to)) : null;
        $client_no = request()->client_no ?? '';
        // $plans = Planning::get();
        // dd($plans);
        $clients = Client::latest()->get();
        $plan_reports = Planning::query()
            ->with('client', 'survey')
            ->when(!empty($client_no), function ($q) use ($client_no) {
                $q->where('client_no', $client_no);
            })
            ->when(!empty($dateFrom) && !empty($dateTo), function ($q) use ($dateFrom, $dateTo) {

                $q->whereBetween('created_at', [$dateFrom, $dateTo]);
            })
            ->when(!empty($dateFrom) && empty($dateTo), function ($q) use ($dateFrom) {
                $q->where('created_at', '>=', $dateFrom);
            })
            ->when(!empty($dateTo) && empty($dateFrom), function ($q) use ($dateTo) {
                $q->where('created_at', '<=', empty($dateTo));
            })
            ->when(empty($dateFrom) && empty($dateTo) && empty($client_no), function ($q) {
                $q->where('created_at', '>=', now()->subDays(30));
            })
            ->where('is_modified', 0)
            ->get();
        if (request('type') == 'PDF') {
            $pdf = PDF::loadView('sales::pdf.plan-report', ['plan_reports' => $plan_reports, 'clients' => $clients], [], [
                'format' => 'A4',
                'orientation' => 'L'
            ]);
            return $pdf->stream('plan-report.pdf');
        } else {
            return view('sales::reports.plan-report', compact('plan_reports', 'clients'));
        }
    }

    public function planModificationReport()
    {
        $dateFrom = request()->date_from ? date('Y-m-d', strtotime(request()->date_from)) : null;
        $dateTo = request()->date_to ? date('Y-m-d', strtotime(request()->date_to)) : null;
        $client_no = request()->client_no ?? '';
        // $plans = Planning::get();
        // dd($plans);
        $clients = Client::latest()->get();
        $plan_reports = Planning::query()
            ->with('client', 'ConnectivityRequirement')
            ->when(!empty($client_no), function ($q) use ($client_no) {
                $q->where('client_no', $client_no);
            })
            ->when(!empty($dateFrom) && !empty($dateTo), function ($q) use ($dateFrom, $dateTo) {

                $q->whereBetween('created_at', [$dateFrom, $dateTo]);
            })
            ->when(!empty($dateFrom) && empty($dateTo), function ($q) use ($dateFrom) {
                $q->where('created_at', '>=', $dateFrom);
            })
            ->when(!empty($dateTo) && empty($dateFrom), function ($q) use ($dateTo) {
                $q->where('created_at', '<=', empty($dateTo));
            })
            ->when(empty($dateFrom) && empty($dateTo) && empty($client_no), function ($q) {
                $q->where('created_at', '>=', now()->subDays(30));
            })
            ->where('is_modified', 1)
            ->get();
        if (request('type') == 'PDF') {
            $pdf = PDF::loadView('sales::pdf.plan-modification-report', ['plan_reports' => $plan_reports, 'clients' => $clients], [], [
                'format' => 'A4',
                'orientation' => 'L'
            ]);
            return $pdf->stream('plan-modification-report.pdf');
        } else {
            return view('sales::reports.plan-modification-report', compact('plan_reports', 'clients'));
        }
    }

    public function monthlySalesSummaryReport()
    {
        $dateFrom = request()->date_from ? date('Y-m-d', strtotime(request()->date_from)) : null;
        $dateTo = request()->date_to ? date('Y-m-d', strtotime(request()->date_to)) : null;
        $client_no = request()->client_no ?? '';
        $sales_data = [];
        //client_no, client_name, Connectivity Point, Method, Data, Internet, ip, OTC, MRC, activation_date, billing_date, billing_address, ac_holder, remarks   
        $monthly_sales_summary = Sale::query()
            ->with('client', 'saleDetails', 'saleProductDetails', 'saleLinkDetails.finalSurveyDetails')
            ->when(!empty($client_no), function ($q) use ($client_no) {
                $q->where('client_no', $client_no);
            })
            ->when(!empty($dateFrom) && !empty($dateTo), function ($q) use ($dateFrom, $dateTo) {

                $q->whereBetween('created_at', [$dateFrom, $dateTo]);
            })
            ->when(!empty($dateFrom) && empty($dateTo), function ($q) use ($dateFrom) {
                $q->where('created_at', '>=', $dateFrom);
            })
            ->when(!empty($dateTo) && empty($dateFrom), function ($q) use ($dateTo) {
                $q->where('created_at', '<=', empty($dateTo));
            })
            ->when(empty($dateFrom) && empty($dateTo) && empty($client_no), function ($q) {
                $q->where('created_at', '>=', now()->subDays(30));
            })
            ->where('is_modified', 0)
            ->get()
            ->map(function ($sale) use (&$sales_data) {
                $sale->saleDetails->map(function ($saleDetail, $index) use ($sale, &$sales_data) {
                    $sales_data[] = [
                        'client_no' => $sale->client->client_no,
                        'client_name' => $sale->client->client_name,
                        'connectivity_point' => $saleDetail->feasibilityRequirementDetails->connectivity_point,
                        'products' => $saleDetail->saleProductDetails,
                        'otc' => $saleDetail->otc,
                        'mrc' => $saleDetail->mrc,
                        'activation_date' => $saleDetail?->connectivity?->commissioning_date,
                        'billing_date' => $saleDetail?->connectivity?->billing_date,
                        'billing_address' => $saleDetail->billingAddress->address,
                        'account_holder' => $sale->account_holder,
                        'remarks' => $sale->remarks,
                    ];
                    // dd($sales_data);
                });
            });
        $clients = Client::latest()->get();
        if (request('type') == 'PDF') {
            $pdf = PDF::loadView('sales::pdf.monthly-sales-summary-report', ['sales_data' => $sales_data, 'clients' => $clients], [], [
                'format' => 'A4',
                'orientation' => 'L'
            ]);
            return $pdf->stream('monthly-sales-summary-report.pdf');
        } else {
            return view('sales::reports.monthly-sales-summary-report', compact('sales_data', 'clients'));
        }
    }
}
