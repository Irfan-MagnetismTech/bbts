<?php

namespace Modules\Billing\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Billing\Entities\BillGenerate;
use Modules\Billing\Entities\BrokenDaysBill;
use Modules\Sales\Entities\SaleProductDetail;

class BrokenDaysBillController extends Controller
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
        return view('billing::brokenDaysBill.create');
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
            $data = $request->only('client_no', 'fr_no', 'date', 'bill_no', 'type', 'days', 'total_amount','user_id');
            $data['user_id'] = Auth()->id();
            $data['type'] = 'Broken Days Bill';
            $data['total_amount'] = $request->net_total_amount;
            $bill = BrokenDaysBill::create($data);

            $billGenerateData = [
                'client_no' => $bill->client_no,
                'date' => $bill->date,
                'bill_no' => $bill->bill_no,
                'bill_type' => $bill->type,
                'amount' => $bill->total_amount,
                'user_id' => $bill->user_id,
            ];

            $billGenerate = BillGenerate::create($billGenerateData);

            $getProducts = [];
            $getBillGenerateProducts = [];
            foreach ($request->product_name as $key => $val) {
                $getProducts[] = $this->getProductData($request, $key);
                $getBillGenerateProducts[] = $this->getBillGenerateProductData($request, $key, $bill);
            }

            $bill->BrokenDaysBillDetails()->createMany($getProducts);
            $billGenerate->lines()->createMany($getBillGenerateProducts);

            DB::commit();
            return redirect()->route('broken-days-bills.create')->with('message', 'Data has been created successfully');
        } catch (Exception $error) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($error->getMessage());
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
    public function edit($id)
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

    public function get_fr_product()
    {
        $items = SaleProductDetail::query()
            ->where('fr_no', request()->fr_no)
            ->get()
            ->map(fn ($item) => [
                'product_id'                 => $item->product_id,
                'product_name'                 => $item->product_name,
                'quantity'                 => $item->quantity,
                'unit'                 => $item->unit,
                'fr_no'                 => $item->fr_no,
                'rate'                 => $item->rate,
                'price'                 => $item->price,
                'vat_amount'                 => $item->vat_amount,
                'total_price'                 => $item->total_price,
            ]);
        return response()->json($items);
    }

    private function getProductData($request, $key)
    {
        return [
            'product_id'        => $request->product_id[$key],
            'quantity'          => $request->quantity[$key],
            'unit_price'          => $request->unit_price[$key],
            'vat'          => $request->vat[$key],
            'total_price'       => $request->total_price[$key],
            'total_amount'       => $request->total_amount[$key],
        ];
    }

    private function getBillGenerateProductData($request, $key, $bill)
    {
        return [
            'broken_days_bill_id'        => $bill->id,
            'fr_no'        => $bill->fr_no,
            'bill_type'        => $bill->type,
            'product_id'        => $request->product_id[$key],
            'quantity'          => $request->quantity[$key],
            'unit_price'          => $request->unit_price[$key],
            'vat'          => $request->vat[$key],
            'total_price'       => $request->total_price[$key],
            'total_amount'       => $request->total_amount[$key],
        ];
    }
}
