<?php

namespace Modules\Sales\Http\Controllers;

use Modules\Sales\Http\Requests\LeadGenerationRequest;
use Illuminate\Contracts\Support\Renderable;
use Modules\Sales\Entities\LeadGeneration;
use Modules\Sales\Services\CommonService;
use App\Models\Dataencoding\District;
use App\Models\Dataencoding\Division;
use Illuminate\Routing\Controller;
use App\Models\Dataencoding\Thana;
use Illuminate\Http\Request;

class LeadGenerationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $lead_generations = LeadGeneration::with('division', 'district', 'thana')->get();
        return view('sales::lead_generation.index', compact('lead_generations'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $divisons = Division::all();
        $organizations = [
            '1' => 'School',
            '2' => 'Hospital',
            '3' => 'Hotel',
            '4' => 'Restaurant',
            '5' => 'Office',
            '6' => 'Others',
        ];

        return view('sales::lead_generation.create', compact('divisons', 'organizations'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(LeadGenerationRequest $request)
    {
        $data = $request->only('client_name', 'address', 'division_id', 'district_id', 'thana_id', 'landmark', 'lat_long', 'contact_person', 'designation', 'contact_no',  'email', 'business_type', 'client_type', 'website');
        if ($request->hasFile('upload_file')) {
            $file_name = CommonService::fileUpload($request->file('upload_file'), 'uploads/lead_generation');
            $data['document'] = $file_name;
        }
        $data['client_id'] = date('Y') . '-' . LeadGeneration::count() + 1;
        LeadGeneration::create($data);
        return redirect()->route('lead-generation.index')->with('success', 'Lead Generation Created Successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $lead_generation = LeadGeneration::with('division', 'district', 'thana')->find($id);
        return view('sales::lead_generation.show', compact('lead_generation'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $lead_generation = LeadGeneration::with('division', 'district', 'thana')->find($id);
        $divisons = Division::all();
        $districts = District::where('division_id', $lead_generation->division_id)->get();
        $thanas = Thana::where('district_id', $lead_generation->district_id)->get();
        $organizations = [
            '1' => 'School',
            '2' => 'Hospital',
            '3' => 'Hotel',
            '4' => 'Restaurant',
            '5' => 'Office',
            '6' => 'Others',
        ];
        return view('sales::lead_generation.create', compact('lead_generation', 'divisons', 'districts', 'thanas', 'organizations'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(LeadGenerationRequest $request, LeadGeneration $lead_generation)
    {
        $data = $request->only('client_name', 'address', 'division_id', 'district_id', 'thana_id', 'landmark', 'lat_long', 'contact_person', 'designation', 'contact_no',  'email', 'business_type', 'client_type', 'website', 'current_provider', 'existing_bandwidth', 'existing_mrc', 'chance_of_business', 'potentiality', 'remarks');
        if ($request->hasFile('upload_file')) {
            $file_name = CommonService::UpdatefileUpload($request->file('upload_file'), 'uploads/lead_generation', $lead_generation->document);
            $data['document'] = $file_name;
        }
        $lead_generation->update($data);
        return redirect()->route('lead-generation.index')->with('success', 'Lead Generation Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(LeadGeneration $lead_generation)
    {
        $lead_generation->delete();
        return redirect()->route('lead-generation.index')->with('success', 'Lead Generation Deleted Successfully');
    }

    public function getClient(Request $request)
    {
        $main_leads = [];
        //get client where match the request data
        $lead_generations = LeadGeneration::where('client_id', 'like', '%' . $request->client_id . '%')->get();
        foreach ($lead_generations as $lead_generation) {
            $main_leads[] = [
                'label' => $lead_generation->client_id,
                'value' => $lead_generation->client_name,
                'lead_generation_id' => $lead_generation->id,
            ];
        }
        return response()->json($main_leads);
    }
}
