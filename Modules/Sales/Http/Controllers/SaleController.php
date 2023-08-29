<?php

namespace Modules\Sales\Http\Controllers;

use PDF;
use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\UploadService;
use Modules\Sales\Entities\Sale;
use Modules\SCM\Entities\ScmMur;
use Modules\Sales\Entities\Offer;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Sales\Entities\Costing;
use Modules\Sales\Entities\Planning;
use App\Models\Dataencoding\Division;
use App\Models\Dataencoding\Employee;
use Modules\Sales\Entities\SaleDetail;
use Illuminate\Database\QueryException;
use Modules\SCM\Entities\ScmRequisition;
use Modules\Sales\Entities\BillingAddress;
use Modules\Sales\Entities\SaleLinkDetail;
use Illuminate\Contracts\Support\Renderable;
use Modules\Billing\Entities\BillingOtcBill;
use Modules\Sales\Entities\CollectionAddress;
use Modules\Sales\Entities\SaleProductDetail;
use Modules\Sales\Entities\CostingLinkEquipment;
use Modules\Sales\Entities\FeasibilityRequirement;
use Modules\Sales\Entities\CostingProductEquipment;

class SaleController extends Controller
{
    function __construct(private UploadService $uploadFile)
    {
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $sales = Sale::all();
        return view('sales::sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $divisions = Division::latest()->get();
        return view('sales::sales.create', compact('divisions'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->only('wo_no', 'grand_total', 'effective_date', 'contract_duration',  'remarks', 'offer_id', 'account_holder', 'client_no', 'mq_no', 'employee_id');
            $data['sla'] = $this->uploadFile->handleFile($request->sla, 'sales/sale');
            $data['work_order'] = $this->uploadFile->handleFile($request->work_order, 'sales/sale');
            $sale = Sale::create($data);
            $detailsData = $this->makeRow($request->all());
            $saleDetail = $sale->saleDetails()->createMany($detailsData);
            $saleService = $this->makeServiceRow($request->all(), $saleDetail);
            $saleLink = $this->makeLinkRow($request->all(), $saleDetail);
            SaleLinkDetail::insert($saleLink);
            SaleProductDetail::insert($saleService);
            DB::commit();
            return redirect()->route('sales.index')->with('success', 'Sales Created Successfully');
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
    public function show(Sale $sales)
    {
        return view('sales::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param Sale $sales
     * @return Renderable
     */
    public function edit(Sale $sale)
    {
        $divisions = Division::latest()->get();
        $billing_address = BillingAddress::where('client_no', $sale->client_no)->get();
        $collection_address = CollectionAddress::where('client_no', $sale->client_no)->get();
        return view('sales::sales.create', compact('sale', 'divisions', 'billing_address', 'collection_address'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Sale $sales Object
     * @return Renderable
     */
    public function update(Request $request, Sale $sale)
    {
        $data = $request->only('wo_no', 'grand_total', 'effective_date', 'contract_duration',  'remarks', 'offer_id', 'account_holder', 'client_no', 'mq_no', 'employee_id');
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
            $detailsData = $this->makeRow($request->all());
            $sale->saleDetails()->delete();
            $saleDetail = $sale->saleDetails()->createMany($detailsData);
            $saleService = $this->makeServiceRow($request->all(), $saleDetail);
            $sale->saleLinkDetails()->delete();
            $sale->saleProductDetails()->delete();
            $saleLink = $this->makeLinkRow($request->all(), $saleDetail, true);
            SaleLinkDetail::insert($saleLink);
            SaleProductDetail::insert($saleService);
            DB::commit();
            return redirect()->route('sales.index')->with('success', 'Sales Updated Successfully');
        } catch (Exception $err) {
            DB::rollBack();
            return redirect()->back()->with('error', $err->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param Sale $sales
     * @return Renderable
     */
    public function destroy(Sale $sale)
    {
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

    private function makeRow($raw)
    {
        $data = [];
        foreach ($raw['fr_no'] as $key => $value) {
            $data[] = [
                'checked'               => (isset($raw['checked']) && isset($raw['checked'][$key])) ? 1 : 0,
                'fr_no'                 => $raw['fr_no'][$key],
                'costing_id'            => $raw['costing_id'][$key],
                'client_no'             => $raw['client_no'],
                'delivery_date'         => $raw['delivery_date'][$key],
                'billing_address_id'    => $raw['billing_address_id'][$key],
                'collection_address_id' => $raw['collection_address_id'][$key],
                'bill_payment_date'     => $raw['bill_payment_date'][$key],
                'payment_status'        => $raw['payment_status'][$key],
                'mrc'                   => $raw['mrc'][$key],
                'otc'                   => $raw['otc'][$key],
                'total_mrc'             => $raw['total_mrc'][$key]
            ];
        }
        return $data;
    }

    private function makeServiceRow($raw, $saleDetail, $includeCreatedAt = false)
    {
        $data = [];
        foreach ($raw['fr_no'] as $key => $value) {
            foreach ($raw['product_name'][$key] as $key1 => $value) {
                $rowData = [
                    'product_name'      => $raw['product_name'][$key][$key1],
                    'fr_no'             => $raw['fr_no'][$key],
                    'product_id'        => $raw['product_id'][$key][$key1],
                    'quantity'          => $raw['quantity'][$key][$key1],
                    'unit'              => $raw['unit'][$key][$key1],
                    'rate'              => $raw['rate'][$key][$key1],
                    'price'             => $raw['price'][$key][$key1],
                    'total_price'       => $raw['total_price'][$key][$key1],
                    'vat_amount'        => $raw['vat_amount'][$key][$key1],
                    'total_amount'        => $raw['total_amount'][$key][$key1],
                    'sale_id'           => $saleDetail[$key]['sale_id'],
                    'sale_detail_id'    => $saleDetail[$key]['id'],
                    'updated_at'        => now()
                ];
                if ($includeCreatedAt) {
                    $rowData['created_at'] = now();
                }
                $data[] = $rowData;
            }
        }
        return $data;
    }


    private function makeLinkRow($raw, $saleDetail, $includeCreatedAt = false)
    {
        $data = [];
        foreach ($raw['fr_no'] as $key => $value) {
            foreach ($raw['link_no'][$key] as $key1 => $value) {
                $rowData = [
                    'link_no'           => $raw['link_no'][$key][$key1],
                    'client_no'         => $raw['client_no'],
                    'link_type'         => $raw['link_type'][$key][$key1],
                    'fr_no'             => $raw['fr_no'][$key],
                    'sale_id'           => $saleDetail[$key]['sale_id'],
                    'sale_detail_id'    => $saleDetail[$key]['id'],
                    'updated_at'        => now()
                ];
                if ($includeCreatedAt) {
                    $rowData['created_at'] = now();
                }
                $data[] = $rowData;
            }
        }
        return $data;
    }

    public function getClientInfoForSales()
    {
        $items = Offer::query()
            ->with(['client', 'offerDetails.costing.costingProducts.product', 'offerDetails.frDetails', 'offerDetails.offerLinks'])
            ->whereHas('client', function ($qr) {
                return $qr->where('client_name', 'like', '%' . request()->search . '%');
            })
            ->get()
            ->map(fn ($item) => [
                'value'                 => $item->client->client_name,
                'label'                 => $item->client->client_name . ' ( ' . ($item?->mq_no ?? '') . ' )',
                'client_no'             => $item->client_no,
                'client_id'             => $item->client->id,
                'offer_id'              => $item->id,
                'mq_no'                 => $item->mq_no,
                'billing_address'       => BillingAddress::where('client_no', $item->client_no)->get(),
                'collection_address'    => CollectionAddress::where('client_no', $item->client_no)->get(),
                'details'               => $item->offerDetails
            ]);
        return response()->json($items);
    }

    public function getFrsBasedOnMq()
    {
        $items = Offer::query()
            ->with(['client'])
            ->where('mq_no', 'like', '%' . request()->search . '%')
            ->get()
            ->map(fn ($item) => [
                'value'        => $item->mq_no,
                'label'        => $item->mq_no . '( ' . ($item?->client?->client_name ?? '') . ' )',
                'client_no'    => $item->client_no,
                'client_name'  => $item?->client?->client_name,
                'offer_id'     => $item->id,
                'mq_no'        => $item->mq_no
            ]);
        return response()->json($items);
    }

    public function testTestTest()
    {
        $lists = BillingAddress::where('client_no', request()->client_no)->get()->latest();
        $lists = CollectionAddress::where('client_no', request()->client_no)->get()->latest();
    }


    public function getEmployees()
    {
        $items = Employee::where('name', 'like', '%' . request()->search . '%')
            ->get()
            ->map(fn ($item) => [
                'value'        => $item->name,
                'label'        => $item->name,
                'id'           => $item->id
            ]);
        return response()->json($items);
    }

    public function updateAddress(Request $request)
    {
        try {
            DB::beginTransaction();
            $data['address'] = $request->address_add;
            $data['client_id'] = $request->client_id;
            $data['client_no'] = $request->client_no_add;
            $data['contact_person'] = $request->contact_person_add;
            $data['designation'] = $request->designation_add;
            $data['phone'] = $request->phone_add;
            $data['email'] = $request->email_add;
            $data['division_id'] = $request->division_id;
            $data['district_id'] = $request->district_id;
            $data['thana_id'] = $request->thana_id;
            $data['fr_no'] = $request->fr;
            if ($request->update_type == 'billing') {
                $data['submission_date'] = $request->submission_date_add;
                $data['submission_by'] = $request->submission_by_add;
                BillingAddress::create($data);
                $listData = BillingAddress::where('client_no', $request->client_no_add)->get();
            } else {
                $data['payment_method'] = $request->payment_method_add;
                $data['payment_date'] = $request->payment_date_add;
                CollectionAddress::create($data);
                $listData = CollectionAddress::where('client_no', $request->client_no_add)->get();
            }
            DB::commit();
            return response()->json(['status' => 'success', 'listdata' => $listData, 'messsage' => 'Address Added Successfully'], 200);
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), 500);
        }
    }

    public function pnlSummary($mq_no = null)
    {
        $feasibility_requirement = FeasibilityRequirement::with('feasibilityRequirementDetails.costing')
            // ->withSum('feasibilityRequirementDetails.costing', 'total_otc_with_client_equipment')
            ->where('mq_no', $mq_no)->first();
        $sale = Sale::where('mq_no', $mq_no)->first();

        // dd($feasibility_requirement);
        return view('sales::pnl.pnl_summary', compact('feasibility_requirement', 'mq_no', 'sale'));
    }

    public function pnlDetails($mq_no = null)
    {
        $feasibility_requirement = FeasibilityRequirement::with('feasibilityRequirementDetails.costing.costingProducts')
            ->where('mq_no', $mq_no)->first();
        if ($feasibility_requirement) {
            $feasibility_requirement->feasibilityRequirementDetails->map(function ($item) {
                if ($item->costing) {
                    $item->costing->costingProducts->map(function ($item) {
                        $item->sale_product = SaleProductDetail::where('product_id', $item->product_id)->where('fr_no', $item->fr_no)->first();
                        return $item;
                    });
                    return $item;
                }
            });
        }
        return view('sales::pnl.pnl_details', compact('feasibility_requirement', 'mq_no'));
    }

    public function pnlApproveByFinance($mq_no = null)
    {
        $sales = Sale::where('mq_no', $mq_no)->first();
        $sales->update([
            'finance_approval' => 'Approved',
            'finance_approved_by' => auth()->user()->id
        ]);
        return redirect()->back()->with('success', 'Approved Successfully');
    }

    public function pnlApproveByManagement($mq_no = null)
    {
        try {
            DB::beginTransaction();
            $datas = Planning::with('equipmentPlans.material', 'planLinks.PlanLinkEquipments.material')
                ->where('mq_no', $mq_no)
                ->get();
            // $Costingdatas = Costing::with('costingLinks.costingLinkEquipments', 'costingProductEquipments')
            //     ->where('mq_no', $mq_no)
            //     ->get();
            $material_array = [];
            foreach ($datas as $key => $values) {
                $cle_data = CostingLinkEquipment::whereHas('costing', function ($qr) use ($values) {
                    $qr->where("fr_no", $values->fr_no)->where('ownership', 'Client');
                })->get();


                $cpe_data = CostingProductEquipment::whereHas('costing', function ($qr) use ($values) {
                    $qr->where("fr_no", $values->fr_no)->where('ownership', 'Client');
                })->get();
                $saleData = SaleDetail::where('fr_no', $values->fr_no)->get()->first();
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
                    $equipment_amount += $cle_data_values->rate * $cle_data_values->quantity;
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
                if (count($values->equipmentPlans)) {
                    $material_array[$key]['parent']['main'] = [
                        "client_no"         => $values->client_no,
                        "fr_no"             => $values->fr_no,
                        "type"              => 'client',
                        "requisition_by"    => auth()->id(),
                        "branch_id"         => 1,
                        "date"              => now()->format('d-m-Y'),
                    ];
                    foreach ($values->equipmentPlans as $key2 => $values2) {
                        $material_array[$key]['parent']['child'][] = [
                            "material_id"   => $values2->material_id,
                            "item_code"     => $values2->material->code,
                            "brand_id"      => $values2->brand_id,
                            "quantity"      => $values2->quantity,
                            "model"         => $values2->model,
                        ];
                    }
                }

                foreach ($values->planLinks as $key2 => $values2) {
                    $material_array[$key]['link'][$key2]['main'] = [
                        "client_no"         => $values->client_no,
                        "fr_no"             => $values->fr_no,
                        "link_no"           => $values2->link_no,
                        "type"              => 'client',
                        "requisition_by"    => auth()->id(),
                        "branch_id"         => 1,
                        "date"              => now()->format('d-m-Y'),
                    ];
                    foreach ($values2->PlanLinkEquipments as $key3 => $values3) {
                        $material_array[$key]['link'][$key2]['child'][] = [
                            "material_id"   => $values3->material_id,
                            "item_code"     => $values3->material->code,
                            "brand_id"      => $values3->brand_id,
                            "quantity"      => $values3->quantity,
                            "model"         => $values3->model,
                        ];
                    }
                }
            }
            $lastMRSId = ScmRequisition::latest()->first();
            $currentYear = now()->format('Y');
            $mrsNoCounter = $lastMRSId ? $lastMRSId->id + 1 : 1;
            foreach ($material_array as $key => $value) {
                if (isset($value['parent'])) {
                    $mrsNo = 'MRS-' . $currentYear . '-' . $mrsNoCounter;
                    $mrsNoCounter++;
                    $value['parent']['main']['mrs_no'] = $mrsNo;
                    $reqq = ScmRequisition::create($value['parent']['main']);
                    $reqChildItems = collect($value['parent']['child'])->map(function ($child) use ($reqq) {
                        $child['req_key'] = $reqq->id . '-' . $child['item_code'];
                        return $child;
                    });
                    $reqq->scmRequisitiondetails()->createMany($reqChildItems);
                }
                foreach ($value['link'] as $key1 => $value1) {
                    $mrsNo = 'MRS-' . $currentYear . '-' . $mrsNoCounter;
                    $mrsNoCounter++;
                    $value1['main']['mrs_no'] = $mrsNo;
                    $reqq = ScmRequisition::create($value1['main']);
                    $reqChildItems = collect($value1['child'])->map(function ($child) use ($reqq) {
                        $child['req_key'] = $reqq->id . '-' . $child['item_code'];
                        return $child;
                    });
                    $reqq->scmRequisitiondetails()->createMany($reqChildItems);
                }
            }
            $sales = Sale::where('mq_no', $mq_no)->first();
            $sales->update([
                'management_approval' => 'Approved',
                'management_approved_by' => auth()->user()->id,
                'approval_date'  => now()
            ]);
            DB::commit();
            return redirect()->route('pnl-summary', $mq_no)->with('success', 'Approved Successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('pnl-summary', $mq_no)->with('error', $e->getMessage());
        }
    }

    public function pnlApproveByCmo($mq_no = null)
    {
        $sales = Sale::where('mq_no', $mq_no)->first();
        $sales->update([
            'cmo_approval' => 'Approved',
            'cmo_approved_by' => auth()->user()->id
        ]);
        return redirect()->back()->with('success', 'Approved Successfully');
    }

    public function clientOffer($mq_no = null)
    {
        $offer = Offer::firstWhere('mq_no', $mq_no);

        $offerData = $offer->offerDetails->map(function ($item) {
            $item->total_product = $item->costing->costingProducts->sum(function ($item) {
                return $item->rate * $item->quantity;
            });
            $offer_mrc = $item->total_offer_mrc ?? 0;
            $product_amount = $item->offer_product_amount ?? 0;
            $management_cost = $item->offer_management_cost ?? 0;
            $total_mrc = $offer_mrc + $product_amount + $management_cost;
            $profit_percentage = $item->profit_percentage = (($total_mrc / $item->total_product) * 100) - 100;
            $item->costing->costingProducts->map(function ($item) use ($profit_percentage) {
                $item->product_price = ($item->rate * ($profit_percentage / 100)) + $item->rate;
                return $item;
            });
            // dump($item->toArray());
            return $item;
        });
        // dd();

        $costingProductEquipments = $offer->costing->costingProductEquipments->where('ownership', 'Client');
        $costingLinkEquipments = $offer->costing->costingLinkEquipments->where('ownership', 'Client');
        $mergedEquipments = $costingProductEquipments->merge($costingLinkEquipments);

        $uniqueEquipments = $mergedEquipments->unique('material_id')->map(function ($item) use ($mergedEquipments) {
            $item->sum_quantity = $mergedEquipments->where('material_id', $item->material_id)->sum('quantity');
            $item->total_price = $mergedEquipments->where('material_id', $item->material_id)->sum(function ($item) {
                return $item->rate * $item->quantity;
            });
            return $item;
        });

        return view('sales::offers.client_offer', compact('mq_no', 'offer', 'offerData', 'uniqueEquipments'));
    }
    public function pnlSummaryPdf($mq_no = null)
    {
        $feasibility_requirement = FeasibilityRequirement::with('feasibilityRequirementDetails.costing')
            ->where('mq_no', $mq_no)->first();

        return PDF::loadView('sales::pnl.pnl_summary_pdf', ['feasibility_requirement' => $feasibility_requirement], [], [
            'format'                     => 'A4',
            'orientation'                => 'L',
            'title'                      => 'PNL Summary',
        ])->stream('summary.pdf');
        return view('sales::pnl.pnl_summary_pdf', compact('feasibility_requirement'));
    }
    public function pnlDetailsPdf($mq_no = null)
    {
        $feasibility_requirement = FeasibilityRequirement::with('feasibilityRequirementDetails.costing.costingProducts')
            ->where('mq_no', $mq_no)->first();
        $feasibility_requirement?->feasibilityRequirementDetails->map(function ($item) {
            if ($item->costing) {
                $item->costing->costingProducts->map(function ($item) {
                    $item->sale_product = SaleProductDetail::where('product_id', $item->product_id)->where('fr_no', $item->fr_no)->first();
                    return $item;
                });
                return $item;
            }
            return $item;
        });

        return PDF::loadView('sales::pnl.pnl_details_pdf', ['feasibility_requirement' => $feasibility_requirement], [], [
            'format'                     => 'A4',
            'orientation'                => 'L',
            'title'                      => 'PNL Details',
        ])->stream('details.pdf');
        return view('sales::pnl.pnl_details_pdf', compact('feasibility_requirement'));
    }
}
