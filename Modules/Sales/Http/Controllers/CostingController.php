<?php

namespace Modules\Sales\Http\Controllers;

use App\Jobs\SendEmailNotificationJob;
use App\Services\BbtsGlobalService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Sales\Entities\Costing;
use Modules\Sales\Entities\CostingLink;
use Modules\Sales\Entities\CostingLinkEquipment;
use Modules\Sales\Entities\CostingProduct;
use Modules\Sales\Entities\CostingProductEquipment;
use Modules\Sales\Entities\Planning;
use Modules\Sales\Entities\FeasibilityRequirementDetail;
use Modules\Sales\Entities\LeadGeneration;
use Illuminate\Support\Facades\Mail;
use Modules\Admin\Entities\User;
use PDF;


class CostingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    function __construct()
    {
        $this->middleware('permission:cost-view|cost-create|cost-edit|cost-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:cost-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:cost-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:cost-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $from_date = date('Y-m-d', strtotime(request()->get('from_date'))) ?? date('Y-m-d');
        $to_date = date('Y-m-d', strtotime(request()->get('to_date'))) ?? date('Y-m-d');
        $costings = Costing::with('costingProducts', 'costingLinks', 'costingLinks.costingLinkEquipments')
            ->when($from_date, function ($query, $from_date) {
                return $query->whereDate('created_at', '>=', $from_date);
            })
            ->when($to_date, function ($query, $to_date) {
                return $query->whereDate('created_at', '<=', $to_date);
            })
            ->clone();
        // if (!auth()->user()->hasRole(['Admin', 'Super-Admin'])) {
        //     $costings = $costings->where('created_by', auth()->user()->id);
        // }
        $costings = $costings->latest()->get();
        return view('sales::costing.index', compact('costings'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($id = null)
    {
        // dd('ff');
        $feasibilityRequirementDetail = FeasibilityRequirementDetail::find($id);
        // dd($feasibilityRequirementDetail);
        $planning = Planning::with('equipmentPlans.material', 'servicePlans', 'planLinks.PlanLinkEquipments.material')
            ->where('fr_no', $feasibilityRequirementDetail->fr_no)->first();
        return view('sales::costing.create', compact('planning', 'feasibilityRequirementDetail'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */

    public function store(Request $request)
    {
        // dd($request->all());
        try {
            $feasibility_requirement_detail = FeasibilityRequirementDetail::with('feasibilityRequirement')->where('fr_no', $request->fr_no)->first();

            DB::beginTransaction();

            $costingData = $request->all();

            $costing = Costing::create($costingData);

            $this->createOrUpdateCostingProducts($request, $costing);

            $this->createOrUpdateCostingMaterials($request, $costing);

            $this->createOrUpdateCostingLinks($request, $costing);

            DB::commit();

            $notificationReceivers = User::whereHas('roles', function ($q) {
                $q->whereIn('name', ['Sales Admin', 'Admin']);
            })->get();

            $notificationData = [
                'type' => 'Planning',
                'message' => 'A new Costing has been created by ' . auth()->user()->name,
                'url' => 'sales/costing/' . $costing->id,
            ];

            BbtsGlobalService::sendNotification($notificationReceivers, $notificationData);

            $data = [
                'to' => 'salesadmin@bbts.net',
                'cc' => 'yasir@bbts.net',
                'heading' => 'New Costing Created',
                'greetings' => 'Dear Sir/Madam,',
                'message' => "I am writing to inform you about a new costing that has been generated for our esteemed client",
                'url' =>  route('costing.show', $costing->id),
                'button_text' => 'View Costing',
                'client_name' => $request->client_name ?? '',
                'client_no' => $costing->client_no,
                'mq_no' => $costing->mq_no,
                'created_by' => auth()->user()->name,
                'created_at' => $costing->created_at,
                'client_email' => '',
                'fr_no' => $costing->fr_no,
                'auto_mail_alert' => 'This is an auto generated send to you from BBTS.' . PHP_EOL . 'Please do not reply to this email.',
                'regards' => 'BBTS',
            ];

            SendEmailNotificationJob::dispatch($data);
            // return response()->json(['message' => 'Data saved successfully.']);
            return redirect()->route('feasibility-requirement.show', $feasibility_requirement_detail->feasibilityRequirement->id)->with('success', 'Connectivity Requirement Created Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to save data. Error: ' . $e->getMessage());
        }
    }



    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $costing = Costing::with('costingProducts', 'costingProductEquipments', 'costingLinks.costingLinkEquipments', 'lead_generation', 'feasibilityRequirementDetail')->find($id);
        return view('sales::costing.show', compact('costing'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $costing = Costing::with('costingProducts', 'costingProductEquipments', 'costingLinks.costingLinkEquipments', 'lead_generation', 'feasibilityRequirementDetail')->find($id);
        return view('sales::costing.edit', compact('costing'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {

        try {
            DB::beginTransaction();

            $costingData = $request->all();

            $costing = Costing::find($id);

            $costing->update($costingData);

            $this->createOrUpdateCostingProducts($request, $costing);

            $this->createOrUpdateCostingMaterials($request, $costing);

            $this->createOrUpdateCostingLinks($request, $costing);

            DB::commit();
            $notificationReceivers = User::whereHas('roles', function ($q) {
                $q->whereIn('name', ['Sales Admin', 'Admin']);
            })->get();

            $notificationData = [
                'type' => 'Planning',
                'message' => 'A Costing has been updated by ' . auth()->user()->name,
                'url' => 'sales/costing/' . $costing->id,
            ];

            BbtsGlobalService::sendNotification($notificationReceivers, $notificationData);

            $client = $request->client_name ?? '';
            $client_number = $costing->client_no ?? '';
            $fr_no = $costing->fr_no ?? '';
            $mq_no = $costing->mq_no ?? '';
            $fromAddress = auth()->user()->email;
            $fromName = auth()->user()->name;
            $to = 'salesadmin@bbts.net';
            $cc = ['yasir@bbts.net', 'shiful@magnetismtech.com', 'saleha@magnetismtech.com', $fromAddress];
            $subject = "Costing Updated";
            $messageBody = "Dear Sir,\n
        I am writing to inform you about a new Costing $mq_no has been updated for our esteemed client, $client ($client_number). \n
        Costing Details:
        Client: $client
        Client No: $client_number
        FR No: $fr_no
        MQ No: $mq_no \n
        Please find the details from software in Costing List.
        Thank you for your attention to this matter. I look forward to your guidance and support.\n
        Best regards,
        $fromName";

            Mail::raw($messageBody, function ($message) use ($to, $cc, $subject, $fromAddress, $fromName) {
                $message->from($fromAddress, $fromName)->to($to)->cc($cc)->subject($subject);
            });
            // return response()->json(['message' => 'Data saved successfully.']);
            return redirect()->route('costing.index')->with('success', 'Data saved successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to save data. Error: ' . $e->getMessage());
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
            DB::beginTransaction();

            $costing = Costing::find($id);

            $costing->delete();

            DB::commit();
            // return response()->json(['message' => 'Data saved successfully.']);
            return redirect()->route('costing.index')->with('success', 'Data Deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to Delete Data. Error: ' . $e->getMessage());
        }
    }


    private function createOrUpdateCostingProducts($request, $costing)
    {
        if (!empty($request->product_id)) {
            foreach ($request->product_id as $key => $product) {
                $productData = [
                    'costing_id' => $costing->id,
                    'product_id' => $product,
                    'fr_no' => $request->fr_no,
                    'quantity' => $request->product_quantity[$key],
                    'rate' => $request->product_rate[$key],
                    'unit' => $request->product_unit[$key],
                    'sub_total' => $request->product_price[$key],
                    'product_vat' => $request->product_vat[$key],
                    'product_vat_amount' => $request->product_vat_amount[$key],
                    'operation_cost' => $request->product_operation_cost[$key],
                    'operation_cost_total' => $request->product_operation_cost_total[$key],
                    'offer_price' => $request->offer_price[$key],
                    'total' => $request->product_offer_total[$key],
                ];
                if (isset($request->costing_product_id[$key])) {
                    $costingProduct = CostingProduct::find($request->costing_product_id[$key]);
                    $costingProduct->update($productData);
                } else {
                    CostingProduct::create($productData);
                }
            }
        }
    }

    private function createOrUpdateCostingMaterials($request, $costing)
    {
        if (!empty($request->material_id)) {
            foreach ($request->material_id as $key => $material) {
                $materialData = [
                    'costing_id' => $costing->id,
                    'material_id' => $request->material_id[$key],
                    'quantity' => $request->equipment_quantity[$key],
                    'rate' => $request->equipment_rate[$key],
                    'total' => $request->equipment_total[$key],
                    'unit' => $request->equipment_unit[$key],
                    'ownership' => $request->equipment_ownership[$key],
                ];
                if (isset($request->costing_product_equipment_id[$key])) {
                    $costingProductEquipment = CostingProductEquipment::find($request->costing_product_equipment_id[$key]);
                    $costingProductEquipment->update($materialData);
                } else {
                    CostingProductEquipment::create($materialData);
                }
            }
        }
    }

    private function  createOrUpdateCostingLinks($request, $costing)
    {

        for ($rowNo = 1; $rowNo <= $request->total_key; $rowNo++) {
            $costingLinkData = [
                'costing_id' => $costing->id,
                'link_status' => request('plan_link_status_' . $rowNo) ?? 0,
                'link_no' => request('link_no_' . $rowNo),
                'link_type' => request('link_type_' . $rowNo),
                'option' => request('option_' . $rowNo),
                'transmission_capacity' => request('capacity_' . $rowNo),
                'rate' => request('rate_' . $rowNo),
                'quantity' => request('quantity_' . $rowNo),
                'total' => request('link_total_' . $rowNo),
                'plan_all_equipment_total' => request('plan_all_equipment_total_' . $rowNo),
                'plan_client_equipment_total' => request('plan_client_equipment_total_' . $rowNo),
                'partial_total' => request('plan_equipment_partial_total_' . $rowNo),
                'deployment_cost' => request('plan_equipment_deployment_cost_' . $rowNo),
                'interest_perchantage' => request('plan_equipment_perchantage_interest_' . $rowNo),
                'interest' => request('plan_equipment_interest_' . $rowNo),
                'vat_perchantage' => request('plan_equipment_perchantage_vat_' . $rowNo),
                'vat' => request('plan_equipment_vat_' . $rowNo),
                'tax_perchantage' => request('plan_equipment_perchantage_tax_' . $rowNo),
                'tax' => request('plan_equipment_tax_' . $rowNo),
                'grand_total' => request('plan_equipment_grand_total_' . $rowNo),
                'otc' => request('plan_equipment_otc_' . $rowNo),
                'roi' => request('plan_equipment_roi_' . $rowNo),
                'investment' => request('plan_equipment_total_inv_' . $rowNo),
                'capacity_amount' => request('plan_equipment_capacity_' . $rowNo),
                'operation_cost' => request('plan_equipment_operation_cost_' . $rowNo),
                'total_mrc' => request('plan_equipment_total_mrc_' . $rowNo),
            ];

            if (request('costing_link_id_' . $rowNo)) {
                $costingLink = CostingLink::find(request('costing_link_id_' . $rowNo));
                $costingLink->update($costingLinkData);
            } else {
                $costingLink = CostingLink::create($costingLinkData);
            }
            if (request('plan_equipment_material_id_' . $rowNo)) {
                foreach (request('plan_equipment_material_id_' . $rowNo) as $key => $equipment) {

                    $equipmentData = [
                        'costing_id' => $costing->id,
                        'costing_link_id' => $costingLink->id,
                        'material_id' => request('plan_equipment_material_id_' . $rowNo)[$key],
                        'unit' => request('plan_equipment_unit_' . $rowNo)[$key],
                        'rate' => request('plan_equipment_rate_' . $rowNo)[$key],
                        'quantity' => request('plan_equipment_quantity_' . $rowNo)[$key],
                        'total' => request('plan_equipment_total_' . $rowNo)[$key],
                        'ownership' => request('ownership_' . $rowNo)[$key],
                    ];
                    if (isset(request('costing_link_equipment_id_' . $rowNo)[$key])) {
                        $costingLinkEquipment = CostingLinkEquipment::find(request('costing_link_equipment_id_' . $rowNo)[$key]);
                        $costingLinkEquipment->update($equipmentData);
                    } else {
                        CostingLinkEquipment::create($equipmentData);
                    }
                }
            }
        }
    }
    public function modifiedList()
    {
        $costings = Costing::with('costingProducts', 'costingLinks', 'costingLinks.costingLinkEquipments')
            ->where('is_modified', 1)
            ->latest()
            ->get();
        return view('sales::costing.modification_list', compact('costings'));
    }

    public function CostingPdf($id)
    {
        $costing = Costing::with('costingProducts', 'costingProductEquipments', 'costingLinks.costingLinkEquipments', 'lead_generation', 'feasibilityRequirementDetail')->find($id);
        $pdf = PDF::loadView('sales::costing.pdf', ['costing' => $costing], [], [
            'format' => 'A4'
        ]);
        return $pdf->stream($costing->lead_generation->client_name . '-' . $costing->connectivity_point . '-costing.pdf');
    }
}
