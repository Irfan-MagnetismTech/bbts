<?php

namespace App\Http\Controllers;

use App\Model\Department;
use App\Model\Designation;
use App\Model\District;
use App\Model\Division;
use App\Model\Employee;
use App\Model\Team;
use App\Model\Thana;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Spatie\Permission\Traits\HasRoles;

class EmployeeController extends Controller
{
    use HasRoles;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:employee-view|employee-create|employee-edit|employee-delete', ['only' => ['index','show']]);
        $this->middleware('permission:employee-create', ['only' => ['create','store']]);
        $this->middleware('permission:employee-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:employee-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $employees=Employee::with('designation','department')->latest()->get();
       //dd($employees);
        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";
        $designations = Designation::orderBy('name')->pluck('name', 'id');
        $departments = Department::orderBy('name')->pluck('name', 'id');
        $divisions =Division::orderBy('name')->pluck('name', 'id');
        $district= [];
        $thanas=[];
        $teams=Team::pluck('name','id');
        return view('employees.create', compact('formType','thanas','designations','departments','district','divisions','teams'));
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
            $employee_data = $request->except('district_id','division_id');
            $employee_data['picture'] = $request->hasFile('picture')? $request->file('picture')->store('employee'): null;

            Employee::create($employee_data);
            return redirect()->route('employees.index')->with('message', 'Data has been inserted successfully');
            }
        catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        $employee = Employee::where('id', $employee->id)
            ->with('user.sells.apartment.project', 'user.sells.salesCollections', 'user.sells.sellClient.client', 'user.leads')
            ->firstOrFail();
        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
//      dd($employee);
        $formType = "edit";
        $designations = Designation::orderBy('name')->pluck('name', 'id');
        $departments = Department::orderBy('name')->pluck('name', 'id');
        $teams=Team::pluck('name','id');
        $divisions=Division::orderBy('name')->pluck('name', 'id');
        $district= District::where('division_id',$employee->preThana->district->division_id)->orderBy('name')->pluck('name', 'id');
        $thanas=Thana::where('district_id',$employee->preThana->district_id)->orderBy('name')->pluck('name', 'id');
//        $perthanas=Thana::where('district_id',$employee->preThana->district_id)->orderBy('name')->pluck('name', 'id');

        return view('employees.create', compact('employee','formType', 'designations','departments','divisions','district','thanas','teams'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        try{
            $data = $request->except('district_id','division_id');

            if($request->hasFile('picture')){
                file_exists(asset($employee->picture)) && $employee->picture ?unlink($employee->picture):null;
                $data['picture'] = $request->file('picture')->store('employee');
            }
//            if($request->hasFile('picture')){
//                $pictureName =$request->fname.'_'.time(). '_' . $request->picture->getClientOriginalName();
//                if(!empty($employee->picture) && file_exists(public_path("images/Employees/$employee->image"))){
//                    unlink(public_path("images/Employees/$employee->picture"));
//                    $request->picture->move('images/Employees',$pictureName);
//                }else{
//                    $request->picture->move('images/Employees',$pictureName);
//                }
//                $data['picture'] =$pictureName;
//            }
            $employee->update($data);
            return redirect()->route('employees.index')->with('message', 'Data has been updated successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        try{
            $employee->delete();
            return redirect()->route('employees.index')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
