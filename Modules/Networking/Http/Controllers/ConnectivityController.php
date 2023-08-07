<?php

namespace Modules\Networking\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Admin\Entities\Ip;
use Illuminate\Routing\Controller;
use App\Models\Dataencoding\Employee;
use Modules\Sales\Entities\SaleDetail;
use Illuminate\Contracts\Support\Renderable;
use Modules\Sales\Entities\SaleProductDetail;
use Modules\Networking\Entities\ClientFacility;
use Modules\Networking\Entities\LogicalConnectivity;
use Modules\Networking\Entities\PhysicalConnectivity;
use Modules\Networking\Entities\BandwidthDestribution;

class ConnectivityController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $salesDetails = SaleDetail::query()
            ->with('sale', 'client', 'frDetails')
            ->latest()
            ->get();
        return view('networking::connectivities.index', compact('salesDetails'));
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
            ->where('sale_id', $salesDetail->sale_id)
            ->with('lines')
            ->latest()
            ->first();

        $logicalConnectivityInternet = LogicalConnectivity::query()
            ->where([
                'fr_no' => $physicalConnectivity->fr_no,
                'client_no' => $physicalConnectivity->client_no,
                'product_category' => 'Internet'
            ])
            ->with('lines.product')
            ->latest()
            ->first();

        $logicalConnectivityBandwidths = BandwidthDestribution::query()
            ->where('logical_connectivity_id', $logicalConnectivityInternet->id)
            ->with('ip')
            ->get();

        $facilityTypes = explode(',', $logicalConnectivityInternet->facility_type);

        $clientFacility = ClientFacility::query()
            ->where('logical_connectivity_id', $logicalConnectivityInternet->id)
            ->first();

        $physicalConnectivity = PhysicalConnectivity::with('lines')
            ->where('sale_id', $salesDetail->sale_id)
            ->latest()
            ->firstOrFail();

        $logicalConnectivities = LogicalConnectivity::with(['lines.product'])
            ->forProductCategories(['VAS', 'Data', 'Internet'])
            ->forClientAndFrNo($physicalConnectivity->client_no, $physicalConnectivity->fr_no)
            ->latest()
            ->get()
            ->keyBy('product_category');

        $logicalConnectivityVas = $logicalConnectivities->get('VAS');
        $logicalConnectivityData = $logicalConnectivities->get('Data');
        $logicalConnectivityInternet = $logicalConnectivities->get('Internet');

        return view('networking::connectivities.create', compact('salesDetail', 'employees', 'physicalConnectivity', 'logicalConnectivityInternet', 'logicalConnectivityBandwidths', 'logicalConnectivityVas', 'logicalConnectivityData', 'facilityTypes', 'clientFacility'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
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
