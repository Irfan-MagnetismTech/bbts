<?php

namespace Modules\SCM\Http\Controllers;

use Illuminate\Http\Request;
use Modules\SCM\Entities\ScmMrr;
use Modules\Admin\Entities\Brand;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\Branch;
use Modules\SCM\Entities\StockLedger;
use Modules\SCM\Entities\ScmRequisition;
use Illuminate\Contracts\Support\Renderable;
use Modules\SCM\Entities\FiberTracking;
use Modules\SCM\Entities\ScmRequisitionDetail;
use Modules\SCM\Entities\ScmPurchaseRequisition;

class ScmMirController extends Controller
{
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
    public function store(Request $request)
    {
        //
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
            ->when(request()->customQueryFields['type'] == 'MRR', function ($query) {
                $query->whereHasMorph('receivable', ScmMrr::class, function ($query) {
                    $query->where('mrr_no', 'like', '%' . request()->search . '%');
                });
            })
            // ->when(request()->type == 'ERR', function ($query) {
            //     $query->whereHasMorph('receivable', ScmPurchaseRequisition::class, function ($query) {
            //         $query->where('err_no', 'like', '%' . request()->search . '%');
            //     });
            // })
            // ->when(request()->type == 'WCR', function ($query) {
            //     $query->whereHasMorph('receivable', ScmPurchaseRequisition::class, function ($query) {
            //         $query->where('wcr_no', 'like', '%' . request()->search . '%');
            //     });
            // })
            ->take(10)
            ->get()
            ->unique(function ($item) {
                return $item->receivable->mrr_no ?? $item->receivable->err_no ?? $item->receivable->wcr_no;
            })
            ->map(fn ($item) => [
                'value' => $item->receivable->mrr_no ?? $item->receivable->err_no ?? $item->receivable->wcr_no,
                'label' => $item->receivable->mrr_no ?? $item->receivable->err_no ?? $item->receivable->wcr_no,
                'id' => $item->receivable->id,
            ])
            ->values()
            ->all();

        return response()->json($data);
    }

    public function mrsAndTypeWiseMaterials()
    {
        $data['materials'] = StockLedger::query()
            ->with('material', 'brand')
            ->whereIn('material_id', function ($q) {
                return $q->select('material_id')
                    ->from('scm_requisition_details')
                    ->where('scm_requisition_id', request()->scm_requisition_id);
            })
            ->where(['receivable_id' => request()->receivable_id, 'received_type' => request()->received_type])
            ->get();

        return response()->json($data);
    }

    public function getMaterialStock()
    {
        if (request()->type == 'Drum') {
            $from_branch_balance = FiberTracking::query()
                ->where('branch_id', request()->from_branch_id)
                ->sum('quantity');
            $to_branch_balance = FiberTracking::query()
                ->where('branch_id', request()->to_branch_id)
                ->sum('quantity');
        } else {
            $from_branch_balance = StockLedger::query()
                ->where('branch_id', request()->from_branch_id)
                ->where('material_id', request()->material_id)
                ->sum('quantity');
            $to_branch_balance = StockLedger::query()
                ->where('branch_id', request()->to_branch_id)
                ->where('material_id', request()->material_id)
                ->sum('quantity');
        }
        $data = [
            'from_branch_balance' => $from_branch_balance,
            'to_branch_balance' => $to_branch_balance,
        ];
        return response()->json($data);
    }
}
