<?php

namespace Modules\SCM\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Admin\Entities\Brand;
use Illuminate\Routing\Controller;
use Modules\Admin\Entities\Branch;
use Modules\SCM\Entities\Material;
use Modules\SCM\Entities\PurchaseOrder;
use Modules\SCM\Http\Requests\MrrRequest;
use Modules\SCM\Entities\PurchaseOrderLine;
use Illuminate\Contracts\Support\Renderable;

class ScmMrrController extends Controller
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
        $brands = Brand::latest()->get();
        return view('scm::mrr.create', compact('brands'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(MrrRequest $request)
    {
        dd($request->all());
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

    public function searchPoWithDate(Request $request)
    {
        $search = $request->search;
        $items = PurchaseOrder::query()
            ->with('purchaseOrderLines')
            ->where("po_no", "like", "%$search%")
            ->get()
            ->map(fn ($item) => [
                'value' => $item->id,
                'label' => $item->po_no,
                'date' => $item->date,
                'supplier_id' => $item?->supplier_id ?? 0,
                'supplier_name' => $item?->supplier?->name ?? 0
            ]);


        return response()->json($items);
    }

    public function getMaterialForPo($po_id)
    {
        $items = PurchaseOrderLine::query()
            ->with('material')
            ->whereHas('purchaseOrder', function ($item) use ($po_id) {
                return $item->where('id', $po_id);
            })->get()->unique('material_id');


        return response()->json($items);
    }

    public function getUnit($material_id)
    {
        $items = Material::find($material_id);


        return response()->json($items);
    }
}
