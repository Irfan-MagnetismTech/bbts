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
use Modules\Networking\Entities\PhysicalConnectivity;
use Modules\Sales\Entities\FeasibilityRequirementDetail;
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
        return view('networking::physical-connectivities.create', compact('connectivity_links'));
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
                    'pop' => $request->pop[$key],
                    'ldp' => $request->ldp[$key],
                    'bbts_link_id' => $request->bbts_link_id[$key],
                    'device_ip' => $request->device_ip[$key],
                    'port' => $request->port[$key],
                    'vlan' => $request->vlan[$key],
                    'connectivity_details' => $request->connectivity_details[$key],
                    'comment' => $request->comment[$key],
                ];
            }

            $connectivity_point = explode('_', $request->connectivity_point);
            $request->merge([
                'connectivity_point' => $connectivity_point[0],
                'fr_no' => $connectivity_point[1],
            ]);

            $physicalConnectivity = PhysicalConnectivity::create($request->all());
            $physicalConnectivity->lines()->createMany($dataList);

            DB::commit();

            return redirect()->route('physical-connectivities.edit', $physicalConnectivity->id);
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

        return view('networking::physical-connectivities.create', compact('physicalConnectivity', 'feasibility_details', 'challanInfo', 'connectivity_points', 'clientInfo', 'connectivity_links'));
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
                    'port' => $request->port[$key],
                    'vlan' => $request->vlan[$key],
                    'connectivity_details' => $request->connectivity_details[$key],
                    'comment' => $request->comment[$key],
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
