<?php

namespace Modules\Sales\Http\Controllers;

use App\Jobs\SendEmailNotificationJob;
use App\Services\BbtsGlobalService;
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
use Illuminate\Support\Facades\Mail;
use Modules\Admin\Entities\User;
use Modules\Sales\Entities\LeadGeneration;
use Modules\Sales\Entities\ConnectivityRequirement;
use Modules\Sales\Entities\FinalSurveyDetail;
use Modules\Sales\Entities\Vendor;
use Modules\Sales\Services\CommonService;
use PDF;


class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    function __construct()
    {
        $this->middleware('permission:survey-view|survey-create|survey-edit|survey-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:survey-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:survey-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:survey-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        // dd('ok');
        $from_date = request()->from_date ? date('Y-m-d', strtotime(request()->from_date)) : '';
        $to_date = request()->to_date ? date('Y-m-d', strtotime(request()->to_date)) : '';
        $surveys = Survey::with('surveyDetails', 'lead_generation')
            ->when($from_date, function ($query, $from_date) {
                return $query->where('created_at', '>=', $from_date);
            })
            ->when($to_date, function ($query, $to_date) {
                return $query->where('created_at', '<=', $to_date);
            })
            ->where('is_modified', 0)
            ->clone();
        if (!auth()->user()->hasRole(['Admin', 'Super-Admin']) && !empty(request()->get('from_date')) && !empty(request()->get('to_date'))) {
            $surveys = $surveys->whereHas('feasibilityRequirementDetails.feasibilityRequirement', function ($q) {
                $q->where('user_id', auth()->user()->id);
            });
        } elseif (!auth()->user()->hasRole(['Admin', 'Super-Admin']) && empty(request()->get('from_date')) && empty(request()->get('to_date'))) {
            $surveys = $surveys->whereHas('feasibilityRequirementDetails.feasibilityRequirement', function ($q) {
                $q->where('user_id', auth()->user()->id);
            })->take(10);
        }
        $surveys = $surveys->latest()->get();
        return view('sales::survey.index', compact('surveys'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($fr_id)
    {
        $fr_detail = FeasibilityRequirementDetail::with('feasibilityRequirement')->find($fr_id);
        $all_fr_list = FeasibilityRequirementDetail::get();
        $connectivity_requirement = ConnectivityRequirement::with('connectivityRequirementDetails.vendor', 'connectivityProductRequirementDetails', 'lead_generation')->where('fr_no', $fr_detail->fr_no)->first();
        $pops = $fr_detail->branch_id ? Pop::where('branch_id', $fr_detail->branch_id)->get() : Pop::get();
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
        $feasibility_requirement_detail = FeasibilityRequirementDetail::with('feasibilityRequirement')->where('fr_no', $request->fr_no)->first();
        $survey_data = $request->only('date', 'client_no', 'fr_no', 'survey_remarks');
        $survey_data['user_id'] = auth()->user()->id ?? '';
        $survey_data['branch_id'] = auth()->user()->branch_id ?? null;
        $survey_data['date'] = date('Y-m-d', strtotime($request->date));
        $survey_data['mq_no'] = FeasibilityRequirement::where('client_no', $survey_data['client_no'])->first()->mq_no;
        $survey_data['lead_generation_id'] = LeadGeneration::where('client_no', $survey_data['client_no'])->first()->id;
        $survey_data['feasibility_requirement_details_id'] = FeasibilityRequirementDetail::where('fr_no', $survey_data['fr_no'])->first()->id;
        if ($request->hasFile('document')) {
            $file_name = CommonService::fileUpload($request->file('survey_document'), 'uploads/survey');
            $survey_data['document'] = $file_name;
        }
        DB::beginTransaction();
        try {
            $survey = Survey::create($survey_data);
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
                $survey_details['current_capacity'] = $request->current_capacity[$key] ?? '';
                $survey_details['remarks'] = $request->remarks[$key];
                SurveyDetail::create($survey_details);
            }
            DB::commit();

            $notificationReceivers = User::whereHas('roles', function ($q) {
                $q->whereIn('name', ['Sales Admin', 'Admin']);
            })->get();

            $notificationData = [
                'type' => 'Survey',
                'message' => 'A new Survey has been created by ' . auth()->user()->name,
                'url' => 'sales/survey/' . $survey->id,
            ];

            BbtsGlobalService::sendNotification($notificationReceivers, $notificationData);

            $data = [
                'to' => 'planning@bbts.net',
                'cc' => 'yasir@bbts.net',
                'heading' => 'New Survey Created',
                'greetings' => 'Dear Sir/Madam,',
                'message' => "I am writing to inform you about a new survey that has been generated for our esteemed client",
                'url' =>  route('survey.show', $survey->id),
                'button_text' => 'View Survey',
                'client_name' => $request->client_name ?? '',
                'client_no' => $survey->client_no,
                'mq_no' => $survey->mq_no,
                'created_by' => auth()->user()->name,
                'created_at' => $survey->created_at,
                'client_email' => '',
                'fr_no' => $survey->fr_no,
                'auto_mail_alert' => 'This is an auto generated send to you from BBTS.' . PHP_EOL . 'Please do not reply to this email.',
                'regards' => 'BBTS',
            ];

            SendEmailNotificationJob::dispatch($data);
            return redirect()->route('feasibility-requirement.show', $feasibility_requirement_detail->feasibilityRequirement->id)->with('success', 'Connectivity Requirement Created Successfully');
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
        $connectivity_requirement = ConnectivityRequirement::with('connectivityRequirementDetails.vendor', 'connectivityProductRequirementDetails', 'lead_generation')->where('fr_no', $survey->fr_no)->first();
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
        $fr_detail = $survey->feasibilityRequirementDetails;
        $connectivity_requirement = ConnectivityRequirement::with('connectivityRequirementDetails.vendor', 'connectivityProductRequirementDetails', 'lead_generation')->where('fr_no', $survey->fr_no)->first();
        $pops = Pop::get();
        $vendors = Vendor::get();
        return view('sales::survey.create', compact('survey', 'connectivity_requirement', 'pops', 'vendors', 'fr_detail'));
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
        $survey_data['branch_id'] = auth()->user()->branch_id ?? null;
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
                $survey_details['current_capacity'] = $request->current_capacity[$key] ?? '';
                $survey_details['remarks'] = $request->remarks[$key];
                SurveyDetail::create($survey_details);
            }
            DB::commit();

            $notificationReceivers = User::whereHas('roles', function ($q) {
                $q->whereIn('name', ['Sales Admin', 'Admin']);
            })->get();

            $notificationData = [
                'type' => 'Survey',
                'message' => 'A Survey has been updated by ' . auth()->user()->name,
                'url' => 'sales/survey/' . $survey_details->id,
            ];

            BbtsGlobalService::sendNotification($notificationReceivers, $notificationData);

            $client = $request->client_name ?? '';
            $client_number = $survey->client_no ?? '';
            $fr_no = $survey->fr_no ?? '';
            $mq_no = $survey->mq_no ?? '';
            $date = $survey->date ?? '';
            $fromAddress = auth()->user()->email;
            $fromName = auth()->user()->name;
            $to = 'planning@bbts.net';
            $cc = ['yasir@bbts.net', 'shiful@magnetismtech.com', 'saleha@magnetismtech.com', $fromAddress];
            $subject = "Survey Updated";
            $messageBody = "Dear Sir,\n
        I am writing to inform you about a new Survey $mq_no has been updated for our esteemed client, $client ($client_number). \n
        Survey Details:
        Client: $client
        Client No: $client_number
        FR No: $fr_no
        MQ No: $mq_no
        Date: $date \n
        Please find the details from software in Survey List.
        Thank you for your attention to this matter. I look forward to your guidance and support.\n
        Best regards,
        $fromName";

            Mail::raw($messageBody, function ($message) use ($to, $cc, $subject, $fromAddress, $fromName) {
                $message->from($fromAddress, $fromName)->to($to)->cc($cc)->subject($subject);
            });
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

    public function surveyPdf($id)
    {
        $survey = Survey::with('surveyDetails', 'lead_generation')->find($id);
        $connectivity_requirement = ConnectivityRequirement::with('connectivityRequirementDetails.vendor', 'connectivityProductRequirementDetails', 'lead_generation')->where('fr_no', $survey->fr_no)->first();
        $pdf = PDF::loadView('sales::survey.pdf', compact('survey', 'connectivity_requirement'));
        return $pdf->stream($survey->lead_generation->client_name . '-' . $survey->connectivity_point . 'survey.pdf');
    }
}
