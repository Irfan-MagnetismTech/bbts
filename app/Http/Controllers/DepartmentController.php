<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::latest()->paginate();
        return view('departments.create', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::latest()->paginate();
        return view('departments.create', compact('departments'));
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
            Department::create($data);
            return redirect()->route('departments.create')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
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
    public function edit(Department $department)
    {
        $departments = Department::latest()->paginate();
        return view('departments.create', compact('department', 'departments'));
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
            $department=Department::findOrFail($id);
            $data = $request->all();
            $department->update($data);
            return redirect()->route('departments.create')->with('message', 'Data has been updated successfully');
        }catch(QueryException $e){
            return redirect()->route('departments.create')->withInput()->withErrors($e->getMessage());
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
            // if($department->employees->isNotEmpty()){
            //     return back()->withErrors(["There are some Employees who belongs this Department. Please remove them first."]);
            // }

            $department=Department::findOrFail($id);
            $department->delete();
            return redirect()->route('departments.create')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('departments.create')->withErrors($e->getMessage());
        }
    }
}
