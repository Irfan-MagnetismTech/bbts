<?php

namespace Modules\SCM\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Admin\Entities\Brand;
use Illuminate\Routing\Controller;
use Modules\Admin\Entities\Branch;
use Illuminate\Contracts\Support\Renderable;
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
        $out_from = ['mrr', 'err', 'wcr'];
        $brands = Brand::latest()->get();
        $branches = Branch::latest()->get();
        return view('scm::mir.create', compact('brands', 'branches', 'out_from'));
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
        $items = ScmPurchaseRequisition::query()
            ->where("prs_no", "like", "%" . request()->search . "%")
            ->get()
            ->map(fn ($item) => [
                'value' => $item->prs_no,
                'label' => $item->prs_no,
                'scm_purchase_requisition_id' => $item->id,
            ]);

        return response()->json($items);
    }
}
