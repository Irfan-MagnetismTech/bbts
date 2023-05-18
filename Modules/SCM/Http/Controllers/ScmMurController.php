<?php

namespace Modules\SCM\Http\Controllers;

use Exception;
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
use Modules\SCM\Entities\ScmChallan;
use Illuminate\Database\QueryException;
use Modules\Sales\Entities\ClientDetail;
use Modules\SCM\Entities\ScmChallanLine;
use Modules\SCM\Entities\ScmRequisition;
use Modules\Sales\Entities\SaleLinkDetail;
use Illuminate\Contracts\Support\Renderable;

class ScmMurController extends Controller
{
    private $murNo;

    public function __construct(BbtsGlobalService $globalService)
    {
        $this->murNo = $globalService->generateUniqueId(ScmMur::class, 'MUR');
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $scmMurs = ScmMur::latest()->get();
        return view('scm::mur.index', compact('scmMurs'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $challanData = ScmChallan::find(request()->challan_id);
        if ($challanData) {
            $challanData->load('scmRequisition', 'client', 'scmChallanLines');
        }

        $formType = "create";
        $brands = Brand::latest()->get();
        $branchs = Branch::latest()->get();
        $client_links = SaleLinkDetail::where('fr_no', $challanData->fr_no)->pluck('link_no');
        $challanLines = [];
        foreach ($challanData->scmChallanLines as $key => $value) {
            $serial_count = count(json_decode($value->serial_code));
            if ($serial_count) {
                foreach (json_decode($value->serial_code) as $key1 => $value1) {
                    $iiidd = ScmChallanLine::where(['material_id' => $value->material_id, 'item_code' => $value->material->code, 'brand_id' => $value->brand_id, 'model' => $value->model, 'serial_code'   => $value1, 'scm_challan_id' => $challanData->id])->get();
                    $challanLines[] = [
                        'material_id'       => $value->material_id,
                        'material_name'     => $value->material->name,
                        'description'       => $value->description,
                        'item_code'         => $value->material->code,
                        'unit'              => $value->material->unit,
                        'brand_id'          => $value->brand_id,
                        'brand_name'        => $value->brand->name,
                        'model'             => $value->model,
                        'receiveable_type'  => ($value->receiveable_type == get_class(new ScmMrr())) ? 'MRR' : (($value->receiveable_type == get_class(new ScmWcr())) ? 'WCR' : (($value->receiveable_type == get_class(new ScmErr())) ? 'ERR' : NULL)),
                        'receiveable_id'   => $value->receiveable_id,
                        'serial_code'   => $value1,
                        'quantity'      => ($value->material->type == 'Drum') ? $value->quantity : 1,
                    ];
                }
            } else {
                $challanLines[] = [
                    'material_id'       => $value->material_id,
                    'material_name'     => $value->material->name,
                    'description'       => $value->description,
                    'item_code'         => $value->material->code,
                    'unit'              => $value->material->unit,
                    'brand_id'          => $value->brand_id,
                    'brand_name'        => $value->brand->name,
                    'model'             => $value->model,
                    'receiveable_type'  => ($value->receiveable_type == get_class(new ScmMrr())) ? 'MRR' : (($value->receiveable_type == get_class(new ScmWcr())) ? 'WCR' : (($value->receiveable_type == get_class(new ScmErr())) ? 'ERR' : NULL)),
                    'receiveable_id'   => $value->receiveable_id,
                    'serial_code'   => '',
                    'quantity'      => $value->quantity,
                ];
            }
        }
        $challanLines = collect($challanLines);
        return view('scm::mur.create', compact('formType', 'brands', 'branchs', 'challanData', 'challanLines'));
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
            $challan_data = ScmChallan::find($request->challan_id);
            $mur_data = $request->all();
            $mur_data['mur_no'] = $this->murNo;
            $mur_data['created_by'] = auth()->user()->id;
            $mur = ScmMur::create($mur_data);
            $stock = [];
            $mur_lines = [];
            foreach ($request->material_name as $key => $val) {
                $mur_lines[] = $this->getLineData($request, $key);
                $stock[] = $this->getStockData($request, $key, $mur->id);
            };
            $mur->lines()->createMany($mur_lines);
            $challan_data->stockable()->delete();
            $mur->stockable()->createMany($stock);
            DB::commit();
            return redirect()->route('material-utilizations.index')->with('message', 'Data has been created successfully');
        } catch (Exception $err) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($err->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show()
    {
        return view('scm::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(ScmMur $material_utilization)
    {
        $formType = "edit";
        return view('scm::mur.create', compact('formType', 'material_utilization'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, ScmMur $material_utilization)
    {
        try {
            DB::beginTransaction();
            $mur_data = $request->all();
            $material_utilization->update($mur_data);
            $stock = [];
            $mur_lines = [];
            foreach ($request->material_name as $key => $val) {
                $mur_lines[] = $this->getLineData($request, $key);
                $stock[] = $this->getStockData($request, $key, $material_utilization->id);
            };
            $material_utilization->lines()->delete();
            $material_utilization->lines()->createMany($mur_lines);
            $material_utilization->stockable()->delete();
            $material_utilization->stockable()->createMany($stock);
            DB::commit();
            return redirect()->route('material-utilizations.index')->with('message', 'Data has been updated successfully');
        } catch (Exception $err) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($err->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(ScmMur $material_utilization)
    {
        try {
            DB::beginTransaction();
            $material_utilization->stockable()->delete();
            $material_utilization->delete();
            DB::commit();
            return redirect()->route('material-utilizations.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $err) {
            DB::rollBack();
            return redirect()->route('material-utilizations.index')->withInput()->withErrors($err->getMessage());
        }
    }

    public function searchChallanNo()
    {
        $data = ScmChallan::query()
            ->where('challan_no', 'like', '%' . request()->search . '%')
            ->get()
            ->take(10)
            ->map(fn ($item) => [
                'value'     => $item->challan_no,
                'label'     => $item->challan_no,
                'id'        => $item->id,
                'date'      => $item->date,
            ])
            ->values()
            ->all();

        return response()->json($data);
    }

    private function getLineData($req, $ke)
    {
        return [
            'material_id'       => $req->material_id[$ke] ?? null,
            'description'       => $req->description[$ke] ?? null,
            'brand_id'          => $req->brand_id[$ke] ?? null,
            'model'             => $req->model[$ke]  ?? null,
            'serial_code'       => $req->serial_code[$ke] ?? null,
            'quantity'          => $req->quantity[$ke] ?? null,
            'utilized_quantity' => $req->utilized_quantity[$ke] ?? null,
            'client_ownership'  => $req->client_ownership[$ke] ?? null,
            'bbts_ownership'    => $req->bbts_ownership[$ke] ?? null,
            'remarks'           => $req->remarks[$ke] ?? null,
            'receiveable_id'    => $req->receiveable_id[$ke] ?? null,
            'receiveable_type'    => $req->receiveable_type[$ke] ?? null
        ];
    }


    private function getStockData($req, $ke, $id)
    {
        return [
            'received_type'     => $req->receiveable_type[$ke] ?? NULL,
            'receiveable_id'    => $req->receiveable_id[$ke] ?? NULL,
            'receiveable_type'  => ($req->receiveable_type[$ke] == 'MRR') ? ScmMrr::class : (($req->receiveable_type[$ke] == 'WCR') ? ScmWcr::class : (($req->receiveable_type[$ke] == 'ERR') ? ScmErr::class : NULL)),
            'material_id'       => $req->material_id[$ke] ?? null,
            'stockable_type'    => ScmMur::class ?? null,
            'stockable_id'      => $id ?? null,
            'brand_id'          => $req->brand_id[$ke] ?? null,
            'branch_id'         => $req->branch_id ?? null,
            'model'             => $req->model[$ke] ?? null,
            'quantity'          => -1 * ($req->utilized_quantity[$ke]) ?? null,
            'item_code'         => $req->item_code[$ke] ?? null,
            'serial_code'       => $req->serial_code[$ke] ?? null,
            'unit'              => $req->unit[$ke] ?? null,
        ];
    }
}
