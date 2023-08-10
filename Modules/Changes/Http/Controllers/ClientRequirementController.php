<?php

namespace Modules\Changes\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\QueryException;
use Modules\Sales\Entities\Category;
use Modules\Sales\Entities\Product;
use Modules\Sales\Entities\Vendor;
use Illuminate\Support\Facades\DB;
use Modules\Sales\Entities\ConnectivityRequirement;
use Modules\Sales\Entities\ConnectivityProductRequirementDetail;
use Modules\Sales\Entities\ConnectivityRequirementDetail;
use Mpdf\Tag\Dd;

class ClientRequirementController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $client_requirements = ConnectivityRequirement::where('is_modified', 1)->get();
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
    {
        return $this->storeOrUpdate($request);
    }

    protected function storeOrUpdate($request, ConnectivityRequirement $requirement = null)
    {
        $requestedData = collect($request->all());
        $parentData = $requestedData->merge($this->extractParentData($request))->toArray();

        try {
            DB::beginTransaction();

            $requirement = $this->createOrUpdateConnectivityRequirement($parentData, $requirement);

            $productRequirementData = $this->extractProductRequirementData($parentData);
            $requirement->connectivityProductRequirementDetails()->createMany($productRequirementData);

            $requirementDetailsData = $this->extractRequirementDetailsData($parentData);
            $requirement->connectivityRequirementDetails()->createMany($requirementDetailsData);

            DB::commit();

            return $this->redirectToIndexWithMessage($requirement);
        } catch (QueryException $e) {
            DB::rollback();

            return $this->handleErrorAndRedirectBack($e, $parentData);
        }
    }

    protected function extractParentData($request)
    {
        return [
            'user_id' => auth()->id() ?: '',
            'branch_id' => auth()->user()->branch_id ?: '',
            'change_type' => json_encode($request->change_type),
            'is_modified' => 1,
        ];
    }

    protected function createOrUpdateConnectivityRequirement(array $parentData, ConnectivityRequirement $requirement = null)
    {
        if (!$requirement) {
            return ConnectivityRequirement::create($parentData);
        } else {
            $requirement->update($parentData);
            $requirement->connectivityProductRequirementDetails()->delete();
            $requirement->connectivityRequirementDetails()->delete();
            return $requirement;
        }
    }

    protected function extractProductRequirementData($request)
    {
        $data = [];
        foreach ($request['plan'] as $key => $plan) {
            if (!empty($plan)) {
                $data[] = [
                    'category_id' => $request['product_category'][$key],
                    'product_id' => $request['product'][$key],
                    'capacity' => $plan,
                    'remarks' => $request['remarks'][$key],
                ];
            }
        }
        return $data;
    }

    protected function extractRequirementDetailsData($request)
    {
        $data = [];
        foreach ($request['link_type'] as $key => $link_type) {
            if (!empty($link_type)) {
                $data[] = [
                    'link_type' => $link_type,
                    'method' => $request['method'][$key],
                    'connectivity_capacity' => $request['connectivity_capacity'][$key],
                    'sla' => $request['uptime_req'][$key],
                    'vendor_id' => $request['vendor_id'][$key],
                ];
            }
        }
        return $data;
    }

    protected function redirectToIndexWithMessage(ConnectivityRequirement $requirement)
    {
        $message = 'Connectivity Requirement ' . ($requirement->wasRecentlyCreated ? 'Created' : 'Updated') . ' Successfully';
        return redirect()->route('client-requirement-modification.index')->with('success', $message);
    }

    protected function handleErrorAndRedirectBack(QueryException $e)
    {
        return redirect()->back()->with('error', $e->getMessage())->withInput();
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
    public function update(Request $request, ConnectivityRequirement $requirement)
    {
        return $this->storeOrUpdate($request, $requirement);
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
