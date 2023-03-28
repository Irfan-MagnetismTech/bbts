<?php

namespace Modules\Sales\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Sales\Entities\Category;
use Modules\Sales\Entities\FeasibilityRequirement;
use Modules\Sales\Entities\FeasibilityRequirementDetail;

use Illuminate\Support\Facades\DB;
use Modules\Sales\Entities\ConnectivityRequirement;
use Modules\Sales\Entities\ConnectivityRequirementDetail;
use Modules\Sales\Entities\ConnectivityProductRequirementDetail;
use Modules\Sales\Http\Requests\ConnectivityRequirementRequest;

class ConnectivityRequirementController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $connectivity_requirements = ConnectivityRequirement::with('connectivityRequirementDetails', 'connectivityProductRequirementDetails', 'lead_generation', 'fromLocation')->get();
        return view('sales::connectivity_requirement.index', compact('connectivity_requirements'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($fr_id)
    {
        $fr_detail = FeasibilityRequirementDetail::with('feasibilityRequirement.lead_generation', 'feasibilityRequirement.feasibilityRequirementDetails')->find($fr_id);
        $feasibility_requirement = FeasibilityRequirement::where('client_id', $fr_detail->feasibilityRequirement->client_id)->first();
        $all_fr_list = FeasibilityRequirementDetail::where('feasibility_requirement_id', $feasibility_requirement->id)->get();
        $categories = Category::all();
        return view('sales::connectivity_requirement.create', compact('fr_detail', 'categories', 'all_fr_list'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(ConnectivityRequirementRequest $request)
    {
        $connectivity_requirement_data = $request->only('date', 'client_id', 'from_location', 'aggregation_type', 'fr_no');
        $connectivity_requirement_data['user_id'] = auth()->user()->id ?? '';
        $connectivity_requirement_data['branch_id'] = auth()->user()->branch_id ?? '';
        $connectivity_requirement_data['date'] = date('Y-m-d', strtotime($request->date));
        $connectivity_requirement_data['mq_no'] = FeasibilityRequirement::where('client_id', $connectivity_requirement_data['client_id'])->first()->mq_no;

        DB::beginTransaction();
        try {
            $connectivity_requirement = ConnectivityRequirement::create($connectivity_requirement_data);
            foreach ($request->category_id as $key => $category_id) {
                $connectivity_requirement_details['connectivity_requirement_id'] = $connectivity_requirement->id;
                $connectivity_requirement_details['category_id'] = $category_id;
                $connectivity_requirement_details['product_id'] = $request->product_id[$key];
                $connectivity_requirement_details['capacity'] = $request->capacity[$key];
                ConnectivityProductRequirementDetail::create($connectivity_requirement_details);
            }
            foreach ($request->link_type as $key => $link_type) {
                $connectivity_product_requirement_details['connectivity_requirement_id'] = $connectivity_requirement->id;
                $connectivity_product_requirement_details['link_type'] = $link_type;
                $connectivity_product_requirement_details['method'] = $request->method[$key];
                $connectivity_product_requirement_details['connectivity_capacity'] = $request->connectivity_capacity[$key];
                $connectivity_product_requirement_details['sla'] = $request->uptime_req[$key];
                ConnectivityRequirementDetail::create($connectivity_product_requirement_details);
            }
            DB::commit();
            return redirect()->route('connectivity-requirement.index')->with('success', 'Connectivity Requirement Created Successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $connectivity_requirement = ConnectivityRequirement::with('connectivityRequirementDetails', 'connectivityProductRequirementDetails', 'lead_generation', 'fromLocation')->find($id);
        return view('sales::connectivity_requirement.show', compact('connectivity_requirement'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $product_select = [];
        $product_unit = [];
        $connectivity_requirement = ConnectivityRequirement::with('connectivityRequirementDetails', 'connectivityProductRequirementDetails.category.products', 'lead_generation', 'fromLocation')->find($id);

        foreach ($connectivity_requirement->connectivityProductRequirementDetails as $key => $connectivityProductRequirementDetail) {
            $product_select[] = $connectivityProductRequirementDetail->category->products->pluck('id', 'name');
            $product_unit[] = $connectivityProductRequirementDetail->product->unit;
        }
        $connectivity_requirement->product_unit = $product_unit;
        $connectivity_requirement->product_select = $product_select;
        $all_fr_list = FeasibilityRequirementDetail::where('feasibility_requirement_id', $connectivity_requirement->fromLocation->feasibility_requirement_id)->get();
        $categories = Category::all();
        // dd($categories);
        return view('sales::connectivity_requirement.create', compact('connectivity_requirement', 'categories', 'all_fr_list'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, ConnectivityRequirement $connectivity_requirement)
    {
        $connectivity_requirement_data = $request->only('date', 'client_id', 'from_location', 'aggregation_type', 'fr_no');
        $connectivity_requirement_data['user_id'] = auth()->user()->id ?? '';
        $connectivity_requirement_data['branch_id'] = auth()->user()->branch_id ?? '';
        $connectivity_requirement_data['date'] = date('Y-m-d', strtotime($request->date));
        $connectivity_requirement_data['mq_no'] = FeasibilityRequirement::where('client_id', $connectivity_requirement_data['client_id'])->first()->mq_no;

        DB::beginTransaction();
        try {
            $connectivity_requirement->update($connectivity_requirement_data);
            $connectivity_requirement->connectivityProductRequirementDetails()->delete();
            $connectivity_requirement->connectivityRequirementDetails()->delete();
            foreach ($request->category_id as $key => $category_id) {
                $connectivity_requirement_details['connectivity_requirement_id'] = $connectivity_requirement->id;
                $connectivity_requirement_details['category_id'] = $category_id;
                $connectivity_requirement_details['product_id'] = $request->product_id[$key];
                $connectivity_requirement_details['capacity'] = $request->capacity[$key];
                ConnectivityProductRequirementDetail::create($connectivity_requirement_details);
            }
            foreach ($request->link_type as $key => $link_type) {
                $connectivity_product_requirement_details['connectivity_requirement_id'] = $connectivity_requirement->id;
                $connectivity_product_requirement_details['link_type'] = $link_type;
                $connectivity_product_requirement_details['method'] = $request->method[$key];
                $connectivity_product_requirement_details['connectivity_capacity'] = $request->connectivity_capacity[$key];
                $connectivity_product_requirement_details['sla'] = $request->uptime_req[$key];
                ConnectivityRequirementDetail::create($connectivity_product_requirement_details);
            }
            DB::commit();
            return redirect()->route('connectivity-requirement.index')->with('success', 'Connectivity Requirement Updated Successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
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