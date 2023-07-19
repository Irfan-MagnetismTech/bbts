<?php

namespace Modules\Billing\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Billing\Entities\MonthlyBill;
use Illuminate\Contracts\Support\Renderable;
use Modules\Billing\Entities\BillGenerate;
use Modules\Sales\Entities\SaleDetail;

class MonthlyBillController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('billing::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('billing::monthlyBills.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            $datas = SaleDetail::with(['sale.saleProductDetails', 'sale.saleLinkDetails'])->where('checked', 1)->get()->groupBy('billing_address_id');
            foreach ($datas as $key => $val) {
                $child = [];
                $parent = [
                    'client_no' => $val->first()->sale->client_no,
                    'billing_address_id' => $key,
                    'date' => $request->date,
                    'bill_type' => "Monthly Bill",
                    'month' => explode("-", $request->month)[1]
                ];
                $net_amount = 0;
                foreach ($val as $key1 => $val2) {
                    foreach ($val2->sale->saleProductDetails as $kk => $vv) {
                        $child[] = [
                            "fr_no"                    => $vv->fr_no,
                            "product_id"               => $vv->product_id,
                            "quantity"                 => $vv->quantity,
                            "unit_price"               => $vv->price,
                            "total_price"              => $vv->quantity * $vv->price,
                            "total_product_price"      => $vv->quantity * $vv->price,
                            "total_amount"             => $vv->quantity * $vv->price,
                            "net_amount"               => $vv->quantity * $vv->price,
                            'bill_type'                => "Monthly Bill",
                        ];
                        $net_amount += ($vv->quantity * $vv->price);
                    }
                }

                $data = BillGenerate::create($parent);
                $data->lines()->createMany($child);
            }
        } catch (Exception $err) {
            dd($err->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('billing::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(MonthlyBill $monthlyBill)
    {
        return view('billing::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        try {
        } catch (Exception $err) {
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
}
