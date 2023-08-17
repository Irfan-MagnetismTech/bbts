<?php

namespace Modules\Changes\Http\Controllers;

use Mpdf\Tag\Dd;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Sales\Entities\Vendor;
use Modules\Sales\Entities\Product;
use Modules\Sales\Entities\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Renderable;
use Modules\Sales\Entities\ConnectivityRequirement;
use Modules\Networking\Entities\PhysicalConnectivity;
use Modules\Sales\Entities\FeasibilityRequirementDetail;
use Modules\Sales\Entities\ConnectivityRequirementDetail;
use Modules\Sales\Entities\ConnectivityProductRequirementDetail;

class ClientRequirementController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $client_requirements = ConnectivityRequirement::modified()->latest()->get();
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
        // dd($request->all());
        return $this->storeOrUpdate($request);
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
    public function edit(ConnectivityRequirement $clientRequirementModification)
    {
        $products = Product::all();
        $categories = Category::all();
        $vendors = Vendor::all();
        $frList = FeasibilityRequirementDetail::where('client_no', $clientRequirementModification->client_no)->pluck('fr_no', 'id');
               
        $physicalConnectivity = PhysicalConnectivity::query()
            ->with('lines.connectivityLink.vendor')
            ->whereClientNoAndFrNo($clientRequirementModification->client_no,$clientRequirementModification->fr_no)
            ->orderBy('sale_id', 'desc')
            ->first();

        return view('changes::client_requirement.create', compact('products', 'categories', 'vendors', 'clientRequirementModification', 'frList', 'physicalConnectivity'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, ConnectivityRequirement $clientRequirementModification)
    {
        // dd($request->all());
        return $this->storeOrUpdate($request, $clientRequirementModification);
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

    /**
     * Creating or updating the connectivity requirement
     * 
     * @param Request $request
     * @param ConnectivityRequirement|null $requirement
     * @return RedirectResponse
     * 
     * @throws QueryException
     */
    protected function storeOrUpdate($request, ConnectivityRequirement $clientRequirementModification = null): RedirectResponse
    {
        $requestedData = collect($request->all());
        $parentData = $requestedData->merge($this->extraParentData($request))->toArray();

        try {
            DB::beginTransaction();

            $requirement = $this->createOrUpdateConnectivityRequirement($parentData, $clientRequirementModification);

            $productRequirementData = $this->extractProductRequirementData($parentData);
            $requirement->connectivityProductRequirementDetails()->createMany($productRequirementData);

            $requirementDetailsData = $this->extractRequirementDetailsData($parentData);
            $requirement->connectivityRequirementDetails()->createMany($requirementDetailsData);

            DB::commit();

            return $this->redirectWithSuccessMessage($requirement);
        } catch (QueryException $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Adding extra data to the parent data
     * 
     * @param Request $request
     * @return array
     */
    protected function extraParentData($request): array
    {
        return [
            'user_id' => auth()->id() ?: '',
            'branch_id' => auth()->user()->branch_id ?: '',
            'change_type' => json_encode($request->change_type),
            'is_modified' => 1,
        ];
    }

    /**
     * Creating or updating the connectivity requirement
     * 
     * @param array $parentData
     * @param ConnectivityRequirement|null $requirement
     * @return ConnectivityRequirement
     */
    protected function createOrUpdateConnectivityRequirement(array $parentData, ConnectivityRequirement $clientRequirementModification = null)
    {
        if (!$clientRequirementModification) {
            return ConnectivityRequirement::create($parentData);
        } else {
            $clientRequirementModification->update($parentData);
            $clientRequirementModification->connectivityProductRequirementDetails()->delete();
            $clientRequirementModification->connectivityRequirementDetails()->delete();
            return $clientRequirementModification;
        }
    }

    /**
     * Creating product requirement lines data
     * 
     * @param $request
     * @return array
     */
    protected function extractProductRequirementData($request): array
    {
        $data = [];
        foreach ($request['plan'] as $key => $plan) {
            if (!empty($plan)) {
                $data[] = [
                    'category_id' => $request['product_category'][$key],
                    'product_id' => $request['product'][$key],
                    'prev_quantity' => $request['prev_quantity'][$key],
                    'capacity' => $plan,
                    'remarks' => $request['remarks'][$key],
                ];
            }
        }
        return $data;
    }

    /**
     * Creating requirement lines data
     * 
     * @param $request
     * @return array
     */
    protected function extractRequirementDetailsData($request): array
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

    /**
     * Redirecting to index page with message
     * 
     * @param ConnectivityRequirement $clientRequirementModification
     * @return RedirectResponse
     */
    protected function redirectWithSuccessMessage(ConnectivityRequirement $clientRequirementModification): RedirectResponse
    {
        $message = 'Connectivity Requirement ' . ($clientRequirementModification->wasRecentlyCreated ? 'Created' : 'Updated') . ' Successfully';
        return redirect()->route('client-requirement-modification.index')->with('success', $message);
    }
}
