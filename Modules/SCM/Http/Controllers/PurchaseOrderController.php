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
use Modules\SCM\Entities\Cs;
use Modules\SCM\Entities\CsMaterialSupplier;
use Modules\SCM\Entities\Indent;
use Modules\SCM\Entities\IndentLine;
use Modules\SCM\Entities\PoMaterial;
use Modules\SCM\Entities\ScmPurchaseRequisitionDetails;
use Modules\SCM\Http\Requests\PurchaseOrderRequest;
use Spatie\Permission\Traits\HasRoles;


use function Termwind\render;

class PurchaseOrderController extends Controller
{
    use HasRoles;

    private $purchaseOrderNo;

    public function __construct(BbtsGlobalService $globalService)
    {
        $this->middleware('permission:scm-purchase-order-view|scm-purchase-order-create|scm-purchase-order-edit|scm-purchase-order-delete', ['only' => ['index', 'show', 'getCsPdf', 'getAllDetails', 'getMaterialSuppliersDetails', 'csApproved']]);
        $this->middleware('permission:scm-purchase-order-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:scm-purchase-order-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:scm-purchase-order-delete', ['only' => ['destroy']]);
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
        // dd($request->all());
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
            if (!empty($finalData['poTermsAndConditions'])) {
                $purchaseOrder->poTermsAndConditions()->createMany($finalData['poTermsAndConditions']);
            }

            PoMaterial::insert($finalData['poMaterials']);

            DB::commit();
            return redirect()->route('purchase-orders.index')->with('message', 'Purchase Order Created Successfully');
        } catch (QueryException $e) {
            DB::rollBack();

            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(PurchaseOrder $purchaseOrder)
    {
        return view('scm::purchase-orders.show', compact('purchaseOrder'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(PurchaseOrder $purchaseOrder)
    {
        $vatOrTax = [
            'Include', 'Exclude'
        ];

        $indentWiseRequisitions = IndentLine::query()
            ->with('scmPurchaseRequisition')
            ->where('indent_id', $purchaseOrder->indent_id)
            ->get()
            ->map(
                function ($item) {
                    return [
                        $item->scmPurchaseRequisition->id => $item->scmPurchaseRequisition->prs_no
                    ];
                }
            );
        $indent = Indent::where('id', $purchaseOrder->indent_id)->first();
        $indent_wise_cs = Cs::select('id', 'cs_no')->where('indent_no', $indent->indent_no)->get();
        $cs_materials = $this->searchMaterialByCsAndRequsiition($purchaseOrder->cs->id);
        foreach ($purchaseOrder->purchaseOrderLines as $key => $value) {
            $cs_brands = $this->searchMaterialBrandByCsAndRequsiition($purchaseOrder->cs->id, $purchaseOrder->supplier_id, $value->material_id);
            $cs_models = $this->searchMaterialPriceByCsAndRequsiition($purchaseOrder->cs->id, $purchaseOrder->supplier_id, $value->material_id);
        }
        return view('scm::purchase-orders.create', compact('purchaseOrder', 'vatOrTax', 'indentWiseRequisitions', 'cs_materials', 'cs_brands', 'cs_models', 'indent_wise_cs'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        $validatedRequest = $this->checkValidation($request);
        if (!empty($validatedRequest->original)) {
            return response()->json($validatedRequest->original);
        }

        try {
            $finalData = $this->preparePurchaseOrderData($request, $purchaseOrder);

            DB::beginTransaction();
            $finalData['purchaseOrderData']['created_by'] = auth()->user()->id;

            $purchaseOrder->update($finalData['purchaseOrderData']);

            $oldPoCompositeKeys = $purchaseOrder->purchaseOrderLines()->pluck('po_composit_key')->unique();
            $oldpoMaterials = PoMaterial::whereIn('po_composit_key', $oldPoCompositeKeys)->get();

            $oldpoMaterials->each->forceDelete();
            $purchaseOrder->purchaseOrderLines()->delete();
            $purchaseOrder->purchaseOrderLines()->createMany($finalData['purchaseOrderLinesData']);
            $purchaseOrder->poTermsAndConditions()->delete();
            if ($finalData['poTermsAndConditions'] != null) {
                $purchaseOrder->poTermsAndConditions()->createMany($finalData['poTermsAndConditions']);
            }
            PoMaterial::insert($finalData['poMaterials']);

            DB::commit();
            return redirect()->route('purchase-orders.index')->with('message', 'Purchase Order Updated Successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('requisitions.index')->withInput()->withErrors($e->getMessage());
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

    public function searchMaterialByCsAndRequsiition($cs_id = null)
    {
        $csId = request()->cs_id ?? $cs_id;
        return CsMaterial::with('material', 'brand')
            ->orderBy('id')
            ->where('cs_id', $csId)
            ->get()
            ->unique('material_id');


        // return CsMaterial::with('material', 'brand')
        //     ->orderBy('id')
        //     ->where('cs_id', request()->cs_id)
        //     ->whereIn('material_id', function ($query) use ($reqId) {
        //         $query->select('material_id')
        //             ->from('scm_purchase_requisition_details')
        //             ->where('scm_purchase_requisition_id', $reqId);
        //     })
        //     ->get()
        //     ->unique('material_id', 'brand_id');
    }

    public function searchMaterialBrandByCsAndRequsiition($csId, $supplierId, $materialId)
    {
        return CsMaterialSupplier::query()
            ->with('brand', function ($query) {
                $query->select('id', 'name');
            })
            ->whereHas('csMaterial', function ($query) use ($csId, $materialId) {
                $query->where('cs_id', $csId)
                    ->where('material_id', $materialId);
            })
            ->whereHas('csSupplier', function ($query) use ($csId, $supplierId) {
                $query->where('cs_id', $csId)
                    ->where('supplier_id', $supplierId);
            })
            ->get();
    }

    public function searchMaterialPriceByCsAndRequsiition($csId, $supplierId, $materialId)
    {
        $data = CsMaterialSupplier::query()
            ->with('csMaterial.material', function ($query) {
                $query->select('id', 'name');
            })
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
            ->get();

            return $data ; 

    }

    public function getMaterialByCS ($cs_no, $supplier_id){
        
        return CsMaterialSupplier::with('csMaterial.material','brand')
            ->where('cs_id', $cs_no)
            ->whereHas('csSupplier', function ($query) use ($cs_no, $supplier_id) {
                $query->where('cs_id', $cs_no)->where('supplier_id', $supplier_id);
            })
            ->get();
    }

    private function checkValidation($request)
    {
        $customValidations = Validator::make($request->all(), [
            'po_type' => 'required',
            'date' => 'required',
            'supplier_id' => 'required',
            'indent_id' => 'required',
            'cs_id.*' => 'required',
            'quotaion_id.*' => 'required',
            'matterial_name.*' => 'required',
            'material_id.*' => 'required',
        ], [
            'po_type.required' => 'PO Type is required',
            'date.required' => 'Date is required',
            'supplier_id.required' => 'Supplier is required',
            'indent_id.required' => 'Indent is required',
            'cs_id.*.required' => 'CS is required',
            'quotaion_id.*.required' => 'Quotation is required',
            'matterial_name.*.required' => 'Material Name is required',
            'material_id.*.required' => 'Material is required',
        ]);

        if ($customValidations->fails()) {
            return response()->json($customValidations->errors());
        }
    }

    private function preparePurchaseOrderData($request, $purchaseOrder = null)
    {
        $requestMethod = request()->method();
        $purchaseOrderData = $request->all();

        $purchaseOrderLinesData = [];
        foreach ($purchaseOrderData['material_id'] as $key => $value) {
            $purchaseOrderLinesData[] = [
                'po_composit_key' => ($requestMethod === "PUT" ? $purchaseOrder->po_no : $this->purchaseOrderNo) . '-' . $request->material_id[$key] . '-' . $request->brand_id[$key] ?? null,
                'material_id' => $request->material_id[$key] ?? null,
                'brand_id' => $request->brand_id[$key] ?? null,
                'model' => $request->model[$key] ?? null,
                'description' => $request->description[$key] ?? null,
                'quantity' => $request->quantity[$key] ?? null,
                'warranty_period' => $request->warranty_period[$key] ?? null,
                'unit_price' => $request->unit_price[$key] ?? null,
                'vat' => $request->vat[$key] ?? null,
                'tax' => $request->tax[$key] ?? null,
                'total_amount' => $request->quantity[$key] * $request->unit_price[$key] ?? null,
                'required_date' => $request->required_date[$key] ?? null,
            ];
        }

        $poTermsAndConditions = [];
        foreach ($purchaseOrderData['terms_and_conditions'] as $key => $value) {
            $poTermsAndConditions[] = [
                'particular' => $value
            ];
        }

        $materials = [];
        $allMaterialsAreSame = true;
        $firstMaterialId = $purchaseOrderLinesData[0]['material_id'];
        foreach ($purchaseOrderLinesData as $key => $value) {
            if ($firstMaterialId != $value['material_id']) {
                $allMaterialsAreSame = false;
                break;
            }
        }

        if ($allMaterialsAreSame) {
            $materials[] = [
                'po_composit_key' => ($requestMethod === "PUT" ? $purchaseOrder->po_no : $this->purchaseOrderNo) . '-' . $request->material_id[$key] . '-' . $request->brand_id[$key],
                'material_id' => $firstMaterialId,
                'quantity' => array_sum(array_column($purchaseOrderLinesData, 'quantity')),
                'brand_id' => $request->brand_id[$key] ?? null,
                'model' => $request->model[$key] ?? null,
                'unit_price' => $request->unit_price[$key] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        } else {
            foreach ($purchaseOrderLinesData as $key => $value) {
                $materials[] = [
                    'po_composit_key' => ($requestMethod === "PUT" ? $purchaseOrder->po_no : $this->purchaseOrderNo) . '-' . $request->material_id[$key] . '-' . $request->brand_id[$key],
                    'material_id' => $value['material_id'],
                    'quantity' => $value['quantity'],
                    'brand_id' => $request->brand_id[$key] ?? null,
                    'model' => $request->model[$key] ?? null,
                    'unit_price' => $request->unit_price[$key] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        $poMaterials = [];
        // Iterate through each element of the given array
        foreach ($materials as $item) {
            // Create a unique key based on material_id and brand_id
            $key = $item['material_id'] . '-' . $item['brand_id'];
            // If the key already exists in the merged array, add the quantity
            if (isset($poMaterials[$key])) {
                $poMaterials[$key]['quantity'] += (int)$item['quantity'];
            } else {
                // If the key doesn't exist, add a new item to the merged array
                $poMaterials[$key] = $item;
            }
        }
        // Convert the merged array back to a sequential array
        $poMaterials = array_values($poMaterials);

        return [
            'purchaseOrderData' => $purchaseOrderData,
            'purchaseOrderLinesData' => $purchaseOrderLinesData,
            'poTermsAndConditions' => $poTermsAndConditions,
            'poMaterials' => $poMaterials,
        ];
    }

    public function pdf($id = null)
    {
        $purchase_order = PurchaseOrder::where('id', $id)->first();
        return view('scm::purchase-orders.pdf', compact('purchase_order'));

    }
}
