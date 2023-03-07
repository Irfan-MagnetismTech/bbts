<?php

namespace Modules\SCM\Http\Controllers;

use Termwind\Components\Dd;
use Illuminate\Http\Request;
use Modules\Admin\Entities\Brand;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\SCM\Entities\Material;
use App\Services\BbtsGlobalService;
use Modules\SCM\Entities\CsMaterial;
use Illuminate\Database\QueryException;
use Modules\SCM\Entities\PurchaseOrder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Support\Renderable;
use Modules\SCM\Entities\CsMaterialSupplier;
use Modules\SCM\Entities\ScmPurchaseRequisitionDetails;
use Modules\SCM\Http\Requests\PurchaseOrderRequest;

use function Termwind\render;

class PurchaseOrderController extends Controller
{
    private $purchaseOrderNo;

    public function __construct(BbtsGlobalService $globalService)
    {
        $this->purchaseOrderNo = $globalService->generateUniqueId(PurchaseOrder::class, 'PO');
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        $all_pos = PurchaseOrder::query()
            ->with('purchaseOrderLines', 'supplier', 'indent', 'purchaseOrderLines.cs', 'createdBy')
            ->latest()->get();
        if (!empty(request()->message)) {
            // $message = 'request()->message';
            session()->flash('message', 'Purchase Order Created Successfully');
            return view('scm::purchase-orders.index', compact('all_pos'));
        } else {
            return view('scm::purchase-orders.index', compact('all_pos'));
        }
        // return $purchaseOrders = PurchaseOrder::with('purchaseOrderLines')->get();
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
        $validatedRequest = $this->checkValidation($request);
        if (!empty($validatedRequest->original)) {
            return response()->json($validatedRequest->original);
        }

        try {
            $finalData = $this->preparePurchaseOrderData($request);

            DB::beginTransaction();
            $finalData['purchaseOrderData']['po_no'] = $this->purchaseOrderNo;
            $finalData['purchaseOrderData']['created_by'] = auth()->user()->id;

            $purchaseOrder = PurchaseOrder::create($finalData['purchaseOrderData']);
            $purchaseOrder->purchaseOrderLines()->createMany($finalData['purchaseOrderLinesData']);
            $purchaseOrder->poTermsAndConditions()->createMany($finalData['poTermsAndConditions']);

            DB::commit();
            return response()->json(['status' => 'success', 'messsage' => 'Purchase Order Created Successfully'], 200);

            // return redirect()->route('purchase-orders.index')->with('success', 'Purchase Order Created Successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), 500);
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
        // return $purchaseOrder->load('purchaseOrderLines');

        return view('scm::purchase-orders.show', compact('purchaseOrder'));
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
            foreach ($request->purchase_requisition_id as $key => $data) {
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
        } catch (QueryException $e) {

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
        try {
            DB::beginTransaction();

            $purchaseOrder->purchaseOrderLines()->delete();
            $purchaseOrder->poTermsAndConditions()->delete();
            $purchaseOrder->delete();

            DB::commit();

            return redirect()->route('purchase-orders.index')->with('message', 'Purchase Order Deleted Successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('purchase-orders.index')->with('error', $e->getMessage());
        }
    }

    public function searchMaterialByCsAndRequsiition($csId, $reqId)
    {
        return CsMaterial::with('material')
            ->orderBy('id')
            ->where('cs_id', $csId)
            ->whereIn('material_id', function ($query) use ($reqId) {
                $query->select('material_id')
                    ->from('scm_purchase_requisition_details')
                    ->where('scm_purchase_requisition_id', $reqId);
            })
            ->get()
            ->unique('material_id');
    }

    public function searchMaterialPriceByCsAndRequsiition($csId, $supplierId, $materialId)
    {
        return CsMaterialSupplier::query()
            ->with('csMaterial.material', function ($query) {
                $query->select('id', 'name', 'unit');
            })
            ->whereHas('csMaterial', function ($query) use ($csId, $materialId) {
                $query->where('cs_id', $csId)
                    ->where('material_id', $materialId);
            })
            ->whereHas('csSupplier', function ($query) use ($csId, $supplierId) {
                $query->where('cs_id', $csId)
                    ->where('supplier_id', $supplierId);
            })
            ->first();
    }

    private function checkValidation($request)
    {
        $customValidations = Validator::make($request->all(), [
            'date' => 'required',
            'supplier_id' => 'required',
            'indent_id' => 'required',
            'cs_id.*' => 'required',
            'quotaion_id.*' => 'required',
            'material_id.*' => 'required',
        ], [
            'date.required' => 'Date is required',
            'supplier_id.required' => 'Supplier is required',
            'indent_id.required' => 'Indent is required',
            'cs_id.*.required' => 'CS is required',
            'quotaion_id.*.required' => 'Quotation is required',
            'material_id.*.required' => 'Material is required',
        ]);

        if ($customValidations->fails()) {
            return response()->json($customValidations->errors());
        }
    }

    private function preparePurchaseOrderData($request)
    {
        $purchaseOrderData = $request->all();

        $purchaseOrderLinesData = [];
        foreach ($purchaseOrderData['purchase_requisition_id'] as $key => $data) {
            $purchaseOrderLinesData[] = [
                'scm_purchase_requisition_id' => $request->purchase_requisition_id[$key],
                'po_composit_key'         => 452,
                'cs_id'                      => $request->cs_id[$key],
                'quotation_no'               => $request->quotation_no[$key],
                'material_id'             => $request->material_id[$key],
                'description'             => $request->description[$key],
                'quantity'                => $request->quantity[$key],
                'warranty_period'         => $request->warranty_period[$key],
                'unit_price'              => $request->unit_price[$key],
                'vat'                     => $request->vat[$key],
                'tax'                     => $request->tax[$key],
                'total_amount'            => $request->quantity[$key] * $request->unit_price[$key],
                'required_date'           => $request->required_date[$key],
            ];
        }

        $poTermsAndConditions = [];
        foreach ($purchaseOrderData['terms_and_conditions'] as $key => $data) {
            $poTermsAndConditions[] = [
                'particular' => $data
            ];
        }

        return [
            'purchaseOrderData' => $purchaseOrderData,
            'purchaseOrderLinesData' => $purchaseOrderLinesData,
            'poTermsAndConditions' => $poTermsAndConditions,
        ];
    }
}
