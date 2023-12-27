<?php

namespace Modules\Networking\Http\Controllers;

use Termwind\Components\Dd;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Sales\Entities\SaleDetail;
use Modules\Networking\Entities\VasService;
use Illuminate\Contracts\Support\Renderable;
use Modules\Networking\Entities\LogicalConnectivity;
use Modules\Networking\Entities\PhysicalConnectivity;

class LogicalConnectivityVasController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return abort(404);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $saleDetails = SaleDetail::query()
            ->whereSaleIdAndFrNo(request()->get('sale_id'), request()->get('fr_no'))
            ->with(['client', 'frDetails', 'saleProductDetails' => function ($q) {
                $q->whereHas('product', function ($query) {
                    $query->where('category_id', '7');
                });
            }])
            ->latest()
            ->first();

        $physicalConnectivityVas = PhysicalConnectivity::query()
            ->whereSaleIdAndFrNo($saleDetails->sale_id, $saleDetails->fr_no)
            ->with('lines')
            ->latest()
            ->first();

        $vasServices = VasService::query()
            ->with('lines.product')
            ->where('fr_no', $saleDetails->fr_no)
            ->latest()
            ->first();

        $logicalConnectivityVas = LogicalConnectivity::query()
            ->where([
                'fr_no' => $saleDetails->fr_no,
                'client_no' => $saleDetails->client_no,
                'product_category' => 'VAS'
            ])
            ->with('lines.product')
            ->latest()
            ->first();

        return view('networking::logical-vas-connectivities.create', compact('saleDetails', 'physicalConnectivityVas', 'vasServices', 'logicalConnectivityVas'));
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

            $dataList = [];
            foreach ($request->product_id as $key => $value) {
                $dataList[] = [
                    'product_id' => $value,
                    'product_category' => 'VAS',
                    'quantity' => $request->quantity[$key],
                    'remarks' => $request->remarks[$key]
                ];
            }

            $request->merge([
                'product_category' => 'VAS',
            ]);

            $logicalConnectivity = LogicalConnectivity::updateOrCreate(
                [
                    'fr_no' => $request->fr_no,
                    'client_no' => $request->client_no,
                    'product_category' => 'VAS'
                ],
                $request->all()
            );

            $logicalConnectivity->lines()->delete();
            $logicalConnectivity->lines()->createMany($dataList);

            DB::commit();

            return redirect()->back()->with('message', 'Logical Connectivity VAS created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $vasServices = VasService::query()
            ->with('lines.product')
            ->where('fr_no', $id)
            ->latest()
            ->first();
        $saleDetails = SaleDetail::query()
            ->whereSaleIdAndFrNo($vas->sale_id, $vas->fr_no)
            ->with(['client', 'frDetails', 'saleProductDetails' => function ($q) {
                $q->whereHas('product', function ($query) {
                    $query->where('category_id', '7');
                });
            }])
            ->latest()
            ->first();

        $physicalConnectivityVas = PhysicalConnectivity::query()
            ->whereSaleIdAndFrNo($saleDetails->sale_id, $saleDetails->fr_no)
            ->with('lines')
            ->latest()
            ->first();
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        return abort(404);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        return abort(404);
    }
}
