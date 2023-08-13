<?php

namespace Modules\Changes\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\Brand;
use Modules\Sales\Entities\ConnectivityRequirement;
use Modules\Sales\Entities\EquipmentPlan;
use Modules\Sales\Entities\FinalSurveyDetail;
use Modules\Sales\Entities\LeadGeneration;
use Modules\Sales\Entities\PlanLink;
use Modules\Sales\Entities\PlanLinkEquipment;
use Modules\Sales\Entities\Planning;
use Modules\Sales\Entities\Vendor;
use Modules\SCM\Entities\Material;
use Modules\Sales\Entities\Product;
use Modules\Sales\Entities\ServicePlan;
use Modules\Sales\Entities\Survey;
use Modules\Sales\Entities\SurveyDetail;


class ClientPlanningModificationController extends Controller
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
        $connectivity_requirement = ConnectivityRequirement::with('connectivityRequirementDetails', 'connectivityProductRequirementDetails')->where('fr_no', $fr_no)->where('is_modified', 1)->latest()->first();
        $lead_generation = LeadGeneration::where('client_no', $connectivity_requirement->client_no)->first();
        $particulars = Product::get();
        $materials = Material::get();
        $brands = Brand::get();
        $vendors = Vendor::get();
        return view('changes::modify_planning.create', compact('connectivity_requirement', 'lead_generation', 'particulars', 'materials', 'brands', 'vendors'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $plan_data = $request->only('fr_no', 'client_no');
        $plan_data['date'] = date('Y-m-d');
        $plan_data['user_id'] = auth()->user()->id ?? '';
        $plan_data['is_modified'] = 1;
        DB::beginTransaction();

        $plan = Planning::create($plan_data);

        $this->createOrUpdateServicePlans($request, $plan);

        $this->createOrUpdateEquipmentPlans($request, $plan);

        if ($request->total_key > 0) {
            $this->createOrUpdatePlanLinks($request, $plan);
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

    public function getModifySurveyDetails(Request $request)
    {
        $survey = Survey::where('client_no', $request->client_id)->where('fr_no', $request->fr_no)->where('is_modified', 1)->latest()->first();
        if ($survey) {
            $surveyDetails = SurveyDetail::with('vendor', 'pop')->where('survey_id', $survey->id)->where('link_type', $request->link_type)->where('option', $request->option)->first();
            return response()->json($surveyDetails);
        }
        return response()->json(['message' => 'No Survey Found']);
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
            if ($linkType !== null) {
                $planLinkData = [
                    'link_type' => $linkType,
                    'link_no' => request("link_no_{$i}"),
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

                $survey = Survey::where('fr_no', $request->fr_no)
                    ->where('client_no', $request->client_no)
                    ->first();

                $surveyDetails = SurveyDetail::where('survey_id', $survey->id)
                    ->where('link_type', $linkType)
                    ->where('option', request("option_{$i}"))
                    ->first();

                $finalSurveyData = [
                    'link_no' => $surveyDetails->link_no ?? '',
                    'vendor_id' => request("link_vender_id_{$i}"),
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

                $finalSurveyId = request("final_survey_id_{$i}");
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
}
