<?php

namespace Modules\Changes\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Sales\Entities\Costing;
use Modules\Sales\Entities\CostingLink;
use Modules\Sales\Entities\CostingLinkEquipment;
use Modules\Sales\Entities\CostingProduct;
use Modules\Sales\Entities\CostingProductEquipment;
use Modules\Sales\Entities\FeasibilityRequirement;
use Modules\Sales\Entities\FeasibilityRequirementDetail;
use Modules\Sales\Entities\Planning;
use Modules\Sales\Entities\Sale;

class CostingModificationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $costings = Costing::with('costingProducts', 'costingLinks', 'costingLinks.costingLinkEquipments')->where('is_modified', 1)->latest()->get();
        return view('changes::modify_costing.index', compact('costings'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($connectivity_requirement_id = null)
    {
        // Load the planning data
        $planning = Planning::with('equipmentPlans.material', 'servicePlans.connectivityProductRequirementDetails.product', 'planLinks.PlanLinkEquipments.material')
            ->where('connectivity_requirement_id', $connectivity_requirement_id)
            ->where('is_modified', 1)
            ->first();

        // Load the old sale data
        $old_sale = Sale::query()
            ->whereHas('saleDetails', function ($query) use ($planning) {
                $query->where('fr_no', $planning->fr_no);
            })
            ->with(['saleDetails' => function ($query) use ($planning) {
                $query->where('fr_no', $planning->fr_no)->with('saleProductDetails');
            }])
            ->first();

        // Iterate through service plans and merge data into $planning
        $sale_products = [];
        foreach ($old_sale->saleDetails as $key => $saleDetail) {
            foreach ($saleDetail->saleProductDetails as $key => $saleProductDetail) {
                $sale_products[] = [
                    'product_id' => $saleProductDetail->product_id,
                    'product_name' => $saleProductDetail->product->name,
                    'unit' => $saleProductDetail->unit,
                    'vat' => $saleProductDetail->vat_percent,
                    'quantity' => $saleProductDetail->quantity,
                    'rate' => $saleProductDetail->rate,
                ];
            }
        }


        $service_products = [];
        $servicePlanProduct = $planning->servicePlans->pluck('connectivityProductRequirementDetails')->toArray();
        foreach ($servicePlanProduct as $key => $product) {
            $service_products[] = [
                'product_id' => $product['product_id'],
                'product_name' => $product['product']['name'],
                'unit' => $product['product']['unit'],
                'vat' => $product['product']['vat'],
                'quantity' => $product['capacity'],
                'rate' => 0,
            ];
        }

        $sale_products_assoc = [];
        foreach ($sale_products as $sale_product) {
            $product_id = $sale_product['product_id'];
            $sale_products_assoc[$product_id] = $sale_product;
        }

        // Convert $service_products to an associative array indexed by product_id
        $service_products_assoc = [];
        foreach ($service_products as $service_product) {
            $product_id = $service_product['product_id'];
            $service_products_assoc[$product_id] = $service_product;
        }

        $products = $service_products_assoc + $sale_products_assoc;

        // dd($products);
        // foreach ($service_products as $key => $service_product) {
        //     if ($service_product['product_id'] != $sale_products['product_id'][$key]) {
        //         array_push($sale_products[$key], $service_product);
        //     }
        // }

        $feasibilityRequirementDetail = $planning->feasibilityRequirementDetail;
        $pnl_summary_data = $this->getPNLSummary($planning);
        return view('changes::modify_costing.create', compact('planning', 'feasibilityRequirementDetail', 'pnl_summary_data', 'products'));
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

            $costingData = $request->all();
            $costingData['created_by'] = auth()->user()->id;
            $costingData['is_modified'] = 1;
            $costing = Costing::create($costingData);

            $this->createOrUpdateCostingProducts($request, $costing);

            $this->createOrUpdateCostingMaterials($request, $costing);

            $this->createOrUpdateCostingLinks($request, $costing);

            DB::commit();
            // return response()->json(['message' => 'Data saved successfully.']);
            return redirect()->route('costing-modification.index')->with('success', 'Data saved successfully.');
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
        return view('sales::modify_costing.edit', compact('costing'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $costing = Costing::with('costingProducts', 'costingProductEquipments', 'costingLinks.costingLinkEquipments', 'lead_generation', 'feasibilityRequirementDetail')->find($id);
        $feasibilityRequirementDetail = $costing->feasibilityRequirementDetail;
        $pnl_summary_data = $this->getPNLSummary($costing);
        return view('changes::modify_costing.edit', compact('costing', 'feasibilityRequirementDetail', 'pnl_summary_data'));
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
        //
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

    public function getPNLSummary($helperdata)
    {

        $mq_no = $helperdata->feasibilityRequirementDetail->feasibilityRequirement->mq_no;
        $feasibility_requirement = FeasibilityRequirement::with('feasibilityRequirementDetails.offerDetail', 'feasibilityRequirementDetails.costing.costingLinks')->where('mq_no', $mq_no)->first();
        $sale = Sale::where('mq_no', $mq_no)->first();
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
        foreach ($feasibility_requirement->feasibilityRequirementDetails as $details) {
            if ($details->costing) {
                $month = $details->costing->month;
                $total_otc = $details->offerDetail->total_offer_otc;
                $investment = $details->costing->costingLinks->sum('investment');
                $product_cost = $details->costing->product_total_cost + $details->costing->total_operation_cost;
                $monthly_cost = ($investment - $total_otc) / $month + $details->costing->costingLinks->sum('capacity_amount') + $details->offerDetail->equipment_total_mrc;
                $total_monthly_cost = $monthly_cost + $product_cost;
                $monthly_revenue = $details->offerDetail->grand_total;
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
                    'connectivity_point' => $details->connectivity_point,
                    'pnl' => $monthly_pnl
                ];
            }
            array_push($pnl_data, $data);
        }
        $existing_connection_data = [
            'total_fr' => $feasibility_requirement->feasibilityRequirementDetails->count(),
            'connection_month' => Carbon::parse($sale->commision_date)->diffInMonths(Carbon::now()),
            'total_revenue' => $total_revenue,
            'pnl_data' => $pnl_data,
        ];
        return $existing_connection_data;
    }
}
