<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Admin\Entities\Brand;
use Illuminate\Routing\Controller;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\QueryException;
use Modules\Admin\Http\Requests\BrandRequest;

class BrandController extends Controller
{
    use HasRoles;
    function __construct()
    {
        // $this->middleware('permission:brand-view|brand-create|brand-edit|brand-delete', ['only' => ['index','show']]);
        // $this->middleware('permission:brand-create', ['only' => ['create','store']]);
        // $this->middleware('permission:brand-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:brand-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $brands = Brand::latest()->get();
        $formType = "create";
        return view('admin::brands.create', compact('brands', 'formType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";
        $brands = Brand::latest()->get();
        return view('admin::brands.create', compact('brands', 'formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */ 
    public function store(BrandRequest $request)
    {
        try{
            $data = $request->all();
            Brand::create($data);
            return redirect()->route('brands.create')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->route('brands.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        $formType = "edit";
        $brands = Brand::latest()->get();
        return view('admin::brands.create', compact('brand', 'brands', 'formType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(BrandRequest $request, Brand $brand)
    {
        try{
            $data = $request->all();
            $brand->update($data);
            return redirect()->route('brands.create')->with('message', 'Data has been updated successfully');
        }catch(QueryException $e){
            return redirect()->route('brands.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        try{
            $brand->delete();
            return redirect()->route('brands.create')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('brands.create')->withErrors($e->getMessage());
        }
    }
}
