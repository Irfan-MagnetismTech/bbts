<?php

namespace Modules\SCM\Http\Controllers;

use Illuminate\Http\Request;
use Modules\SCM\Entities\ScmMir;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Services\BbtsGlobalService;
use Modules\SCM\Entities\ScmChallan;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Renderable;
use Modules\SCM\Entities\ScmGatePass;
use Spatie\Permission\Traits\HasRoles;

class ScmGatePassController extends Controller
{
    private $GatePassNo;
    public function __construct(BbtsGlobalService $globalService)
    {
        $this->GatePassNo = $globalService->generateUniqueId(ScmGatePass::class, 'GatePass');
        $this->middleware('permission:scm-gate-pass-view|scm-gate-pass-create|scm-gate-pass-edit|scm-gate-pass-delete', ['only' => ['index', 'show', 'getCsPdf', 'getAllDetails', 'getMaterialSuppliersDetails', 'csApproved']]);
        $this->middleware('permission:scm-gate-pass-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:scm-gate-pass-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:scm-gate-pass-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $gate_passes = ScmGatePass::with('lines')->latest()->get();
        return view('scm::gate-passes.index', compact('gate_passes'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('scm::gate-passes.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $gate_pass_data = $request->only('date', 'type');
            $gate_pass_data['gate_pass_no'] =  $this->GatePassNo;
            $gate_pass_data['carrier'] =  $request->carrier_name;
            // $gate_pass_data['created_by'] = auth()->id();

            $gate_pass_details = [];
            foreach ($request->remarks as $kk => $val) {

                $gate_pass_details[] = [
                    'challan_id' => (isset($request->challan_id[$kk]) && ($request->type == 'challan')) ? $request->challan_id[$kk] : NULL,
                    'mir_id' => (isset($request->mir_id[$kk]) && ($request->type == 'mir')) ? $request->mir_id[$kk] : NULL,
                ];
            };

            $challan = ScmGatePass::create($gate_pass_data);
            $challan->lines()->createMany($gate_pass_details);

            DB::commit();
            return redirect()->route('gate-passes.index')->with('message', 'Data has been created successfully');
        } catch (QueryException $err) {
            DB::rollBack();
            return redirect()->route('gate-passes.create')->withInput()->withErrors($err->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(ScmGatePass $gate_pass)
    {
        return view('scm::gate-passes.show', compact('gate_pass'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(ScmGatePass $gate_pass)
    {
        $gate_pass->load(['lines.challan', 'lines.mir']);
        return view('scm::gate-passes.create', compact('gate_pass'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, ScmGatePass $gate_pass)
    {
        try {
            DB::beginTransaction();
            $gate_pass_data = $request->only('date', 'type');
            $gate_pass_data['carrier'] =  $request->carrier_name;
            // $gate_pass_data['created_by'] = auth()->id();

            $gate_pass_details = [];
            foreach ($request->remarks as $kk => $val) {
                $gate_pass_details[] = [

                    'challan_id' => (isset($request->challan_id[$kk]) && ($request->type == 'challan')) ? $request->challan_id[$kk] : NULL,
                    'mir_id' => (isset($request->mir_id[$kk]) && ($request->type == 'mir')) ? $request->mir_id[$kk] : NULL,
                ];
            };

            $gate_pass->update($gate_pass_data);
            $gate_pass->lines()->delete();
            $gate_pass->lines()->createMany($gate_pass_details);

            DB::commit();
            return redirect()->route('gate-passes.index')->with('message', 'Data has been updated successfully');
        } catch (QueryException $err) {
            DB::rollBack();
            return redirect()->route('gate-passes.create')->withInput()->withErrors($err->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(ScmGatePass $gate_pass)
    {
        try {
            $gate_pass->delete();
            return redirect()->route('gate-passes.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $err) {
            return redirect()->route('gate-passes.index')->withInput()->withErrors($err->getMessage());
        }
    }

    public function searchChallanNo()
    {
        $challan = ScmChallan::where('challan_no', 'like', '%' . request()->search . '%')
            ->get()
            ->take(10)
            ->map(fn ($item) => [
                'value' => $item->challan_no,
                'label' => $item->challan_no,
                'id'    => $item->id,
            ])
            ->values();

        return $challan;
    }

    public function searchMirNo()
    {
        $mir = ScmMir::where('mir_no', 'like', '%' . request()->search . '%')
            ->get()
            ->take(10)
            ->map(fn ($item) => [
                'value' => $item->mir_no,
                'label' => $item->mir_no,
                'id'    => $item->id,
            ])
            ->values();

        return $mir;
    }
}
