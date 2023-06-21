<?php

namespace Modules\Sales\Http\Controllers;

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
        //
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

    public function getClientInfoForSales()
    {
        $items = Offer::query()
            ->with(['client'])
            ->whereHas('client', function ($qr) {
                return $qr->where('client_name', 'like', '%' . request()->search . '%');
            })
            ->get()
            ->map(fn ($item) => [
                'value' => $item->client->client_name,
                'label' => $item->client->client_name,
                'client_no' => $item->client_no,
                'offer_id' => $item->id,
                'mq_no' => $item->mq_no
            ]);
        return response()->json($items);
    }

    private function getFrData()
    {
    }
}
