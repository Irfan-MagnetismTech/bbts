<?php

namespace Modules\Networking\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Sales\Entities\Product;
use Illuminate\Contracts\Support\Renderable;
use Modules\Networking\Http\Requests\NetServiceRequisitionRequest;

class NetServiceRequisitionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('networking::service-requisition.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $products = Product::latest()->get();
        return view('networking::service-requisition.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     * @param NetServiceRequisitionRequest $request
     * @return Renderable
     */
    public function store(NetServiceRequisitionRequest $request)
    {
        dd($request->all());
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
    public function edit($id)
    {
        return view('networking::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param NetServiceRequisitionRequest $request
     * @param int $id
     * @return Renderable
     */
    public function update(NetServiceRequisitionRequest $request, $id)
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
}
