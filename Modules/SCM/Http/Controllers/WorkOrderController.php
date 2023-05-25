<?php

namespace Modules\SCM\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Admin\Entities\Pop;
use Modules\Admin\Entities\Brand;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\Branch;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Renderable;

class WorkOrderController extends Controller
{
    use HasRoles;
    function __construct()
    {
        // $this->middleware('permission:requisition-view|requisition-create|requisition-edit|requisition-delete', ['only' => ['index','show']]);
        // $this->middleware('permission:requisition-create', ['only' => ['create','store']]);
        // $this->middleware('permission:requisition-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:requisition-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $requisitions = ScmWorkOrder::with('client', 'requisitionBy')->latest()->get();

        return view('scm::requisitions.index', compact('requisitions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";
        $requisitions = ScmWorkOrder::latest()->get();
        $brands = Brand::latest()->get();
        $branchs = Branch::latest()->get();

        return view('scm::requisitions.create', compact('requisitions', 'formType', 'brands', 'branchs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ScmWorkOrderRequest $request)
    {
        try {
            DB::beginTransaction();
            if (request()->type == 'client') {
                $requestData = $request->only('type', 'client_id', 'date', 'branch_id', 'fr_composite_key');
            } elseif (request()->type == 'warehouse') {
                $requestData = $request->only('type', 'date', 'branch_id');
            } else {
                $requestData = $request->only('type', 'date', 'branch_id', 'pop_id');
            }

            $lastMRSId = ScmWorkOrder::latest()->first();
            if ($lastMRSId) {
                if (now()->format('Y') != date('Y', strtotime($lastMRSId->created_at))) {
                    $requestData['mrs_no'] = 'MRS-' . now()->format('Y') . '-' . 1;
                } else {
                    $requestData['mrs_no'] = 'MRS-' . now()->format('Y') . '-' . ($lastMRSId->id + 1);
                }
            } else {
                $requestData['mrs_no'] = 'MRS-' . now()->format('Y') . '-' . 1;
            }
            $requestData['requisition_by'] = auth()->id();
            $requisition = ScmWorkOrder::create($requestData);

            $requisitionDetails = [];
            foreach ($request->material_id as $key => $data) {
                $requisitionDetails[] = [
                    'material_id' => $request->material_id[$key],
                    'item_code' => $request->item_code[$key],
                    'req_key' => $requisition->id . '-' . $request->item_code[$key],
                    'description' => $request->description[$key],
                    'quantity' => $request->quantity[$key],
                    'brand_id' => $request->brand_id[$key],
                    'model' => $request->model[$key],
                    'purpose' => $request->purpose[$key],
                ];
            }

            $requisition->ScmWorkOrderdetails()->createMany($requisitionDetails);
            DB::commit();

            return redirect()->route('requisitions.index')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('requisitions.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ScmWorkOrder  $requisition
     * @return \Illuminate\Http\Response
     */
    public function show(ScmWorkOrder $requisition)
    {
        // dd($requisition->ScmWorkOrderdetailsWithMaterial);
        return view('scm::requisitions.show', compact('requisition'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ScmWorkOrder  $requisition
     * @return \Illuminate\Http\Response
     */
    public function edit(ScmWorkOrder $requisition)
    {
        $formType = "edit";
        $brands = Brand::latest()->get();
        $branchs = Branch::latest()->get();
        $pops = Pop::latest()->get();
        $clients = Client::latest()->get();
        $clientDetails = ClientDetail::latest()->get();
        $clientInfos = ClientDetail::where('client_id', $requisition->client_id)->get();
        // $branchwisePops = ScmWorkOrder::with('pop')->where('id', $requisition->id)->get();
        $branchwisePops = Pop::where('branch_id', $requisition->branch_id)->get();
        // $fr_composite_key = $requisition->fr_composite_key;
        return view('scm::requisitions.create', compact('requisition', 'formType', 'brands', 'pops', 'clients', 'clientDetails', 'clientInfos', 'branchs', 'branchwisePops'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ScmWorkOrder  $requisition
     * @return \Illuminate\Http\Response
     */
    public function update(SupplierRequest $request, ScmWorkOrder $requisition)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();
            if (request()->type == 'client') {
                $requestData = $request->only('type', 'client_id', 'date', 'branch_id', 'fr_composite_key');
            } elseif (request()->type == 'warehouse') {
                $requestData = $request->only('type', 'date', 'branch_id');
            } else {
                $requestData = $request->only('type', 'date', 'branch_id', 'pop_id');
            }
            $requestData['requisition_by'] = auth()->id();

            $requisition->update($requestData);

            $requisitionDetails = [];
            foreach ($request->material_id as $key => $data) {
                $requisitionDetails[] = [
                    'material_id' => $request->material_id[$key],
                    'item_code' => $request->item_code[$key],
                    'req_key' => $requisition->id . '-' . $request->item_code[$key],
                    'description' => $request->description[$key],
                    'quantity' => $request->quantity[$key],
                    'brand_id' => $request->brand_id[$key],
                    'model' => $request->model[$key],
                    'purpose' => $request->purpose[$key],
                ];
            }

            $requisition->ScmWorkOrderdetails()->delete();
            $requisition->ScmWorkOrderdetails()->createMany($requisitionDetails);
            DB::commit();

            return redirect()->route('requisitions.index')->with('message', 'Data has been updated successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('requisitions.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ScmWorkOrder  $requisition
     * @return \Illuminate\Http\Response
     */
    public function destroy(ScmWorkOrder $requisition)
    {
        try {
            $requisition->delete();
            return redirect()->route('requisitions.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            return redirect()->route('requisitions.index')->withErrors($e->getMessage());
        }
    }

    public function searchMaterialByRequsiition($csId, $reqId)
    {
        return CsMaterial::with('material', 'brand')
            ->orderBy('id')
            ->where('cs_id', $csId)
            ->whereIn('material_id', function ($query) use ($reqId) {
                $query->select('material_id')
                    ->from('scm_purchase_requisition_details')
                    ->where('scm_purchase_requisition_id', $reqId);
            })
            ->get()
            ->unique('material_id', 'brand_id');
    }

    public function searchMaterialPriceByCsAndRequsiition($csId, $supplierId, $materialId)
    {
        return CsMaterialSupplier::query()
            ->with('csMaterial.brand', function ($query) {
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
    }

    private function checkValidation($request)
    {
        $customValidations = Validator::make($request->all(), [
            'date' => 'required',
            'supplier_id' => 'required',
            'indent_id' => 'required',
            'cs_id.*' => 'required',
            'quotaion_id.*' => 'required',
            'matterial_name.*' => 'required',
            'material_id.*' => 'required',
        ], [
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

    private function prepareworkOrderData($request, $workOrder = null)
    {
        $requestMethod = request()->method();
        $workOrderData = $request->all();

        $workOrderLinesData = [];
        foreach ($workOrderData['purchase_requisition_id'] as $key => $value) {
            $workOrderLinesData[] = [
                'scm_purchase_requisition_id' => $request->purchase_requisition_id[$key] ?? null,
                'po_composit_key'         => ($requestMethod === "PUT" ? $workOrder->po_no :  $this->workOrderNo) . '-' . $request->material_id[$key] . '-' . $request->brand_id[$key] ?? null,
                'cs_id'                      => $request->cs_id[$key] ?? null,
                'quotation_no'               => $request->quotation_no[$key] ?? null,
                'material_id'             => $request->material_id[$key] ?? null,
                'brand_id'                => $request->brand_id[$key] ?? null,
                'description'             => $request->description[$key] ?? null,
                'quantity'                => $request->quantity[$key] ?? null,
                'warranty_period'         => $request->warranty_period[$key] ?? null,
                'unit_price'              => $request->unit_price[$key] ?? null,
                'vat'                     => $request->vat[$key] ?? null,
                'tax'                     => $request->tax[$key] ?? null,
                'total_amount'            => $request->quantity[$key] * $request->unit_price[$key] ?? null,
                'required_date'           => $request->required_date[$key] ?? null,
            ];
        }

        $poTermsAndConditions = [];
        foreach ($workOrderData['terms_and_conditions'] as $key => $value) {
            $poTermsAndConditions[] = [
                'particular' => $value
            ];
        }

        $materials = [];
        $allMaterialsAreSame = true;
        $firstMaterialId = $workOrderLinesData[0]['material_id'];
        foreach ($workOrderLinesData as $key => $value) {
            if ($firstMaterialId != $value['material_id']) {
                $allMaterialsAreSame = false;
                break;
            }
        }

        if ($allMaterialsAreSame) {
            $materials[] = [
                'po_composit_key' => ($requestMethod === "PUT" ? $workOrder->po_no :  $this->workOrderNo) . '-' . $request->material_id[$key] . '-' . $request->brand_id[$key],
                'material_id' => $firstMaterialId,
                'quantity' => array_sum(array_column($workOrderLinesData, 'quantity')),
                'brand_id' => $request->brand_id[$key] ?? null,
                'unit_price' => $request->unit_price[$key] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        } else {
            foreach ($workOrderLinesData as $key => $value) {
                $materials[] = [
                    'po_composit_key' => ($requestMethod === "PUT" ? $workOrder->po_no :  $this->workOrderNo) . '-' . $request->material_id[$key] . '-' . $request->brand_id[$key],
                    'material_id' => $value['material_id'],
                    'quantity' => $value['quantity'],
                    'brand_id' => $request->brand_id[$key] ?? null,
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
                $poMaterials[$key]['quantity'] += (int) $item['quantity'];
            } else {
                // If the key doesn't exist, add a new item to the merged array
                $poMaterials[$key] = $item;
            }
        }
        // Convert the merged array back to a sequential array
        $poMaterials = array_values($poMaterials);

        return [
            'workOrderData' => $workOrderData,
            'workOrderLinesData' => $workOrderLinesData,
            'poTermsAndConditions' => $poTermsAndConditions,
            'poMaterials' => $poMaterials,
        ];
    }
}
