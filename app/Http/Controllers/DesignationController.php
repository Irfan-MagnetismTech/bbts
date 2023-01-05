<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use HasRoles;
    function __construct()
    {
        $this->middleware('permission:designation-view|designation-create|designation-edit|designation-delete', ['only' => ['index','show']]);
        $this->middleware('permission:designation-create', ['only' => ['create','store']]);
        $this->middleware('permission:designation-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:designation-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $designations = Designation::latest()->get();
        $formType = "create";
        return view('designations.create', compact('designations', 'formType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";
        $designations = Designation::latest()->get();
        return view('designations.create', compact('designations', 'formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $data = $request->all();
            Designation::create($data);
            return redirect()->route('designations.create')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->route('designations.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $formType = "edit";
        $designations = Designation::latest()->get();
        return view('designations.create', compact('designation', 'designations', 'formType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $data = $request->all();
            $designation->update($data);
            return redirect()->route('designations.create')->with('message', 'Data has been updated successfully');
        }catch(QueryException $e){
            return redirect()->route('designations.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            if($designation->employees->isNotEmpty()){
                return back()->withErrors(["There are some Employees who belongs this Designation. Please remove them first."]);
            }
            $designation->delete();
            return redirect()->route('designations.create')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('designations.create')->withErrors($e->getMessage());
        }
    }
}
