<?php

namespace Modules\SCM\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Admin\Entities\Brand;
use Illuminate\Routing\Controller;
use Illuminate\Database\QueryException;
use Modules\SCM\Entities\PurchaseOrder;
use Illuminate\Contracts\Support\Renderable;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return $purchaseOrders = PurchaseOrder::with('purchaseOrderLines')->get();
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $brands = Brand::latest()->get();

        $vatOrTax = [
            'Include', 'Exclude'
        ];

        return view('scm::purchase-orders.create', compact('brands', 'vatOrTax'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            $purchaseOrderData = $request->only('po_no', 'date', 'comparative_statement_id', 'indent_id', 'remarks', 'trams_of_Supply', 'trams_of_payment', 'trams_of_condition', 'delivery_location', 'created_by', 'branch_id');

            $purchaseOrderLinesData = [];
            foreach ($request->purchase_requisition_id as $key => $data)
            {
                $purchaseOrderLinesData[] = [
                    'purchase_requisition_id' => $request->purchase_requisition_id[$key],
                    'purchase_order_id'       => $request->purchase_order_id[$key],
                    'material_id'             => $request->material_id[$key],
                    'po_composit_key'         => $request->po_composit_key[$key],
                    'quantity'                => $request->quantity[$key],
                    'warranty_period'         => $request->warranty_period[$key],
                    'installation_cost'       => $request->installation_cost[$key],
                    'transport_cost'          => $request->transport_cost[$key],
                    'unit_price'              => $request->unit_price[$key],
                    'vat'                     => $request->vat[$key],
                    'tax'                     => $request->tax[$key],
                    'total_amount'            => $request->total_amount[$key],
                    'required_date'           => $request->required_date[$key],
                ];
            }

            $purchaseOrder = PurchaseOrder::create($purchaseOrderData);
            $purchaseOrder->purchaseOrderLines()->createMany($purchaseOrderLinesData);
            //
        }
        catch (QueryException $e)
        {

            // return redirect()->route('requisitions.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(PurchaseOrder $purchaseOrder)
    {
        return $purchaseOrder->load('purchaseOrderLines');

        return view('scm::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(PurchaseOrder $purchaseOrder)
    {
        return $purchaseOrder->load('purchaseOrderLines');

        return view('scm::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        try {
            $purchaseOrderData = $request->only('po_no', 'date', 'comparative_statement_id', 'indent_id', 'remarks', 'trams_of_Supply', 'trams_of_payment', 'trams_of_condition', 'delivery_location', 'created_by', 'branch_id');

            $purchaseOrderLinesData = [];
            foreach ($request->purchase_requisition_id as $key => $data)
            {
                $purchaseOrderLinesData[] = [
                    'purchase_requisition_id' => $request->purchase_requisition_id[$key],
                    'purchase_order_id'       => $request->purchase_order_id[$key],
                    'material_id'             => $request->material_id[$key],
                    'po_composit_key'         => $request->po_composit_key[$key],
                    'quantity'                => $request->quantity[$key],
                    'warranty_period'         => $request->warranty_period[$key],
                    'installation_cost'       => $request->installation_cost[$key],
                    'transport_cost'          => $request->transport_cost[$key],
                    'unit_price'              => $request->unit_price[$key],
                    'vat'                     => $request->vat[$key],
                    'tax'                     => $request->tax[$key],
                    'total_amount'            => $request->total_amount[$key],
                    'required_date'           => $request->required_date[$key],
                ];
            }

            $purchaseOrder->update($purchaseOrderData);
            $purchaseOrder->purchaseOrderLines()->delete();
            $purchaseOrder->purchaseOrderLines()->createMany($purchaseOrderLinesData);
            //
        }
        catch (QueryException $e)
        {

            return redirect()->route('requisitions.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->delete();
    }
}
