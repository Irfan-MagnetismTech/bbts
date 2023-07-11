<?php

namespace Modules\Networking\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Sales\Entities\Product;
use Illuminate\Contracts\Support\Renderable;
use Modules\Networking\Entities\VasService;

class VasServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $datas = VasService::all();
        return view('networking::service-requisition.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $products = Product::query()
            ->where('category_id', 7)
            ->latest()
            ->get();
        return view('networking::vas-services.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     * @param NetServiceRequisitionRequest $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $datas = $request->only('type', 'fr_no', 'from_pop_id', 'to_pop_id', 'capacity_type', 'capacity', 'client_no', 'date', 'required_date', 'vendor_id', 'remark');
            $dataList = [];
            foreach ($request->service_id as $key => $value) {
                $dataList[] = [
                    "service_id"  => $value,
                    'remarks'     => $request->remarks[$key],
                    'quantity'    => $request->quantity[$key],
                ];
            }
            $requisition = NetServiceRequisition::create($datas);
            $requisition->lines()->createMany($dataList);
            DB::commit();
            return redirect()->route('service-requisitions.index')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $err) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($err->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        abort(404);
        return view('networking::service-requisition.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(NetServiceRequisition $service_requisition)
    {
        $products = Product::latest()->get();
        $fr_nos = Client::with('saleDetails')->where('client_no', $service_requisition->client_no)->first()?->saleDetails ?? [];
        return view('networking::service-requisition.create', compact('products', 'service_requisition', 'fr_nos'));
    }

    /**
     * Update the specified resource in storage.
     * @param NetServiceRequisitionRequest $request
     * @param int $id
     * @return Renderable
     */
    public function update(NetServiceRequisitionRequest $request, NetServiceRequisition $service_requisition)
    {
        try {
            DB::beginTransaction();
            $datas = $request->only('type', 'fr_no', 'from_pop_id', 'to_pop_id', 'capacity_type', 'capacity', 'client_no', 'date', 'required_date', 'vendor_id', 'remark');
            $dataList = [];
            foreach ($request->service_id as $key => $value) {
                $dataList[] = [
                    "service_id"  => $value,
                    'remarks'     => $request->remarks[$key],
                    'quantity'    => $request->quantity[$key],
                ];
            }
            $service_requisition->update($datas);
            $service_requisition->lines()->delete();
            $service_requisition->lines()->createMany($dataList);
            DB::commit();
            return redirect()->route('service-requisitions.index')->with('message', 'Data has been updated successfully');
        } catch (QueryException $err) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($err->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(NetServiceRequisition $service_requisition)
    {
        try {
            $service_requisition->delete();
            return redirect()->route('service-requisitions.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $err) {
            return redirect()->back()->withInput()->withErrors($err->getMessage());
        }
    }
}
