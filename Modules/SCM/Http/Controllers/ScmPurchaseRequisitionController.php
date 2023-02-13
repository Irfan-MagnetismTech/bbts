<?php

namespace Modules\SCM\Http\Controllers;

use Termwind\Components\Dd;
use Modules\Admin\Entities\Pop;
use Modules\Admin\Entities\Brand;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\Branch;
use Modules\Sales\Entities\Client;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\QueryException;
use Modules\Sales\Entities\ClientDetail;
use Modules\SCM\Entities\ScmPurchaseRequisition;
use Modules\SCM\Http\Requests\SupplierRequest;
use Modules\SCM\Http\Requests\ScmPurchaseRequisitionRequest;

class ScmPurchaseRequisitionController extends Controller
{
    use HasRoles;
    function __construct()
    {
        // $this->middleware('permission:requisition-view|requisition-create|requisition-edit|requisition-delete', ['only' => ['index','show']]);
        // $this->middleware('permission:requisition-create', ['only' => ['create','store']]);
        // $this->middleware('permission:requisition-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:requisition-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $purchaseRequisitions = ScmPurchaseRequisition::with('client', 'requisitionBy')->latest()->get();

        return view('scm::purchase-requisitions.index', compact('purchaseRequisitions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";
        $purchaseRequisitions = ScmPurchaseRequisition::latest()->get();
        $brands = Brand::latest()->get();
        $branchs = Branch::latest()->get();

        return view('scm::purchase-requisitions.create', compact('purchaseRequisitions', 'formType', 'brands', 'branchs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ScmPurchaseRequisitionRequest $request)
    {
        try {
            DB::beginTransaction();
            if (request()->has('client')) {
                $requestData = $request->only('type', 'client_id', 'date', 'branch_id', 'fr_composite_key');
            } elseif (request()->has('warehouse')) {
                $requestData = $request->only('type', 'date', 'branch_id');
            } else {
                $requestData = $request->only('type', 'date', 'branch_id', 'pop_id');
            }

            $lastMRSId = ScmPurchaseRequisition::latest()->first();
            if ($lastMRSId) {
                $requestData['mrs_no'] = now()->format('Y') . '-' . $lastMRSId->id + 1;
            } else {
                $requestData['mrs_no'] = now()->format('Y') . '-' . 1;
            }
            $requestData['requisition_by'] = auth()->id();
            $requisition = ScmPurchaseRequisition::create($requestData);

            $requisitionDetails = [];
            foreach ($request->material_id as $key => $data) {
                $requisitionDetails[] = [
                    'material_id' => $request->material_id[$key],
                    'item_code' => $request->item_code[$key],
                    'req_key' => $requisition->id . '-' . $request->item_code[$key],
                    'description' => $request->description[$key],
                    'quantity' => $request->quantity[$key],
                    'brand_id' => $request->brand_id[$key],
                    'model' => $request->model[$key],
                    'purpose' => $request->purpose[$key],
                ];
            }

            $requisition->scmRequisitiondetails()->createMany($requisitionDetails);
            DB::commit();

            return redirect()->route('purchase-requisitions.index')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('purchase-requisitions.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ScmPurchaseRequisition  $requisition
     * @return \Illuminate\Http\Response
     */
    public function show(ScmPurchaseRequisition $requisition)
    {
        // dd($requisition->scmRequisitiondetailsWithMaterial);
        return view('scm::purchase-requisitions.show', compact('requisition'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ScmPurchaseRequisition  $requisition
     * @return \Illuminate\Http\Response
     */
    public function edit(ScmPurchaseRequisition $requisition)
    {
        $formType = "edit";
        $brands = Brand::latest()->get();
        $branchs = Branch::latest()->get();
        $pops = Pop::latest()->get();
        $clients = Client::latest()->get();
        $clientDetails = ClientDetail::latest()->get();
        $clientInfos = ClientDetail::where('client_id', $requisition->client_id)->get();
        // $branchwisePops = ScmPurchaseRequisition::with('pop')->where('id', $requisition->id)->get();
        $branchwisePops = Pop::where('branch_id', $requisition->branch_id)->get();
        // $fr_composite_key = $requisition->fr_composite_key;
        return view('scm::purchase-requisitions.create', compact('requisition', 'formType', 'brands', 'pops', 'clients', 'clientDetails', 'clientInfos', 'branchs', 'branchwisePops'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ScmPurchaseRequisition  $requisition
     * @return \Illuminate\Http\Response
     */
    public function update(SupplierRequest $request, ScmPurchaseRequisition $requisition)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();
            if (request()->has('client')) {
                $requestData = $request->only('type', 'client_id', 'date', 'branch_id', 'fr_composite_key');
            } elseif (request()->has('warehouse')) {
                $requestData = $request->only('type', 'date', 'branch_id');
            } else {
                $requestData = $request->only('type', 'date', 'branch_id', 'pop_id');
            }
            $requestData['requisition_by'] = auth()->id();

            $requisition->update($requestData);

            $requisitionDetails = [];
            foreach ($request->material_id as $key => $data) {
                $requisitionDetails[] = [
                    'material_id' => $request->material_id[$key],
                    'item_code' => $request->item_code[$key],
                    'req_key' => $requisition->id . '-' . $request->item_code[$key],
                    'description' => $request->description[$key],
                    'quantity' => $request->quantity[$key],
                    'brand_id' => $request->brand_id[$key],
                    'model' => $request->model[$key],
                    'purpose' => $request->purpose[$key],
                ];
            }

            $requisition->scmRequisitiondetails()->delete();
            $requisition->scmRequisitiondetails()->createMany($requisitionDetails);
            DB::commit();

            return redirect()->route('purchase-requisitions.index')->with('message', 'Data has been updated successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('purchase-requisitions.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ScmPurchaseRequisition  $requisition
     * @return \Illuminate\Http\Response
     */
    public function destroy(ScmPurchaseRequisition $requisition)
    {
        try {
            $requisition->delete();
            return redirect()->route('purchase-requisitions.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            return redirect()->route('purchase-requisitions.index')->withErrors($e->getMessage());
        }
    }
}
