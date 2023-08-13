<?php

namespace Modules\Changes\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Admin\Entities\Pop;
use Illuminate\Routing\Controller;
use Modules\Sales\Entities\Vendor;
use Illuminate\Contracts\Support\Renderable;
use Modules\Networking\Entities\PhysicalConnectivityLines;
use Modules\Sales\Entities\ConnectivityRequirement;
use Modules\Sales\Entities\FeasibilityRequirementDetail;

class ModifiedSurveyController extends Controller
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
    public function create($id)
    {
        // $fr_detail = FeasibilityRequirementDetail::with('feasibilityRequirement')->find($fr_id);
        $all_fr_list = FeasibilityRequirementDetail::get();
        $connectivity_requirement = ConnectivityRequirement::with('connectivityRequirementDetails.vendor', 'connectivityProductRequirementDetails', 'client', 'FeasibilityRequirementDetail.feasibilityRequirement')->where('id', $id)->first();
        $current_qty = $connectivity_requirement->connectivityProductRequirementDetails;
        $previous_qty = ConnectivityRequirement::with('connectivityRequirementDetails.vendor', 'connectivityProductRequirementDetails', 'client', 'FeasibilityRequirementDetail.feasibilityRequirement')->where('fr_no', $connectivity_requirement->fr_no)->latest()->first()->connectivityProductRequirementDetails;
        $merged_qty = $previous_qty->merge($current_qty);
        $grouped_qty = $merged_qty->groupBy('product_id');
        $grouped_current_qty = $current_qty->groupBy('product_id');
        $grouped_previous_qty = $previous_qty->groupBy('product_id');
        $pops = Pop::get();
        $vendors = Vendor::get();
        $existingConnections = PhysicalConnectivityLines::query()
            ->whereHas('physicalConnectivity', function ($qr) use ($connectivity_requirement) {
                return $qr->where('fr_no', $connectivity_requirement->fr_no);
            })->get();
        return view('changes::modified_servey.create', compact('connectivity_requirement', 'grouped_qty', 'grouped_previous_qty', 'grouped_current_qty', 'existingConnections'));
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
