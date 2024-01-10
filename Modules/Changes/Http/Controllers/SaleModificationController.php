<?php

namespace Modules\Changes\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Services\UploadService;
use Modules\Sales\Entities\Sale;
use Modules\SCM\Entities\ScmMur;
use Modules\Sales\Entities\Offer;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;
use Modules\Sales\Entities\Costing;
use Modules\Sales\Entities\Planning;
use App\Models\Dataencoding\Division;
use App\Models\Dataencoding\Employee;
use Carbon\Carbon;
use Exception;
use Modules\Sales\Entities\SaleDetail;
use Illuminate\Database\QueryException;
use Modules\SCM\Entities\ScmRequisition;
use Modules\Sales\Entities\BillingAddress;
use Modules\Sales\Entities\SaleLinkDetail;
use Modules\Billing\Entities\BillingOtcBill;
use Modules\Networking\Entities\NetServiceRequisition;
use Modules\Sales\Entities\Client;
use Modules\Sales\Entities\CollectionAddress;
use Modules\Sales\Entities\ConnectivityRequirement;
use Modules\Sales\Entities\SaleProductDetail;
use Modules\Sales\Entities\CostingLinkEquipment;
use Modules\Sales\Entities\FeasibilityRequirement;
use Modules\Sales\Entities\CostingProductEquipment;
use Modules\Sales\Entities\FeasibilityRequirementDetail;

class SaleModificationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    function __construct(private UploadService $uploadFile)
    {
    }

    public function index()
    {
        $from_date = date('Y-m-d', strtotime(request()->get('from_date'))) ?? '';
        $to_date = date('Y-m-d', strtotime(request()->get('to_date'))) ?? '';
        $sales = Sale::where('is_modified', 1)
            ->when($from_date, function ($query, $from_date) {
                return $query->whereDate('created_at', '>=', $from_date);
            })
            ->when($to_date, function ($query, $to_date) {
                return $query->whereDate('created_at', '<=', $to_date);
            })
            ->latest()
            ->get();
        return view('changes::modify_sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($connectivity_requirement_id)
    {
        $connectivity = ConnectivityRequirement::find($connectivity_requirement_id);
        $frNo = $connectivity->fr_no;
        // dd($frNo);
        $oldSale = Sale::whereHas('saleDetails', function ($query) use ($frNo) {
            $query->where('fr_no', $frNo);
        })->with(['saleDetails' => function ($query) use ($frNo) {
            $query->where('fr_no', $frNo);
        }])
            ->first();
        $divisions = Division::latest()->get();
        return view('changes::modify_sales.create', compact('divisions', 'connectivity_requirement_id', 'oldSale'));
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
            DB::beginTransaction();
            $data = $request->only('wo_no',  'connectivity_requirement_id', 'grand_total', 'effective_date', 'contract_duration',  'remarks', 'offer_id', 'account_holder', 'client_no', 'mq_no', 'employee_id');
            $data['sla'] = $this->uploadFile->handleFile($request->sla, 'sales/sale');
            $data['work_order'] = $this->uploadFile->handleFile($request->work_order, 'sales/sale');
            $data['is_modified'] = 1;
            $sale = Sale::create($data);
            $detailsData = $this->makeRow($request->all(), $sale->id);
            $saleDetail = SaleDetail::create($detailsData);
            $saleService = $this->makeServiceRow($request->all(), $saleDetail);
            $saleLink = $this->makeLinkRow($request->all(), $saleDetail);
            SaleLinkDetail::insert($saleLink);
            SaleProductDetail::insert($saleService);
            DB::commit();
            return redirect()->route('sales-modification.index')->with('success', 'Sales Created Successfully');
        } catch (Exception $err) {
            DB::rollBack();
            return redirect()->back()->with('error', $err->getMessage())->withInput();
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
        $sale = Sale::where('id', $id)->first();
        $frNo = $sale->saleDetails->first()->fr_no;
        $oldSale = Sale::whereHas('saleDetails', function ($query) use ($frNo) {
            $query->where('fr_no', $frNo);
        })->with(['saleDetails' => function ($query) use ($frNo) {
            $query->where('fr_no', $frNo);
        }])
            ->first();
        $divisions = Division::latest()->get();
        $billing_address = BillingAddress::where('client_no', $sale->client_no)->get();
        $collection_address = CollectionAddress::where('client_no', $sale->client_no)->get();
        return view('changes::modify_sales.create', compact('sale', 'divisions', 'billing_address', 'collection_address', 'oldSale'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $sale = Sale::where('id', $id)->first();
        $data = $request->only('wo_no', 'connectivity_requirement_id', 'grand_total', 'effective_date', 'contract_duration',  'remarks', 'offer_id', 'account_holder', 'client_no', 'mq_no', 'employee_id');
        if ($request->hasFile('sla')) {
            $data['sla'] = $this->uploadFile->handleFile($request->sla, 'sales/sale', $sale->sla);
        } else {
            $data['sla'] = $sale->sla;
        }
        if ($request->hasFile('work_order')) {
            $data['work_order'] = $this->uploadFile->handleFile($request->work_order, 'sales/sale', $sale->work_order);
        } else {
            $data['work_order'] = $sale->work_order;
        }

        try {
            DB::beginTransaction();
            $sale->update($data);
            $detailsData = $this->makeRow($request->all(), $sale->id);
            $sale->saleDetails()->delete();
            $saleDetail = SaleDetail::create($detailsData);

            $saleService = $this->makeServiceRow($request->all(), $saleDetail);
            $sale->saleLinkDetails()->delete();
            $sale->saleProductDetails()->delete();
            $saleLink = $this->makeLinkRow($request->all(), $saleDetail, true);
            SaleLinkDetail::insert($saleLink);
            SaleProductDetail::insert($saleService);
            DB::commit();
            return redirect()->route('sales-modification.index')->with('success', 'Sales Updated Successfully');
        } catch (Exception $err) {
            DB::rollBack();
            return redirect()->back()->with('error', $err->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $sale = Sale::where('id', $id)->first();
        try {
            DB::beginTransaction();
            $this->uploadFile->deleteFile($sale->sla);
            $this->uploadFile->deleteFile($sale->work_order);
            $sale->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Sales Deleted Successfully');
        } catch (Exception $err) {
            DB::rollBack();
            return redirect()->back()->with('error', $err->getMessage())->withInput();
        }
    }

    private function makeRow($raw, $sale_id)
    {
        $data = [
            'sale_id'               => $sale_id,
            'checked'               => (isset($raw['checked']) && isset($raw['checked'])) ? 1 : 0,
            'fr_no'                 => $raw['fr_no'],
            'costing_id'            => $raw['costing_id'],
            'client_no'             => $raw['client_no'],
            'delivery_date'         => $raw['delivery_date'],
            'billing_address_id'    => $raw['billing_address_id'],
            'collection_address_id' => $raw['collection_address_id'],
            // 'bill_payment_date'     => $raw['bill_payment_date'],
            // 'payment_status'        => $raw['payment_status'],
            'mrc'                   => $raw['mrc'],
            'otc'                   => $raw['otc'],
            'total_mrc'             => $raw['total_mrc']
        ];
        // dd($data);
        return $data;
    }

    private function makeServiceRow($raw, $saleDetail, $includeCreatedAt = false)
    {
        $data = [];
        foreach ($raw['product_name'] as $key => $value) {
            $rowData = [
                'product_name'      => $raw['product_name'][$key],
                'fr_no'             => $raw['fr_no'],
                'product_id'        => $raw['product_id'][$key],
                'quantity'          => $raw['quantity'][$key],
                'unit'              => $raw['unit'][$key],
                'rate'              => $raw['rate'][$key],
                'price'             => $raw['price'][$key],
                'total_price'       => $raw['total_price'][$key],
                'vat_amount'        => $raw['vat_amount'][$key],
                'vat_percent'       => $raw['vat_percent'][$key],
                'sale_id'           => $saleDetail['sale_id'],
                'sale_detail_id'    => $saleDetail['id'],
                'updated_at'        => now()
            ];
            if ($includeCreatedAt) {
                $rowData['created_at'] = now();
            }
            $data[] = $rowData;
        }
        return $data;
    }


    private function makeLinkRow($raw, $saleDetail, $includeCreatedAt = false)
    {
        $data = [];
        // if(!empty($raw['link_no'])){
        foreach ($raw['link_no'] as $key1 => $value) {
            $rowData = [
                'link_no'           => $raw['link_no'][$key1],
                'client_no'         => $raw['client_no'],
                'link_type'         => $raw['link_type'][$key1],
                'fr_no'             => $raw['fr_no'],
                'sale_id'           => $saleDetail['sale_id'],
                'sale_detail_id'    => $saleDetail['id'],
                'updated_at'        => now()
            ];
            if ($includeCreatedAt) {
                $rowData['created_at'] = now();
            }
            $data[] = $rowData;
        }
        // }

        return $data;
    }

    public function getFrWisePnlReport($fr_no)
    {
        $connectivityRequirements = ConnectivityRequirement::where('fr_no', $fr_no)->get();
        $total_investment = 0;
        $total_budget = 0;
        $total_revenue = 0;
        $total_monthly_pnl = 0;
        $total_pnl = 0;
        $grand_total_monthly_cost = 0;
        $total_yearly_pnl = 0;
        $grand_total_otc = 0;
        $total_product_cost = 0;
        $sum_of_monthly_cost = 0;
        $pnl_data = [];
        foreach ($connectivityRequirements as $connectivityRequirement) {
            if ($connectivityRequirement->is_modified == '0') {
                if ($connectivityRequirement->costing) {
                    $month = $connectivityRequirement->costing->month;
                    $total_otc = $connectivityRequirement->offerDetail->total_offer_otc;
                    $investment = $connectivityRequirement->costing->costingLinks->sum('investment');
                    $product_cost = $connectivityRequirement->costing->product_total_cost + $connectivityRequirement->costing->total_operation_cost;
                    $monthly_cost = ($investment - $total_otc) / $month + $connectivityRequirement->costing->costingLinks->sum('capacity_amount');
                    $total_monthly_cost = $monthly_cost + $product_cost;
                    $monthly_revenue = $connectivityRequirement->offerDetail->grand_total;
                    $total_investment += $investment;
                    $grand_total_otc += $total_otc;
                    $total_product_cost += $product_cost;
                    $sum_of_monthly_cost += $monthly_cost;
                    $total_budget += $total_monthly_cost;
                    $grand_total_monthly_cost += $total_monthly_cost * $month;
                    $total_revenue += $monthly_revenue;
                    $monthly_pnl = $monthly_revenue - $total_monthly_cost;
                    $total_monthly_pnl += $monthly_pnl;
                    $total_yearly_pnl += $monthly_pnl * $month;
                    $data = [
                        'connectivity_point' => $connectivityRequirement->connectivity_point,
                        'pnl' => $monthly_pnl
                    ];
                }
                array_push($pnl_data, $data);
            } else {
                $costing = Costing::where('connectivity_requirement_id', $connectivityRequirement->id)->first();
                if ($costing) {
                    $month = $costing->month;
                    $total_otc = $connectivityRequirement->offerDetail->total_offer_otc;
                    $investment = $costing->costingLinks->sum('investment');
                    $product_cost = $costing->product_total_cost + $costing->total_operation_cost;
                    $monthly_cost = ($investment - $total_otc) / $month + $costing->costingLinks->sum('capacity_amount') + $connectivityRequirement->offerDetail->equipment_total_mrc;
                    $total_monthly_cost = $monthly_cost + $product_cost;
                    $monthly_revenue = $connectivityRequirement->offerDetail->grand_total;
                    $total_investment += $investment;
                    $grand_total_otc += $total_otc;
                    $total_product_cost += $product_cost;
                    $sum_of_monthly_cost += $monthly_cost;
                    $total_budget += $total_monthly_cost;
                    $grand_total_monthly_cost += $total_monthly_cost * $month;
                    $total_revenue += $monthly_revenue;
                    $monthly_pnl = $monthly_revenue - $total_monthly_cost;
                    $total_monthly_pnl += $monthly_pnl;
                    $total_yearly_pnl += $monthly_pnl * $month;
                    $data = [
                        'connectivity_point' => $connectivityRequirement->connectivity_point,
                        'pnl' => $monthly_pnl
                    ];
                    array_push($pnl_data, $data);
                }
            }
        }

        return $pnl_data;
    }

    public function getClientInfoForSales()
    {
        $offer = Offer::query()
            ->with(['client:id,client_name,client_no', 'offerDetails.costing.costingProducts.product', 'offerDetails.frDetails', 'offerDetails.offerLinks'])
            ->where('connectivity_requirement_id', request()->connectivity_requirement_id)
            ->first();
        $saleDetails = SaleDetail::where('fr_no', $offer->offerDetails->first()->fr_no)->orderBy('id', 'desc')->first();
        $current_plan_links = [];
        $old_plan_links = [];
        $offer->offerDetails->map(function ($item) use (&$current_plan_links) {
            $item->offerLinks->map(function ($link) use (&$current_plan_links, $item) {
                $current_plan_links[] = [
                    'link_no' => $link->link_no,
                    'link_type' => $link->link_type,
                    'fr_no' => $item->fr_no,
                ];
                return $item;
            });
        });

        // dd($oldSale->saleDetails->first()->saleLinkDetails);
        $saleDetails->saleLinkDetails->map(function ($item) use (&$old_plan_links) {
            $old_plan_links[] = [
                'link_no' => $item->link_no,
                'link_type' => $item->planLinkDetail->link_type,
                'fr_no' => $item->fr_no,
            ];
            return $item;
        });



        // $oldSaleDetail->map(function ($item) use (&$old_plan_links) {
        //     $old_plan_links[] = [
        //         'link_no' => $item->link_no,
        //         'link_type' => $item->planLinkDetail->link_type,
        //         'fr_no' => $item->fr_no,
        //     ];
        //     return $item;
        // });
        // dd('current_plan_links', $current_plan_links, 'old_plan_links', $old_plan_links);

        $offerLinks = array_merge($old_plan_links, $current_plan_links);
        $offerLinks = array_unique($offerLinks, SORT_REGULAR);
        $offer->offerDetails->map(function ($item) use ($offerLinks) {
            $item->mergedLinks = collect($offerLinks)->where('fr_no', $item->fr_no)->toArray();
        });


        $offer['billing_address'] = BillingAddress::where('client_no', $offer->client_no)->get();
        $offer['collection_address'] = CollectionAddress::where('client_no', $offer->client_no)->get();
        $offer->toArray();
        return response()->json($offer);
    }

    public function pnlSummary($connectivity_requirement_id = null)
    {
        $connectivity_requirement = ConnectivityRequirement::where('id', $connectivity_requirement_id)->first();
        $sale = Sale::where('connectivity_requirement_id', $connectivity_requirement_id)->first();
        return view('changes::modify_pnl.pnl_summary', compact('connectivity_requirement', 'sale', 'connectivity_requirement_id'));
    }

    public function pnlDetails($connectivity_requirement_id = null)
    {
        $connectivity_requirement = ConnectivityRequirement::where('id', $connectivity_requirement_id)->first();
        if ($connectivity_requirement) {
            $connectivity_requirement->costingByConnectivity->costingProducts->map(function ($item) {
                $item->sale_product = SaleProductDetail::where('product_id', $item->product_id)->where('fr_no', $item->fr_no)->first();
                return $item;
            });
        }
        return view('changes::modify_pnl.pnl_details', compact('connectivity_requirement', 'connectivity_requirement_id'));
    }

    public function pnlApproveByFinance($connectivity_requirement_id = null)
    {
        $sales = Sale::where('connectivity_requirement_id', $connectivity_requirement_id)->first();
        $sales->update([
            'finance_approval' => 'Approved',
            'finance_approved_by' => auth()->user()->id
        ]);
        return redirect()->back()->with('success', 'Approved Successfully');
    }

    public function pnlApproveByCmo($connectivity_requirement_id = null)
    {
        $sales = Sale::where('connectivity_requirement_id', $connectivity_requirement_id)->first();
        $sales->update([
            'cmo_approval' => 'Approved',
            'cmo_approved_by' => auth()->user()->id
        ]);
        return redirect()->back()->with('success', 'Approved Successfully');
    }

    public function pnlApproveByManagement($connectivity_requirement_id = null)
    {
        try {
            DB::beginTransaction();

            $saleDetails = SaleDetail::with('saleLinkDetails.planLinkDetail')
                ->whereHas('sale', function ($q) use ($connectivity_requirement_id) {
                    $q->where('connectivity_requirement_id', $connectivity_requirement_id);
                })->get();


            $lastMRSId = ScmRequisition::latest()->first();
            $currentYear = now()->format('Y');
            $mrsNoCounter = $lastMRSId ? $lastMRSId->id + 1 : 1;

            foreach ($saleDetails as $saleDetail) {
                foreach ($saleDetail->saleLinkDetails as $saleLinkDetail) {
                    // dump($saleLinkDetail->finalSurveyDetails->toArray());
                    $nttn_req = [
                        'client_no' => $saleLinkDetail->client_no,
                        'fr_no' => $saleLinkDetail->fr_no,
                        'type' => 'Client',
                        'date' => now()->format('d-m-Y'),
                        'from_pop_id' => $saleLinkDetail->finalSurveyDetails->pop_id ?? null,
                        'vendor_id' => $saleLinkDetail->finalSurveyDetails->vendor_id ?? null,
                        'capacity' => $saleLinkDetail->planLinkDetail->new_transmission_capacity,
                    ];

                    NetServiceRequisition::create($nttn_req);

                    if ($saleDetail->saleLinkDetails()->exists()) {
                        $mrsNoCounter++;
                        $mrsNo = 'MRS-' . $currentYear . '-' . $mrsNoCounter;

                        $link_equipment_requisition = [
                            "client_no"         => $saleDetail->client_no,
                            "mrs_no"            => $mrsNo,
                            "fr_no"             => $saleDetail->fr_no,
                            "type"              => 'client',
                            "requisition_by"    => auth()->id(),
                            "branch_id"         => 1,
                            "date"              => now()->format('d-m-Y'),
                        ];
                        $link_equipment_requisitionData = ScmRequisition::create($link_equipment_requisition);

                        $link_eqp_details = [];
                        foreach ($saleLinkDetail->planLinkDetail->PlanLinkEquipments as $planLinkEquipment) {
                            $link_eqp_details[] = [
                                "material_id"   => $planLinkEquipment->material_id,
                                "item_code"     => $planLinkEquipment->material->code,
                                "req_key"     => $link_equipment_requisitionData->id . '-' . $planLinkEquipment->material->code,
                                "brand_id"      => $planLinkEquipment->brand_id,
                                "quantity"      => $planLinkEquipment->quantity,
                                "model"         => $planLinkEquipment->model,
                            ];
                        }
                        $link_equipment_requisitionData->scmRequisitiondetails()->createMany($link_eqp_details);
                    }
                }
                $sale = Sale::where('connectivity_requirement_id', $connectivity_requirement_id)->first();
                // dd($sale->costingByConnectivity->planningByConnectivity->equipmentPlans());
                if ($sale->costingByConnectivity->planningByConnectivity->equipmentPlans()->exists()) {
                    $mrsNoCounter++;
                    $mrsNo = 'MRS-' . $currentYear . '-' . $mrsNoCounter;

                    $product_equipment_requisitions = [
                        "client_no"         => $saleDetail->client_no,
                        "mrs_no"            => $mrsNo,
                        "fr_no"             => $saleDetail->fr_no,
                        "type"              => 'client',
                        "requisition_by"    => auth()->id(),
                        "branch_id"         => 1,
                        "date"              => now()->format('d-m-Y'),
                    ];

                    $product_equipment_requisitionsData = ScmRequisition::create($product_equipment_requisitions);
                    $product_eqp_details = [];
                    foreach ($sale->costingByConnectivity->planningByConnectivity->equipmentPlans as $equipmentPlan) {
                        $product_eqp_details[] = [
                            "material_id"   => $equipmentPlan->material_id,
                            "item_code"     => $equipmentPlan->material->code,
                            "req_key"       => $product_equipment_requisitionsData->id . '-' . $equipmentPlan->material->code,
                            "brand_id"      => $equipmentPlan->brand_id,
                            "quantity"      => $equipmentPlan->quantity,
                            "model"         => $equipmentPlan->model,
                        ];
                    }
                    $product_equipment_requisitionsData->scmRequisitiondetails()->createMany($product_eqp_details);
                }
            }
            // dd();

            $datas = Planning::with('equipmentPlans.material', 'planLinks.PlanLinkEquipments.material')
                ->where('connectivity_requirement_id', $connectivity_requirement_id)
                ->get();
            $material_array = [];

            foreach ($datas as $key => $values) {

                $cle_data = CostingLinkEquipment::whereHas('costing', function ($qr) use ($values) {
                    $qr->where("connectivity_requirement_id", $values->connectivity_requirement_id)->where('ownership', 'Client');
                })->get();

                $cpe_data = CostingProductEquipment::whereHas('costing', function ($qr) use ($values) {
                    $qr->where("connectivity_requirement_id", $values->connectivity_requirement_id)->where('ownership', 'Client');
                })->get();
                $sale = Sale::where('connectivity_requirement_id', $values->connectivity_requirement_id)->first();
                $saleData = SaleDetail::where('sale_id', $sale->id)->get()->first();
                if (!$saleData) {
                    continue;
                }
                $otc_lines_data = [];
                $equipment_amount = 0;


                foreach ($cle_data as $cle_data_key => $cle_data_values) {
                    $otc_lines_data[] = [
                        'material_id' => $cle_data_values->material_id,
                        'quantity' => $cle_data_values->quantity,
                        'rate' => $cle_data_values->rate,
                        'amount' => $cle_data_values->rate * $cle_data_values->quantity,
                    ];
                    $equipment_amount += $cle_data_values->rate * $cle_data_values->quantity;
                }

                foreach ($cpe_data as $cpe_data_key => $cpe_data_values) {
                    $otc_lines_data[] = [
                        'material_id' => $cpe_data_values->material_id,
                        'quantity' => $cpe_data_values->quantity,
                        'rate' => $cpe_data_values->rate,
                        'amount' => $cpe_data_values->rate * $cpe_data_values->quantity,
                    ];
                    $equipment_amount += $cpe_data_values->rate * $cpe_data_values->quantity;
                }
                $TotalAmount = $saleData->otc;
                $installation_charge = -1 * ($TotalAmount - $equipment_amount);
                $otc = [
                    'client_no' =>  $values->client_no,
                    'fr_no' =>  $values->fr_no,
                    'sale_id' => $saleData->sale_id,
                    'sale_detail_id' => $saleData->id,
                    'date' =>  Carbon::now()->format('Y-m-d'),
                    'user_id' => auth()->id(),
                    'equipment_amount' => $equipment_amount,
                    'installation_charge' => $installation_charge,
                    'total_amount' => $TotalAmount,
                ];

                $otc_data = BillingOtcBill::create($otc);
                $otc_data->lines()->createMany($otc_lines_data);

                // if (count($values->equipmentPlans)) {
                //     $material_array[$key]['parent']['main'] = [
                //         "client_no"         => $values->client_no,
                //         "fr_no"             => $values->fr_no,
                //         "type"              => 'client',
                //         "requisition_by"    => auth()->id(),
                //         "branch_id"         => 1,
                //         "date"              => now()->format('d-m-Y'),
                //     ];
                //     foreach ($values->equipmentPlans as $key2 => $values2) {
                //         $material_array[$key]['parent']['child'][] = [
                //             "material_id"   => $values2->material_id,
                //             "item_code"     => $values2->material->code,
                //             "brand_id"      => $values2->brand_id,
                //             "quantity"      => $values2->quantity,
                //             "model"         => $values2->model,
                //         ];
                //     }
                // }

                // foreach ($values->planLinks as $key2 => $values2) {
                //     $material_array[$key]['link'][$key2]['main'] = [
                //         "client_no"         => $values->client_no,
                //         "fr_no"             => $values->fr_no,
                //         "link_no"           => $values2->link_no,
                //         "type"              => 'client',
                //         "requisition_by"    => auth()->id(),
                //         "branch_id"         => 1,
                //         "date"              => now()->format('d-m-Y'),
                //     ];
                //     foreach ($values2->PlanLinkEquipments as $key3 => $values3) {
                //         $material_array[$key]['link'][$key2]['child'][] = [
                //             "material_id"   => $values3->material_id,
                //             "item_code"     => $values3->material->code,
                //             "brand_id"      => $values3->brand_id,
                //             "quantity"      => $values3->quantity,
                //             "model"         => $values3->model,
                //         ];
                //     } 
                //  }
            }
            // $lastMRSId = ScmRequisition::latest()->first();
            // $currentYear = now()->format('Y');
            // $mrsNoCounter = $lastMRSId ? $lastMRSId->id + 1 : 1;
            /* foreach ($material_array as $key => $value) {
                if (isset($value['parent'])) {
                    $mrsNo = 'MRS-' . $currentYear . '-' . $mrsNoCounter;
                    $mrsNoCounter++;
                    $value['parent']['main']['mrs_no'] = $mrsNo;
                    // $reqq = ScmRequisition::create($value['parent']['main']);
                    // $reqChildItems = collect($value['parent']['child'])->map(function ($child) use ($reqq) {
                    //     $child['req_key'] = $reqq->id . '-' . $child['item_code'];
                    //     return $child;
                    // });
                    // $reqq->scmRequisitiondetails()->createMany($reqChildItems);
                }
                foreach ($value['link'] as $key1 => $value1) {
                    $mrsNo = 'MRS-' . $currentYear . '-' . $mrsNoCounter;
                    $mrsNoCounter++;
                    $value1['main']['mrs_no'] = $mrsNo;
                    // $reqq = ScmRequisition::create($value1['main']);
                    // $reqChildItems = collect($value1['child'])->map(function ($child) use ($reqq) {
                    //     $child['req_key'] = $reqq->id . '-' . $child['item_code'];
                    //     return $child;
                    // });
                    // $reqq->scmRequisitiondetails()->createMany($reqChildItems);
                }
            } */
            $sales = Sale::where('connectivity_requirement_id', $connectivity_requirement_id)->first();
            $sales->update([
                'management_approval' => 'Approved',
                'management_approved_by' => auth()->user()->id,
                'approval_date'  => now()
            ]);

            DB::commit();
            return redirect()->route('modify-pnl-summary', $connectivity_requirement_id)->with('success', 'Approved Successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('modify-pnl-summary', $connectivity_requirement_id)->with('error', $e->getMessage());
        }
    }
}
