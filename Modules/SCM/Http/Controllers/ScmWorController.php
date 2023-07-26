<?php

namespace Modules\SCM\Http\Controllers;

use Illuminate\Http\Request;
use Modules\SCM\Entities\ScmWor;
use Modules\Admin\Entities\Brand;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\Branch;
use App\Services\BbtsGlobalService;
use Modules\SCM\Entities\ScmChallan;
use Modules\SCM\Entities\StockLedger;
use Illuminate\Database\QueryException;
use Modules\SCM\Entities\PurchaseOrderLine;
use Illuminate\Contracts\Support\Renderable;
use Modules\SCM\Entities\ScmMur;

class ScmWorController extends Controller
{
    private $worNo;

    public function __construct(BbtsGlobalService $globalService)
    {
        $this->worNo = $globalService->generateUniqueId(ScmWor::class, 'WOR');
        $this->middleware('permission:scm-wor-view|scm-wor-create|scm-wor-edit|scm-wor-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:scm-wor-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:scm-wor-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:scm-wor-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $worData = ScmWor::latest()->get();
        return view('scm::wor.index', compact('worData'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $brands = Brand::latest()->get();
        $branches = Branch::latest()->get();
        return view('scm::wor.create', compact('brands', 'branches'));
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
            $scm_wor = $request->all();
            $scm_wor['wor_no'] = $this->worNo;
            $scm_wor['created_by'] = auth()->user()->id;
            $wcrr = ScmWor::create($scm_wor);
            $stock = [];
            $wor_lines = [];
            foreach ($request->material_id as $key => $val) {
                $wor_lines[] = $this->getLineData($request, $key, $wcrr->id);
                $stock[] = $this->getStockData($request, $key, $wcrr->id);
            };

            $wcrr->lines()->createMany($wor_lines);
            $wcrr->stockable()->createMany($stock);
            DB::commit();
            return redirect()->route('work-order-receives.index')->with('message', 'Data has been created successfully');
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
    public function show($id)
    {
        abort(404);
        // return view('scm::wor.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(ScmWor $work_order_receife)
    {
        $formType = "edit";
        $brands = Brand::latest()->get();
        $branches = Branch::latest()->get();
        return view('scm::wor.create', compact('work_order_receife', 'brands', 'branches', 'formType'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, ScmWor $work_order_receife)
    {
        try {
            DB::beginTransaction();

            $work_order_receife->update($request->all());
            $work_order_receife->lines()->delete();
            $work_order_receife->stockable()->delete();

            $stock = [];
            $wor_lines = [];
            foreach ($request->material_id as $key => $val) {
                $wor_lines[] = $this->getLineData($request, $key, $work_order_receife->id);
                $stock[] = $this->getStockData($request, $key, $work_order_receife->id);
            };

            $work_order_receife->lines()->createMany($wor_lines);
            $work_order_receife->stockable()->createMany($stock);
            DB::commit();
            return redirect()->route('work-order-receives.index')->with('message', 'Data has been updated successfully');
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
    public function destroy(ScmWor $work_order_receife)
    {
        try {
            DB::beginTransaction();
            $work_order_receife->delete();
            $work_order_receife->lines()->delete();
            $work_order_receife->stockable()->delete();

            DB::commit();
            return redirect()->route('work-order-receives.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $err) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($err->getMessage());
        }
    }

    public function searchSerialForWor()
    {
        $data = PurchaseOrderLine::query()
            ->with(['material', 'brand'])
            ->whereHas('purchaseOrder', function ($item) {
                $item->where('purchase_order_id', request()->customQueryFields['po_id']);
            })
            ->whereHas('material', function ($item) {
                $item->where('name', 'like', '%' . request()->search . '%');
            })
            ->get();

        $items = StockLedger::query()
            ->with(['material', 'brand'])
            ->whereIn('material_id', $data->pluck('material_id')->toArray())
            ->whereIn('brand_id', $data->pluck('brand_id')->toArray())
            ->get()
            ->groupBy(['serial_code'])
            ->map(function ($group) {
                if ($group->last()->stockable_type == ScmWor::class && isset(request()->customQueryFields['wor_id'])) {
                    return $group->slice(-2, 1)->last();
                } else {
                    return $group->last();
                }
            })
            ->filter(function ($item) {
                return $item->stockable_type == ScmMur::class;
            })
            ->flatten()
            ->map(fn ($item) => [
                'value' => $item->material->name,
                'label' => $item->material->name . ' - ' . $item->serial_code . ' - ' . $item->brand->name . ' - ' . $item->model,
                'material_id' => $item->material_id,
                'serial_code' => $item->serial_code,
                'brand_id' => $item->brand_id,
                'brand_name' => $item->brand->name,
                'model' => $item->model,
                'unit' => $item->material->unit,
                'item_code' => $item->material->code,
                'item_type' => $item->material->type,
            ]);
        return response()->json($items);
    }

    private function getLineData($req, $ke, $id)
    {
        return [
            'material_id'               => $req->material_id[$ke] ?? null,
            'item_code'                 => $req->item_code[$ke] ?? null,
            'model'                     => $req->model[$ke]  ?? null,
            'serial_code'               => $req->serial_code[$ke] ?? null,
            'brand_id'                  => $req->brand_id[$ke] ?? null,
        ];
    }

    private function getStockData($req, $ke, $id)
    {
        return [
            'received_type'     => 'WOR',
            'receiveable_id'    => $id,
            'receiveable_type'  => ScmWor::class,
            'material_id'       => $req->material_id[$ke] ?? null,
            'stockable_type'    => ScmWor::class,
            'stockable_id'      => $id ?? null,
            'brand_id'          => $req->brand_id[$ke] ?? null,
            'branch_id'         => $req->branch_id ?? null,
            'model'             => $req->model[$ke] ?? null,
            'quantity'          => 1,
            'item_code'         => $req->item_code[$ke] ?? null,
            'serial_code'       => $req->serial_code[$ke] ?? null,
            'unit'              => $req->unit[$ke] ?? null,
        ];
    }
}
