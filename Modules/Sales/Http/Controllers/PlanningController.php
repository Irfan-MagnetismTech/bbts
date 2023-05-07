<?php

namespace Modules\Sales\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Sales\Entities\Product;
use Modules\Sales\Entities\Planning;
use Modules\Sales\Entities\ServicePlan;
use Modules\Sales\Entities\EquipmentPlan;
use Modules\Sales\Entities\FeasibilityRequirementDetail;
use Modules\Sales\Entities\LeadGeneration;
use Modules\Sales\Entities\ConnectivityProductRequirementDetail;
use Modules\Sales\Entities\ConnectivityRequirement;

class PlanningController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('sales::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($id = null)
    {
        $feasibilityRequirementDetail = FeasibilityRequirementDetail::with('feasibilityRequirement')->where('id', $id)->first();
        $lead_generation = LeadGeneration::where('id', $feasibilityRequirementDetail->feasibilityRequirement->lead_generation_id)->first();
        $connectivityRequirement = ConnectivityRequirement::where('fr_no', $feasibilityRequirementDetail->fr_no)->first();
        $connectivityProductRequirementDetails = ConnectivityProductRequirementDetail::where('connectivity_requirement_id', $connectivityRequirement->id)->get();
        $particulars = Product::get();
        return view('sales::planning.create', compact('feasibilityRequirementDetail', 'lead_generation', 'connectivityProductRequirementDetails', 'particulars'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $data = $request->only('client_id', 'fr_no', 'link_type', 'option');
        $data['user_id'] = auth()->user()->id ?? '';
        $data['branch_id'] = auth()->user()->branch_id ?? '';
        $service_plan = $request->only('particulars', 'client_req', 'plan');
        $equipment_plan = $request->only('material', 'quantity', 'unit');
        $planning = Planning::create($data);

        foreach ($service_plan['particulars'] as $key => $particular) {
            $service_plan['planning_id'] = $planning->id;
            $service_plan['particulars'] = $particular;
            $service_plan['client_req'] = $service_plan['client_req'][$key];
            $service_plan['plan'] = $service_plan['plan'][$key];
            ServicePlan::create($service_plan);
        }

        foreach ($equipment_plan['material'] as $key => $material) {
            $equipment_plan['planning_id'] = $planning->id;
            $equipment_plan['material'] = $material;
            $equipment_plan['quantity'] = $equipment_plan['quantity'][$key];
            $equipment_plan['unit'] = $equipment_plan['unit'][$key];
            EquipmentPlan::create($equipment_plan);
        }

        return redirect()->route('planning.index')->with('success', 'Planning created successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('sales::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('sales::edit');
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
