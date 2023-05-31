<?php

namespace Modules\SCM\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Admin\Entities\Brand;
use Illuminate\Routing\Controller;
use Modules\Admin\Entities\Branch;
use Modules\SCM\Entities\ScmChallan;
use Modules\SCM\Entities\StockLedger;
use Illuminate\Contracts\Support\Renderable;
use Modules\SCM\Entities\PurchaseOrderLine;

class ScmWorController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('scm::wor.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $brands = Brand::latest()->get();
        $branches = Branch::latest()->get();
        return view('scm::wor.create', compact('brands', 'branches'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        // return view('scm::wor.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('scm::wor.create');
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

    public function searchSerialForWor()
    {
        $data = PurchaseOrderLine::query()
            ->with(['material', 'brand'])
            ->whereHas('purchaseOrder', function ($item) {
                $item->where('purchase_order_id', request()->customQueryFields['id']);
            })
            ->whereHas('material', function ($item) {
                $item->where('name', 'like', '%' . request()->search . '%');
            })
            ->get();

        $items = StockLedger::query()
            ->with(['material', 'brand'])
            ->whereIn('material_id', $data->pluck('material_id')->toArray())
            ->whereIn('brand_id', $data->pluck('brand_id')->toArray())
            ->get()
            ->groupBy(['serial_code'])
            ->map(function ($group) {
                return $group->last();
            })
            ->filter(function ($item) {
                return $item->stockable_type == ScmChallan::class;
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
