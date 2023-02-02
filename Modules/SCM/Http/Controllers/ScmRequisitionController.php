<?php

namespace Modules\SCM\Http\Controllers;

use Modules\Admin\Entities\Unit;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\QueryException;
use Modules\SCM\Entities\ScmRequisition;
use Modules\SCM\Http\Requests\SupplierRequest;

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
        $requisitions = ScmRequisition::latest()->get();

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

        return view('scm::requisitions.create', compact('requisitions', 'formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupplierRequest $request)
    {
        try {
            $requestData = $request->only('mrs_no', 'type', 'client_id', 'fr_composit_key', 'date', 'remarks', 'branch_id', 'pop_id', 'purpose');
            $requestData['requisition_by'] = auth()->id();
            $requisitionDetails = [];
            foreach ($request->material_id as $key => $data) {
                $requisitionDetails[] = [
                    'floor_id' => !empty($request->floor_id[$key]) ? $request->floor_id[$key] : null,
                    'material_id' => $request->material_id[$key],
                    'quantity' => $request->quantity[$key],
                    'required_date' => $request->required_date[$key]
                ];
            }

            DB::beginTransaction();
            $requisition = ScmRequisition::create($requestData);
            $requisition->requisitionDetails()->createMany($requisitionDetails);
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
        //
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
        $requisitions = ScmRequisition::latest()->get();

        return view('scm::requisitions.create', compact('requisition', 'requisitions', 'formType'));
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
