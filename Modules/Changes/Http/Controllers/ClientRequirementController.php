<?php

namespace Modules\Changes\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;
use Modules\Changes\Entities\ClientRequirement;
use Modules\Changes\Http\Requests\ClientRequirementRequest;
use Modules\Sales\Entities\Category;
use Modules\Sales\Entities\Product;
use Modules\Sales\Entities\Vendor;
use Illuminate\Support\Facades\DB;
use Modules\Sales\Entities\ConnectivityRequirement;
use Modules\Sales\Entities\ConnectivityProductRequirementDetail;
use Modules\Sales\Entities\ConnectivityRequirementDetail;

class ClientRequirementController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $client_requirements = ConnectivityRequirement::modified()->get();
        return view('changes::client_requirement.index', compact('client_requirements'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $products = Product::all();
        $categories = Category::all();
        $vendors = Vendor::all();
        return view('changes::client_requirement.create', compact('products', 'categories', 'vendors'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    { {
            DB::beginTransaction();
            try {
                $requirement = $this->createConnectivityRequirement($request);
                $this->createConnectivityProductRequirements($request, $requirement);
                $this->createConnectivityRequirementDetails($request, $requirement);

                DB::commit();
                return redirect()->route('client-requirement-modification.index')->with('success', 'Connectivity Requirement Created Successfully');
            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->back()->with('error', $e->getMessage())->withInput();
            }
        }
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

    protected function createConnectivityRequirement($request)
    {
        $data = $request->only('client_no', 'fr_no', 'from_date', 'to_date', 'existing_mrc', 'decrease_mrc', 'connectivity_remarks');
        $data['user_id'] = auth()->id() ?: '';
        $data['branch_id'] = auth()->user()->branch_id ?: '';
        $data['date'] = date('Y-m-d', strtotime($request->date));
        $data['change_type'] = json_encode($request->change_type);
        $data['activation_date'] = date('Y-m-d', strtotime($request->activation_date));
        $data['is_modified'] = 1;
        return ConnectivityRequirement::create($data);
    }

    protected function createConnectivityProductRequirements($request, $requirement)
    {

        foreach ($request->plan as $key => $plan) {
            if (!empty($plan)) {
                ConnectivityProductRequirementDetail::create([
                    'connectivity_requirement_id' => $requirement->id,
                    'category_id' => $request->product_category[$key],
                    'product_id' => $request->product[$key],
                    'capacity' => $plan,
                    'remarks' => $request->remarks[$key],
                ]);
            }
        }
    }

    protected function createConnectivityRequirementDetails($request, $requirement)
    {
        foreach ($request->link_type as $key => $link_type) {
            if (!empty($link_type)) {
                ConnectivityRequirementDetail::create([
                    'connectivity_requirement_id' => $requirement->id,
                    'link_type' => $link_type,
                    'method' => $request->method[$key],
                    'connectivity_capacity' => $request->connectivity_capacity[$key],
                    'sla' => $request->uptime_req[$key],
                    'vendor_id' => $request->vendor_id[$key],
                ]);
            }
        }
    }
}
