<?php

namespace Modules\Changes\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Sales\Entities\Planning;

class CostingModificationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('changes::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($fr_no = null)
    {
        $planning = Planning::with('equipmentPlans.material', 'servicePlans', 'planLinks.PlanLinkEquipments.material')
            ->where('fr_no', $fr_no)->where('is_modified', 1)->first();
        $feasibilityRequirementDetail = $planning->feasibilityRequirementDetail;
        return view('sales::costing.create', compact('planning', 'feasibilityRequirementDetail'));
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
        return view('changes::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('changes::edit');
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
}