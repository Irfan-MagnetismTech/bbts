<?php

namespace Modules\Changes\Http\Controllers;

use Doctrine\DBAL\Query\QueryException;
use Modules\Changes\Services\PlanningDataSet;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\Brand;
use Modules\Networking\Entities\PhysicalConnectivityLines;
use Modules\Sales\Entities\ConnectivityRequirement;
use Modules\Sales\Entities\EquipmentPlan;
use Modules\Sales\Entities\FeasibilityRequirement;
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
use Modules\SCM\Entities\ScmMrr;
use Modules\SCM\Entities\ScmMur;

class ClientPlanningModificationController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $plans = Planning::with('planLinks', 'feasibilityRequirementDetail.feasibilityRequirement')->where('is_modified', 1)->latest()->get();
        return view('changes::modify_planning.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */

    public function create($connectivity_requirement_id = null)
    {
        try {
            // dd('jj');
            // Retrieve the connectivity requirement with its related data
            $connectivity_requirement = ConnectivityRequirement::with([
                'connectivityRequirementDetails',
                'connectivityProductRequirementDetails',
                'lead_generation.division',
                'lead_generation.district',
                'lead_generation.thana',
            ])->where('id', $connectivity_requirement_id)
                ->where('is_modified', 1)
                ->latest()
                ->firstOrFail();

            $data = PlanningDataSet::setData($old = null, $connectivity_requirement, $plan = null);
            $previous_products = ScmMur::with('lines')->where('client_no', $connectivity_requirement->client_no)->where('fr_no', $connectivity_requirement->fr_no)->where('link_no', '=', null)->first();
            $existingConnections = PhysicalConnectivityLines::query()
                ->whereHas('physicalConnectivity', function ($qr) use ($connectivity_requirement) {
                    return $qr->where('fr_no', $connectivity_requirement->fr_no)->where('is_modified', 0);
                })->get();
            $data['existingConnections'] = $existingConnections;
            $data['previous_products'] = $previous_products;
            return view('changes::modify_planning.create', $data);
        } catch (\Exception $e) {
            // dd($e);
            return redirect()->back()->with('error', 'Error fetching data.');
        }
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $plan_data = $request->only('fr_no', 'client_no', 'connectivity_requirement_id', 'remarks');
        $plan_data['date'] = date('Y-m-d');
        $plan_data['user_id'] = auth()->user()->id ?? '';
        $plan_data['is_modified'] = 1;

        try {
            DB::beginTransaction();

            $plan = Planning::create($plan_data);

            $this->createOrUpdateServicePlans($request, $plan);

            $this->createOrUpdateEquipmentPlans($request, $plan);

            if ($request->total_key > 0) {
                $this->createOrUpdatePlanLinks($request, $plan);
            }

            DB::commit();
            return redirect()->route('client-plan-modification.index')->with('success', 'Planning created successfully');
        } catch (\Exception $e) {

            $old = $request->input();
            $data = PlanningDataSet::setData($old, $connectivity_requirement = null, $plan = null);
            DB::rollback();
            return view('changes::modify_planning.create', $data)->with('error', 'Error saving data.');
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
        $plan = Planning::with('lead_generation', 'planLinks', 'equipmentPlans', 'servicePlans.connectivityProductRequirementDetails.product', 'servicePlans.product', 'ConnectivityRequirement')->where('id', $id)->first();
        $data = PlanningDataSet::setData($old = null, $connectivity_requirement = null, $plan);
        $previous_products = ScmMur::with('lines')->where('client_no', $plan->client_no)->where('fr_no', $plan->fr_no)->where('link_no', '=', null)->first();
        $existingConnections = PhysicalConnectivityLines::query()
            ->whereHas('physicalConnectivity', function ($qr) use ($plan) {
                return $qr->where('fr_no', $plan->fr_no)->where('is_modified', 0);
            })->get();
        $data['existingConnections'] = $existingConnections;
        $data['previous_products'] = $previous_products;
        return view('changes::modify_planning.create', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $plan_data = $request->only('fr_no', 'client_no', 'connectivity_requirement_id', 'remarks');
        $plan_data['date'] = date('Y-m-d');
        $plan_data['user_id'] = auth()->user()->id ?? '';
        $plan_data['is_modified'] = 1;
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
            return redirect()->route('client-plan-modification.index')->with('success', 'Planning updated successfully');
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
    public function destroy($id)
    {
        try {
            Planning::findOrFail($id)->delete();
            return redirect()->back()->with('success', 'Planning deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting data.');
        }
    }


    public function getModifySurveyDetails(Request $request)
    {
        $survey = Survey::where('client_no', $request->client_id)->where('fr_no', $request->fr_no)->where('is_modified', 1)->where('connectivity_requirement_id', $request->connectivity_requirement_id)->first();
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
                    'vendor_id' => request("link_vender_id_{$i}") ?? '',
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
}
