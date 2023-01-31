<?php

namespace Modules\Admin\Http\Controllers;

use Modules\Admin\Entities\Pop;
use Illuminate\Routing\Controller;
use Modules\Admin\Entities\Branch;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\QueryException;
use Modules\Admin\Http\Requests\PopRequest;

class PopController extends Controller
{
    use HasRoles;
    function __construct()
    {
        // $this->middleware('permission:pop-view|pop-create|pop-edit|pop-delete', ['only' => ['index','show']]);
        // $this->middleware('permission:pop-create', ['only' => ['create','store']]);
        // $this->middleware('permission:pop-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:pop-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $pops = Pop::with('branch')->latest()->get();
        $formType = "create";
        return view('admin::pops.create', compact('pops', 'formType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";
        $pops = Pop::latest()->get();
        $branches = Branch::latest()->get();
        return view('admin::pops.create', compact('formType', 'branches', 'pops'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */ 
    public function store(PopRequest $request)
    {
        try{
            $data = $request->all();
            Pop::create($data);
            return redirect()->route('pops.create')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->route('pops.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pop  $pop
     * @return \Illuminate\Http\Response
     */
    public function show(Pop $pop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pop  $pop
     * @return \Illuminate\Http\Response
     */
    public function edit(Pop $pop)
    {
        $formType = "edit";
        $pops = Pop::latest()->get();
        return view('admin::pops.create', compact('pop', 'pops', 'formType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pop  $pop
     * @return \Illuminate\Http\Response
     */
    public function update(PopRequest $request, Pop $pop)
    {
        try{
            $data = $request->all();
            $pop->update($data);
            return redirect()->route('pops.create')->with('message', 'Data has been updated successfully');
        }catch(QueryException $e){
            return redirect()->route('pops.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pop  $pop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pop $pop)
    {
        try{
            $pop->delete();
            return redirect()->route('pops.create')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('pops.create')->withErrors($e->getMessage());
        }
    }
}
