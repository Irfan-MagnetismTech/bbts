<?php

namespace Modules\SCM\Http\Controllers;

use Illuminate\Http\Request;
use Modules\SCM\Entities\ScmWcr;
use Modules\Admin\Entities\Brand;
use Modules\SCM\Entities\ScmWcrr;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\Branch;
use App\Services\BbtsGlobalService;
use Modules\SCM\Entities\StockLedger;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Renderable;

class ScmWcrrController extends Controller
{
    private $wcrrNo;

    public function __construct(BbtsGlobalService $globalService)
    {
        $this->wcrrNo = $globalService->generateUniqueId(ScmWcrr::class, 'WCRR');
        $this->middleware('permission:scm-wcrr-view|scm-wcrr-create|scm-wcrr-edit|scm-wcrr-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:scm-wcrr-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:scm-wcrr-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:scm-wcrr-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $ScmDatas = ScmWcrr::latest()->get();
        return view('scm::wcrrs.index', compact('ScmDatas'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $formType = "create";
        $brands = Brand::latest()->get();
        $branches = Branch::latest()->get();
        return view('scm::wcrrs.create', compact('formType', 'brands', 'branches'));
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
            $scm_wcr = $request->only('wcr_id', 'date', 'branch_id');
            $scm_wcr['wcrr_no'] = $this->wcrrNo;
            $scm_wcr['created_by'] = auth()->user()->id;
            $wcrr = ScmWcrr::create($scm_wcr);
            $stock = [];
            $wcrr_lines = [];
            foreach ($request->material_name as $key => $val) {
                if (isset($request->status[$key]) && $request->status[$key]) {
                    $wcrr_lines[] = $this->getLineData($request, $key, $wcrr->id);
                    $stock[] = $this->getStockData($request, $key, $wcrr->id);
                }
            };
            $wcrr->lines()->createMany($wcrr_lines);
            $wcrr->stockable()->createMany($stock);
            DB::commit();
            return redirect()->route('warranty-claims-receives.index')->with('message', 'Data has been created successfully');
        } catch (QueryException $err) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($err->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(ScmWcrr $warranty_claims_receife)
    {
        return view('scm::wcrrs.show', compact('warranty_claims_receife'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(ScmWcrr $warranty_claims_receife) /*laravel converted $warranty_claims_receives to $warranty_claims_receife*/
    {
        $formType = "edit";
        $brands = Brand::latest()->get();
        $branches = Branch::latest()->get();
        return view('scm::wcrrs.create', compact('formType', 'brands', 'branches', 'warranty_claims_receife'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, ScmWcrr $warranty_claims_receife)
    {
        try {
            DB::beginTransaction();
            $scm_wcr = $request->only('wcr_id', 'date', 'branch_id');
            $scm_wcr['wcrr_no'] = $this->wcrrNo;
            $scm_wcr['created_by'] = auth()->user()->id;
            $warranty_claims_receife->update($scm_wcr);
            $stock = [];
            $wcrr_lines = [];
            foreach ($request->material_name as $key => $val) {
                if (isset($request->status[$key]) && $request->status[$key]) {
                    $wcrr_lines[] = $this->getLineData($request, $key, $warranty_claims_receife->id);
                    $stock[] = $this->getStockData($request, $key, $warranty_claims_receife->id);
                }
            };
            $warranty_claims_receife->lines()->delete();
            $warranty_claims_receife->stockable()->delete();
            $warranty_claims_receife->lines()->createMany($wcrr_lines);
            $warranty_claims_receife->stockable()->createMany($stock);
            DB::commit();
            return redirect()->route('warranty-claims-receives.index')->with('message', 'Data has been updated successfully');
        } catch (QueryException $err) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($err->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(ScmWcrr $warranty_claims_receife)
    {
        try {
            DB::beginTransaction();
            $warranty_claims_receife->stockable()->delete();
            $warranty_claims_receife->delete();
            DB::commit();
            return redirect()->route('warranty-claims-receives.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $err) {
            DB::rollBack();
            return redirect()->route('warranty-claims-receives.index')->withInput()->withErrors($err->getMessage());
        }
    }


    private function getLineData($req, $ke, $id)
    {
        return [
            'material_id'               => $req->material_id[$ke] ?? null,
            'item_code'                 => $req->description[$ke] ?? null,
            'material_type'             => $req->item_code[$ke] ?? null,
            'model'                     => $req->model[$ke]  ?? null,
            'serial_code'               => $req->serial_code[$ke] ?? null,
            'brand_id'                  => $req->brand_id[$ke] ?? null,
        ];
    }

    private function getStockData($req, $ke, $id)
    {
        return [
            'received_type'     => 'WCRR',
            'receiveable_id'    => null,
            'receiveable_type'  => null,
            'material_id'       => $req->material_id[$ke] ?? null,
            'stockable_type'    => ScmWcrr::class,
            'stockable_id'      => $id ?? null,
            'brand_id'          => $req->brand_id[$ke] ?? null,
            'branch_id'         => $req->branch_id ?? null,
            'model'             => $req->model[$ke] ?? null,
            'quantity'          => 1,
            'item_code'         => $req->item_code[$ke] ?? null,
            'serial_code'       => $req->serial_code[$ke] ?? null,
            'unit'              => $req->unit[$ke] ?? null,
            'date'              => $req->date,
        ];
    }


    public function searchWcrForWcrr(Request $request)
    {
        $items = ScmWcr::query()
            ->where('wcr_no', 'like', '%' . $request->search . '%')
            ->get()
            ->map(fn ($item) => [
                'value' => $item->wcr_no,
                'label' => $item->wcr_no,
                'wcr_id' => $item->id,
                'sending_date' => $item->sending_date,
            ]);

        return response()->json($items);
    }


    public function searchMaterialForWcrr(Request $request)
    {
        $data = StockLedger::query()->whereHasMorph('stockable', [ScmWcr::class], function ($item) use ($request) {
            return $item->where('id', request()->wcr_id);
        })->pluck('serial_code');

        $datas = StockLedger::query()->whereIn('serial_code', $data)->get()
            ->groupBy(['serial_code'])
            ->map(function ($group) {
                return $group->last();
            })
            ->filter(function ($item) {
                return $item->stockable_type == ScmWcr::class;
            })
            ->flatten()
            ->map(fn ($item) => [
                'material_name' => $item->material->name,
                'material_id' => $item->material_id,
                'serial_code' => $item->serial_code,
                'brand_id' => $item->brand_id,
                'brand_name' => $item->brand->name,
                'model' => $item->model,
                'unit' => $item->material->unit,
                'item_code' => $item->material->code,
                'item_type' => $item->material->type,
            ]);

        return response()->json($datas);
    }
}
