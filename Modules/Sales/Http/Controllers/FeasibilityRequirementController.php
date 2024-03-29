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
use App\Jobs\SendEmailNotificationJob;
use App\Mail\CommonNotificationEmail;
use App\Notifications\CommonNotification;
use App\Services\BbtsGlobalService;
use App\Services\EmailService;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Admin\Entities\Branch;
use Modules\Admin\Entities\User;

class FeasibilityRequirementController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    function __construct()
    {
        $this->middleware('permission:feasibility-view|feasibility-create|feasibility-edit|feasibility-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:feasibility-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:feasibility-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:feasibility-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $from_date = request()->from_date ? date('Y-m-d', strtotime(request()->from_date)) : '';
        $to_date =  request()->to_date ? date('Y-m-d', strtotime(request()->to_date)) : '';
        $feasibility_requirements = FeasibilityRequirement::with('lead_generation', 'feasibilityRequirementDetails')
            ->when($from_date, function ($query, $from_date) {
                return $query->whereDate('date', '>=', $from_date);
            })
            ->when($to_date, function ($query, $to_date) {
                return $query->whereDate('date', '<=', $to_date);
            })
            ->where('branch_id', auth()->user()->branch_id ?? '1')
            ->clone();
        if (!auth()->user()->hasRole(['Admin', 'Super-Admin']) && !empty(request()->get('from_date')) && !empty(request()->get('to_date'))) {
            $feasibility_requirements = $feasibility_requirements->where('user_id', auth()->user()->id);
        } elseif (!auth()->user()->hasRole(['Admin', 'Super-Admin']) && empty(request()->get('from_date')) && empty(request()->get('to_date'))) {
            $feasibility_requirements = $feasibility_requirements->where('user_id', auth()->user()->id)->take(10);
        }
        $feasibility_requirements = $feasibility_requirements->latest()->get();
        return view('sales::feasibility_requirement.index', compact('feasibility_requirements'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $divisions = Division::all();
        $branches = Branch::all();
        return view('sales::feasibility_requirement.create', compact('divisions', 'branches'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */


    public function store(FeasibilityRequirementRequest $request)
    {
        if ($request->file) {
            $additionalData = $request;
            Excel::import(new FeasibilityRequirementImport($additionalData), $request->file('file'));
        } else {
            try {
                DB::beginTransaction();
                $data = $request->only('client_no', 'is_existing', 'date', 'lead_generation_id', 'existing_mq');
                $data['user_id'] = auth()->user()->id;
                $data['branch_id'] = auth()->user()->branch_id ?? '1';

                $maxMqNo = FeasibilityRequirement::where('client_no', $data['client_no'])->orderBy('id', 'desc')->first();
                if ($maxMqNo) {
                    $maxMqNo = $maxMqNo->mq_no;
                }
                $data['mq_no'] = 'MQ' . '-' . $data['client_no'] . '-' . ($maxMqNo ? (explode('-', $maxMqNo)[3] + 1) : '1');
                $feasibilityRequirement = FeasibilityRequirement::create($data);

                $feasibilityDetails = [];
                $maxFrNo = FeasibilityRequirementDetail::where('client_no', $data['client_no'])->orderBy('id', 'desc')->first();
                if ($maxFrNo) {
                    $maxFrNo = $maxFrNo->fr_no;
                    $frArray = explode('-', $maxFrNo);
                    $fr_serial = intval($frArray[count($frArray) - 1]) + 1;
                } else {
                    $fr_serial = 1;
                }

                foreach ($request['connectivity_point'] as $key => $connectivityPoint) {
                    $frNo = 'fr' . '-' . $data['client_no'] . '-' . $fr_serial;
                    $fr_serial += 1;
                    $feasibilityDetails[] = [
                        'connectivity_point' => $connectivityPoint ?? null,
                        'aggregation_type' => $request['aggregation_type'][$key] ?? null,
                        'client_no' => $data['client_no'] ?? '',
                        'fr_no' => $frNo ?? '',
                        'branch_id' => $request['branch_id'][$key] ?? null,
                        'division_id' => $request['division_id'][$key] ?? null,
                        'district_id' => $request['district_id'][$key] ?? null,
                        'thana_id' => $request['thana_id'][$key] ?? null,
                        'location' => $request['location'][$key] ?? null,
                        'lat' => $request['lat'][$key] ?? null,
                        'long' => $request['long'][$key] ?? null,
                        'contact_name' => $request['contact_name'][$key] ?? null,
                        'contact_designation' => $request['contact_designation'][$key] ?? null,
                        'contact_number' => $request['contact_number'][$key] ?? null,
                        'contact_email' => $request['contact_email'][$key] ?? null,
                    ];
                }

                $feasibilityRequirement->feasibilityRequirementDetails()->createMany($feasibilityDetails);

                $notificationReceivers = User::whereHas('roles', function ($q) {
                    $q->whereIn('name', ['Sales Admin', 'Survey-Manager']);
                })->get();

                $notificationData = [
                    'type' => 'Feasibility Requirement',
                    'message' => 'A new feasibility requirement has been created by ' . auth()->user()->name,
                    'url' => 'sales/feasibility-requirement/' . $feasibilityRequirement->id,
                ];

                BbtsGlobalService::sendNotification($notificationReceivers, $notificationData);

                $data = [
                    'to' => 'survey@bbts.net',
                    'cc' => 'yasir@bbts.net',
                    'heading' => 'New Feasibility Requirement Created',
                    'greetings' => 'Dear Sir/Madam,',
                    'message' => "A new $feasibilityRequirement->mq_no has been created for the client $request->client_name ($feasibilityRequirement->client_no). Please find the details from Feasibility Requirement Show.",
                    'url' =>  route('feasibility-requirement.show', $feasibilityRequirement->id),
                    'buttonText' => 'View Feasibility Requirement',
                    'client_name' => $request->client_name ?? '',
                    'client_no' => $feasibilityRequirement->client_no,
                    'mq_no' => $feasibilityRequirement->mq_no,
                    'created_by' => auth()->user()->name,
                    'created_at' => $feasibilityRequirement->created_at,
                    'client_email' => $request->client_email ?? 'N/A',
                    'fr_no' => '',
                    'auto_mail_alert' => 'This is an auto generated send to you from BBTS.' . PHP_EOL . 'Please do not reply to this email.',
                    'regards' => 'BBTS',
                ];

                SendEmailNotificationJob::dispatch($data);
                DB::commit();
                return redirect()->route('feasibility-requirement.index')->with('success', 'Feasibility Requirement Created Successfully');
            } catch (\Exception $e) {
                DB::rollback();
                // Handle the exception or display an error message
                return back()->with('error', $e->getMessage());
            }
        }
        return redirect()->route('feasibility-requirement.index')->with('success', 'Feasibility Requirement Created Successfully');
    }


    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $feasibility_requirement = FeasibilityRequirement::with('feasibilityRequirementDetails.connectivityRequirement', 'feasibilityRequirementDetails.branch', 'feasibilityRequirementDetails.survey')->find($id);
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
        $branches = Branch::all();
        $districts = District::whereIn('division_id', $feasibility_requirement->feasibilityRequirementDetails->pluck('division_id'))->get();
        $thanas = Thana::whereIn('district_id', $feasibility_requirement->feasibilityRequirementDetails->pluck('district_id'))->get();
        $existing_mqs = FeasibilityRequirement::where('client_no', $feasibility_requirement->client_no)->where('id', '!=', $feasibility_requirement->id)->pluck('mq_no')->toArray();
        return view('sales::feasibility_requirement.create', compact('feasibility_requirement', 'branches', 'divisions', 'districts', 'thanas', 'existing_mqs'));
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
        if ($request->file) {
            $additionalData = $request;
            $feasibilityRequirement = $feasibility_requirement;
            Excel::import(new FeasibilityRequirementImportUpdate($additionalData, $feasibilityRequirement), $request->file('file'));
            return redirect()->route('feasibility-requirement.index')->with('success', 'Feasibility Requirement Updated Successfully');
        } else {
            $data = $request->only('client_no', 'is_existing', 'date', 'lead_generation_id', 'existing_mq');
            $data['user_id'] = auth()->user()->id;
            $data['branch_id'] = auth()->user()->branch_id ?? '1';

            $feasibility_requirement->update($data);
            // dd($feasibility_requirement);

            foreach ($request->connectivity_point as $key => $link) {
                $detailId = $request['detail_id'][$key] ?? null;
                $frNo = 'fr' . '-' . $data['client_no'] . '-';
                $detailsData = [
                    'connectivity_point' => $request['connectivity_point'][$key] ?? null,
                    'client_no' => $data['client_no'] ?? '',
                    'aggregation_type' => $request['aggregation_type'][$key] ?? null,
                    'branch_id' => $request['branch_id'][$key] ?? null,
                    'division_id' => $request['division_id'][$key] ?? null,
                    'district_id' => $request['district_id'][$key] ?? null,
                    'thana_id' => $request['thana_id'][$key] ?? null,
                    'location' => $request['location'][$key] ?? null,
                    'lat' => $request['lat'][$key] ?? null,
                    'long' => $request['long'][$key] ?? null,
                    'contact_name' => $request['contact_name'][$key] ?? null,
                    'contact_designation' => $request['contact_designation'][$key] ?? null,
                    'contact_number' => $request['contact_number'][$key] ?? null,
                    'contact_email' => $request['contact_email'][$key] ?? null,
                ];

                if ($detailId) {
                    $feasibility = FeasibilityRequirementDetail::find($detailId);
                    if ($feasibility) {
                        $feasibility->update($detailsData);
                    }
                } else {
                    $maxFrNo = FeasibilityRequirementDetail::where('client_no', $data['client_no'])->orderBy('id', 'desc')->first()->fr_no;


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

            $notificationReceivers = User::whereHas('roles', function ($q) {
                $q->where('name', 'Sales Admin');
            })->get();

            $notificationData = [
                'type' => 'Feasibility Requirement',
                'message' => 'A new feasibility requirement has been updated by ' . auth()->user()->name,
                'url' => 'sales/feasibility-requirement/' . $feasibility_requirement->id,
            ];

            BbtsGlobalService::sendNotification($notificationReceivers, $notificationData);
            $client = $request->client_name ?? '';
            $to = 'survey@bbts.net';
            $cc = 'yasir@bbts.net';
            //                $cc = 'saleha@magnetismtech.com';
            $receiver = '';
            $subject = "Feasibility Requirement Updated";
            $messageBody = "Feasibility Requirement $feasibility_requirement->mq_no has been updated for the client $client ($feasibility_requirement->client_no). Please find the details from Feasibility Requirement List.";
            // $fromAddress = 'csd@bbts.net';
            $fromAddress = auth()->user()->email;
            $fromName = auth()->user()->name;
            // Mail::send('sales::email.feasibility_requirement', ['feasibilityRequirement' => $feasibilityRequirement], function ($message) use ($to, $cc, $subject) {
            //     $message->to($to)->cc($cc)->subject($subject);
            // });
            Mail::raw($messageBody, function ($message) use ($to, $cc, $subject, $fromAddress, $fromName) {
                $message->from($fromAddress, $fromName)->to($to)->cc($cc)->subject($subject);
            });
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
