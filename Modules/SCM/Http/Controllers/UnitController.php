<?php

namespace Modules\SCM\Http\Controllers;

use Illuminate\Http\Request;
use Modules\SCM\Entities\Unit;
use Illuminate\Routing\Controller;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\QueryException;
use Modules\SCM\Http\Requests\UnitRequest;

class UnitController extends Controller
{
    use HasRoles;
    function __construct()
    {
        // $this->middleware('permission:unit-view|unit-create|unit-edit|unit-delete', ['only' => ['index','show']]);
        // $this->middleware('permission:unit-create', ['only' => ['create','store']]);
        // $this->middleware('permission:unit-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:unit-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $units = Unit::latest()->get();
        $formType = "create";
        return view('scm::units.create', compact('units', 'formType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";
        $units = Unit::latest()->get();
        return view('scm::units.create', compact('units', 'formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */ 
    public function store(UnitRequest $request)
    {
        try{
            $data = $request->all();
            Unit::create($data);
            return redirect()->route('units.create')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->route('units.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function show(Unit $unit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function edit(Unit $unit)
    {
        $formType = "edit";
        $units = Unit::latest()->get();
        return view('scm::units.create', compact('unit', 'units', 'formType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update(UnitRequest $request, Unit $unit)
    {
        try{
            $data = $request->all();
            $unit->update($data);
            return redirect()->route('units.create')->with('message', 'Data has been updated successfully');
        }catch(QueryException $e){
            return redirect()->route('units.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unit $unit)
    {
        try{
            $unit->delete();
            return redirect()->route('units.create')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('units.create')->withErrors($e->getMessage());
        }
    }
}
