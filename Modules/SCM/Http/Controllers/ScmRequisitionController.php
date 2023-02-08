<?php

namespace Modules\SCM\Http\Controllers;

use Termwind\Components\Dd;
use Modules\Admin\Entities\Pop;
use Modules\Admin\Entities\Brand;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Sales\Entities\Client;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\QueryException;
use Modules\Sales\Entities\ClientDetail;
use Modules\SCM\Entities\ScmRequisition;
use Modules\SCM\Http\Requests\SupplierRequest;
use Modules\SCM\Http\Requests\ScmRequisitionRequest;

class ScmRequisitionController extends Controller
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
        $requisitions = ScmRequisition::latest()->get();
        $brands = Brand::latest()->get();

        return view('scm::requisitions.create', compact('requisitions', 'formType', 'brands'));
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
            $requestData = $request->only('type', 'client_id', 'date', 'branch_id', 'pop_id', 'fr_composite_key');
            $lastMRSId = ScmRequisition::latest()->first();
            if ($lastMRSId) {
                $requestData['mrs_no'] = now()->format('Y') . '-' . $lastMRSId->id + 1;
            } else {
                $requestData['mrs_no'] = now()->format('Y') . '-' . 1;
            }
            $requestData['requisition_by'] = auth()->id();
            $requisitionDetails = [];
            foreach ($request->material_id as $key => $data) {
                $requisitionDetails[] = [
                    'material_id' => $request->material_id[$key],
                    'description' => $request->description[$key],
                    'quantity' => $request->quantity[$key],
                    'brand_id' => $request->brand_id[$key],
                    'model' => $request->model[$key],
                    'purpose' => $request->purpose[$key],
                ];
            }

            DB::beginTransaction();
            $requisition = ScmRequisition::create($requestData);
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
        $formType = "edit";
        $brands = Brand::latest()->get();
        $pops = Pop::latest()->get();
        $clients = Client::latest()->get();
        $clientDetails = ClientDetail::latest()->get();
        $clientInfo = ClientDetail::where('client_id', $requisition->client_id)->get();
        return view('scm::requisitions.create', compact('requisition', 'formType', 'brands', 'pops', 'clients', 'clientDetails', 'clientInfo'));
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
        try {
            $data = $request->all();
            $requisition->update($data);
            return redirect()->route('requisitions.index')->with('message', 'Data has been updated successfully');
        } catch (QueryException $e) {
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
