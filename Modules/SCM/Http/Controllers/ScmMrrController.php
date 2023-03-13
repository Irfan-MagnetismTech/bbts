<?php

namespace Modules\SCM\Http\Controllers;

use Illuminate\Http\Request;
use Modules\SCM\Entities\ScmMrr;
use Modules\Admin\Entities\Brand;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\Branch;
use Modules\SCM\Entities\Material;
use Illuminate\Database\QueryException;
use Modules\SCM\Entities\PurchaseOrder;
use Modules\SCM\Http\Requests\MrrRequest;
use Modules\SCM\Entities\PurchaseOrderLine;
use Illuminate\Contracts\Support\Renderable;

class ScmMrrController extends Controller
{
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
        return view('scm::mrr.create', compact('brands'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(MrrRequest $request)
    {
        $requestData = $request->only('branch_id', 'date', 'purchase_order_id', 'supplier_id', 'challan_no', 'challan_date');
        $data = PurchaseOrder::with('purchaseOrderLines')->findOrFail($request->purchase_order_id);
        dd($data);
        try {

            $lastMRSId = ScmMrr::latest()->first();
            if ($lastMRSId) {
                $requestData['mrr_no'] = 'mrr-' . now()->format('Y') . '-' . $lastMRSId->id + 1;
            } else {
                $requestData['mrr_no'] = 'mrr-' . now()->format('Y') . '-' . 1;
            }
            $requestData['created_by'] = auth()->id();
            $purchaseRequisition = ScmMrr::create($requestData);

            $requisitionDetails = [];
            $serialCode = [];
            foreach ($request->material_name as $key => $data) {
                $requisitionDetails[] = [
                    'material_id' => $request->material_name[$key],
                    'item_code' => $request->description[$key],
                    'brand_id' => $request->brand_id[$key],
                    'model' => $request->model[$key],
                    'quantity' => $request->quantity[$key],
                    'initial_mark' => $request->initial_mark[$key],
                    'final_mark' => $request->final_mark[$key],
                    'item_code' => $request->item_code[$key],
                ];
                $serialCode[] = explode(',', $request->sl_code[$key]);
            }
            $sdas = $purchaseRequisition->scmMrrLines()->createMany($requisitionDetails);

            foreach ($sdas as $key => $value) {
                $value->scmMrrSerialCodeLines()->createMany(array_map(function ($serial) {
                    return ['serial_or_drum_code' => $serial];
                }, $serialCode[$key]));
            }
            // dd($sdas);
            return redirect()->route('purchase-requisitions.index')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            dd($e->getMessage());

            return redirect()->route('purchase-requisitions.create')->withInput()->withErrors($e->getMessage());
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

    public function searchPoWithDate(Request $request)
    {
        $search = $request->search;
        $items = PurchaseOrder::query()
            ->with('purchaseOrderLines')
            ->where("po_no", "like", "%$search%")
            ->get()
            ->map(fn ($item) => [
                'value' => $item->id,
                'label' => $item->po_no,
                'date' => $item->date,
                'supplier_id' => $item?->supplier_id ?? 0,
                'supplier_name' => $item?->supplier?->name ?? 0
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
