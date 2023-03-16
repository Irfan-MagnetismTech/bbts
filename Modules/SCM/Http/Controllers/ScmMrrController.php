<?php

namespace Modules\SCM\Http\Controllers;

use Illuminate\Http\Request;
use Modules\SCM\Entities\ScmMrr;
use Modules\Admin\Entities\Brand;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\Branch;
use Modules\SCM\Entities\Material;
use App\Services\BbtsGlobalService;
use Illuminate\Database\QueryException;
use Modules\SCM\Entities\PurchaseOrder;
use Modules\SCM\Http\Requests\MrrRequest;
use Modules\SCM\Entities\PurchaseOrderLine;
use Illuminate\Contracts\Support\Renderable;

class ScmMrrController extends Controller
{

    private $materialReceiveNo;

    public function __construct(BbtsGlobalService $globalService)
    {
        $this->materialReceiveNo = $globalService->generateUniqueId(ScmMrr::class, 'MRR');
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $mrrs = ScmMrr::with('scmMrrLines.scmMrrSerialCodeLines')->latest()->get();

        return view('scm::mrr.index', compact('mrrs'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $brands = Brand::latest()->get();
        $branches = Branch::latest()->get();
        return view('scm::mrr.create', compact('brands', 'branches'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(MrrRequest $request)
    {
        $requestData = $request->only('branch_id', 'date', 'purchase_order_id', 'supplier_id', 'challan_no', 'challan_date');
        try {
            DB::beginTransaction();
            $requestData['mrr_no'] =  $this->materialReceiveNo;
            $requestData['created_by'] = auth()->id();

            $mrrDetails = [];
            $serialCode = [];
            foreach ($request->material_id as $key => $data) {
                $mrrDetails[] = [
                    'material_id' => $request->material_id[$key],
                    'description' => $request->description[$key],
                    'brand_id' => $request->brand_id[$key],
                    'model' => $request->model[$key],
                    'quantity' => $request->quantity[$key],
                    'initial_mark' => $request->initial_mark[$key],
                    'final_mark' => $request->final_mark[$key],
                    'item_code' => $request->item_code[$key],
                    'warranty_period' => $request->warranty_period[$key],
                    'unit_price' => $request->unit_price[$key],
                ];
                $serialCode[] = explode(',', $request->sl_code[$key]);
            }
            $materialReceive = ScmMrr::create($requestData);
            $MrrDetail = $materialReceive->scmMrrLines()->createMany($mrrDetails);
            $stock = [];
            foreach ($MrrDetail as $key => $value) {
                $value->scmMrrSerialCodeLines()->createMany(array_map(function ($serial) use ($request, $key, $value, $materialReceive, &$stock) {
                    if ($request->material_type[$key] == 'Drum') {
                        $serial_code = 'F-' . $serial;
                    } else {
                        $serial_code = 'SL-' . $serial;
                    }
                    $stock[] = [
                        'material_id'       => $value->material_id,
                        'stockable_type'    => ScmMrr::class,
                        'stockable_id'      => $materialReceive->id,
                        'brand_id'          => $value->brand_id,
                        'branch_id'         => $request->branch_id,
                        'model'             => $value->model,
                        'quantity'          => 1,
                        'initial_mark'      => $value->initial_mark,
                        'final_mark'        => $value->final_mark,
                        'item_code'         => $value->item_code,
                        'warranty_period'   => $value->warranty_period,
                        'unit_price'        => $value->unit_price,
                        'serial_code'       => $serial_code,
                        'unit'              => $request->unit[$key],
                    ];
                    return [
                        'serial_or_drum_key'    => $serial,
                        'serial_or_drum_code'   =>  $serial_code,
                    ];
                }, $serialCode[$key]));
            }
            $materialReceive->stockLedgerReceivable()->createMany($stock);
            DB::beginTransaction();
            return redirect()->route('material-receives.index')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('material-receives.create')->withInput()->withErrors($e->getMessage());
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
    public function edit(ScmMrr $materialReceive)
    {
        $material_list = PurchaseOrderLine::query()
            ->with('material')
            ->where('purchase_order_id', $materialReceive->purchase_order_id)
            ->get()
            ->pluck('material_id', 'material.materialNameWithCode');

        $brands = Brand::latest()->get();
        $branches = Branch::latest()->get();
        return view('scm::mrr.create', compact('branches', 'brands', 'material_list', 'materialReceive'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(MrrRequest $request, ScmMrr $materialReceive)
    {
        $requestData = $request->only('branch_id', 'date', 'purchase_order_id', 'supplier_id', 'challan_no', 'challan_date');
        try {
            DB::beginTransaction();
            $mrrDetails = [];
            $serialCode = [];
            foreach ($request->material_id as $key => $data) {
                $mrrDetails[] = [
                    'material_id'       => $request->material_id[$key],
                    'description'       => $request->description[$key],
                    'brand_id'          => $request->brand_id[$key],
                    'model'             => $request->model[$key],
                    'quantity'          => $request->quantity[$key],
                    'initial_mark'      => $request->initial_mark[$key],
                    'final_mark'        => $request->final_mark[$key],
                    'item_code'         => $request->item_code[$key],
                    'warranty_period'   => $request->warranty_period[$key],
                    'unit_price'        => $request->unit_price[$key],
                ];
                $serialCode[] = explode(',', $request->sl_code[$key]);
            }
            $materialReceive->update($requestData);
            $materialReceive->scmMrrLines()->delete();
            $materialReceive->stockLedgerReceivable()->delete();
            $MrrDetail = $materialReceive->scmMrrLines()->createMany($mrrDetails);
            $stock = [];
            foreach ($MrrDetail as $key => $value) {
                $value->scmMrrSerialCodeLines()->createMany(array_map(function ($serial) use ($request, $key, $value, $materialReceive, &$stock) {
                    if ($request->material_type[$key] == 'Drum') {
                        $serial_code = 'F-' . $serial;
                    } else {
                        $serial_code = 'SL-' . $serial;
                    }
                    $stock[] = [
                        'material_id'       => $value->material_id,
                        'stockable_type'    => ScmMrr::class,
                        'stockable_id'      => $materialReceive->id,
                        'brand_id'          => $value->brand_id,
                        'branch_id'         => $request->branch_id,
                        'model'             => $value->model,
                        'quantity'          => 1,
                        'initial_mark'      => $value->initial_mark,
                        'final_mark'        => $value->final_mark,
                        'item_code'         => $value->item_code,
                        'warranty_period'   => $value->warranty_period,
                        'unit_price'        => $value->unit_price,
                        'serial_code'       =>  $serial_code,
                        'unit'              => $request->unit[$key],
                    ];
                    return [
                        'serial_or_drum_key'    => $serial,
                        'serial_or_drum_code'   =>  $serial_code,
                    ];
                }, $serialCode[$key]));
            }
            $materialReceive->stockLedgerReceivable()->createMany($stock);
            DB::commit();
            return redirect()->route('material-receives.index')->with('message', 'Data has been updated successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('material-receives.create')->withInput()->withErrors($e->getMessage());
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

    public function searchPoWithDate(Request $request)
    {
        $search = $request->search;
        $items = PurchaseOrder::query()
            ->with('purchaseOrderLines')
            ->where("po_no", "like", "%$search%")
            ->get()
            ->map(fn ($item) => [
                'value'          => $item->id,
                'label'          => $item->po_no,
                'date'           => $item->date,
                'supplier_id'    => $item?->supplier_id ?? 0,
                'supplier_name'  => $item?->supplier?->name ?? 0
            ]);


        return response()->json($items);
    }

    public function getMaterialForPo($po_id)
    {
        $items = PurchaseOrderLine::query()
            ->with('material')
            ->whereHas('purchaseOrder', function ($item) use ($po_id) {
                return $item->where('id', $po_id);
            })->get()->unique('material_id');


        return response()->json($items);
    }

    public function getUnit($material_id)
    {
        $items = Material::find($material_id);
        return response()->json($items);
    }
}
