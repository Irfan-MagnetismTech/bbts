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
use App\Services\BbtsGlobalService;
use Modules\SCM\Entities\ScmMurLine;
use Modules\SCM\Entities\StockLedger;
use Illuminate\Database\QueryException;
use Modules\SCM\Entities\ScmRequisition;
use Illuminate\Contracts\Support\Renderable;
use Modules\Sales\Entities\Client;
use Modules\SCM\Entities\ScmErrLine;
use Modules\SCM\Entities\ScmPurchaseRequisition;

class ScmErrController extends Controller
{
    private $errNo;

    public function __construct(BbtsGlobalService $globalService)
    {
        $this->errNo = $globalService->generateUniqueId(ScmErr::class, 'Err');
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $errs = ScmErr::with('scmErrLines', 'scmErrLines.material')->latest()->get();

        return view('scm::errs.index', compact('errs'));
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
        try {
            DB::beginTransaction();
            if ($request->type == 'client') {
                $err_data = $request->only('type', 'date', 'purpose', 'branch_id', 'assigned_person', 'reason_of_inactive', 'inactive_date', 'equipment_type', 'fr_no', 'link_no', 'client_no');
            } elseif ($request->type == 'internal') {
                $err_data = $request->only('type', 'date', 'purpose', 'branch_id', 'assigned_person', 'reason_of_inactive', 'inactive_date', 'pop_id');
            }

            $err_data['err_no'] =  $this->errNo;
            $err_data['created_by'] = auth()->id();

            $err_lines = [];
            foreach ($request->material_name as $key => $val) {
                $err_lines[] = $this->getErrLines($request, $key);
            };

            $err = ScmErr::create($err_data);
            $err->scmErrLines()->createMany($err_lines);

            DB::commit();
            return redirect()->route('errs.index')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('errs.create')->withInput()->withErrors($e->getMessage());
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
    public function edit(ScmErr $err)
    {
        $fr_nos = Client::with('saleDetails')->where('client_no', $err->client_no)->first()?->saleDetails ?? [];
        $client_links = Client::with('saleLinkDetails')->where('client_no', $err->client_no)->first()?->saleLinkDetails ?? [];

        return view('scm::errs.create', compact('err', 'fr_nos', 'client_links'));
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
        $types = ['client', 'internal'];
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
            ->when(!request()->type || !in_array(request()->type, $types), function ($query) {
                $query->where('id', null);
            })
            ->select([
                DB::raw('(SELECT name FROM materials WHERE id = scm_mur_lines.material_id) AS material_name'),
                DB::raw('(SELECT code FROM materials WHERE id = scm_mur_lines.material_id) AS item_code'),
                DB::raw('(SELECT unit FROM materials WHERE id = scm_mur_lines.material_id) AS unit'),
                DB::raw('(SELECT name FROM brands WHERE id = scm_mur_lines.brand_id) AS brand_name'),
                'serial_code',
                'material_id',
                'brand_id',
                'model',
                DB::raw('SUM(utilized_quantity) as utilized_quantity, SUM(bbts_ownership) as bbts_ownership, SUM(client_ownership) as client_ownership'),
            ])
            ->groupBy(['material_id', 'brand_id', 'model', 'serial_code'])
            ->get();

        return response()->json($materials);
    }

    public function getErrLines($req, $key1)
    {
        return  [
            'material_id'   => $req->material_id[$key1],
            'description' => $req->description[$key1],
            'utilized_quantity' => $req->utilized_quantity[$key1],
            'item_code' => $req->item_code[$key1],
            'brand_id' => $req->brand_id[$key1],
            'model' => $req->model[$key1],
            'serial_code' => $req->serial_code[$key1],
            'bbts_ownership' => $req->bbts_ownership[$key1],
            'client_ownership' => $req->client_ownership[$key1],
            'bbts_damaged' => $req->bbts_damaged[$key1],
            'client_damaged' => $req->client_damaged[$key1],
            'bbts_useable' => $req->bbts_useable[$key1],
            'client_useable' => $req->client_useable[$key1],
            'quantity' => $req->quantity[$key1],
            'remarks' => $req->remarks[$key1],
        ];
    }
}
