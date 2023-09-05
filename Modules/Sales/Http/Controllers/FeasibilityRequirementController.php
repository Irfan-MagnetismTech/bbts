<?php

namespace Modules\Sales\Http\Controllers;

use App\Models\Dataencoding\District;
use App\Models\Dataencoding\Thana;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Dataencoding\Division;
use Illuminate\Support\Facades\DB;
use Modules\Sales\Entities\FeasibilityRequirement;
use Modules\Sales\Entities\FeasibilityRequirementDetail;
use Modules\Sales\Http\Requests\FeasibilityRequirementRequest;
use App\Exports\FeasibilityRequirementExport;
use App\Imports\FeasibilityRequirementImport;
use App\Imports\FeasibilityRequirementImportUpdate;
use Maatwebsite\Excel\Facades\Excel;

class FeasibilityRequirementController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $feasibility_requirements = FeasibilityRequirement::with('lead_generation', 'feasibilityRequirementDetails.surveySum')->latest()->get();
        return view('sales::feasibility_requirement.index', compact('feasibility_requirements'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $divisions = Division::all();
        return view('sales::feasibility_requirement.create', compact('divisions'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */


    public function store(FeasibilityRequirementRequest $request)
    {
        // dd($request->all());
        if ($request->file) {
            $additionalData = $request;
            Excel::import(new FeasibilityRequirementImport($additionalData), $request->file('file'));
        } else {
            try {
                DB::beginTransaction();
                $data = $request->only('client_no', 'is_existing', 'date', 'lead_generation_id');
                $data['user_id'] = auth()->user()->id;
                $data['branch_id'] = auth()->user()->branch_id ?? '1';

                $maxMqNo = FeasibilityRequirement::where('client_no', $data['client_no'])->max('mq_no');
                $data['mq_no'] = 'MQ' . '-' . $data['client_no'] . '-' . ($maxMqNo ? (explode('-', $maxMqNo)[3] + 1) : '1');

                $feasibilityRequirement = FeasibilityRequirement::create($data);

                $feasibilityDetails = [];
                $maxFrNo = FeasibilityRequirementDetail::where('client_no', $data['client_no'])->max('fr_no');
                if ($maxFrNo) {
                    $frArray = explode('-', $maxFrNo);
                    $fr_serial = intval($frArray[count($frArray) - 1]) + 1;
                } else {
                    $fr_serial = 1;
                }

                foreach ($request['connectivity_point'] as $key => $connectivityPoint) {
                    $frNo = 'fr' . '-' . $data['client_no'] . '-' . $fr_serial;
                    $fr_serial++;
                    $feasibilityDetails[] = [
                        'connectivity_point' => $connectivityPoint,
                        'aggregation_type' => $request['aggregation_type'][$key],
                        'client_no' => $data['client_no'],
                        'fr_no' => $frNo,
                        'division_id' => $request['division_id'][$key],
                        'district_id' => $request['district_id'][$key],
                        'thana_id' => $request['thana_id'][$key],
                        'location' => $request['location'][$key],
                        'lat' => $request['lat'][$key],
                        'long' => $request['long'][$key],
                        'contact_name' => $request['contact_name'][$key],
                        'contact_designation' => $request['contact_designation'][$key],
                        'contact_number' => $request['contact_number'][$key],
                        'contact_email' => $request['contact_email'][$key],
                    ];
                }

                $feasibilityRequirement->feasibilityRequirementDetails()->createMany($feasibilityDetails);
                DB::commit();


                return redirect()->route('feasibility-requirement.create')->with('success', 'Feasibility Requirement Created Successfully');
            } catch (\Exception $e) {
                DB::rollback();
                // Handle the exception or display an error message
                return back()->with('error', $e->getMessage());
            }
        }
        return redirect()->route('feasibility-requirement.create')->with('success', 'Feasibility Requirement Created Successfully');
    }


    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $feasibility_requirement = FeasibilityRequirement::with('feasibilityRequirementDetails.connectivityRequirement', 'feasibilityRequirementDetails.survey')->find($id);
        return view('sales::feasibility_requirement.show', compact('feasibility_requirement'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $feasibility_requirement = FeasibilityRequirement::with('feasibilityRequirementDetails',)->find($id);
        $divisions = Division::all();
        $districts = District::whereIn('division_id', $feasibility_requirement->feasibilityRequirementDetails->pluck('division_id'))->get();
        $thanas = Thana::whereIn('district_id', $feasibility_requirement->feasibilityRequirementDetails->pluck('district_id'))->get();
        return view('sales::feasibility_requirement.create', compact('feasibility_requirement', 'divisions', 'districts', 'thanas'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(FeasibilityRequirement $feasibility_requirement, FeasibilityRequirementRequest $request)
    {
        //  dd($request->all());
        $data = $request->only('client_no', 'is_existing', 'date');
        $data['user_id'] = auth()->user()->id;
        $data['branch_id'] = auth()->user()->branch_id ?? '1';

        $feasibility_requirement->update($data);

        foreach ($request->connectivity_point as $key => $link) {
            $detailId = $request['detail_id'][$key] ?? null;
            $frNo = 'fr' . '-' . $data['client_no'] . '-';
            $detailsData = [
                'connectivity_point' => $request['connectivity_point'][$key],
                'client_no' => $data['client_no'],
                'aggregation_type' => $request['aggregation_type'][$key],
                'division_id' => $request['division_id'][$key],
                'district_id' => $request['district_id'][$key],
                'thana_id' => $request['thana_id'][$key],
                'location' => $request['location'][$key],
                'lat' => $request['lat'][$key],
                'long' => $request['long'][$key],
                'contact_name' => $request['contact_name'][$key],
                'contact_designation' => $request['contact_designation'][$key],
                'contact_number' => $request['contact_number'][$key],
                'contact_email' => $request['contact_email'][$key],
            ];

            if ($detailId) {
                $feasibility = FeasibilityRequirementDetail::find($detailId);
                if ($feasibility) {
                    $feasibility->update($detailsData);
                }
            } else {
                dd('fine');
                $maxFrNo = FeasibilityRequirementDetail::where('client_no', $data['client_no'])->max('fr_no');

                if ($maxFrNo) {
                    $frArray = explode('-', $maxFrNo);
                    $frSerial = intval($frArray[count($frArray) - 1]) + 1;
                    $frNo .= $frSerial;
                } else {
                    $maxFrNo = FeasibilityRequirementDetail::where('client_no', $data['client_no'])->max('fr_no');

                    if ($maxFrNo) {
                        $frArray = explode('-', $maxFrNo);
                        $frSerial = intval($frArray[count($frArray) - 1]) + 1;
                        $frNo .= $frSerial;
                    } else {
                        $frNo .= '1';
                    }
                    $detailsData['fr_no'] = $frNo;
                    $feasibility_requirement->feasibilityRequirementDetails()->create($detailsData);
                }
            }

            return redirect()->route('feasibility-requirement.index')->with('success', 'Feasibility Requirement Updated Successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(FeasibilityRequirement $feasibilityRequirement)
    {
        $feasibility_detail = $feasibilityRequirement->feasibilityRequirementDetails;
        foreach ($feasibility_detail as $key => $value) {
            $value->delete();
        }
        $feasibilityRequirement->delete();
        return redirect()->route('feasibility-requirement.index')->with('success', 'Feasibility Requirement Deleted Successfully');
    }

    public function deleteFeasibilityRequirementDetail(Request $request)
    {
        $feasibilityRequirementDetail = FeasibilityRequirementDetail::find($request->id);
        $feasibilityRequirementDetail->delete();
        return response()->json(['success' => 'Deleted Successfully']);
    }

    public function getClientFrList(Request $request)
    {
        $feasibility_requirement = FeasibilityRequirement::where('client_id', $request->client_id)->first();
        $feasibility_requirement_details = FeasibilityRequirementDetail::select('id', 'link_name', 'fr_no')->where('feasibility_requirement_id', $feasibility_requirement->id)->get();
        return response()->json($feasibility_requirement_details);
    }
    public function exportFeasibilityRequirement()
    {
        return Excel::download(new FeasibilityRequirementExport, 'feasibility-requirement-details.xlsx');
    }
}
