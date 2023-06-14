<?php

namespace Modules\Sales\Http\Controllers;

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


class CostingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('sales::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($id = null)
    {
        $feasibilityRequirementDetail = FeasibilityRequirementDetail::find($id);
        $planning = Planning::with('equipmentPlans', 'servicePlans', 'planLinks')->where('fr_no', $feasibilityRequirementDetail->fr_no)->first();
        return view('sales::costing.create', compact('planning', 'feasibilityRequirementDetail'));
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

            $costingData = $request->only('client_no', 'connectivity_point_name', 'month', 'product_total_cost', 'total_operation_cost', 'total_cost_amount', 'product_grand_total', 'equipment_wise_total', 'client_equipment_total', 'equipment_partial_total', 'equipment_deployment_cost', 'equipment_interest', 'equipment_vat', 'equipment_tax', 'equipment_grand_total', 'equipment_otc', 'equipment_roi', 'total_investment', 'total_otc', 'total_product_cost', 'total_service_cost', 'total_mrc', 'management_perchantage', 'management_cost_amount', 'management_cost_total', 'equipment_price_for_client', 'total_otc_with_client_equipment');

            $costing = Costing::create($costingData);

            foreach ($request->product as $key => $product) {
                $productData = [
                    'costing_id' => $costing->id,
                    'product_id' => $product,
                    'quantity' => $request->product_quantity[$key],
                    'rate' => $request->product_rate[$key],
                    'unit' => $request->product_unit[$key],
                    'sub_total' => $request->product_price[$key],
                    'operation_cost' => $request->product_operation_cost[$key],
                    'operation_cost_total' => $request->product_total_cost[$key],
                    'offer_price' => $request->offer_price[$key],
                    'total' => $request->product_offer_total[$key],
                ];
                $costingProduct = CostingProduct::create($productData);
            }

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
                $costingMaterial = CostingProductEquipment::create($materialData);
            }

            for ($rowNo = 1; $rowNo <= request('total_key'); $rowNo++) {
                $costingLinkData = [
                    'costing_id' => $costing->id,
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
                    'interest' => request('plan_equipment_interest_' . $rowNo),
                    'vat' => request('plan_equipment_vat_' . $rowNo),
                    'tax' => request('plan_equipment_tax_' . $rowNo),
                    'grand_total' => request('plan_equipment_grand_total_' . $rowNo),
                    'otc' => request('plan_equipment_otc_' . $rowNo),
                    'roi' => request('plan_equipment_roi_' . $rowNo),
                    'investment' => request('plan_equipment_total_inv_' . $rowNo),
                    'capacity_amount' => request('plan_equipment_capacity_' . $rowNo),
                    'operation_cost' => request('plan_equipment_operation_cost_' . $rowNo),
                    'total_mrc' => request('plan_equipment_total_mrc_' . $rowNo),
                ];
                $costingLink = CostingLink::create($costingLinkData);
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
                    $costingLinkEquipment = CostingLinkEquipment::create($equipmentData);
                }
            }
            DB::commit();
            dd('success');
            return response()->json(['message' => 'Data saved successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to save data. Error: ' . $e->getMessage()], 500);
        }
    }


    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('sales::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('sales::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
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
}