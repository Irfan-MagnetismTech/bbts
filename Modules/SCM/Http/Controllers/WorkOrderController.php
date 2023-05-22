<?php

namespace Modules\SCM\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Admin\Entities\Pop;
use Modules\Admin\Entities\Brand;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\Branch;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Renderable;

class WorkOrderController extends Controller
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
        $requisitions = ScmWorkOrder::with('client', 'requisitionBy')->latest()->get();

        return view('scm::requisitions.index', compact('requisitions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";
        $requisitions = ScmWorkOrder::latest()->get();
        $brands = Brand::latest()->get();
        $branchs = Branch::latest()->get();

        return view('scm::requisitions.create', compact('requisitions', 'formType', 'brands', 'branchs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ScmWorkOrderRequest $request)
    {
        try {
            DB::beginTransaction();
            if (request()->type == 'client') {
                $requestData = $request->only('type', 'client_id', 'date', 'branch_id', 'fr_composite_key');
            } elseif (request()->type == 'warehouse') {
                $requestData = $request->only('type', 'date', 'branch_id');
            } else {
                $requestData = $request->only('type', 'date', 'branch_id', 'pop_id');
            }

            $lastMRSId = ScmWorkOrder::latest()->first();
            if ($lastMRSId) {
                if (now()->format('Y') != date('Y', strtotime($lastMRSId->created_at))) {
                    $requestData['mrs_no'] = 'MRS-' . now()->format('Y') . '-' . 1;
                } else {
                    $requestData['mrs_no'] = 'MRS-' . now()->format('Y') . '-' . ($lastMRSId->id + 1);
                }
            } else {
                $requestData['mrs_no'] = 'MRS-' . now()->format('Y') . '-' . 1;
            }
            $requestData['requisition_by'] = auth()->id();
            $requisition = ScmWorkOrder::create($requestData);

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

            $requisition->ScmWorkOrderdetails()->createMany($requisitionDetails);
            DB::commit();

            return redirect()->route('requisitions.index')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('requisitions.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ScmWorkOrder  $requisition
     * @return \Illuminate\Http\Response
     */
    public function show(ScmWorkOrder $requisition)
    {
        // dd($requisition->ScmWorkOrderdetailsWithMaterial);
        return view('scm::requisitions.show', compact('requisition'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ScmWorkOrder  $requisition
     * @return \Illuminate\Http\Response
     */
    public function edit(ScmWorkOrder $requisition)
    {
        $formType = "edit";
        $brands = Brand::latest()->get();
        $branchs = Branch::latest()->get();
        $pops = Pop::latest()->get();
        $clients = Client::latest()->get();
        $clientDetails = ClientDetail::latest()->get();
        $clientInfos = ClientDetail::where('client_id', $requisition->client_id)->get();
        // $branchwisePops = ScmWorkOrder::with('pop')->where('id', $requisition->id)->get();
        $branchwisePops = Pop::where('branch_id', $requisition->branch_id)->get();
        // $fr_composite_key = $requisition->fr_composite_key;
        return view('scm::requisitions.create', compact('requisition', 'formType', 'brands', 'pops', 'clients', 'clientDetails', 'clientInfos', 'branchs', 'branchwisePops'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ScmWorkOrder  $requisition
     * @return \Illuminate\Http\Response
     */
    public function update(SupplierRequest $request, ScmWorkOrder $requisition)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();
            if (request()->type == 'client') {
                $requestData = $request->only('type', 'client_id', 'date', 'branch_id', 'fr_composite_key');
            } elseif (request()->type == 'warehouse') {
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

            $requisition->ScmWorkOrderdetails()->delete();
            $requisition->ScmWorkOrderdetails()->createMany($requisitionDetails);
            DB::commit();

            return redirect()->route('requisitions.index')->with('message', 'Data has been updated successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('requisitions.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ScmWorkOrder  $requisition
     * @return \Illuminate\Http\Response
     */
    public function destroy(ScmWorkOrder $requisition)
    {
        try {
            $requisition->delete();
            return redirect()->route('requisitions.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            return redirect()->route('requisitions.index')->withErrors($e->getMessage());
        }
    }
}
