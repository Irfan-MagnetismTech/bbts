<?php

namespace Modules\SCM\Http\Controllers;

use Illuminate\Http\Request;
use Modules\SCM\Entities\Indent;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Services\BbtsGlobalService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Contracts\Support\Renderable;
use Modules\SCM\Http\Requests\IndentRequest;
use Spatie\Permission\Traits\HasRoles;

class IndentController extends Controller
{
    private $indentNo;

    public function __construct(BbtsGlobalService $globalService)
    {
        $this->indentNo = $globalService->generateUniqueId(Indent::class, 'IND');
        $this->middleware('permission:scm-indent-view|scm-indent-create|scm-indent-edit|scm-indent-delete', ['only' => ['index', 'show', 'getCsPdf', 'getAllDetails', 'getMaterialSuppliersDetails', 'csApproved']]);
        $this->middleware('permission:scm-indent-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:scm-indent-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:scm-indent-delete', ['only' => ['destroy']]);
    }
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
        $requestedData = $request->only(['date']);
        $requestedData['indent_no'] = $this->indentNo;
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
    public function edit(Indent $indent)
    {
        return view('scm::indents.create', compact('indent'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Indent $indent)
    {
        $requestedData = $request->only(['date']);
        $requestedData['indent_by'] = auth()->user()->id;
        $requestedData['branch_id'] = auth()->user()->branch_id;

        try {
            DB::beginTransaction();
            $indent->update($requestedData);
            $indent->indentLines()->delete();
            foreach ($request->prs_id as $key => $value) {
                $indent->indentLines()->create(['scm_purchase_requisition_id' => $value]);
            }
            DB::commit();

            return redirect()->route('indents.index')->with('message', 'Indents updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());;
        }
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
