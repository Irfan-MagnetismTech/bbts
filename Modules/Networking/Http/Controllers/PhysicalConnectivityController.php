<?php

namespace Modules\Networking\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Sales\Entities\Client;
use Modules\Sales\Entities\Planning;
use Modules\SCM\Entities\ScmChallan;
use Illuminate\Support\Facades\Session;
use Illuminate\Contracts\Support\Renderable;
use Modules\Admin\Entities\ConnectivityLink;
use Modules\Networking\Entities\NetFiberManagement;
use Modules\Networking\Entities\PhysicalConnectivity;
use Modules\Sales\Entities\FeasibilityRequirementDetail;
use Modules\Sales\Entities\SaleDetail;
use PharIo\Manifest\Url;
use Termwind\Components\Dd;

class PhysicalConnectivityController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $physicalConnectivities = PhysicalConnectivity::query()
            ->with('lines')
            ->latest()
            ->get();
        return view('networking::physical-connectivities.index', compact('physicalConnectivities'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $connectivity_links = ConnectivityLink::latest()->get();
        Session::put('physicalConnectivityEditUrl', request()->fullUrl());

        $sale_id = request()->get('sale_id');
        $challanInfo = [];
        $connectivity_points = [];
        $saleDetails = [];
        $fiber_cores = [];

        if (request()->get('sale_id')) {
            $saleDetails = SaleDetail::query()
                ->with('saleLinkDetails')
                ->whereSaleIdAndFrNo(request()->get('sale_id'), request()->get('fr_no'))
                ->first();

            // $physicalConnectivity = PhysicalConnectivity::query()
            // ->whereSaleId(request()->get('sale_id'))
            // ->with('lines')
            // ->latest()
            // ->first();

            // dd($physicalConnectivity);

            // $feasibility_details = FeasibilityRequirementDetail::with('feasibilityRequirement')->where('fr_no', $physicalConnectivity->fr_no)->first();

            $challanInfo = ScmChallan::query()
                ->where('fr_no', $saleDetails->fr_no)
                ->get();

            // dd($saleDetails->client_no);

            $connectivity_points = FeasibilityRequirementDetail::query()
                ->where('client_no', $saleDetails->client_no)
                ->get();

            // dd($connectivity_points);

            // $clientInfo = FeasibilityRequirementDetail::query()
            //     ->where('fr_no', $physicalConnectivity->fr_no)
            //     ->first();

            // $connectivity_links = ConnectivityLink::latest()->get();

            $fiber_cores = NetFiberManagement::latest()->get();
        }

        return view('networking::physical-connectivities.create', compact('challanInfo', 'connectivity_points', 'saleDetails', 'connectivity_links', 'fiber_cores'));
        // return view('networking::physical-connectivities.create', compact('connectivity_links','saleDetails', 'feasibility_details', 'challanInfo', 'connectivity_points', 'clientInfo'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $dataList = [];
            foreach ($request->link_type as $key => $value) {
                $dataList[] = [
                    'link_type' => $value,
                    'method' => $request->method[$key],
                    'link_no' => $request->link_no[$key],
                    'pop' => $request->pop[$key],
                    'pop_id' => $request->pop_id[$key],
                    'ldp' => $request->ldp[$key],
                    'bbts_link_id' => $request->bbts_link_id[$key],
                    'device_ip' => $request->device_ip[$key],
                    'port' => $request->port[$key],
                    'vlan' => $request->vlan[$key],
                    'connectivity_details' => $request->connectivity_details[$key],
                    'comment' => $request->comment[$key],
                    'fiber_core_composite_key' => $request->fiber_core_composite_key[$key] ?? '',
                ];
            }

            // dd($request->all());

            $connectivity_point = explode('_', $request->connectivity_point);
            $request->merge([
                'connectivity_point' => $connectivity_point[0],
                'fr_no' => $connectivity_point[1],
            ]);

            $physicalConnectivity = PhysicalConnectivity::create($request->all());
            $physicalConnectivity->lines()->createMany($dataList);

            DB::commit();

            return redirect()->route('physical-connectivities.index')->with('message', 'Physical Connectivity Created Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show()
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(PhysicalConnectivity $physicalConnectivity)
    {
        Session::put('physicalConnectivityEditUrl', url()->current());

        $feasibility_details = FeasibilityRequirementDetail::with('feasibilityRequirement')->where('fr_no', $physicalConnectivity->fr_no)->first();

        $challanInfo = ScmChallan::query()
            ->where('fr_no', $physicalConnectivity->fr_no)
            ->get();

        $connectivity_points = FeasibilityRequirementDetail::query()
            ->where('client_no', $physicalConnectivity->client_no)
            ->get();

        $clientInfo = FeasibilityRequirementDetail::query()
            ->where('fr_no', $physicalConnectivity->fr_no)
            ->first();

        $connectivity_links = ConnectivityLink::latest()->get();

        $fiber_cores = NetFiberManagement::latest()->get();

        return view('networking::physical-connectivities.create', compact('physicalConnectivity', 'feasibility_details', 'challanInfo', 'connectivity_points', 'clientInfo', 'connectivity_links', 'fiber_cores'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, PhysicalConnectivity $physicalConnectivity)
    {
        try {
            DB::beginTransaction();

            $dataList = [];
            foreach ($request->link_type as $key => $value) {
                $dataList[] = [
                    'link_type' => $value,
                    'method' => $request->method[$key],
                    'pop' => $request->pop[$key],
                    'ldp' => $request->ldp[$key],
                    'bbts_link_id' => $request->bbts_link_id[$key],
                    'device_ip' => $request->device_ip[$key],
                    'pop_id' => $request->pop_id[$key],
                    'port' => $request->port[$key],
                    'vlan' => $request->vlan[$key],
                    'connectivity_details' => $request->connectivity_details[$key],
                    'comment' => $request->comment[$key],
                    'fiber_core_composite_key' => $request->fiber_core_composite_key[$key] ?? '',
                ];
            }

            $connectivity_point = explode('_', $request->connectivity_point);
            $request->merge([
                'connectivity_point' => $connectivity_point[0],
                'fr_no' => $connectivity_point[1],
            ]);

            $physicalConnectivity->update($request->all());
            $physicalConnectivity->lines()->delete();
            $physicalConnectivity->lines()->createMany($dataList);

            DB::commit();

            return redirect()->route('physical-connectivities.index')->with('message', 'Physical Connectivity Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(PhysicalConnectivity $physicalConnectivity)
    {
        try {
            DB::beginTransaction();

            $physicalConnectivity->lines()->delete();
            $physicalConnectivity->delete();

            DB::commit();

            return redirect()->route('physical-connectivities.index')->with('message', 'Physical Connectivity Deleted Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function getNetworkInfoByFr()
    {
        $networkInfo = Planning::query()
            ->with('finalSurveyDetail')
            ->where('fr_no', request('fr_no'))
            ->get();

        return response()->json($networkInfo);
    }

    public function getChallanInfoByLinkNo()
    {
        $challanInfo = ScmChallan::query()
            ->with('scmChallanLines')
            ->where('link_no', request('link_no'))
            ->get();

        return response()->json($challanInfo);
    }

    public function getChallanInfoByChallanNo()
    {
        $challanInfo = ScmChallan::query()
            ->with('scmChallanLines')
            ->where('challan_no', request('challan_no'))
            ->get();

        return response()->json($challanInfo);
    }
}
