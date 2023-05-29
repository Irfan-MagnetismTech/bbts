<?php

namespace Modules\SCM\Http\Controllers;

use Illuminate\Http\Request;
use Modules\SCM\Entities\ScmWcr;
use Modules\Admin\Entities\Brand;
use Illuminate\Routing\Controller;
use Modules\Admin\Entities\Branch;
use Modules\SCM\Entities\StockLedger;
use Illuminate\Contracts\Support\Renderable;

class ScmWcrrController extends Controller
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
        return view('scm::wcrrs.create', compact('formType', 'brands', 'branchs'));
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

    public function searchWcrForWcrr(Request $request)
    {
        $items = ScmWcr::query()
            ->where('wcr_no', 'like', '%' . $request->search . '%')
            ->get()
            ->map(fn ($item) => [
                'value' => $item->wcr_no,
                'label' => $item->wcr_no,
                'wcr_id' => $item->id,
                'sending_date' => $item->sending_date,
            ]);

        return response()->json($items);
    }


    public function searchMaterialForWcrr(Request $request)
    {
        $data = StockLedger::query()->whereHasMorph('stockable', [ScmWcr::class], function ($item) use ($request) {
            return $item->where('id', request()->wcr_id);
        })->pluck('serial_code');

        $datas = StockLedger::query()->whereIn('serial_code', $data)->get()
        ->groupBy(['serial_code'])
        ->map(function ($group) {
            return $group->last();
        })
        ->filter(function ($item) {
            return $item->stockable_type == ScmWcr::class;
        })
        ->flatten()
        ->map(fn ($item) => [
            'material_name' => $item->material->name,
            'material_id' => $item->material_id,
            'serial_code' => $item->serial_code,
            'brand_id' => $item->brand_id,
            'brand_name' => $item->brand->name,
            'model' => $item->model,
            'unit' => $item->material->unit,
            'item_code' => $item->material->code,
            'item_type' => $item->material->type,
        ]);

        return response()->json($datas);
    }
}
