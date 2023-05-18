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

            $err_data = $this->checkType($request);
            $err_data['err_no'] = $this->errNo;
            $err_data['created_by'] = auth()->id();

            $err = ScmErr::create($err_data);

            $err_lines = [];
            $stock = [];
            foreach ($request->material_name as $key => $val) {
                $err_lines[] = $this->getErrLines($request, $key);
                $stock[] = $this->getStockData($request, $key, $err);
            }

            $err->scmErrLines()->createMany($err_lines);
            $err->stockable()->createMany($stock);

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
    public function update(Request $request, ScmErr $err)
    {
        try {
            DB::beginTransaction();

            $err_data = $this->checkType($request);
            $err_data['err_no'] = $this->errNo;
            $err_data['created_by'] = auth()->id();

            $err->update($err_data);

            $err_lines = [];
            $stock = [];
            foreach ($request->material_name as $key => $val) {
                $err_lines[] = $this->getErrLines($request, $key);
                $stock[] = $this->getStockData($request, $key, $err);
            }

            $err->scmErrLines()->delete();
            $err->scmErrLines()->createMany($err_lines);

            $err->stockable()->delete();
            $err->stockable()->createMany($stock);

            DB::commit();
            return redirect()->route('errs.index')->with('message', 'Data has been updated successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('errs.edit', $err->id)->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(ScmErr $err)
    {
        try {
            DB::beginTransaction();

            $err->scmErrLines()->delete();
            $err->stockable()->delete();
            $err->delete();

            DB::commit();
            return redirect()->route('errs.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('errs.index')->withInput()->withErrors($e->getMessage());
        }
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

    private function getErrLines($request, $key1)
    {
        return  [
            'material_id'   => $request->material_id[$key1],
            'description' => $request->description[$key1],
            'utilized_quantity' => $request->utilized_quantity[$key1],
            'item_code' => $request->item_code[$key1],
            'brand_id' => $request->brand_id[$key1],
            'model' => $request->model[$key1],
            'serial_code' => $request->serial_code[$key1],
            'bbts_ownership' => $request->bbts_ownership[$key1],
            'client_ownership' => $request->client_ownership[$key1],
            'bbts_damaged' => $request->bbts_damaged[$key1],
            'client_damaged' => $request->client_damaged[$key1],
            'bbts_useable' => $request->bbts_useable[$key1],
            'client_useable' => $request->client_useable[$key1],
            'quantity' => $request->quantity[$key1],
            'remarks' => $request->remarks[$key1],
        ];
    }

    private function getStockData($request, $key, $err)
    {
        return [
            'received_type'     => 'ERR',
            'receiveable_id'    => $err->id,
            'receiveable_type'  => ScmErr::class,
            'material_id'       => $request->material_id[$key],
            'stockable_type'    => ScmErr::class,
            'stockable_id'      => $err->id,
            'brand_id'          => $request->brand_id[$key],
            'branch_id'         => $request->branch_id,
            'model'             => $request->model[$key],
            'quantity'          => $request->bbts_useable[$key] + $request->client_useable[$key],
            'damaged_quantity'  => $request->bbts_damaged[$key] + $request->client_damaged[$key],
            'item_code'         => $request->item_code[$key],
            'serial_code'       => $request->serial_code[$key],
            'unit'              => $request->unit[$key],
        ];
    }

    private function checkType($request)
    {
        $err_data = $request->only('type', 'date', 'purpose', 'branch_id', 'assigned_person', 'reason_of_inactive', 'inactive_date');

        if ($request->type == 'client') {
            $err_data['equipment_type'] = $request->equipment_type;
            $err_data['fr_no'] = $request->fr_no;
            $err_data['link_no'] = $request->link_no;
            $err_data['client_no'] = $request->client_no;
        } elseif ($request->type == 'internal') {
            $err_data['pop_id'] = $request->pop_id;
        }
        return $err_data;
    }
}
