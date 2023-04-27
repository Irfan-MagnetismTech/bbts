<?php

namespace Modules\SCM\Http\Controllers;

use Modules\Admin\Entities\Unit;
use Illuminate\Routing\Controller;
use Modules\SCM\Entities\Supplier;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\QueryException;
use Modules\SCM\Http\Requests\SupplierRequest;

class SupplierController extends Controller
{
    use HasRoles;
    function __construct()
    {
        // $this->middleware('permission:supplier-view|supplier-create|supplier-edit|supplier-delete', ['only' => ['index','show']]);
        // $this->middleware('permission:supplier-create', ['only' => ['create','store']]);
        // $this->middleware('permission:supplier-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:supplier-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $suppliers = Supplier::latest()->get();

        return view('scm::suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";
        $suppliers = Supplier::latest()->get();

        return view('scm::suppliers.create', compact('suppliers', 'formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */ 
    public function store(SupplierRequest $request)
    {
        try{
            $data = $request->all();
            Supplier::create($data);
            return redirect()->route('suppliers.index')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->route('suppliers.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        $formType = "edit";
        $suppliers = Supplier::latest()->get();
        
        return view('scm::suppliers.create', compact('supplier', 'suppliers', 'formType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(SupplierRequest $request, Supplier $supplier)
    {
        try{
            $data = $request->all();
            $supplier->update($data);
            return redirect()->route('suppliers.index')->with('message', 'Data has been updated successfully');
        }catch(QueryException $e){
            return redirect()->route('suppliers.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        try{
            $supplier->delete();
            return redirect()->route('suppliers.index')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('suppliers.index')->withErrors($e->getMessage());
        }
    }
}
