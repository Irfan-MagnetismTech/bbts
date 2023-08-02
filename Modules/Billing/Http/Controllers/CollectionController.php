<?php

namespace Modules\Billing\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Sales\Entities\Client;
use App\Services\BbtsGlobalService;
use Modules\Billing\Entities\BillGenerate;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\QueryException;
use Modules\Billing\Entities\Collection;

class CollectionController extends Controller
{


    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('billing::collection.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('billing::collection.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            $CollectionData = $request->only('client_no', 'mr_no', 'date', 'remarks', 'total_amount', 'total_net_amount', 'total_receive_amount', 'total_due');
            $BillCollection = Collection::create($CollectionData);
            $lineRow = $this->createLineRow($request);
            $collectionBillRow = $this->createCollectionBillRow($request);
            $BillCollection->lines()->createMany($lineRow);
            $BillCollection->collectionLines()->createMany($collectionBillRow);
            dd('Done');
        } catch (QueryException $err) {
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


    public function createLineRow($req)
    {
        $row = [];
        foreach ($req->payment_method as $key => $value) {
            $row[] = [
                'payment_method'    => $req->payment_method[$key],
                'bank_name'         => isset($req->bank_name[$key]) ? $req->bank_name[$key] : NULL,
                'instrument_no'     => $req->instrument_no[$key],
                'instrument_date'   => $req->instrument_date[$key],
                'amount'            => $req->amount[$key]
            ];
        }
        return $row;
    }


    public function createCollectionBillRow($req)
    {
        $row = [];
        foreach ($req->bill_no as $key => $value) {
            $row[] = [
                'bill_no'           => $req->bill_no[$key],
                'amount'            => $req->bill_amount[$key],
                'previous_due'      => $req->previous_due[$key],
                'discount'          => $req->discount[$key],
                'penalty'           => $req->penalty[$key],
                'net_amount'        => $req->net_amount[$key],
                'receive_amount'    => $req->receive_amount[$key],
                'due'               => $req->due[$key]
            ];
        }
        return $row;
    }

    public function get_client()
    {
        $items = Client::query()
            ->where('client_name', 'like', '%' . request()->search . '%')
            ->get()
            ->map(fn ($item) => [
                'value'                 => $item->client_name,
                'label'                 => $item->client_name,
                'client_no'             => $item->client_no,
                'client_id'             => $item->id
            ]);
        return response()->json($items);
    }

    public function get_bill()
    {
        $items = BillGenerate::query()
            ->with('collection')
            ->where('bill_no', 'like', '%' . request()->search . '%')
            ->where('client_no', request()->customQueryFields['client_no'])
            ->get()
            ->map(fn ($item) => [
                'value'                 => $item->bill_no,
                'label'                 => $item->bill_no,
                'amount'                => $item->amount,
                'id'                    => $item->id,
                'previous_due'          => count($item?->collection) ? $item?->collection?->last()?->due : 0,
            ]);
        return response()->json($items);
    }
}
