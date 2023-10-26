<?php

namespace Modules\SCM\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Billing\Entities\BillRegister;
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
use Modules\SCM\Entities\FiberTracking;
use Modules\SCM\Entities\PoMaterial;
use Modules\SCM\Entities\ScmMrrLine;
use Modules\SCM\Http\Requests\ScmMrrRequest;

class ScmMrrController extends Controller
{

    private $materialReceiveNo;

    public function __construct(BbtsGlobalService $globalService)
    {
        $this->materialReceiveNo = $globalService->generateUniqueId(ScmMrr::class, 'MRR');
        $this->middleware('permission:scm-mrr-view|scm-mrr-create|scm-mrr-edit|scm-mrr-delete', ['only' => ['index', 'show', 'getCsPdf', 'getAllDetails', 'getMaterialSuppliersDetails', 'csApproved']]);
        $this->middleware('permission:scm-mrr-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:scm-mrr-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:scm-mrr-delete', ['only' => ['destroy']]);
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
        // dd($branches);
        return view('scm::mrr.create', compact('brands', 'branches'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(ScmMrrRequest $request)
    {
        $requestData = $request->only('branch_id', 'date', 'purchase_order_id', 'supplier_id', 'challan_no', 'challan_date','bill_reg_no','bill_date');
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
                    'order_quantity' => $request->order_quantity[$key] ?? 0,
                    'initial_mark' => $request->initial_mark[$key] ?? null,
                    'final_mark' => $request->final_mark[$key] ?? null,
                    'item_code' => $request->item_code[$key],
                    'warranty_period' => $request->warranty_period[$key] ?? 0,
                    'unit_price' => $request->unit_price[$key],
                    'po_composit_key' => $request->po_composit_key[$key],
                ];
                $serialCode[] = explode(',', $request->sl_code[$key]);
            }
            $materialReceive = ScmMrr::create($requestData);
            $MrrDetail = $materialReceive->scmMrrLines()->createMany($mrrDetails);
            $stock = [];
            // $CablePeace = [];
            foreach ($MrrDetail as $key => $value) {
                $value->scmMrrSerialCodeLines()->createMany(array_map(function ($serial) use ($request, $key, $value, $materialReceive, &$stock,/*&$CablePeace*/) {
                    if ($request->material_type[$key] == 'Drum') {
                        $serial_code = 'F-' . $serial;
                        $quantity = ($value->final_mark - $value->initial_mark) + 1;
                    } else {
                        if ($serial == '') {
                            $serial_code = Null;
                            $quantity = $value->quantity;
                            $order_quantity = $value->order_quantity;
                            $received_quantity = $value->received_quantity;
                        } else {
                            $serial_code = 'SL-' . $serial;
                            $quantity = 1;
                        }
                    }
                    $stock[] = [
                        'received_type'     => 'MRR',
                        'material_id'       => $value->material_id,
                        // 'receiveable_type'  => ScmMrr::class,
                        // 'receiveable_id'    => $materialReceive->id,
                        'brand_id'          => $value->brand_id,
                        'branch_id'         => $request->branch_id,
                        'model'             => $value->model,
                        'quantity'          => $quantity,
                        'initial_mark'      => $value->initial_mark ?? null,
                        'final_mark'        => $value->final_mark ?? null,
                        'item_code'         => $value->item_code,
                        'warranty_period'   => $value->warranty_period ?? 0,
                        'unit_price'        => $value->unit_price,
                        'serial_code'       => $serial_code,
                        'unit'              => $request->unit[$key],
                    ];
                    return [
                        'serial_or_drum_key'    =>  $serial,
                        'serial_or_drum_code'   =>  $serial_code,
                    ];
                }, $serialCode[$key]));
            }
            $materialReceive->stockable()->createMany($stock);
            DB::commit();
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
    public function show(ScmMrr $materialReceive)
    {
        return view('scm::mrr.show', compact('materialReceive'));
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
            ->unique('material_id');

        $materialReceive->with('scmMrrLines');
        $materialReceive->scmMrrLines->map(function ($item) {
            $item->left_quantity = PurchaseOrderLine::query()
                ->where('po_composit_key', $item->po_composit_key)
                ->sum('quantity') - ScmMrrLine::query()
                ->where('po_composit_key', $item->po_composit_key)
                ->where('scm_mrr_id', '!=', $item->scm_mrr_id)
                ->sum('quantity');
            return $item;
        });

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
    public function update(ScmMrrRequest $request, ScmMrr $materialReceive)
    {
        $requestData = $request->only('branch_id', 'date', 'purchase_order_id', 'supplier_id', 'challan_no', 'challan_date','bill_reg_no','bill_date');
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
                    'order_quantity'    => $request->order_quantity[$key] ?? 0,
                    'initial_mark'      => $request->initial_mark[$key] ?? null,
                    'final_mark'        => $request->final_mark[$key] ?? null,
                    'item_code'         => $request->item_code[$key],
                    'warranty_period'   => $request->warranty_period[$key] ?? 0,
                    'unit_price'        => $request->unit_price[$key],
                    'po_composit_key'   => $request->po_composit_key[$key],
                ];
                $serialCode[] = explode(',', $request->sl_code[$key]);
            }
            $materialReceive->update($requestData);
            $materialReceive->scmMrrLines()->delete();
            $materialReceive->stockable()->delete();
            $MrrDetail = $materialReceive->scmMrrLines()->createMany($mrrDetails);
            $stock = [];
            // $CablePeace = [];
            foreach ($MrrDetail as $key => $value) {
                $value->scmMrrSerialCodeLines()->createMany(array_map(function ($serial) use ($request, $key, $value, $materialReceive, &$stock) {
                    if ($request->material_type[$key] == 'Drum') {
                        $serial_code = 'F-' . $serial;
                        $quantity = ($value->final_mark - $value->initial_mark) + 1;
                    } else {
                        if ($serial == '') {
                            $serial_code = Null;
                            $quantity = $value->quantity;
                            $order_quantity = $value->order_quantity;
                            $left_quantity = $value->left_quantity;
                        } else {
                            $serial_code = 'SL-' . $serial;
                            $quantity = 1;
                        }
                    }
                    $stock[] = [
                        'received_type'     => 'MRR',
                        'material_id'       => $value->material_id,
                        // 'receiveable_type'  => ScmMrr::class,
                        // 'receiveable_id'    => $materialReceive->id,
                        'brand_id'          => $value->brand_id,
                        'branch_id'         => $request->branch_id,
                        'model'             => $value->model,
                        'quantity'          => $quantity,
                        'initial_mark'      => $value->initial_mark ?? null,
                        'final_mark'        => $value->final_mark ?? null,
                        'item_code'         => $value->item_code,
                        'warranty_period'   => $value->warranty_period ?? 0,
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
            $materialReceive->stockable()->createMany($stock);
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
    public function destroy(ScmMrr $materialReceive)
    {
        try {
            DB::beginTransaction();
            $materialReceive->stockable()->delete();
            $materialReceive->delete();
            DB::commit();
            return redirect()->route('material-receives.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $err) {
            DB::rollBack();
            return redirect()->route('material-receives.index')->withInput()->withErrors($err->getMessage());
        }
    }

    public function searchPoWithDate()
    {
        $items = PurchaseOrder::query()
            ->with('purchaseOrderLines')
            ->where("po_no", "like", "%" . request('search') . "%")
            ->where('po_type', request('po_type'))
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

    public function searchBillRegisterNoWithDate()
    {
        $items = BillRegister::query()
            ->where("bill_no", "like", "%" . request('search') . "%")
            ->orWhere('id', 'like', '%' . request('search') . '%')
            ->get()
            ->map(fn ($item) => [
                'value'          => $item->id,
                'label'          => $item->id  . ' ( ' . $item->bill_no . ' )',
                'date'           => $item->date
            ]);
        return response()->json($items);
    }

    public function getMaterialForPo($po_id)
    {
        $items = PurchaseOrderLine::query()
            ->with('material', 'brand')
            ->whereHas('purchaseOrder', function ($item) use ($po_id) {
                return $item->where('id', $po_id);
            })->get();

        $items->map(function ($item) {
            $item->left_quantity = $item->quantity - ScmMrrLine::query()
                ->where('po_composit_key', $item->po_composit_key)
                ->sum('quantity');
            return $item;
        });


        return response()->json($items);
    }

    public function getUnit($material_id)
    {
        $items = Material::find($material_id);
        return response()->json($items);
    }

    public function getPocompositeWithPrice($po_id, $material_id, $brand_id)
    {
        $item = PoMaterial::query()
            ->where([
                'material_id' => $material_id,
                'brand_id' => $brand_id
            ])->whereHas('purchaseOrderLines', function ($item) use ($po_id) {
                return $item->where('purchase_order_id', $po_id);
            })
            ->get();
        return response()->json($item);
    }
}
