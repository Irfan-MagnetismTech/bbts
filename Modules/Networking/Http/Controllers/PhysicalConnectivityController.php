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
        return view('networking::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('networking::physical-connectivities.create');
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
                    'link_id' => $request->link_id[$key],
                    'device_ip' => $request->device_ip[$key],
                    'port' => $request->port[$key],
                    'vlan' => $request->vlan[$key],
                    'distance' => $request->distance[$key],
                    'connectivity_details' => $request->connectivity_details[$key],
                    'comment' => $request->comment[$key],
                ];
            }
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
    public function show($id)
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

        $challanInfo = ScmChallan::query()
            ->where('fr_no', $physicalConnectivity->fr_no)
            ->get();

        $connectivity_points = FeasibilityRequirementDetail::query()
            ->where('client_no', $physicalConnectivity->client_no)
            ->get();

        $clientInfo = FeasibilityRequirementDetail::query()
            ->where('fr_no', $physicalConnectivity->fr_no)
            ->first();

        return view('networking::physical-connectivities.create', compact('physicalConnectivity', 'challanInfo', 'connectivity_points', 'clientInfo'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, PhysicalConnectivity $physicalConnectivity)
    {
        
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
