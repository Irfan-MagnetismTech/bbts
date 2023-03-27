<?php

namespace Modules\Sales\Http\Controllers;

use App\Models\Dataencoding\District;
use App\Models\Dataencoding\Thana;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Dataencoding\Division;
use Modules\Sales\Entities\FeasibilityRequirement;
use Modules\Sales\Entities\FeasibilityRequirementDetail;
use Modules\Sales\Http\Requests\FeasibilityRequirementRequest;

class FeasibilityRequirementController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $feasibility_requirements = FeasibilityRequirement::with('lead_generation')->get();
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
        $data = $request->only('client_id', 'is_existing', 'date', 'lead_generation_id');

        $data['user_id'] = auth()->user()->id;
        $data['branch_id'] = auth()->user()->branch_id ?? '1';

        $max_mq_no = FeasibilityRequirement::where('client_id', $data['client_id'])->max('mq_no');
        if ($max_mq_no == null) {
            $data['mq_no'] = 'MQ' . '-' . $data['client_id'] . '-' . '1';
        } else {
            $mq_array = explode('-', $max_mq_no);
            $data['mq_no'] = 'MQ' . '-' . $data['client_id'] . '-' . ($mq_array[2] + 1);
        }

        $feasibilityRequirement = FeasibilityRequirement::create($data);
        $feasibility_details = $request->only('link_name', 'division_id', 'district_id', 'thana_id', 'location', 'lat_long', 'contact_name', 'contact_designation', 'contact_number', 'contact_email');


        foreach (array_keys($request['link_name']) as $feasibility_key) {
            $fr_no = FeasibilityRequirementDetail::where('feasibility_requirement_id', $feasibilityRequirement->id)->max('fr_no');
            if ($fr_no == null) {
                $fr_no = 'fr' . '-' . $feasibilityRequirement->client_id . '-' . '1';
            } else {
                $fr_array = explode('-', $fr_no);
                $fr_no = 'fr' . '-' . $feasibilityRequirement->client_id . '-' . ($fr_array[2] + 1);
            }
            $feasibility_detail[] = [
                'link_name' => $request['link_name'][$feasibility_key],
                'fr_no' => $fr_no,
                'division_id' => $request['division_id'][$feasibility_key],
                'district_id' => $request['district_id'][$feasibility_key],
                'thana_id' => $request['thana_id'][$feasibility_key],
                'location' => $request['location'][$feasibility_key],
                'lat_long' => $request['lat_long'][$feasibility_key],
                'contact_name' => $request['contact_name'][$feasibility_key],
                'contact_designation' => $request['contact_designation'][$feasibility_key],
                'contact_number' => $request['contact_number'][$feasibility_key],
                'contact_email' => $request['contact_email'][$feasibility_key],
            ];
        }


        // dd($feasibility_detail);
        $feasibilityRequirement->feasibilityRequirementDetails()->createMany($feasibility_detail);
        return redirect()->route('feasibility-requirement.index')->with('success', 'Feasibility Requirement Created Successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $feasibility_requirement = FeasibilityRequirement::with('feasibilityRequirementDetails.connectivityRequirement',)->find($id);
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
        // dd($request->all());
        $data = $request->only('client_id', 'is_existing', 'date');

        $data['user_id'] = auth()->user()->id;
        $data['branch_id'] = auth()->user()->branch_id ?? '1';

        $feasibility_requirement->update($data);

        foreach ($request->link_name as $key => $link) {
            if ($request['detail_id'][$key]) {
                //update feasibility requirement details
                $details = FeasibilityRequirementDetail::find($request['detail_id'][$key]);
                $details->update([
                    'link_name' => $request['link_name'][$key],
                    'division_id' => $request['division_id'][$key],
                    'district_id' => $request['district_id'][$key],
                    'thana_id' => $request['thana_id'][$key],
                    'location' => $request['location'][$key],
                    'lat_long' => $request['lat_long'][$key],
                    'contact_name' => $request['contact_name'][$key],
                    'contact_designation' => $request['contact_designation'][$key],
                    'contact_number' => $request['contact_number'][$key],
                    'contact_email' => $request['contact_email'][$key],
                ]);
            } else {
                $feasibility_requirement->feasibilityRequirementDetails()->create([
                    'link_name' => $request['link_name'][$key],
                    'division_id' => $request['division_id'][$key],
                    'district_id' => $request['district_id'][$key],
                    'thana_id' => $request['thana_id'][$key],
                    'location' => $request['location'][$key],
                    'lat_long' => $request['lat_long'][$key],
                    'contact_name' => $request['contact_name'][$key],
                    'contact_designation' => $request['contact_designation'][$key],
                    'contact_number' => $request['contact_number'][$key],
                    'contact_email' => $request['contact_email'][$key],
                ]);
            }
        }
        return redirect()->route('feasibility-requirement.index')->with('success', 'Feasibility Requirement Updated Successfully');
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
}
