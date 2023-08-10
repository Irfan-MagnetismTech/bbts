<?php

namespace Modules\Changes\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Admin\Entities\Brand;
use Modules\Sales\Entities\ConnectivityRequirement;
use Modules\Sales\Entities\LeadGeneration;
use Modules\Sales\Entities\Vendor;
use Modules\SCM\Entities\Material;
use Modules\Sales\Entities\Product;

class ClientPlanningModificationController extends Controller
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
    public function create($fr_no)
    {
        $connectivity_requirement = ConnectivityRequirement::with('connectivityRequirementDetails', 'connectivityProductRequirementDetails')->where('fr_no', $fr_no)->where('is_modified',1)->first();
        $lead_generation = LeadGeneration::where('client_no', $connectivity_requirement->client_no)->first();
        $particulars = Product::get();
        $materials = Material::get();
        $brands = Brand::get();
        $vendors = Vendor::get();
        $particulars = Product::get();
        $materials = Material::get();
        $brands = Brand::get();
        $vendors = Vendor::get();
        return view('changes::modify_planning.create', compact('particulars', 'materials', 'brands', 'vendors'));
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
