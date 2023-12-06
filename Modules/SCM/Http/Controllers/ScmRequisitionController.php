<?php

namespace Modules\SCM\Http\Controllers;

use App\Models\Dataencoding\Employee;
use Modules\SCM\Entities\MaterialBrand;
use Modules\SCM\Entities\MaterialModel;
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
use Modules\SCM\Entities\ScmRequisition;
use Modules\SCM\Http\Requests\SupplierRequest;
use Modules\SCM\Http\Requests\ScmRequisitionRequest;
use Illuminate\Http\Request;

class ScmRequisitionController extends Controller
{
    use HasRoles;
    function __construct()
    {
        $this->middleware('permission:scm-requisition-view|scm-requisition-create|scm-requisition-edit|scm-requisition-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:scm-requisition-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:scm-requisition-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:scm-requisition-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $requisitions = ScmRequisition::with('client', 'requisitionBy')->latest()->get();

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
        $requisitions = ScmRequisition::get();
        $brands = Brand::get();
        $models = MaterialModel::pluck('model');
        $branchs = Branch::get();

        return view('scm::requisitions.create', compact('requisitions', 'formType', 'brands', 'branchs', 'models'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ScmRequisitionRequest $request)
    {
        try {
            DB::beginTransaction();
            if (request()->type == 'client') {
                $requestData = $request->only('type', 'client_no', 'fr_no', 'link_no', 'date', 'branch_id', 'remarks');
            } elseif (request()->type == 'warehouse') {
                $requestData = $request->only('type', 'date', 'branch_id', 'to_branch', 'remarks');
            } elseif (request()->type == 'general') {
                $requestData = $request->only('type', 'date', 'branch_id', 'employee_id', 'pop_id', 'remarks');
                // dd($request->employee_id);
                // dd($requestData);
            } else {
                $requestData = $request->only('type', 'date', 'branch_id', 'pop_id', 'remarks');
            }

            $lastMRSId = ScmRequisition::latest()->first();
            if ($lastMRSId) {
                $composite_mrs = explode('-', $lastMRSId->mrs_no);
                $requestData['mrs_no'] = 'MRS-' . now()->format('Y') . '-' . ($composite_mrs[2] + 1);
            } else {
                $requestData['mrs_no'] = 'MRS-' . now()->format('Y') . '-' . 1;
            }
            $requestData['requisition_by'] = auth()->id();

            $requisition = ScmRequisition::create($requestData);
            $requisitionDetails = [];
            $brands = [];
            $models = [];
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
                    'current_stock' => $request->current_stock[$key] ?? 0,
                ];
                $brands[] = [
                    'material_id' => $request->material_id[$key],
                    'brand_id' => $request->brand_id[$key],
                ];
                $models[] = [
                    'material_id' => $request->material_id[$key],
                    'brand_id' => $request->brand_id[$key],
                    'model' => $request->model[$key],
                ];
                $material_brand = MaterialBrand::updateOrCreate(
                    [
                        'material_id' => $request->material_id[$key],
                        'brand_id' => $request->brand_id[$key],
                    ],
                    $brands
                );
                $material_model = MaterialModel::updateOrCreate(
                    [
                        'material_id' => $request->material_id[$key],
                        'brand_id' => $request->brand_id[$key],
                        'model' => $request->model[$key],
                    ],
                    $models
                );
            }

            $requisition->scmRequisitiondetails()->createMany($requisitionDetails);
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
     * @param  \App\ScmRequisition  $requisition
     * @return \Illuminate\Http\Response
     */
    public function show(ScmRequisition $requisition)
    {
        // dd($requisition->scmRequisitiondetailsWithMaterial);
        return view('scm::requisitions.show', compact('requisition'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ScmRequisition  $requisition
     * @return \Illuminate\Http\Response
     */
    public function edit(ScmRequisition $requisition)
    {
        // dd($requisition->employee_id);
        $formType = "edit";
        $brands = Brand::get();
        $branchs = Branch::get();
        $models = MaterialModel::pluck('model');
        $pops = Pop::get();
        $clients = Client::get();
        $fr_nos = Client::with('saleDetails')->where('client_no', $requisition->client_no)->first()?->saleDetails ?? [];
        $client_links = Client::with('saleLinkDetails')->where('client_no', $requisition->client_no)->first()?->saleLinkDetails ?? [];
        // $branchwisePops = ScmRequisition::with('pop')->where('id', $requisition->id)->get();
        $branchwisePops = Pop::where('branch_id', $requisition->branch_id)->get();
        // $fr_composite_key = $requisition->fr_composite_key;
        return view('scm::requisitions.create', compact('requisition', 'formType', 'brands', 'pops', 'clients', 'fr_nos', 'client_links', 'branchs', 'branchwisePops', 'models'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ScmRequisition  $requisition
     * @return \Illuminate\Http\Response
     */
    public function update(SupplierRequest $request, ScmRequisition $requisition)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();
            if (request()->type == 'client') {
                $requestData = $request->only('type', 'date', 'branch_id', 'client_no', 'fr_no', 'link_no', 'remarks');
            } elseif (request()->type == 'warehouse') {
                $requestData = $request->only('type', 'date', 'branch_id', 'to_branch', 'remarks');
            } elseif (request()->type == 'general') {
                $requestData = $request->only('type', 'date', 'branch_id', 'employee_id', 'pop_id', 'remarks');
                // dd($request->employee_id);
                // dd($requestData);
            } else {
                $requestData = $request->only('type', 'date', 'branch_id', 'pop_id', 'remarks');
                // dd($request->empolyee_id);

            }
            $requestData['requisition_by'] = auth()->id();

            $requisition->update($requestData);

            $requisitionDetails = [];
            $brands = [];
            $models = [];
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
                    'current_stock' => $request->current_stock[$key] ?? 0,
                ];
                $brands[] = [
                    'material_id' => $request->material_id[$key],
                    'brand_id' => $request->brand_id[$key],
                ];
                $models[] = [
                    'material_id' => $request->material_id[$key],
                    'brand_id' => $request->brand_id[$key],
                    'model' => $request->model[$key],
                ];
                $material_brand = MaterialBrand::updateOrCreate(
                    [
                        'material_id' => $request->material_id[$key],
                        'brand_id' => $request->brand_id[$key],
                    ],
                    $brands
                );
                $material_model = MaterialModel::updateOrCreate(
                    [
                        'material_id' => $request->material_id[$key],
                        'brand_id' => $request->brand_id[$key],
                        'model' => $request->model[$key],
                    ],
                    $models
                );
            }

            $requisition->scmRequisitiondetails()->delete();
            $requisition->scmRequisitiondetails()->createMany($requisitionDetails);
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
     * @param  \App\ScmRequisition  $requisition
     * @return \Illuminate\Http\Response
     */
    public function destroy(ScmRequisition $requisition)
    {
        try {
            $requisition->delete();
            return redirect()->route('requisitions.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            return redirect()->route('requisitions.index')->withErrors($e->getMessage());
        }
    }
}
