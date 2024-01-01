<?php

namespace Modules\Sales\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Sales\Entities\Client;
use Modules\Sales\Entities\Planning;

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
        return view('sales::reports.plan-report', compact('plan_reports', 'clients'));
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
        return view('sales::reports.plan-modification-report', compact('plan_reports', 'clients'));
    }
}
