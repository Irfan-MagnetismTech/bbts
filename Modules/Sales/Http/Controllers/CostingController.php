<?php

namespace Modules\Sales\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Sales\Entities\Costing;
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
        dd($request->all());
        $costing_data = $request->only('client_id', 'connectivity_point_name', 'month', 'product_total_cost', 'total_operation_cost', 'total_cost_amount', );
        $costing = Costing::create($costing_data);
        foreach ($request->product as $product) {
            $product_data = [
                'costing_id' => $costing->id,
                'product_id' => $product['product_id'],
                'product_name' => $product['product_name'],
                'product_rate' => $product['product_rate'],
                'product_quantity' => $product['product_quantity'],
                'product_total' => $product['product_total'],
                'product_unit' => $product['product_unit'],
                'product_operation_cost' => $product['product_operation_cost'],
                'product_total_operation_cost' => $product['product_total_operation_cost'],
                'offer_price' => $product['offer_price'],
                'product_offer_total' => $product['product_offer_total'],
            ];
            $costing_product = CostingProduct::create($product_data);
        }

        foreach ($request->material_id as $material) {
            $material_data = [
                'costing_id' => $costing->id,
                'material_id' => $material['material_id'],
                'equipment_quantity' => $material['equipment_quantity'],
                'equipment_rate' => $material['equipment_rate'],
                'equipment_total' => $material['equipment_total'],
                'equipment_unit' => $material['equipment_unit'],
                'equipment_ownership' => $material['equipment_ownership'],
            ];
            $costing_material = CostingProductEquipment::create($material_data);
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
