<?php

namespace Modules\Sales\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Modules\Sales\Entities\Sale;
use Modules\SCM\Entities\ScmMur;
use Modules\Sales\Entities\Offer;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $sales = Sale::all();
        return view('sales::sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('sales::sales.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $data = $request->only('wo_no', 'effective_date', 'contract_duration',  'remarks', 'offer_id', 'account_holder', 'client_no');
        $sale = Sale::create($data);
        $saleDetail = $sale->saleDetails()->createMany($this->makeRow($request->all()));
        dd($saleDetail);
        $saleLink = $saleDetail->createMany($this->makeServiceRow($request->all(), $saleDetail));
        dd('done');
        try {
        } catch (Exception $err) {
            dd($err->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Sale $sales)
    {
        return view('sales::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param Sale $sales
     * @return Renderable
     */
    public function edit(Sale $sales)
    {
        return view('sales::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Sale $sales Object
     * @return Renderable
     */
    public function update(Request $request, Sale $sales)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param Sale $sales
     * @return Renderable
     */
    public function destroy(Sale $sales)
    {
        $sales->delete();
        return redirect()->route('sales.index')->with('success', 'Sales Deleted Successfully');
    }

    private function makeRow($raw)
    {
        $data = [];
        foreach ($raw['fr_no'] as $key => $value) {
            $data[] = [
                /*'checked' => $raw['checked'][$key] ? 1 : 0,*/
                'fr_no'   => $raw['fr_no'][$key],
                'delivery_date'   => $raw['delivery_date'][$key],
                'billing_address'   => $raw['billing_address'][$key],
                'collection_address'   => $raw['collection_address'][$key],
                'bill_payment_date'   => $raw['bill_payment_date'][$key],
                'payment_status'   => $raw['payment_status'][$key],
                'mrc'   => $raw['mrc'][$key],
                'otc'   => $raw['otc'][$key],
                /*'total_mrc'   => $raw['total_mrc'][$key],*/
            ];
        }
        return $data;
    }

    private function makeServiceRow($raw, $saleDetail)
    {
        $data = [];
        foreach ($raw['fr_no'] as $key => $value) {
            foreach ($raw['service'][$key] as $key1 => $value) {
                $data[] = [
                    'service' => $raw['service'][$key][$key1],
                    'quantity'   => $raw['quantity'][$key][$key1],
                    'unit'   => $raw['unit'][$key][$key1],
                    'rate'   => $raw['rate'][$key][$key1],
                    'price'   => $raw['price'][$key][$key1],
                    'total_price'   => $raw['total_price'][$key][$key1],
                    'sale_id' => $saleDetail[$key]['sale_id'],
                ];
            }
        }
        return $data;
    }

    public function getClientInfoForSales()
    {
        $items = Offer::query()
            ->with(['client', 'offerDetails.costing.costingProducts', 'offerDetails.frDetails'])
            ->whereHas('client', function ($qr) {
                return $qr->where('client_name', 'like', '%' . request()->search . '%');
            })
            ->get()
            ->map(fn ($item) => [
                'value' => $item->client->client_name,
                'label' => $item->client->client_name . ' ( ' . ($item?->mq_no ?? '') . ')',
                'client_no' => $item->client_no,
                'offer_id' => $item->id,
                'mq_no' => $item->mq_no,
                'details' => $item->offerDetails
            ]);
        return response()->json($items);
    }

    public function getFrsBasedOnMq()
    {
        $items = Offer::query()
            ->with(['client'])
            ->where('mq_no', 'like', '%' . request()->search . '%')
            ->get()
            ->map(fn ($item) => [
                'value'        => $item->mq_no,
                'label'        => $item->mq_no . '(' . ($item?->client?->client_name ?? '') . ')',
                'client_no'    => $item->client_no,
                'client_name'  => $item?->client?->client_name,
                'offer_id'     => $item->id,
                'mq_no'        => $item->mq_no
            ]);
        return response()->json($items);
    }

    private function getFrData()
    {
    }
}
