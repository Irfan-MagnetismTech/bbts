<?php

namespace Modules\SCM\Http\Controllers;

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
use Modules\SCM\Http\Requests\ScmMirRequest;
use Modules\SCM\Entities\ScmRequisitionDetail;
use Modules\SCM\Entities\ScmPurchaseRequisition;

class ScmMirController extends Controller
{
    private $mirNo;

    public function __construct(BbtsGlobalService $globalService)
    {
        $this->mirNo = $globalService->generateUniqueId(ScmMir::class, 'MIR');
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('scm::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $received_type = ['mrr', 'err', 'wcr'];
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
        dd($request->all());
        $data['mir_no'] = $this->mirNo;
        $data['received_date'] = date('Y-m-d', strtotime($data['received_date']));
        $data['received_by'] = auth()->user()->id;
        $data['received_type'] = $data['received_type'] ?? 'mrr';
        $data['received_from'] = $data['received_from'] ?? null;
        $data['received_to'] = $data['received_to'] ?? null;
        $data['received_remarks'] = $data['received_remarks'] ?? null;
        $data['received_status'] = $data['received_status'] ?? 'pending';

        $mir = ScmMir::create($data);

        if ($mir) {
            $this->updateStockLedger($data, $mir);
            $this->updateScmRequisitionDetail($data, $mir);
            $this->updateScmPurchaseRequisition($data, $mir);
            $this->updateScmMrr($data, $mir);
        }

        return redirect()->route('scm.mir.index')->with('success', 'MIR Created Successfully');
    }

    private function updateStockLedger($data, $mir)
    {
        $stockLedger = StockLedger::where('mrr_no', $data['mrr_no'])->first();
        $stockLedger->update([
            'mir_no' => $mir->mir_no,
            'mir_id' => $mir->id,
            'received_date' => $mir->received_date,
            'received_by' => $mir->received_by,
            'received_type' => $mir->received_type,
            'received_from' => $mir->received_from,
            'received_to' => $mir->received_to,
            'received_remarks' => $mir->received_remarks,
            'received_status' => $mir->received_status,
        ]);
    }

    private function updateScmRequisitionDetail($data, $mir)
    {
        $scmRequisitionDetail = ScmRequisitionDetail::where('mrr_no', $data['mrr_no'])->first();
        $scmRequisitionDetail->update([
            'mir_no' => $mir->mir_no,
            'mir_id' => $mir->id,
            'received_date' => $mir->received_date,
            'received_by' => $mir->received_by,
            'received_type' => $mir->received_type,
            'received_from' => $mir->received_from,
            'received_to' => $mir->received_to,
            'received_remarks' => $mir->received_remarks,
            'received_status' => $mir->received_status,
        ]);
    }

    private function updateScmPurchaseRequisition($data, $mir)
    {
        $scmPurchaseRequisition = ScmPurchaseRequisition::where('mrr_no', $data['mrr_no'])->first();
        $scmPurchaseRequisition->update([
            'mir_no' => $mir->mir_no,
            'mir_id' => $mir->id,
            'received_date' => $mir->received_date,
            'received_by' => $mir->received_by,
            'received_type' => $mir->received_type,
            'received_from' => $mir->received_from,
            'received_to' => $mir->received_to,
            'received_remarks' => $mir->received_remarks,
            'received_status' => $mir->received_status,
        ]);
    }

    private function updateScmMrr($data, $mir)
    {
        $scmMrr = ScmMrr::where('mrr_no', $data['mrr_no'])->first();
        $scmMrr->update([
            'mir_no' => $mir->mir_no,
            'mir_id' => $mir->id,
            'received_date' => $mir->received_date,
            'received_by' => $mir->received_by,
            'received_type' => $mir->received_type,
            'received_from' => $mir->received_from,
            'received_to' => $mir->received_to,
            'received_remarks' => $mir->received_remarks,
            'received_status' => $mir->received_status,
        ]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('scm::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('scm::edit');
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
            ->orderBy('receivable_id')
            ->when(request()->customQueryFields['type'] == 'MRR', function ($query) {
                $query->whereHasMorph('receivable', ScmMrr::class, function ($query2) {
                    $query2->where('mrr_no', 'like', '%' . request()->search . '%');
                });
            })
            ->when(request()->type == 'ERR', function ($query) {
                $query->whereHasMorph('receivable', ScmPurchaseRequisition::class, function ($query) {
                    $query->where('err_no', 'like', '%' . request()->search . '%');
                });
            })
            ->when(request()->type == 'WCR', function ($query) {
                $query->whereHasMorph('receivable', ScmPurchaseRequisition::class, function ($query) {
                    $query->where('wcr_no', 'like', '%' . request()->search . '%');
                });
            })
            ->get()
            ->unique(function ($item) {
                return $item->receivable->mrr_no ?? $item->receivable->err_no ?? $item->receivable->wcr_no;
            })
            ->take(10)
            ->map(fn ($item) => [
                'value' => $item->receivable->mrr_no ?? $item->receivable->err_no ?? $item->receivable->wcr_no,
                'label' => $item->receivable->mrr_no ?? $item->receivable->err_no ?? $item->receivable->wcr_no,
                'id'    => $item->receivable->id,
            ])
            ->values()
            ->all();

        return response()->json($data);
    }

    public function mrsAndTypeWiseMaterials()
    {
        $data['options'] = StockLedger::query()
            ->with('material')
            ->whereIn('material_id', function ($q) {
                return $q->select('material_id')
                    ->from('scm_requisition_details')
                    ->where('scm_requisition_id', request()->scm_requisition_id);
            })
            ->where(['receivable_id' => request()->receivable_id, 'received_type' => request()->received_type])
            ->get()
            ->unique('material_id')
            ->map(fn ($item) => [
                'value' => $item->material->id,
                'label' => $item->material->name,
                'type' => $item->material->type,
                'unit' => $item->material->unit,
            ])
            ->values()
            ->all();

        return response()->json($data);
    }

    public function materialWiseBrands()
    {
        $data['options'] = StockLedger::query()
            ->with('brand')
            ->where([
                'material_id' => request()->material_id,
                'receivable_id' => request()->receivable_id,
                'received_type' => request()->received_type
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
                'receivable_id' => request()->receivable_id,
                'received_type' => request()->received_type
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
                'receivable_id' => request()->receivable_id,
                'received_type' => request()->received_type
            ])
            ->get()
            ->map(fn ($item) => [
                'value' => $item->serial_code,
                'label' => $item->serial_code,
            ]);

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
     * @type Array
     * @response { "from_branch_balance": 0, "to_branch_balance": 0 }
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
}
