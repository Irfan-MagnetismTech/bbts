<?php

namespace Modules\Networking\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Admin\Entities\Ip;
use Illuminate\Routing\Controller;
use Modules\Sales\Entities\SaleDetail;
use Illuminate\Contracts\Support\Renderable;
use Modules\Sales\Entities\SaleProductDetail;
use Modules\Networking\Entities\ClientFacility;
use Modules\Networking\Entities\LogicalConnectivity;
use Modules\Networking\Entities\PhysicalConnectivity;
use Modules\Networking\Entities\BandwidthDestribution;
use Modules\Networking\Entities\CCSchedule;
use Modules\Networking\Entities\Connectivity;

class CCScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $salesDetails = SaleDetail::query()
            ->with('sale', 'client', 'frDetails', 'ccSchedule')
            ->whereHas('sale', function ($query) {
                $query->where('management_approved_by', '!=', null);
            })
            ->latest()
            ->get()
            ->map(function ($saleDetail) {
                $saleDetail['physical_connectivity'] = PhysicalConnectivity::query()
                    ->where('fr_no', $saleDetail->fr_no)->where('is_modified', '0')
                    ->first() ? true : false;
                $saleDetail['logical_connectivity'] = LogicalConnectivity::query()
                    ->where('fr_no', $saleDetail->fr_no)->where('is_modified', '0')
                    ->first() ? true : false;
                $saleDetail['commissioning_date'] = $saleDetail->connectivities->commissioning_date ?? null;
                $saleDetail['billing_date'] = $saleDetail->connectivities->billing_date ?? null;
                return $saleDetail;
            });

            // dd($salesDetails->toArray());
        return view('networking::cc-schedules.index', compact('salesDetails'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $salesDetails = SaleDetail::query()
            ->whereHas('sale', function ($query) {
                $query->where('management_approval', 'Approved');
            })
            ->with(['sale', 'client', 'frDetails'])
            ->whereFrNo(request()->fr_no)
            ->latest()
            ->first();
        // dd($salesDetails);

        $ccSchedules = CCSchedule::query()
            ->whereClientNoAndFrNo($salesDetails->client_no, $salesDetails->fr_no)
            ->latest()
            ->first();

        $approvedType = explode(',', @$ccSchedules->approved_type);

        return view('networking::cc-schedules.create', compact('salesDetails' ?? [], 'ccSchedules' ?? [], 'approvedType' ?? []));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $checkboxes = ['cr_checkbox', 'nttn_checkbox', 'er_checkbox', 'fo_checkbox', 'schedule_checkbox'];

        $approved_type = collect($checkboxes)
            ->map(function ($checkbox) use ($request) {
                return $request->has($checkbox) ? substr($checkbox, 0, -9) : null;
            })
            ->filter()
            ->implode(',');

        $request->merge([
            'approved_type' => $approved_type
        ]);

        CCSchedule::updateOrCreate(
            [
                'fr_no' => $request->fr_no,
                'client_no' => $request->client_no,
            ],
            $request->all()
        );

        return redirect()->back()->with('message', 'Client Connectivity Schedule updated successfully.');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('networking::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('networking::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
