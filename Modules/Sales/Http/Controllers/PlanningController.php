<?php

namespace Modules\Sales\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\QueryException;
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
use Modules\Sales\Entities\FinalSurveyDetail;
use Modules\Sales\Entities\PlanLink;
use Modules\Sales\Entities\SurveyDetail;
use Modules\Sales\Entities\Survey;
use Modules\Sales\Entities\PlanLinkEquipment;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\Brand;
use Modules\Sales\Entities\Vendor;
use Modules\SCM\Entities\Material;

class PlanningController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $plans = Planning::with('planLinks', 'feasibilityRequirementDetail.feasibilityRequirement')->get();
        return view('sales::planning.index', compact('plans'));
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
        $materials = Material::get();
        $brands = Brand::get();
        $vendors = Vendor::get();
        return view('sales::planning.create', compact('feasibilityRequirementDetail', 'lead_generation', 'connectivityProductRequirementDetails', 'particulars', 'materials', 'brands', 'vendors'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */


    public function store(Request $request)
    {
        $feasibility_requirement_detail = FeasibilityRequirementDetail::with('feasibilityRequirement')->where('fr_no', $request->fr_no)->first();
        $request->request->add(['mq_no' => $feasibility_requirement_detail->feasibilityRequirement->mq_no]);
        $plan_data = $request->only('mq_no', 'fr_no', 'client_no');
        $plan_data['date'] = date('Y-m-d');
        $plan_data['user_id'] = auth()->user()->id ?? '';
        DB::beginTransaction();

        $plan = Planning::create($plan_data);

        $this->createServicePlans($request, $plan);

        $this->createEquipmentPlans($request, $plan);

        if ($request->total_key > 0) {
            $this->createPlanLinks($request, $plan);
        }

        DB::commit();

        return redirect()->route('planning.index')->with('success', 'Planning created successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $plan = Planning::with('planLinks', 'equipmentPlans', 'servicePlans',)->where('id', $id)->first();
        return view('sales::planning.show', compact('plan'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $plan = Planning::with('planLinks', 'equipmentPlans', 'servicePlans',)->where('id', $id)->first();
        $particulars = Product::get();
        $materials = Material::get();
        $brands = Brand::get();
        return view('sales::planning.edit', compact('plan', 'particulars', 'materials', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        dd($request->all());
        $plan_data = $request->only('mq_no', 'fr_no', 'client_no');
        $plan_data['date'] = date('Y-m-d');
        $plan_data['user_id'] = auth()->user()->id ?? '';
        DB::beginTransaction();
        try {
            $plan = Planning::where('id', $id)->update($plan_data);
            $this->createServicePlans($request, $plan);
            $this->createEquipmentPlans($request, $plan);
            if ($request->total_key > 0) {
                $this->createPlanLinks($request, $plan);
            }
            DB::commit();
            return redirect()->route('planning.index')->with('success', 'Planning updated successfully');
        } catch (QueryException $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Planning $planning)
    {
        try {
            $planning->delete();
            return redirect()->route('planning.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            return redirect()->route('planning.index')->withErrors($e->getMessage());
        }
    }

    private function createServicePlans($request, $plan)
    {
        foreach ($request->detail_id as $key => $detail_id) {
            $service_plan_data['connectivity_product_requirement_details_id'] = $request->detail_id[$key];
            $service_plan_data['plan'] = $request->plan[$key];
            $service_plan_data['planning_id'] = $plan->id;
            ServicePlan::create($service_plan_data);
        }
    }

    private function createEquipmentPlans($request, $plan)
    {
        foreach ($request->equipment_id as $key => $equipment_id) {
            $equipment_plan_data['material_id'] = $request->equipment_id[$key];
            $equipment_plan_data['brand_id'] = $request->brand_id[$key];
            $equipment_plan_data['quantity'] = $request->quantity[$key];
            $equipment_plan_data['model'] = $request->model[$key];
            $equipment_plan_data['unit'] = $request->unit[$key];
            $equipment_plan_data['remarks'] = $request->equipment_remarks[$key];
            $equipment_plan_data['planning_id'] = $plan->id;
            EquipmentPlan::create($equipment_plan_data);
        }
    }

    private function createPlanLinks($request, $plan)
    {
        for ($i = 1; $i <= $request->total_key; $i++) {
            $plan_link_data['link_type'] = request("link_type_{$i}");
            $plan_link_data['existing_infrastructure'] = request("existing_infrastructure_{$i}");
            $plan_link_data['existing_infrastructure_link'] = request("existing_infrastructure_link_{$i}");
            $plan_link_data['option'] = request("option_{$i}");
            $plan_link_data['existing_transmission_capacity'] = request("existing_transmission_capacity_{$i}");
            $plan_link_data['increase_capacity'] = request("increase_capacity_{$i}");
            $plan_link_data['link_availability_status'] = request("link_availability_status_{$i}");
            $plan_link_data['new_transmission_capacity'] = request("new_transmission_capacity_{$i}");
            $plan_link_data['link_remarks'] = request("link_remarks_{$i}");
            $plan_link_data['planning_id'] = $plan->id;
            $plan_link = PlanLink::create($plan_link_data);
            $survey = Survey::where('fr_no', $request->fr_no)->where('client_no', $request->client_no)->first();
            $survey_details = SurveyDetail::where('survey_id', $survey->id)->where('link_type', request("link_type_{$i}"))->where('option', request("option_{$i}"))->first();
            $final_survey_data['link_no'] = $survey_details->link_no;
            $final_survey_data['vendor_id'] = request("link_vender_id_{$i}");
            $final_survey_data['link_type'] = request("link_type_{$i}");
            $final_survey_data['method'] = request("last_mile_connectivity_method_{$i}");
            $final_survey_data['option'] = request("option_{$i}");
            $final_survey_data['status'] = request("status_{$i}");
            $final_survey_data['pop_id'] = request("link_connecting_pop_id_{$i}");
            $final_survey_data['lat'] = request("connectivity_lat_{$i}");
            $final_survey_data['long'] = request("connectivity_long_{$i}");
            $final_survey_data['distance'] = $survey_details->distance;
            $final_survey_data['current_capacity'] = $survey_details->current_capacity;
            $final_survey_data['survey_id'] = $survey_details->id;
            $final_survey_data['planning_id'] = $plan->id;
            $final_survey_data['plan_link_id'] = $plan_link->id;
            $final_survey = FinalSurveyDetail::create($final_survey_data);
            $materials = request("material_id_$i");
            foreach ($materials as $key => $material_id) {
                $plan_link_equipment['material_id'] = $material_id;
                $plan_link_equipment['brand_id'] = request("brand_id_$i")[$key];
                $plan_link_equipment['quantity'] = request("quantity_$i")[$key];
                $plan_link_equipment['model'] = request("model_$i")[$key];
                $plan_link_equipment['description'] = request("description_$i")[$key];
                $plan_link_equipment['unit'] = request("unit_$i")[$key];
                $plan_link_equipment['remarks'] = request("remarks_$i")[$key];
                $plan_link_equipment['final_survey_id'] = $final_survey->id;
                $plan_link_equipment['planning_id'] = $plan->id;
                $plan_link_equipment['plan_link_id'] = $plan_link->id;
                PlanLinkEquipment::create($plan_link_equipment);
            }
        }
    }
}
