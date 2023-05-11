<?php

namespace Modules\SCM\Http\Controllers;

use Termwind\Components\Dd;
use Illuminate\Http\Request;
use Modules\SCM\Entities\ScmErr;
use Modules\SCM\Entities\ScmMrr;
use Modules\SCM\Entities\ScmMur;
use Modules\SCM\Entities\ScmWcr;
use Modules\Admin\Entities\Brand;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\Branch;
use Modules\SCM\Entities\ScmMurLine;
use Modules\SCM\Entities\StockLedger;
use Modules\SCM\Entities\ScmRequisition;
use Illuminate\Contracts\Support\Renderable;
use Modules\SCM\Entities\ScmPurchaseRequisition;

class ScmErrController extends Controller
{
    protected $laravel;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('scm::errs.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $formType = "create";
        return view('scm::errs.create', compact('formType'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
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

    public function clientMurWiseMaterials()
    {
        $materials = ScmMurLine::query()
            ->when(request()->type === 'client', function ($query) {
                $query->whereHas('scmMur', function ($query) {
                    $query->where([
                        'client_no' => request()->client_no,
                        'fr_no' => request()->fr_no,
                        'equipment_type' => request()->equipment_type,
                        'type' => 'client',
                    ]);
                    if (request()->link_no) {
                        $query->where('link_no', request()->link_no);
                    }
                });
            })
            ->when(request()->type === 'internal', function ($query) {
                $query->whereHas('scmMur', function ($query) {
                    $query->where(['pop_id' => request()->pop_id, 'type' => 'pop']);
                });
            })
            ->when(!request()->type, function ($query) {
                $query->where('id', null);
            })
            ->select([
                DB::raw('(SELECT name FROM materials WHERE id = scm_mur_lines.material_id) AS material_name'),
                DB::raw('(SELECT name FROM brands WHERE id = scm_mur_lines.brand_id) AS brand_name'),
                DB::raw('(SELECT name FROM models WHERE id = scm_mur_lines.model) AS model_name'),
                DB::raw('(SELECT code FROM models WHERE id = scm_mur_lines.code) AS model_name'),
                'material_id',
                'brand_id',
                'model',
                DB::raw('SUM(utilized_quantity) as utilized_quantity', 'SUM(bbts_ownership) as bbts_ownership', 'SUM(client_ownership) as client_ownership')
            ])
            ->groupBy(['material_id', 'brand_id', 'model'])
            ->get();

        return response()->json($materials);
    }

    public function GetStockLedgerData($req, $key1, $key2 = NULL)
    {
        return [
            'branch_id' => $req->branch_id,
            'material_id' => $req->material_name[$key1],
            'receiveable_type' => ($req->received_type[$key1] == 'MRR') ? ScmMrr::class : (($req->received_type[$key1] == 'WCR') ? ScmWcr::class : (($req->received_type[$key1] == 'ERR') ? ScmErr::class : NULL)),
            'received_type' => $req->received_type[$key1],
            'receiveable_id' => $req->type_id[$key1],
            'item_code' => $req->item_code[$key1],
            'unit' => $req->unit[$key1],
            'brand_id' => isset($req->brand[$key1]) ? $req->brand[$key1] : NULL,
            'model' => isset($req->model[$key1]) ? $req->model[$key1] : NULL,
            'serial_code' => (isset($req->serial_code[$key1]) && isset($req->serial_code[$key1][$key2])) ? $req->serial_code[$key1][$key2] : '',
            'quantity' =>  -1 * (isset($key2) ? (($req->material_type[$key1] == "Drum") ? $req->quantity[$key1] : 1) : $req->quantity[$key1]),
        ];
    }

    public function GetMrrDetails($req, $key1)
    {
        return  [
            'receiveable_type' => ($req->received_type[$key1] == 'MRR') ? ScmMrr::class : (($req->received_type[$key1] == 'WCR') ? ScmWcr::class : (($req->received_type[$key1] == 'ERR') ? ScmErr::class : NULL)),
            'receiveable_id' => $req->type_id[$key1],
            'item_code' => $req->item_code[$key1],
            'material_id'   => $req->material_name[$key1],
            'brand_id' => isset($req->brand[$key1]) ? $req->brand[$key1] : NULL,
            'model' => isset($req->model[$key1]) ? $req->model[$key1] : NULL,
            'serial_code' => isset($req->serial_code[$key1]) ? json_encode($req->serial_code[$key1]) : '[]',
            'unit' => $req->unit[$key1],
            'quantity' => $req->quantity[$key1],
            'remarks' => $req->remarks[$key1],
        ];
    }

    
}
