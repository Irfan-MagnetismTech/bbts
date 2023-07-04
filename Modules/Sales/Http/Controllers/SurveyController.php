<?php

namespace Modules\Sales\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Sales\Entities\FeasibilityRequirementDetail;
use Modules\Sales\Entities\FeasibilityRequirement;
use Modules\Sales\Entities\Survey;
use Modules\Sales\Entities\SurveyDetail;
use Modules\Sales\Http\Requests\SurveyRequest;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\Pop;
use Modules\Sales\Entities\LeadGeneration;
use Modules\Sales\Entities\ConnectivityRequirement;
use Modules\Sales\Entities\FinalSurveyDetail;
use Modules\Sales\Entities\Vendor;
use Modules\Sales\Services\CommonService;


class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $surveys = Survey::with('surveyDetails', 'lead_generation')->get();
        return view('sales::survey.index', compact('surveys'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($fr_id)
    {
        $fr_detail = FeasibilityRequirementDetail::with('feasibilityRequirement.lead_generation')->find($fr_id);
        $all_fr_list = FeasibilityRequirementDetail::get();
        $connectivity_requirement = ConnectivityRequirement::with('connectivityRequirementDetails.vendor', 'connectivityProductRequirementDetails', 'lead_generation', 'fromLocation')->where('fr_no', $fr_detail->fr_no)->first();
        $pops = Pop::get();
        $vendors = Vendor::get();
        return view('sales::survey.create', compact('fr_detail', 'all_fr_list', 'connectivity_requirement', 'pops', 'vendors'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $connectivity_requirement_data = $request->only('date', 'client_no', 'fr_no', 'survey_remarks');
        $connectivity_requirement_data['user_id'] = auth()->user()->id ?? '';
        $connectivity_requirement_data['branch_id'] = auth()->user()->branch_id ?? '';
        $connectivity_requirement_data['date'] = date('Y-m-d', strtotime($request->date));
        $connectivity_requirement_data['mq_no'] = FeasibilityRequirement::where('client_no', $connectivity_requirement_data['client_no'])->first()->mq_no;
        $connectivity_requirement_data['lead_generation_id'] = LeadGeneration::where('client_no', $connectivity_requirement_data['client_no'])->first()->id;
        $connectivity_requirement_data['feasibility_requirement_details_id'] = FeasibilityRequirementDetail::where('fr_no', $connectivity_requirement_data['fr_no'])->first()->id;
        if ($request->hasFile('document')) {
            $file_name = CommonService::fileUpload($request->file('survey_document'), 'uploads/survey');
            $data['document'] = $file_name;
        }
        DB::beginTransaction();
        try {
            $connectivity_requirement = Survey::create($connectivity_requirement_data);
            foreach ($request->link_type as $key => $value) {
                $connectivity_requirement_details['survey_id'] = $connectivity_requirement->id;
                $connectivity_requirement_details['link_type'] = $value;
                $connectivity_requirement_details['link_no'] = $connectivity_requirement_data['fr_no'] . '-' . substr($value, 0, 1) . $key + 1;
                $connectivity_requirement_details['option'] = $request->option[$key];
                $connectivity_requirement_details['status'] = $request->status[$key];
                $connectivity_requirement_details['method'] = $request->method[$key];
                $connectivity_requirement_details['vendor_id'] = $request->vendor[$key];
                $connectivity_requirement_details['pop_id'] = $request->pop[$key];
                $connectivity_requirement_details['ldp'] = $request->ldp[$key];
                $connectivity_requirement_details['lat'] = $request->lat[$key];
                $connectivity_requirement_details['long'] = $request->long[$key];
                $connectivity_requirement_details['distance'] = $request->distance[$key];
                $connectivity_requirement_details['current_capacity'] = $request->current_capacity[$key];
                $connectivity_requirement_details['remarks'] = $request->remarks[$key];
                SurveyDetail::create($connectivity_requirement_details);
            }
            DB::commit();
            return redirect()->route('survey.index')->with('success', 'Survey Created Successfully');
        } catch (QueryException $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }


    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $survey = Survey::with('surveyDetails', 'lead_generation')->find($id);
        $connectivity_requirement = ConnectivityRequirement::with('connectivityRequirementDetails.vendor', 'connectivityProductRequirementDetails', 'lead_generation', 'fromLocation')->where('fr_no', $survey->fr_no)->first();
        return view('sales::survey.show', compact('survey', 'connectivity_requirement'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $survey = Survey::with('surveyDetails', 'lead_generation', 'feasibilityRequirementDetails')->find($id);
        $connectivity_requirement = ConnectivityRequirement::with('connectivityRequirementDetails.vendor', 'connectivityProductRequirementDetails', 'lead_generation', 'fromLocation')->where('fr_no', $survey->fr_no)->first();
        $pops = Pop::get();
        $vendors = Vendor::get();
        return view('sales::survey.create', compact('survey', 'connectivity_requirement', 'pops', 'vendors'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Survey $survey)
    {
        $survey_data = $request->only('date', 'client_no', 'fr_no', 'survey_remarks');
        $survey_data['user_id'] = auth()->user()->id ?? '';
        $survey_data['branch_id'] = auth()->user()->branch_id ?? '';
        $survey_data['date'] = date('Y-m-d', strtotime($request->date));
        $survey_data['mq_no'] = FeasibilityRequirement::where('client_no', $survey_data['client_no'])->first()->mq_no;
        $survey_data['lead_generation_id'] = LeadGeneration::where('client_no', $survey_data['client_no'])->first()->id;
        $survey_data['feasibility_requirement_details_id'] = FeasibilityRequirementDetail::where('fr_no', $survey_data['fr_no'])->first()->id;
        if ($request->hasFile('document')) {
            $remove_old_file = CommonService::deleteFile('uploads/survey/' . $survey->document);
            $file_name = CommonService::UpdatefileUpload($request->file('survey_document'), 'uploads/survey', $survey->document);
            $data['document'] = $file_name;
        }
        DB::beginTransaction();
        try {
            $survey->update($survey_data);
            $survey->surveyDetails()->delete();
            $survey->finalSurveyDetails()->delete();
            foreach ($request->link_type as $key => $value) {
                $survey_details['survey_id'] = $survey->id;
                $survey_details['link_type'] = $value;
                $survey_details['link_no'] = $survey_data['fr_no'] . '-' . substr($value, 0, 1) . $key + 1;
                $survey_details['option'] = $request->option[$key];
                $survey_details['status'] = $request->status[$key];
                $survey_details['method'] = $request->method[$key];
                $survey_details['vendor_id'] = $request->vendor[$key];
                $survey_details['pop_id'] = $request->pop[$key];
                $survey_details['ldp'] = $request->ldp[$key];
                $survey_details['lat'] = $request->lat[$key];
                $survey_details['long'] = $request->long[$key];
                $survey_details['distance'] = $request->distance[$key];
                $survey_details['current_capacity'] = $request->current_capacity[$key];
                $survey_details['remarks'] = $request->remarks[$key];
                SurveyDetail::create($survey_details);
            }
            DB::commit();
            return redirect()->route('survey.index')->with('success', 'Survey Updated Successfully');
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
    public function destroy(Survey $survey)
    {
        $survey->surveyDetails()->delete();
        $survey->delete();
        return redirect()->route('survey.index')->with('success', 'Survey Deleted Successfully');
    }

    public function getSurveyDetails(Request $request)
    {
        $survey = Survey::where('client_no', $request->client_id)->where('fr_no', $request->fr_no)->first();
        if ($survey) {
            $surveyDetails = SurveyDetail::with('vendor', 'pop')->where('survey_id', $survey->id)->where('link_type', $request->link_type)->where('option', $request->option)->first();
            return response()->json($surveyDetails);
        }
        return response()->json(['message' => 'No Survey Found']);
    }
}
