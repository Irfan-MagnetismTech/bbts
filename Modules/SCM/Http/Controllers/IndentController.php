<?php

namespace Modules\SCM\Http\Controllers;

use Illuminate\Http\Request;
use Modules\SCM\Entities\Indent;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Renderable;
use Modules\SCM\Http\Requests\IndentRequest;

class IndentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $indents = Indent::query()
            ->with(['indentLines', 'indentLines.scmPurchaseRequisition'])
            ->latest()
            ->get();
            
        return view('scm::indents.index', compact('indents'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('scm::indents.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(IndentRequest $request)
    {
        // dd($request->all());
        $requestedData = $request->only(['indent_no', 'date']);
        $requestedData['indent_by'] = auth()->user()->id;
        $requestedData['branch_id'] = auth()->user()->branch_id;
        try {
            DB::beginTransaction();
            $indent = Indent::create($requestedData);
            foreach ($request->prs_id as $key => $value) {
                $indent->indentLines()->create(['scm_purchase_requisition_id' => $value]);
            }
            DB::commit();

            return redirect()->route('indents.index')->with('message', 'Indents created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());;
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        // return view('scm::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('scm::indents.create');
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
}
