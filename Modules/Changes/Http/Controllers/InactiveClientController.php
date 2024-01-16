<?php

namespace Modules\Changes\Http\Controllers;

use App\Models\Dataencoding\Employee;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Networking\Entities\Activation;
use Modules\Networking\Entities\BandwidthDestribution;
use Modules\Networking\Entities\ClientFacility;
use Modules\Networking\Entities\Connectivity;
use Modules\Networking\Entities\LogicalConnectivity;
use Modules\Networking\Entities\PhysicalConnectivity;
use Modules\Sales\Entities\SaleDetail;

class InactiveClientController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('changes::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($fr_no = null)
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
            ->where('fr_no', $fr_no)
            ->where('is_modify', '1')
            ->latest()
            ->first();
        return view('changes::inactive_clients.connectivities.create', compact('salesDetail', 'employees', 'physicalConnectivity', 'logicalConnectivityBandwidths', 'logicalConnectivities', 'facilityTypes', 'clientFacility', 'connectivity'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            $connectivity = Connectivity::create(request()->all());
            $data = request()->only('client_no', 'fr_no', 'is_active');
            $data['connectivity_id'] = $connectivity->id;
            $activation = Activation::where('fr_no', $request->fr_no)->first();
            $activation->update(['is_active' => $request->is_active]);
            return redirect()->back()->with('message', 'Data has been inserted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('changes::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('changes::edit');
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
