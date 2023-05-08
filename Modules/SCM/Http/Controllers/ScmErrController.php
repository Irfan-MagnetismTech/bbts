<?php

namespace Modules\SCM\Http\Controllers;

use Termwind\Components\Dd;
use Illuminate\Http\Request;
use Modules\SCM\Entities\ScmErr;
use Modules\SCM\Entities\ScmMrr;
use Modules\SCM\Entities\ScmMur;
use Modules\SCM\Entities\ScmWcr;
use Modules\Admin\Entities\Brand;
use Illuminate\Routing\Controller;
use Modules\Admin\Entities\Branch;
use Modules\SCM\Entities\StockLedger;
use Modules\SCM\Entities\ScmRequisition;
use Illuminate\Contracts\Support\Renderable;
use Modules\SCM\Entities\ScmPurchaseRequisition;

class ScmErrController extends Controller
{
    protected $laravel;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('scm::errs.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $formType = "create";
        $brands = Brand::latest()->get();
        $branchs = Branch::latest()->get();
        return view('scm::errs.create', compact('formType', 'brands', 'branchs'));
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

    public function clientMurWiseMaterials()
    {
        $materials = ScmMur::where('client_id', request()->client_id)->get();
        return response()->json($materials);
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
            'receiveable_type' => ($request->received_type[$key1] == 'MRR') ? ScmMrr::class : (($request->received_type[$key1] == 'WCR') ? ScmWcr::class : (($request->received_type[$key1] == 'ERR') ? ScmErr::class : NULL)),
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
            'receiveable_type' => ($request->received_type[$key1] == 'MRR') ? ScmMrr::class : (($request->received_type[$key1] == 'WCR') ? ScmWcr::class : (($request->received_type[$key1] == 'ERR') ? ScmErr::class : null)),
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
            ->when(request()->type == 'ERR', function ($query) {
                $query->whereHasMorph('receiveable', ScmPurchaseRequisition::class, function ($query) {
                    $query->where('err_no', 'like', '%' . request()->search . '%');
                });
            })
            ->when(request()->type == 'WCR', function ($query) {
                $query->whereHasMorph('receiveable', ScmPurchaseRequisition::class, function ($query) {
                    $query->where('wcr_no', 'like', '%' . request()->search . '%');
                });
            })
            ->get()
            ->unique(function ($item) {
                return $item->receiveable->mrr_no ?? $item->receiveable->err_no ?? $item->receiveable->wcr_no;
            })
            ->take(10)
            ->map(fn ($item) => [
                'value' => $item->receiveable->mrr_no ?? $item->receiveable->err_no ?? $item->receiveable->wcr_no,
                'label' => $item->receiveable->mrr_no ?? $item->receiveable->err_no ?? $item->receiveable->wcr_no,
                'id'    => $item->receiveable->id,
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

    public function materialWiseBrands()
    {
        $data['options'] = StockLedger::query()
            ->with('brand')
            ->where([
                'material_id' => request()->material_id,
                'receiveable_id' => request()->receiveable_id,
                'received_type' => request()->received_type,
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
                'receiveable_id' => request()->receiveable_id,
                'received_type' => request()->received_type,
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
}
