<?php

namespace Modules\Changes\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Admin\Entities\Pop;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Sales\Entities\Survey;
use Modules\Sales\Entities\Vendor;
use Modules\Sales\Entities\SurveyDetail;
use Modules\Sales\Services\CommonService;
use Modules\Sales\Entities\LeadGeneration;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\QueryException;
use Modules\Sales\Entities\FeasibilityRequirement;
use Modules\Sales\Entities\ConnectivityRequirement;
use Modules\Sales\Entities\FeasibilityRequirementDetail;
use Modules\Networking\Entities\PhysicalConnectivityLines;
// use Modules\Changes\Entities\Survey;

class ModifiedSurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $surveys = Survey::with('surveyDetails', 'lead_generation')->where('is_modified', '=', 1)->latest()->get();
        return view('changes::modified_servey.index', compact('surveys'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($id)
    {
        // $survey = Survey::with('surveyDetails')->where('id',51)->first();
        // dd($survey);
        $pops = Pop::get();
        $vendors = Vendor::get();
        $connectivity_requirement = ConnectivityRequirement::with('connectivityRequirementDetails.vendor', 'connectivityProductRequirementDetails', 'client', 'FeasibilityRequirementDetail.feasibilityRequirement')->where('id', $id)->first();
        // dd($connectivity_requirement);
        $current_qty = $connectivity_requirement->connectivityProductRequirementDetails;
        $previous_qty = ConnectivityRequirement::with('connectivityRequirementDetails.vendor', 'connectivityProductRequirementDetails', 'client', 'FeasibilityRequirementDetail.feasibilityRequirement')->where('fr_no', $connectivity_requirement->fr_no)->latest()->first()->connectivityProductRequirementDetails;
        $grouped_qty = $previous_qty->merge($current_qty)->groupBy('product_id');
        $grouped_current_qty = $current_qty->groupBy('product_id');
        $grouped_previous_qty = $previous_qty->groupBy('product_id');
        $existingConnections = PhysicalConnectivityLines::query()
            ->whereHas('physicalConnectivity', function ($qr) use ($connectivity_requirement) {
                return $qr->where('fr_no', $connectivity_requirement->fr_no);
            })->get();
        return view('changes::modified_servey.create', compact('pops', 'vendors', 'connectivity_requirement', 'grouped_qty', 'grouped_previous_qty', 'grouped_current_qty', 'existingConnections'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $connectivity_requirement_data = $request->only('date', 'client_no', 'fr_no', 'survey_remarks', 'fr_no', 'mq_no', 'feasibility_requirement_details_id', 'connectivity_requirement_id', 'client_no');
        $connectivity_requirement_data['user_id'] = auth()->user()->id ?? '';
        $connectivity_requirement_data['is_modified'] = 1;
        $connectivity_requirement_data['date'] = date('Y-m-d', strtotime($request->date));
        if ($request->hasFile('survey_attached')) {
            // $file_name = CommonService::fileUpload($request->file('survey_attached'), 'uploads/survey');
            // $data['survey_attached'] = $file_name;
        }
        if ($request->hasFile('requirement')) {
            // $file_name = CommonService::fileUpload($request->file('requirement'), 'uploads/survey');
            // $data['requirement'] = $file_name;
        }
        DB::beginTransaction();
        try {
            $connectivity_requirement = Survey::create($connectivity_requirement_data);
            if ($request->has('new_link_type')) {
                foreach ($request->new_link_type as $key => $value) {
                    $connectivity_requirement_details['survey_id'] = $connectivity_requirement->id;
                    $connectivity_requirement_details['link_type'] = $value;
                    $connectivity_requirement_details['link_no'] = $connectivity_requirement_data['fr_no'] . '-' . substr($value, 0, 1) . $key + 1;
                    $connectivity_requirement_details['option'] = $request->new_option[$key];
                    $connectivity_requirement_details['status'] = $request->status[$key];
                    // dd($request->method[$key]);
                    $connectivity_requirement_details['method'] = $request->method[$key];
                    $connectivity_requirement_details['vendor_id'] = $request->vendor[$key];
                    $connectivity_requirement_details['pop_id'] = $request->pop[$key];
                    $connectivity_requirement_details['ldp'] = $request->ldp[$key];
                    $connectivity_requirement_details['lat'] = $request->new_lat[$key];
                    $connectivity_requirement_details['long'] = $request->new_long[$key];
                    $connectivity_requirement_details['distance'] = $request->new_distance[$key];
                    $connectivity_requirement_details['current_capacity'] = $request->new_current_capacity[$key];
                    $connectivity_requirement_details['remarks'] = $request->new_remarks[$key];
                    SurveyDetail::create($connectivity_requirement_details);
                }
                DB::commit();
            }
            return redirect()->route('survey-modification.index')->with('success', 'Survey Modification Created Successfully');
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
        return view('changes::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $survey = Survey::with('surveyDetails')->where('id', $id)->first();
        // dd($survey);
        $pops = Pop::get();
        $vendors = Vendor::get();
        $connectivity_requirement = ConnectivityRequirement::with('connectivityRequirementDetails.vendor', 'connectivityProductRequirementDetails', 'client', 'FeasibilityRequirementDetail.feasibilityRequirement')->where('id', $survey->connectivity_requirement_id)->first();
        // dd($connectivity_requirement);
        $current_qty = $connectivity_requirement->connectivityProductRequirementDetails;
        $previous_qty = ConnectivityRequirement::with('connectivityRequirementDetails.vendor', 'connectivityProductRequirementDetails', 'client', 'FeasibilityRequirementDetail.feasibilityRequirement')->where('fr_no', $connectivity_requirement->fr_no)->latest()->first()->connectivityProductRequirementDetails;
        $grouped_qty = $previous_qty->merge($current_qty)->groupBy('product_id');
        $grouped_current_qty = $current_qty->groupBy('product_id');
        $grouped_previous_qty = $previous_qty->groupBy('product_id');
        $existingConnections = PhysicalConnectivityLines::query()
            ->whereHas('physicalConnectivity', function ($qr) use ($connectivity_requirement) {
                return $qr->where('fr_no', $connectivity_requirement->fr_no);
            })->get();
        return view('changes::modified_servey.create', compact('survey', 'pops', 'vendors', 'connectivity_requirement', 'grouped_qty', 'grouped_previous_qty', 'grouped_current_qty', 'existingConnections'));
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
        $details = [];
        $survey = Survey::findOrFail($id);
        foreach ($request->link_type as $key => $value) {
            $details[] = [
                'survey_id' => $survey->id,
                'link_type' => $value,
                'link_no' => $survey['fr_no'] . '-' . substr($value, 0, 1) . $key + 1,
                'option' => $request->option[$key],
                'status' => $request->status[$key],
                'method' => $request->method[$key],
                'vendor_id' => $request->vendor[$key],
                'pop_id' => $request->pop[$key],
                'ldp' => $request->ldp[$key],
                'lat' => $request->lat[$key],
                'long' => $request->long[$key],
                'distance' => $request->distance[$key],
                'current_capacity' => $request->capacity[$key],
                'remarks' => $request->new_remarks[$key]
            ];
        }
        $survey->surveyDetails()->delete();
        $survey->surveyDetails()->createMany($details);


        return redirect()->route('survey-modification.index')->with('success', 'Survey Modification Updaated Successfully');
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


    public function getOptionForSurvey($fr_no)
    {
        $datas = Survey::where('fr_no', $fr_no)->get();
        return response()->json($datas);
    }
}
