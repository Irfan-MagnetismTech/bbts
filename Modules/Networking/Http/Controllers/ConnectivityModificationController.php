<?php

namespace Modules\Networking\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Admin\Entities\Ip;
use Illuminate\Routing\Controller;
use App\Models\Dataencoding\Employee;
use Carbon\Carbon;
use Modules\Sales\Entities\SaleDetail;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\DB;
use Modules\Sales\Entities\SaleProductDetail;
use Modules\Networking\Entities\ClientFacility;
use Modules\Networking\Entities\LogicalConnectivity;
use Modules\Networking\Entities\PhysicalConnectivity;
use Modules\Networking\Entities\BandwidthDestribution;
use Modules\Networking\Entities\Connectivity;
use Modules\Sales\Entities\ConnectivityRequirement;

class ConnectivityModificationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $salesDetails = SaleDetail::query()
            ->with('sale', 'client', 'frDetails')
            ->whereHas('sale', function ($query) {
                $query->where('is_modified', '1');
            })
            ->latest()
            ->get();

        return view('networking::modify_connectivities.index', compact('salesDetails'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($fr_no)
    {
        $salesDetail = SaleDetail::query()
            ->with('sale', 'client', 'frDetails')
            ->where('fr_no', $fr_no)
            ->first();

        $employees = Employee::latest()->get();

        $physicalConnectivity = PhysicalConnectivity::query()
            ->whereSaleIdAndFrNo($salesDetail->sale_id, $salesDetail->fr_no)
            ->with('lines')
            ->latest()
            ->first();

        $logicalConnectivities = LogicalConnectivity::with(['lines.product'])
            ->forProductCategories(['VAS', 'Data', 'Internet'])
            ->whereClientNoAndFrNo(@$physicalConnectivity->client_no, @$physicalConnectivity->fr_no)
            ->latest()
            ->get()
            ->keyBy('product_category');

        $facilityTypes = explode(',', $logicalConnectivities->get('Internet')?->facility_type);

        $logicalConnectivityBandwidths = BandwidthDestribution::query()
            ->where('logical_connectivity_id', $logicalConnectivities->get('Internet')?->id)
            ->with('ip')
            ->get();

        $clientFacility = ClientFacility::query()
            ->where('logical_connectivity_id', $logicalConnectivities->get('Internet')?->id)
            ->first();

        $connectivity = Connectivity::query()
            ->with('employee')
            ->whereSaleId($salesDetail->sale_id)
            ->first();

        return view('networking::modify_connectivities.create', compact('salesDetail', 'employees', 'physicalConnectivity', 'logicalConnectivityBandwidths', 'logicalConnectivities', 'facilityTypes', 'clientFacility', 'connectivity'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store()
    {
        try {
            Connectivity::create(request()->all());
            return redirect()->route('connectivities.index')->with('message', 'Data has been inserted successfully');
        } catch (\Exception $e) {
            return redirect()->route('connectivities.create')->withInput()->withErrors($e->getMessage());
        }
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
        try {
            $connectivity = Connectivity::query()
                ->with('employee')
                ->whereSaleId($id)
                ->first();

            $salesDetail = SaleDetail::query()
                ->with('sale', 'client', 'frDetails')
                ->where('sale_id', $id)
                ->first();

            $employees = Employee::latest()->get();

            $physicalConnectivity = PhysicalConnectivity::query()
                ->whereSaleIdAndFrNo($salesDetail->sale_id, $salesDetail->fr_no)
                ->with('lines')
                ->latest()
                ->first();

            $logicalConnectivities = LogicalConnectivity::with(['lines.product'])
                ->forProductCategories(['VAS', 'Data', 'Internet'])
                ->whereClientNoAndFrNo(@$physicalConnectivity->client_no, @$physicalConnectivity->fr_no)
                ->latest()
                ->get()
                ->keyBy('product_category');

            $facilityTypes = explode(',', $logicalConnectivities->get('Internet')?->facility_type);

            $logicalConnectivityBandwidths = BandwidthDestribution::query()
                ->where('logical_connectivity_id', $logicalConnectivities->get('Internet')?->id)
                ->with('ip')
                ->get();

            $clientFacility = ClientFacility::query()
                ->where('logical_connectivity_id', $logicalConnectivities->get('Internet')?->id)
                ->first();

            return view('networking::modify_connectivities.edit', compact('salesDetail', 'employees', 'physicalConnectivity', 'logicalConnectivityBandwidths', 'logicalConnectivities', 'facilityTypes', 'clientFacility', 'connectivity'));
        } catch (\Exception $e) {
            return redirect()->route('connectivities.index')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {

        try {
            $connectivity = Connectivity::query()
                ->whereSaleId($id)
                ->first();

            $connectivity->update(request()->all());

            return redirect()->route('connectivities.index')->with('message', 'Data has been updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('connectivities.edit', $id)->withInput()->withErrors($e->getMessage());
        }
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
