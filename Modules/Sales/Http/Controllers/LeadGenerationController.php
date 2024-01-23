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
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class LeadGenerationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    function __construct()
    {
        $this->middleware('permission:lead-generation-view|lead-generation-create|lead-generation-edit|lead-generation-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:lead-generation-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:lead-generation-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:lead-generation-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $from_date = date('Y-m-d', strtotime(request()->get('from_date'))) ?? '';
        $to_date = date('Y-m-d', strtotime(request()->get('to_date'))) ?? '';
        $lead_generations = LeadGeneration::with('division', 'district', 'thana')
            ->when($from_date, function ($query, $from_date) {
                return $query->whereDate('created_at', '>=', $from_date);
            })
            ->when($to_date, function ($query, $to_date) {
                return $query->whereDate('created_at', '<=', $to_date);
            })
            ->orderBy('id', 'DESC')
            ->get();
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
            '7' => 'Bank',
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
        $data = $request->only('client_name', 'address', 'division_id', 'district_id', 'thana_id', 'landmark', 'lat', 'long', 'contact_person', 'designation', 'contact_no',  'email', 'business_type', 'client_type', 'website', 'current_provider', 'existing_bandwidth', 'existing_mrc', 'chance_of_business', 'potentiality', 'remarks');
        if ($request->hasFile('upload_file')) {
            $file_name = CommonService::fileUpload($request->file('upload_file'), 'uploads/lead_generation');
            $data['document'] = $file_name;
        }

        $latest_lead = LeadGeneration::latest()->first();
        if ($latest_lead) {
            $client_no = explode('-', $latest_lead->client_no);
            $data['client_no'] = date('Y') . '-' . ($client_no[1] + 1);
        } else {
            $data['client_no'] = date('Y') . '-' . 1;
        }
        $data['created_by'] = auth()->user()->id;
        $leadGeneration = LeadGeneration::create($data);

        $client = $leadGeneration->client_name;
        $to = 'salesadmin@bbts.net';
        $cc = 'yasir@bbts.net';
        $receiver = '';
        $subject = "New Lead Generation Created";
        $messageBody = "A new lead has been created for the client $client ($leadGeneration->client_no). Please find the details from Lead Generation List.";
        $fromAddress = auth()->user()->email;
        $fromName = auth()->user()->name;

        Mail::raw($messageBody, function ($message) use ($to, $cc, $subject, $fromAddress, $fromName) {
            $message->from($fromAddress, $fromName)->to($to)->cc($cc)->subject($subject);
        });
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
        $lead_generation = LeadGeneration::with('createdBy')->find($id);
        $divisons = Division::all();
        $districts = District::get();
        $thanas = Thana::where('district_id', $lead_generation->district_id)->get();
        $organizations = [
            '1' => 'School',
            '2' => 'Hospital',
            '3' => 'Hotel',
            '4' => 'Restaurant',
            '5' => 'Office',
            '6' => 'Others',
            '7' => 'Bank',
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
        $data = $request->only('client_name', 'address', 'division_id', 'district_id', 'thana_id', 'landmark', 'lat', 'long', 'contact_person', 'designation', 'contact_no',  'email', 'business_type', 'client_type', 'website', 'current_provider', 'existing_bandwidth', 'existing_mrc', 'chance_of_business', 'potentiality', 'remarks');
        $data['created_by'] = auth()->user()->id;
        if ($request->hasFile('upload_file')) {
            $file_name = CommonService::UpdatefileUpload($request->file('upload_file'), 'uploads/lead_generation', $lead_generation->document);
            $data['document'] = $file_name;
        }
        $lead_generation->update($data);

        $client = $lead_generation->client_name;
        $to = 'salesadmin@bbts.net';
        $cc = 'yasir@bbts.net';
        $receiver = '';
        $subject = "Lead Generation Info Updated";
        $messageBody = "Lead generation info has been updated for the client $client ($lead_generation->client_no). Please find the details from Lead Generation List.";
        $fromAddress = auth()->user()->email;
        $fromName = auth()->user()->name;

        Mail::raw($messageBody, function ($message) use ($to, $cc, $subject, $fromAddress, $fromName) {
            $message->from($fromAddress, $fromName)->to($to)->cc($cc)->subject($subject);
        });
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
        $lead_generations = LeadGeneration::where('client_no', 'like', '%' . $request->search . '%')->where('status', 'Accept')->orWhere('client_name', 'like', '%' . $request->search . '%')->get();
        foreach ($lead_generations as $lead_generation) {
            $main_leads[] = [
                'label' => $lead_generation->client_name . ' ( ' . $lead_generation->client_no . ' )',
                'client_no' => $lead_generation->client_no,
                'client_name' => $lead_generation->client_name,
                'lead_generation_id' => $lead_generation->id,
            ];
        }
        return response()->json($main_leads);
    }

    public function updateStatus(Request $request, $id)
    {
        $lead_generation = LeadGeneration::find($id);
        $lead_generation->status = $request->status;
        $lead_generation->comment = $request->comment;
        $lead_generation->save();

        $client = $lead_generation->client_name;
        $to = $lead_generation->createdBy->email;
        $cc = 'yasir@bbts.net';
        $receiver = '';
        $subject = "Lead Generation Info Updated";
        $messageBody = "Client status updated to $lead_generation->status for client $client ($lead_generation->client_no). Please find the detailed Lead Generation List.";
        $fromAddress = 'salesadmin@bbts.net';
        $fromName = auth()->user()->name;

        Mail::raw($messageBody, function ($message) use ($to, $cc, $subject, $fromAddress, $fromName) {
            $message->from($fromAddress, $fromName)->to($to)->cc($cc)->subject($subject);
        });
        return redirect()->route('lead-generation.index')->with('success', 'Lead Generation Status Updated Successfully');
    }

    public function getClientInformationForProfile(Request $request)
    {
        $main_leads = [];
        //get client where match the request data
        $lead_generations = LeadGeneration::where('client_name', 'like', '%' . $request->client_name . '%')->orWhere('client_no', 'like', '%' . $request->client_name . '%')->get();
        foreach ($lead_generations as $lead_generation) {
            $main_leads[] = [
                'label' => $lead_generation->client_name . ' ( ' . $lead_generation->client_no . ' )',
                'client_name' => $lead_generation->client_name,
                'value' => $lead_generation->client_no,
                'lead_generation_id' => $lead_generation->id,
                'location' => $lead_generation->address,
                'division' => $lead_generation->division_id,
                'district' => $lead_generation->district_id,
                'thana' => $lead_generation->thana_id,
                'lat' => $lead_generation->lat,
                'long' => $lead_generation->long,
                'contact_person' => $lead_generation->contact_person,
                'designation' => $lead_generation->designation,
                'contact_no' => $lead_generation->contact_no,
                'email' => $lead_generation->email,
                'business_type' => $lead_generation->business_type,
                'client_type' => $lead_generation->client_type,
            ];
        }
        $districts = District::where('division_id', $lead_generation->division_id)->get();
        $thanas = Thana::where('district_id', $lead_generation->district_id)->get();
        $data = [
            'lead_generation' => $main_leads,
            'districts' => $districts,
            'thanas' => $thanas,
        ];
        return response()->json($data);
    }
}
