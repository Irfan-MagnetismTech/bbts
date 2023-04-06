<?php

namespace Modules\SCM\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Admin\Entities\Brand;
use Illuminate\Routing\Controller;
use Modules\Admin\Entities\Branch;
use Modules\SCM\Entities\ScmRequisition;
use Illuminate\Contracts\Support\Renderable;
use Modules\SCM\Entities\ScmMrrLine;
use Modules\SCM\Entities\ScmRequisitionDetail;
use Modules\SCM\Entities\StockLedger;

class ScmChallanController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('scm::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $formType = "create";
        $brands = Brand::latest()->get();
        $branchs = Branch::latest()->get();
        $purposes = [
            'activation' => 'Activation',
            'maintenance' => 'Maintenance',
            'shifting' => 'Shifting',
            'own_use' => 'Own Use',
            'stolen' => 'Stolen',
        ];
        $received_type = ['mrr', 'err', 'wcr'];
        return view('scm::challans.create', compact('formType', 'brands', 'branchs', 'purposes', 'received_type'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $mrr_details = [];

        foreach ($request->material_name as $kk => $val) {
            if (isset($request->serial_code[$kk]) && count($request->serial_code[$kk])) {
                foreach ($request->serial_code[$kk] as $key => $value) {
                    $stock_ledgers[] = [
                        'branch_id' => null,
                        'material_id' => $request->material_name[$kk],
                        'item_code' => null,
                        'unit' => $request->unit[$kk],
                        'brand_id' => $request->brand[$kk],
                        'model' => $request->model[$kk],
                        'serial_code' => $request->serial_code[$kk][$key],
                        'quantity' => $request->quantity[$kk],
                    ];
                };
            } elseif (isset($request->material_name[$kk])) {
                $stock_ledgers[] = [
                    'branch_id' => null,
                    'material_id' => $request->material_name[$kk],
                    'item_code' => null,
                    'unit' => $request->unit[$kk],
                    'brand_id' => isset($request->brand[$kk]) ? $request->brand[$kk] : null,
                    'model' => isset($request->model[$kk]) ? $request->model[$kk] : null,
                    'serial_code' => null,
                    'quantity' => $request->quantity[$kk],
                ];
            }
            $mrr_details[] = [
                'received_type' => $request->received_type[$kk],
                'type_id' => $request->type_id[$kk],
                'material_id'   => $request->material_name[$kk],
                'brand_id' => isset($request->brand[$kk]) ? $request->brand[$kk] : null,
                'model' => isset($request->model[$kk]) ? $request->model[$kk] : null,
                'serial_code' => isset($request->serial_code[$kk]) ? json_encode($request->serial_code[$kk]) : [],
                'unit' => json_encode($request->unit[$kk]),
                'quantity' => json_encode($request->quantity[$kk]),
                'remarks' => json_encode($request->remarks[$kk]),
            ];
        };
        dd($stock_ledgers, $mrr_details, $request->all());
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
    }
}
