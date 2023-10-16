<?php

namespace Modules\SCM\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Modules\SCM\Entities\ScmMir;
use Modules\SCM\Entities\ScmMrr;
use Illuminate\Http\JsonResponse;
use Modules\Admin\Entities\Brand;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\Branch;
use App\Services\BbtsGlobalService;
use Modules\SCM\Entities\StockLedger;
use Modules\SCM\Entities\FiberTracking;
use Modules\SCM\Entities\ScmRequisition;
use Illuminate\Contracts\Support\Renderable;
use Modules\SCM\Entities\ScmErr;
use Modules\SCM\Entities\ScmMur;
use Modules\SCM\Http\Requests\ScmMirRequest;
use Modules\SCM\Entities\ScmRequisitionDetail;
use Modules\SCM\Entities\ScmPurchaseRequisition;
use Modules\SCM\Entities\ScmWcrr;
use Modules\SCM\Entities\ScmWor;
use Spatie\Permission\Traits\HasRoles;

class ScmMirController extends Controller
{
    private $mirNo;

    public function __construct(BbtsGlobalService $globalService)
    {
        $this->mirNo = $globalService->generateUniqueId(ScmMir::class, 'MIR');
        $this->middleware('permission:scm-mir-view|scm-mir-create|scm-mir-edit|scm-mir-delete', ['only' => ['index', 'show', 'getCsPdf', 'getAllDetails', 'getMaterialSuppliersDetails', 'csApproved']]);
        $this->middleware('permission:scm-mir-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:scm-mir-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:scm-mir-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $mirs = ScmMir::with('lines', 'toBranch', 'fromBranch', 'courier', 'scmRequisition', 'createdBy')->latest()->get();
        return view('scm::mir.index', compact('mirs'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $received_type = ['MRR', 'ERR', 'WCR'];
        $brands = Brand::latest()->get();
        $branches = Branch::latest()->get();
        return view('scm::mir.create', compact('brands', 'branches', 'received_type'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(ScmMirRequest $request)
    {
        try {
            $mir_data = $request->all();

            $mir_details = [];
            foreach ($request->material_name as $key => $val) {
                if (isset($request->serial_code[$key]) && count($request->serial_code[$key])) {
                    foreach ($request->serial_code[$key] as $keyValue => $value) {
                        $stock_ledgers[] = $this->getStockLedgerData($request, $key, $keyValue, $request->branch_id, true);
                        $stock_ledgers[] = $this->getStockLedgerData($request, $key, $keyValue, $request->to_branch_id, false);
                    };
                } elseif (isset($request->material_name[$key])) {
                    $stock_ledgers[] = $this->getStockLedgerData($request, $key, $key2 = null, $request->branch_id, true);
                    $stock_ledgers[] = $this->getStockLedgerData($request, $key, $key2 = null, $request->to_branch_id, false);
                }
                $mir_details[] = $this->getMirDetails($request, $key);
            };

            $mir_data['mir_no'] = $this->mirNo;
            $mir_data['created_by'] = auth()->user()->id;

            DB::beginTransaction();
            $mir = ScmMir::create($mir_data);
            $mir->lines()->createMany($mir_details);
            $mir->stockable()->createMany($stock_ledgers);
            DB::commit();

            return redirect()->route('material-issues.index')->with('success', 'MIR Created Successfully');
        } catch (Exception $err) {
            DB::rollBack();
            return redirect()->back()->with('error', $err->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(ScmMir $material_issue)
    {
        return view('scm::mir.show', compact('material_issue'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(ScmMir $material_issue)
    {
        $materials = [];
        $brands = [];
        $models = [];
        $serial_codes = [];
        $from_branch_stock = [];
        $to_branch_stock = [];
        $material_issue->lines->each(function ($item, $key) use (&$materials, &$brands, &$models, &$serial_codes, &$from_branch_stock, &$material_issue, &$to_branch_stock) {
            $materials[] = StockLedger::query()
                ->with('material')
                ->where([
                    'receiveable_id' => $item->receiveable_id,
                    'receiveable_type' => $item->receiveable_type,
                    'branch_id' => $material_issue->branch_id,
                ])
                ->get()
                ->unique('material_id');

            $brands[] = StockLedger::query()->with('brand')->dropdownDataList('brand_id', $material_issue, false, false, $item);

            $models[] = StockLedger::query()->dropdownDataList('model', $material_issue, true, false, $item);

            $serial_codes[] = StockLedger::query()->dropdownDataList('serial_code', $material_issue, true, true, $item);

            $from_branch_stock[] = StockLedger::query()->branchStock($material_issue->branch_id, $item);

            $to_branch_stock[] = StockLedger::query()->branchStock($material_issue->to_branch_id, $item);
        });

        return view('scm::mir.create', compact('material_issue', 'materials', 'brands', 'models', 'serial_codes', 'from_branch_stock', 'to_branch_stock'));
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(ScmMirRequest $request, ScmMir $material_issue)
    {
        try {
            $mir_data = $request->all();

            $mir_details = [];
            foreach ($request->material_name as $key => $val) {
                if (isset($request->serial_code[$key]) && count($request->serial_code[$key])) {
                    foreach ($request->serial_code[$key] as $keyValue => $value) {
                        $stock_ledgers[] = $this->getStockLedgerData($request, $key, $keyValue, $request->branch_id, true);
                        $stock_ledgers[] = $this->getStockLedgerData($request, $key, $keyValue, $request->to_branch_id, false);
                    };
                } elseif (isset($request->material_name[$key])) {
                    $stock_ledgers[] = $this->getStockLedgerData($request, $key, $key2 = null, $request->branch_id, true);
                    $stock_ledgers[] = $this->getStockLedgerData($request, $key, $key2 = null, $request->to_branch_id, false);
                }
                $mir_details[] = $this->getMirDetails($request, $key);
            };
            DB::beginTransaction();
            $material_issue->update($mir_data);
            $material_issue->lines()->delete();
            $material_issue->lines()->createMany($mir_details);
            $material_issue->stockable()->delete();
            $material_issue->stockable()->createMany($stock_ledgers);
            DB::commit();

            return redirect()->route('material-issues.index')->with('success', 'MIR Updated Successfully');
        } catch (Exception $err) {
            DB::rollBack();
            return redirect()->route('material-issues.create')->with('error', $err->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param ScmMir $material_issue
     * @return Renderable
     */
    public function destroy(ScmMir $material_issue)
    {
        try {
            DB::beginTransaction();
            $material_issue->lines()->delete();
            $material_issue->stockable()->delete();
            $material_issue->delete();
            DB::commit();
            return redirect()->route('material-issues.index')->with('success', 'MIR Deleted Successfully');
        } catch (Exception $err) {
            DB::rollBack();
            return redirect()->route('material-issues.index')->with('error', $err->getMessage());
        }
    }

    /**
     * Get Stock Ledger Data From Request
     * 
     * @param Request $request
     * @param int $key1
     * @param int $key2
     * @param int $branch_id
     * @param bool $qty
     * 
     * @return array
     */
    public function getStockLedgerData($request, $key1, $key2 = null, $branch_id, $qty): array
    {
        return [
            'receiveable_id' => $request->type_id[$key1],
            'receiveable_type' => ($request->received_type[$key1] == 'MRR') ? ScmMrr::class : (($request->received_type[$key1] == 'WCR') ? ScmWcr::class : (($request->received_type[$key1] == 'ERR') ? ScmErr::class : (($request->received_type[$key1] == 'WOR') ? ScmWor::class : NULL))),
            'received_type' => $request->received_type[$key1],
            'branch_id' => $branch_id,
            'material_id' => $request->material_name[$key1],
            'item_code' => $request->code[$key1],
            'unit' => $request->unit[$key1],
            'brand_id' => isset($request->brand[$key1]) ? $request->brand[$key1] : NULL,
            'model' => isset($request->model[$key1]) ? $request->model[$key1] : NULL,
            'serial_code' => (isset($request->serial_code[$key1]) && isset($request->serial_code[$key1][$key2])) ? $request->serial_code[$key1][$key2] : NULL,
            'quantity' => ($qty ? -1 : 1) * (isset($key2) ? (($request->type[$key1] == 'Drum') ? $request->issued_qty[$key1] : 1) : $request->issued_qty[$key1])
        ];
    }

    /**
     * Get MIR Details From Request
     * 
     * @param Request $request
     * @param int $key1
     * @return array
     */
    public function getMirDetails($request, $key1): array
    {
        return  [
            'material_id'   => $request->material_name[$key1],
            'serial_code' => isset($request->serial_code[$key1]) ? json_encode($request->serial_code[$key1]) : '[]',
            'receiveable_id' => $request->type_id[$key1],
            'receiveable_type' => ($request->received_type[$key1] == 'MRR') ? ScmMrr::class : (($request->received_type[$key1] == 'WCR') ? ScmWcr::class : (($request->received_type[$key1] == 'ERR') ? ScmErr::class : (($request->received_type[$key1] == 'WOR') ? ScmWor::class : null))),
            'brand_id' => isset($request->brand[$key1]) ? $request->brand[$key1] : null,
            'model' => isset($request->model[$key1]) ? $request->model[$key1] : null,
            'quantity' => $request->issued_qty[$key1],
            'remarks' => $request->remarks[$key1],
        ];
    }

    public function searchMrs()
    {
        $items = ScmRequisition::query()
            ->where("mrs_no", "like", "%" . request()->search . "%")
            ->take(10)
            ->get()
            ->map(fn ($item) => [
                'value' => $item->mrs_no,
                'label' => $item->mrs_no,
                'scm_requisition_id' => $item->id,
            ]);

        return response()->json($items);
    }

    public function searchTypeNo()
    {
        $data = StockLedger::query()
            ->where('received_type', request()->customQueryFields['type'])
            ->orderBy('receiveable_id')
            ->when(request()->customQueryFields['type'] == 'MRR', function ($query) {
                $query->whereHasMorph('receiveable', ScmMrr::class, function ($query2) {
                    $query2->where('mrr_no', 'like', '%' . request()->search . '%');
                });
            })
            ->when(request()->customQueryFields['type'] == 'ERR', function ($query) {
                $query->whereHasMorph('receiveable', ScmErr::class, function ($query) {
                    $query->where('err_no', 'like', '%' . request()->search . '%');
                });
            })
            ->when(request()->customQueryFields['type'] == 'WCR', function ($query) {
                $query->whereHasMorph('receiveable', ScmWcrr::class, function ($query) {
                    $query->where('wcr_no', 'like', '%' . request()->search . '%');
                });
            })
            ->when(request()->customQueryFields['type'] == 'WOR', function ($query) {
                $query->whereHasMorph('receiveable', ScmWor::class, function ($query) {
                    $query->where('wor_no', 'like', '%' . request()->search . '%');
                });
            })
            ->get()
            ->unique(function ($item) {
                return $item->receiveable->mrr_no ?? $item->receiveable->err_no ?? $item->receiveable->wcr_no ?? $item->receiveable->wor_no;
            })
            ->take(10)
            ->map(fn ($item) => [
                'value' => $item->receiveable->mrr_no ?? $item->receiveable->err_no ?? $item->receiveable->wcr_no ?? $item->receiveable->wor_no,
                'label' => $item->receiveable->mrr_no ?? $item->receiveable->err_no ?? $item->receiveable->wcr_no ?? $item->receiveable->wor_no,
                'id'    => $item->receiveable->id,
            ])
            ->values()
            ->all();

        // dd($data);
        return response()->json($data);
    }

    public function mrsAndTypeWiseMaterials()
    {
        // dd(request()->from_branch);
        $data['options'] = StockLedger::query()
            ->with('material')
            ->whereIn('material_id', function ($q) {
                return $q->select('material_id')
                    ->from('scm_requisition_details')
                    ->where('scm_requisition_id', request()->scm_requisition_id);
            })
            ->where(['receiveable_id' => request()->receiveable_id, 'received_type' => request()->received_type, 'branch_id' => request()->from_branch])
            ->get()
            ->unique('material_id')
            ->map(fn ($item) => [
                'value' => $item->material->id,
                'label' => $item->material->name,
                'type' => $item->material->type,
                'unit' => $item->material->unit,
                'code' => $item->material->code,
            ])
            ->values()
            ->all();

        return response()->json($data);
    }

    public function mrsAndTypeWiseMaterialsForChallan()
    {
        // dd(request()->from_branch);
        $data['current_stock'] = StockLedger::where('branch_id', request()->branch)
            ->when(request()->receiveable_id, function ($query) {
                return $query->where('receiveable_id', request()->receiveable_id);
            })
            ->when(request()->received_type, function ($query) {
                return $query->where('received_type', request()->received_type);
            })
            ->when(request()->material_id, function ($query) {
                return $query->where('material_id', request()->material_id);
            })
            ->when(request()->brand_id, function ($query) {
                return $query->where('brand_id', request()->brand_id);
            })
            ->when(request()->model, function ($query) {
                return $query->where('model', request()->model);
            })
            ->sum('quantity');

        $scmDetail = ScmRequisitionDetail::where('scm_requisition_id', request()->scm_requisition_id)
            ->when(request()->material_id, function ($query) {
                return $query->where('material_id', request()->material_id);
            })
            ->when(request()->brand_id, function ($query) {
                return $query->where('brand_id', request()->brand_id);
            })
            ->when(request()->model, function ($query) {
                return $query->where('model', request()->model);
            })
            ->first();
        $data['mrs_quantity'] = $scmDetail->quantity ?? 0;

        return response()->json($data);
    }

    public function materialWiseBrands()
    {
        $data['options'] = StockLedger::query()
            ->with('brand')
            ->where([
                'material_id' => request()->material_id,
                'branch_id' => request()->from_branch_id
            ])
            ->get()
            ->unique('brand_id')
            ->map(fn ($item) => [
                'value' => $item->brand->id,
                'label' => $item->brand->name,
            ])
            ->values()
            ->all();

        return response()->json($data);
    }

    /**
     * brandWiseModels
     *
     * @return void
     */
    public function brandWiseModels()
    {
        $data['options'] = StockLedger::query()
            ->where([
                'material_id' => request()->material_id,
                'brand_id' => request()->brand_id,
                'branch_id' => request()->from_branch_id
            ])
            ->get()
            ->unique('model')
            ->map(fn ($item) => [
                'value' => $item->model,
                'label' => $item->model,
            ])
            ->values()
            ->all();

        return response()->json($data);
    }

    /**
     * Get model wise serial codes
     *
     * @return void
     */
    public function modelWiseSerialCodes()
    {
        $data['options'] = StockLedger::query()
            ->where([
                'material_id' => request()->material_id,
                'brand_id' => request()->brand_id,
                'model' => request()->model,
                'receiveable_id' => request()->receiveable_id,
                'received_type' => request()->received_type,
                'branch_id' => request()->from_branch_id
            ])
            ->get()
            ->groupBy('serial_code')
            ->flatMap(function ($item, $key) {
                $quantity = $item->sum('quantity');
                if ($quantity > 0) {
                    $serial_code[$key] = [
                        'label' => $key,
                        'value' => $key,
                    ];
                    return $serial_code;
                }
            })
            ->values();
        return response()->json($data);
    }

    /**
     * Common function for all branch stock
     *
     * @param  integer $branch branch id form request()
     * @return integer sum of stock
     */
    public function branchWiseStock($branch): int
    {
        $branch_balance = StockLedger::query()
            ->where([
                'branch_id' => $branch,
                'received_type' => request()->received_type,
                'receiveable_id' => request()->receiveable_id,
            ])
            ->when(request()->material_id, function ($query) {
                $query->where('material_id', request()->material_id);
            })
            ->when(request()->brand_id, function ($query) {
                $query->where('brand_id', request()->brand_id);
            })
            ->when(request()->model, function ($query) {
                $query->where('model', request()->model);
            })
            ->sum('quantity');

        return $branch_balance;
    }

    public function getStock(): int
    {
        $branch_balance = StockLedger::query()
            ->where([
                'branch_id' => request()->branch_id,
            ])
            ->when(request()->material_id, function ($query) {
                $query->where('material_id', request()->material_id);
            })
            ->when(request()->brand_id, function ($query) {
                $query->where('brand_id', request()->brand_id);
            })
            ->when(request()->model, function ($query) {
                $query->where('model', request()->model);
            })
            ->sum('quantity');

        return $branch_balance;
    }

    /**
     * Get branch wise stock for from and to branch
     *
     * @return JsonResponse
     * 
     */
    public function getMaterialStock(): JsonResponse
    {
        $data = [
            'from_branch_balance' => $this->branchWiseStock(request()->from_branch_id),
            'to_branch_balance' => $this->branchWiseStock(request()->to_branch_id),
        ];
        return response()->json($data);
    }

    public function getChallanMaterialStock(): JsonResponse
    {
        $scmDetail = ScmRequisitionDetail::where('scm_requisition_id', request()->scm_requisition_id)
            ->when(request()->material_id, function ($query) {
                return $query->where('material_id', request()->material_id);
            })
            ->first();
        // $received_quantity = StockLedger::query()
        //     ->where([
        //         'branch_id' => request()->branch_id,
        //         'received_type' => request()->received_type,
        //         'receiveable_id' => request()->receiveable_id,
        //     ])
        //     ->when(request()->material_id, function ($query) {
        //         $query->where('material_id', request()->material_id);
        //     })
        //     ->when(request()->brand_id, function ($query) {
        //         $query->where('brand_id', request()->brand_id);
        //     })
        //     ->when(request()->model, function ($query) {
        //         $query->where('model', request()->model);
        //     })
        //     ->sum('quantity');
        $data = [
            'current_stock' => $this->getStock(),
            'mrs_quantity' => $scmDetail->quantity ?? 0,
            
            // 'received_quantity' => $received_quantity ?? 0
        ];
        return response()->json($data);
    }
}
