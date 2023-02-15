<?php

namespace Modules\SCM\Http\Controllers;

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
        $purchaseRequisitions = ScmPurchaseRequisition::with('requisitionBy')->latest()->get();

        return view('scm::purchase-requisitions.index', compact('purchaseRequisitions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Brand::latest()->get();

        return view('scm::purchase-requisitions.create', compact('brands'));
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
            if (request()->type == 'client') {
                $requestData = $request->only('type', 'client_id', 'date', 'fr_composite_key', 'assessment_no');
            } else {
                $requestData = $request->only('type', 'date');
            }

            $lastMRSId = ScmPurchaseRequisition::latest()->first();
            if ($lastMRSId) {
                $requestData['prs_no'] = 'PRS-' . now()->format('Y') . '-' . $lastMRSId->id + 1;
            } else {
                $requestData['prs_no'] = 'PRS-' . now()->format('Y') . '-' . 1;
            }
            $requestData['requisition_by'] = auth()->id();
            $purchaseRequisition = ScmPurchaseRequisition::create($requestData);

            $requisitionDetails = [];
            foreach ($request->material_id as $key => $data) {
                $requisitionDetails[] = [
                    'material_id' => $request->material_id[$key],
                    'item_code' => $request->item_code[$key],
                    'brand_id' => $request->brand_id[$key],
                    'model' => $request->model[$key],
                    'req_key' => $purchaseRequisition->id . '-' . $request->item_code[$key],
                    'quantity' => $request->quantity[$key],
                    'unit_price' => $request->unit_price[$key],
                    'total_amount' => $request->unit_price[$key] * $request->quantity[$key],
                    'purpose' => $request->purpose[$key],
                ];
            }

            $purchaseRequisition->scmPurchaseRequisitionDetails()->createMany($requisitionDetails);
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
     * @param  \App\ScmPurchaseRequisition  $purchaseRequisition
     * @return \Illuminate\Http\Response
     */
    public function show(ScmPurchaseRequisition $purchaseRequisition)
    {
        return view('scm::purchase-requisitions.show', compact('purchaseRequisition'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ScmPurchaseRequisition  $purchaseRequisition
     * @return \Illuminate\Http\Response
     */
    public function edit(ScmPurchaseRequisition $purchaseRequisition)
    {
        $formType = "edit";
        $brands = Brand::latest()->get();
        $branchs = Branch::latest()->get();
        $pops = Pop::latest()->get();
        $clients = Client::latest()->get();
        $clientDetails = ClientDetail::latest()->get();
        $clientInfos = ClientDetail::where('client_id', $purchaseRequisition->client_id)->get();
        return view('scm::purchase-requisitions.create', compact('purchaseRequisition', 'formType', 'brands', 'pops', 'clients', 'clientDetails', 'clientInfos', 'branchs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ScmPurchaseRequisition  $purchaseRequisition
     * @return \Illuminate\Http\Response
     */
    public function update(SupplierRequest $request, ScmPurchaseRequisition $purchaseRequisition)
    {
        try {
            DB::beginTransaction();
            if (request()->type == 'client') {
                $requestData = $request->only('type', 'client_id', 'date', 'fr_composite_key', 'assessment_no');
            } else {
                $requestData = $request->only('type', 'date');
            }
            $requestData['requisition_by'] = auth()->id();

            $purchaseRequisition->update($requestData);

            $requisitionDetails = [];
            foreach ($request->material_id as $key => $data) {
                $requisitionDetails[] = [
                    'material_id' => $request->material_id[$key],
                    'item_code' => $request->item_code[$key],
                    'brand_id' => $request->brand_id[$key],
                    'model' => $request->model[$key],
                    'req_key' => $purchaseRequisition->id . '-' . $request->item_code[$key],
                    'quantity' => $request->quantity[$key],
                    'unit_price' => $request->unit_price[$key],
                    'total_amount' => $request->unit_price[$key] * $request->quantity[$key],
                    'purpose' => $request->purpose[$key],
                ];
            }

            $purchaseRequisition->scmPurchaseRequisitionDetails()->delete();
            $purchaseRequisition->scmPurchaseRequisitionDetails()->createMany($requisitionDetails);
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
     * @param  \App\ScmPurchaseRequisition  $purchaseRequisition
     * @return \Illuminate\Http\Response
     */
    public function destroy(ScmPurchaseRequisition $purchaseRequisition)
    {
        try {
            $purchaseRequisition->delete();
            return redirect()->route('purchase-requisitions.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            return redirect()->route('purchase-requisitions.index')->withErrors($e->getMessage());
        }
    }
}
