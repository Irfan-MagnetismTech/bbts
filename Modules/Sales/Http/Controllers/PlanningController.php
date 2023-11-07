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
use Modules\Admin\Entities\Pop;
use Modules\Sales\Entities\Vendor;
use Modules\SCM\Entities\Material;

class PlanningController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    function __construct()
    {
        $this->middleware('permission:plan-view|plan-create|plan-edit|plan-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:plan-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:plan-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:plan-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $plans = Planning::with('planLinks', 'feasibilityRequirementDetail.feasibilityRequirement')->latest()->get();
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
        $pops = Pop::get();
        $methods = ['Fiber' => 'Fiber','Radio' => 'Radio','GSM' => 'GSM'];
        return view('sales::planning.create', compact('methods','feasibilityRequirementDetail', 'lead_generation', 'connectivityProductRequirementDetails', 'particulars', 'materials', 'brands', 'vendors', 'pops'));
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
        $plan_data = $request->only('mq_no', 'fr_no', 'client_no', 'remarks');
        $plan_data['date'] = date('Y-m-d');
        $plan_data['user_id'] = auth()->user()->id ?? '';
        DB::beginTransaction();

        $plan = Planning::create($plan_data);

        $this->createOrUpdateServicePlans($request, $plan);

        $this->createOrUpdateEquipmentPlans($request, $plan);

        if ($request->total_key > 0) {
            $this->createOrUpdatePlanLinks($request, $plan);
        }

        DB::commit();

        return redirect()->route('feasibility-requirement.show', $feasibility_requirement_detail->feasibilityRequirement->id)->with('success', 'Connectivity Requirement Created Successfully');
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
        $pops = Pop::get();
        $vendors = Vendor::get();
        return view('sales::planning.edit', compact('plan', 'particulars', 'materials', 'brands', 'pops', 'vendors'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $plan_data = $request->only('mq_no', 'fr_no', 'client_no', 'remarks');
        $plan_data['date'] = date('Y-m-d');
        $plan_data['user_id'] = auth()->user()->id ?? '';
        DB::beginTransaction();
        try {
            $update_plan = Planning::where('id', $id)->update($plan_data);
            $plan = Planning::find($id);
            $this->deleteRequestedItems($request->delete_plan_link_id, $request->delete_equipment_plan_id, $request->delete_link_equipment_id);
            $this->createOrUpdateServicePlans($request, $plan);
            $this->createOrUpdateEquipmentPlans($request, $plan);
            if ($request->total_key > 0) {
                $this->createOrUpdatePlanLinks($request, $plan);
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
            if ($planning->costing) {
                return redirect()->route('planning.index')->with('error', 'Planning has costing, cannot be deleted');
            }
            $planning->delete();
            return redirect()->route('planning.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            return redirect()->route('planning.index')->withErrors($e->getMessage());
        }
    }

    private function createOrUpdateServicePlans($request, $plan)
    {
        foreach ($request->detail_id as $key => $detail_id) {
            $service_plan_data = [
                'connectivity_product_requirement_details_id' => $request->detail_id[$key],
                'plan' => $request->plan[$key],
                'planning_id' => $plan->id
            ];
            if (isset($request->service_plan_id[$key])) {
                ServicePlan::where('id', $request->service_plan_id[$key])->update($service_plan_data);
            } else {
                ServicePlan::create($service_plan_data);
            }
        }
    }

    private function createOrUpdateEquipmentPlans($request, $plan)
    {
        if (!empty($request->equipment_id)) {
            foreach ($request->equipment_id as $key => $equipment_id) {
                $equipment_plan_data = [
                    'material_id' => $request->equipment_id[$key],
                    'brand_id' => $request->brand_id[$key],
                    'quantity' => $request->quantity[$key],
                    'model' => $request->model[$key],
                    'unit' => $request->unit[$key],
                    'remarks' => $request->equipment_remarks[$key],
                    'planning_id' => $plan->id
                ];
                if (isset($request->equipment_plan_id[$key])) {
                    EquipmentPlan::where('id', $request->equipment_plan_id[$key])->update($equipment_plan_data);
                } else {
                    EquipmentPlan::create($equipment_plan_data);
                }
            }
        }
    }


    private function createOrUpdatePlanLinks($request, $plan)
    {

        for ($i = 1; $i <= $request->total_key; $i++) {
            $linkType = request("link_type_{$i}");
            $survey = Survey::where('fr_no', $request->fr_no)
                ->where('client_no', $request->client_no)
                ->first();

            $surveyDetails = SurveyDetail::where('survey_id', $survey->id)
                ->where('link_type', $linkType)
                ->where('option', request("option_{$i}"))
                ->first();

            $finalSurveyId = request("final_survey_id_{$i}");
            $finalSurvey = FinalSurveyDetail::find($finalSurveyId);
            if ($linkType !== null) {
                $planLinkData = [
                    'link_type' => $linkType,
                    'link_no' => $surveyDetails ? $surveyDetails->link_no : $finalSurvey->link_no ?? $request->fr_no . '-' . substr($linkType, 0, 1) . $i,
                    'existing_infrastructure' => request("existing_infrastructure_{$i}"),
                    'existing_infrastructure_link' => request("existing_infrastructure_link_{$i}"),
                    'option' => request("option_{$i}"),
                    'existing_transmission_capacity' => request("existing_transmission_capacity_{$i}"),
                    'increase_capacity' => request("increase_capacity_{$i}"),
                    'link_availability_status' => request("link_availability_status_{$i}"),
                    'new_transmission_capacity' => request("new_transmission_capacity_{$i}"),
                    'link_remarks' => request("link_remarks_{$i}"),
                    'planning_id' => $plan->id,
                ];
                $planLinkId = request("plan_link_id_{$i}");
                $planLink = $planLinkId ? PlanLink::find($planLinkId) : new PlanLink();

                $planLink->fill($planLinkData);
                $planLink->save();
                $finalSurveyData = [
                    'link_no' => $surveyDetails ? $surveyDetails->link_no : $finalSurvey->link_no ?? $request->fr_no . '-' . substr($linkType, 0, 1) . $i,
                    'vendor_id' => request("link_vendor_id_{$i}") ?? '',
                    'link_type' => $linkType,
                    'method' => request("last_mile_connectivity_method_{$i}"),
                    'option' => request("option_{$i}"),
                    'status' => request("status_{$i}"),
                    'pop_id' => request("link_connecting_pop_id_{$i}"),
                    'lat' => request("connectivity_lat_{$i}"),
                    'long' => request("connectivity_long_{$i}"),
                    'distance' => $surveyDetails->distance ?? '',
                    'current_capacity' => $surveyDetails->current_capacity ?? '',
                    'survey_detail_id' => $surveyDetails->id ?? null,
                    'planning_id' => $plan->id,
                    'plan_link_id' => $planLink->id,
                ];

                $finalSurvey = $finalSurveyId ? FinalSurveyDetail::find($finalSurveyId) : new FinalSurveyDetail();
                $finalSurvey->fill($finalSurveyData);
                $finalSurvey->save();

                $materials = request("material_id_{$i}");
                $planLinkEquipmentIds = request("plan_link_equipment_id_{$i}");

                if ($materials) {
                    foreach ($materials as $key => $materialId) {
                        $planLinkEquipment = [
                            'material_id' => $materialId,
                            'brand_id' => request("brand_id_{$i}")[$key],
                            'quantity' => request("quantity_{$i}")[$key],
                            'model' => request("model_{$i}")[$key],
                            'description' => request("description_{$i}")[$key],
                            'unit' => request("unit_{$i}")[$key],
                            'remarks' => request("remarks_{$i}")[$key],
                            'final_survey_id' => $finalSurvey->id,
                            'planning_id' => $plan->id,
                            'plan_link_id' => $planLink->id,
                        ];

                        if ($planLinkEquipmentIds && isset($planLinkEquipmentIds[$key])) {
                            PlanLinkEquipment::where('id', $planLinkEquipmentIds[$key])->update($planLinkEquipment);
                        } else {
                            PlanLinkEquipment::create($planLinkEquipment);
                        }
                    }
                }
            }
        }
    }


    private function deleteRequestedItems($delete_plan_link_id, $delete_equipment_plan_id, $delete_link_equipment_id)
    {
        $delete_plan_link_id = json_decode($delete_plan_link_id);
        if ($delete_plan_link_id) {
            foreach ($delete_plan_link_id as $key => $plan_link_id) {
                PlanLink::where('id', $plan_link_id)->delete();
            }
        }

        $delete_equipment_plan_id = json_decode($delete_equipment_plan_id);
        if ($delete_equipment_plan_id) {
            foreach ($delete_equipment_plan_id as $key => $equipment_plan_id) {
                EquipmentPlan::where('id', $equipment_plan_id)->delete();
            }
        }
        $link_equipment_id_array = json_decode($delete_link_equipment_id);
        if (!empty($link_equipment_id_array)) {
            foreach ($link_equipment_id_array as $key => $equipment_array) {
                PlanLinkEquipment::where('id', $equipment_array->link_equipment_id)->where('plan_link_id', $equipment_array->plan_link_id)->delete();
            }
        }
    }

    public function modifiedList()
    {
        $plans = Planning::with('planLinks', 'feasibilityRequirementDetail.feasibilityRequirement')
            ->where('is_modified',1)
            ->latest()
            ->get();
        return view('sales::planning.modification_list', compact('plans'));
    }
}
