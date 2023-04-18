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

class ScmGatePassController extends Controller
{
    private $GatePassNo;
    public function __construct(BbtsGlobalService $globalService)
    {
        $this->GatePassNo = $globalService->generateUniqueId(ScmGatePass::class, 'GatePass');
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('scm::gate-passes.index');
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
            $gate_pass_data = $request->only('date');
            $gate_pass_data['gate_pass_no'] =  $this->GatePassNo;
            $gate_pass_data['carrier'] =  $request->carrier_name;
            // $gate_pass_data['created_by'] = auth()->id();

            $gate_pass_details = [];
            foreach ($request->mir_id as $kk => $val) {

                $gate_pass_details[] = [
                    'challan_id' => $request->challan_id[$kk],
                    'mir_id' => $request->mir_id[$kk],
                ];
            };

            $challan = ScmGatePass::create($gate_pass_data);
            $challan->lines()->createMany($gate_pass_details);

            DB::commit();
        } catch (QueryException $err) {
            dd($err);
            DB::rollBack();
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('scm::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('scm::edit');
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
