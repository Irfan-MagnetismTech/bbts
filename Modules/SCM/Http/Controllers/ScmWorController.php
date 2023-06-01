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

class ScmWorController extends Controller
{
    private $worNo;

    public function __construct(BbtsGlobalService $globalService)
    {
        $this->worNo = $globalService->generateUniqueId(ScmWor::class, 'WOR');
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('scm::wor.index');
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
        dd($request->all());
        try {
            DB::beginTransaction();
            $scm_wor = $request->only('date', 'branch_id');
            $scm_wor['wor_no'] = $this->worNo;
            $scm_wor['created_by'] = auth()->user()->id;
            $wcrr = ScmWor::create($scm_wor);
            $stock = [];
            $wor_lines = [];
            foreach ($request->material_name as $key => $val) {
                if (isset($request->status[$key]) && $request->status[$key]) {
                    $wor_lines[] = $this->getLineData($request, $key, $wcrr->id);
                    $stock[] = $this->getStockData($request, $key, $wcrr->id);
                }
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
        // return view('scm::wor.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('scm::wor.create');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, ScmWor $scm_wor)
    {
        try {
            DB::beginTransaction();
            $data = $request->only('date', 'branch_id');
            $wcrr = ScmWor::create($data);
            $scm_wor->update($data);

            $stock = [];
            $wor_lines = [];
            foreach ($request->material_name as $key => $val) {
                if (isset($request->status[$key]) && $request->status[$key]) {
                    $wor_lines[] = $this->getLineData($request, $key, $wcrr->id);
                    $stock[] = $this->getStockData($request, $key, $wcrr->id);
                }
            };
            $scm_wor->lines()->delete();
            $scm_wor->stockable()->delete();
            $scm_wor->lines()->createMany($wor_lines);
            $scm_wor->stockable()->createMany($stock);

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
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    public function searchSerialForWor()
    {
        $data = PurchaseOrderLine::query()
            ->with(['material', 'brand'])
            ->whereHas('purchaseOrder', function ($item) {
                $item->where('purchase_order_id', request()->customQueryFields['id']);
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
                return $group->last();
            })
            ->filter(function ($item) {
                return $item->stockable_type == ScmChallan::class;
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
            'item_code'                 => $req->description[$ke] ?? null,
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
