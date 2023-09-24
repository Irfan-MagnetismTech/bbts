<?php

namespace Modules\Billing\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Sales\Entities\Client;
use App\Services\BbtsGlobalService;
use Illuminate\Database\QueryException;
use Modules\Billing\Entities\Collection;
use Modules\Billing\Entities\BillGenerate;
use Illuminate\Contracts\Support\Renderable;
use Modules\Sales\Entities\SaleProductDetail;

class CollectionController extends Controller
{


    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $datas = Collection::query()->get();
        return view('billing::collection.index', compact('datas'));
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
        // dd($request->all());
        if($request->total_amount!=$request->grand_total)
        {
            return redirect()->back()->withInput()->with('message', 'Total amount not equeal'); 
        }
        try {
            DB::beginTransaction();
            $CollectionData = $request->only('client_no', 'mr_no', 'date', 'remarks', 'total_amount', 'total_net_amount','total_vat', 'total_tax','grand_total', 'total_bill_amount', 'total_previous_due', 'total_receive_amount', 'total_due');

            $BillCollection = Collection::create($CollectionData);
            $lineRow = $this->createLineRow($request);
            $collectionBillRow = $this->createCollectionBillRow($request);
            $BillCollection->lines()->createMany($lineRow);
            $BillCollection->collectionBills()->createMany($collectionBillRow);
            DB::commit();
            return redirect()->route('collections.index')->with('message', 'Data has been created successfully');
        } catch (QueryException $error) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($error->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Collection $collection)
    {
        return view('billing::collection.show', compact('collection'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Collection $collection)
    {
        return view('billing::collection.create', compact('collection'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Collection $collection)
    {
        try {
            DB::beginTransaction();
            $CollectionData = $request->only('client_no', 'mr_no', 'date', 'remarks', 'total_amount', 'total_net_amount', 'total_receive_amount', 'total_due');
            $collection->update($CollectionData);
            $lineRow = $this->createLineRow($request);
            $collectionBillRow = $this->createCollectionBillRow($request);
            $collection->lines()->delete();
            $collection->collectionBills()->delete();
            $collection->lines()->createMany($lineRow);
            $collection->collectionBills()->createMany($collectionBillRow);
            DB::commit();
            return redirect()->route('collections.index')->with('message', 'Data has been updated successfully');
        } catch (QueryException $error) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($error->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Collection $collection)
    {
        try {
            $collection->lines()->delete();
            $collection->collectionBills()->delete();
            $collection->delete();
            return redirect()->route('collections.index')->with('message', 'User has been deleted successfully.');
        } catch (QueryException $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
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
