<?php

namespace Modules\SCM\Http\Controllers;

use Illuminate\Http\Request;
use Modules\SCM\Entities\ScmErr;
use Modules\SCM\Entities\ScmMrr;
use Modules\SCM\Entities\ScmWcr;
use Modules\Admin\Entities\Brand;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\Branch;
use Modules\SCM\Entities\StockLedger;
use Illuminate\Contracts\Support\Renderable;

class ScmWcrController extends Controller
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
        $formType = "create";
        $brands = Brand::latest()->get();
        $branchs = Branch::latest()->get();
        return view('scm::wcrs.create', compact('formType', 'brands', 'branchs'));
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

    public function searchSerialForWcr(Request $request)
    {
        $data = StockLedger::whereHas('material', function ($item) use ($request) {
            $item->where('name', 'like', '%' . $request->search . '%');
        })->whereHasMorph('stockable', [ScmMrr::class], function ($item) use ($request) {
            return $item->where('supplier_id', request()->customQueryFields['supplier_id']);
        })
            ->where('quantity', '<=', 1)
            ->pluck('serial_code')
            ->toArray();
        $receive_type = ($request->customQueryFields['type'] == 'MRR') ? ScmMrr::class : (($request->customQueryFields['type'] == 'WCR') ? ScmWcr::class : (($request->customQueryFields['type'] == 'ERR') ? ScmErr::class : NULL));
        $items = StockLedger::query()
            ->with(['material', 'brand'])
            ->whereIn('serial_code', $data)
            ->get()
            ->groupBy(['serial_code'])
            ->map(function ($group) {
                return $group->last();
            })
            ->filter(function ($item) use ($receive_type) {
                return $item->stockable_type == $receive_type;
            })
            ->flatten()
            ->map(fn ($item) => [
                'value' => $item->material->name,
                'label' => $item->material->name . ' - ' . $item->serial_code . ' - ' . $item->brand->name . ' - ' . $item->model,
                'material_id' => $item->material_id,
                'serial_code' => $item->serial_code,
                'brand_id' => $item->brand_id,
                'brand_name' => $item->brand->name,
                'model' => $item->model,
                'unit' => $item->material->unit,
                'item_code' => $item->material->code,
                'item_type' => $item->material->type,
            ]);
        return response()->json($items);
    }
}
