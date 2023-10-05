<?php

namespace App\Http\Controllers\Dataencoding;

use Illuminate\Http\Request;
use App\Models\Dataencoding\Thana;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Dataencoding\District;
use App\Models\Dataencoding\Division;
use App\Models\Dataencoding\Employee;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Dataencoding\Department;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;
use App\Models\Dataencoding\Designation;
use Modules\Admin\Http\Requests\EmployeeRequest;

class EmployeeController extends Controller
{
    use HasRoles;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    const BLOODGROUPS = [
        'A+' => 'A+',
        'A-' => 'A-',
        'B+' => 'B+',
        'B-' => 'B-',
        'O+' => 'O+',
        'O-' => 'O-',
        'AB+' => 'AB+',
        'AB-' => 'AB-'
    ];
    // function __construct()
    // {
    //     $this->middleware('permission:employee-list|employee-create|employee-edit|employee-delete', ['only' => ['index','show']]);
    //     $this->middleware('permission:employee-create', ['only' => ['create','store']]);
    //     $this->middleware('permission:employee-edit', ['only' => ['edit','update']]);
    //     $this->middleware('permission:employee-delete', ['only' => ['destroy']]);
    // }
    public function index()

    {
        //        $test=Employee::with('preThana','preThana.district')->get();
        //        dd($test);
        $employees = Employee::with('designation', 'department')->latest()->get();
        //    dd($employees);
        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $formType = "create";

        $departments = Department::orderBy('name')->pluck('name', 'id');

        $designations = Designation::orderBy('name')->pluck('name', 'id');
        $divisions = Division::orderBy('name')->pluck('name', 'id');
        $predistrict = [];
        $perdistrict = [];
        $prethanas = [];
        $perthanas = [];

        $bloodgroups = self::BLOODGROUPS;

        return view('employees.create', compact('prethanas', 'perthanas', 'formType', 'designations', 'departments', 'predistrict', 'perdistrict', 'divisions', 'bloodgroups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {
        // dd($request->all());
        try {
            // $employee_data = $request->except('district_id','division_id');
            if ($request->hasFile('picture')) {
                $pictureName = $request->fname . '_' . time() . '_' . $request->picture->getClientOriginalName();
                $request->picture->move('images/Employees', $pictureName);
                $employee_data = $request->all();
                $employee_data['picture'] = $pictureName;
            } else {
                $employee_data = $request->all();
                $employee_data['picture'] = "";
            }
            // dd($employee_data);
            if ($request->address_status == 1) {
                $employee_data['per_street_address'] = $employee_data['pre_street_address'];
                $employee_data['per_division_id'] = $employee_data['pre_division_id'];
                $employee_data['per_district_id'] = $employee_data['pre_district_id'];
                $employee_data['per_thana_id'] = $employee_data['pre_thana_id'];
            }
            // dd($employee_data);
            Employee::create($employee_data);
            return redirect()->route('dataencoding.employees.index')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
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
        // dd($employee->department);
        $employee = Employee::with('preDivision', 'perDivision', 'preDistrict',
         'perDistrict', 'preThana', 'perThana')->findOrfail($employee->id);
        // dd($employee);
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
        $formType = "edit";
        $departments = Department::orderBy('name')->pluck('name', 'id');
        $designations = Designation::orderBy('name')->pluck('name', 'id');

        $divisions = Division::orderBy('name')->pluck('name', 'id');
        $districts = District::orderBy('name')->pluck('name', 'id');
        $thanas = Thana::orderBy('name')->pluck('name', 'id');
        $predistrict = District::where('division_id', $employee->preThana->district->division_id ?? '')->orderBy('name')->pluck('name', 'id');
        $perdistrict = District::where('division_id', $employee->perThana->district->division_id ?? '')->orderBy('name')->pluck('name', 'id');
        $prethanas = Thana::where('district_id', $employee->preThana->district_id ?? '')->orderBy('name')->pluck('name', 'id');
        $perthanas = Thana::where('district_id', $employee->perThana->district_id ?? '')->orderBy('name')->pluck('name', 'id');
        $bloodgroups = self::BLOODGROUPS;

        return view('employees.create', compact('employee','formType', 'designations', 'departments', 'divisions', 'districts', 'thanas', 'bloodgroups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeRequest $request, Employee $employee)
    {

        try {
            $data = $request->except('district_id', 'division_id');
            if ($request->hasFile('picture')) {
                $pictureName = $request->fname . '_' . time() . '_' . $request->picture->getClientOriginalName();
                if (!empty($employee->picture) && file_exists(public_path("images/Employees/$employee->image"))) {
                    unlink(public_path("images/Employees/$employee->picture"));
                    $request->picture->move('images/Employees', $pictureName);
                } else {
                    $request->picture->move('images/Employees', $pictureName);
                }
                $data['picture'] = $pictureName;
            }

            if ($request->address_status == 1) {
                $data['per_street_address'] = $data['pre_street_address'];
                $data['per_thana_id'] = $data['pre_thana_id'];
            }

            $employee->update($data);
            return redirect()->route('dataencoding.employees.index')->with('message', 'Data has been updated successfully');
        } catch (QueryException $e) {
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
        //    dd($employee);
        try {
            $employee->delete();
            return redirect()->route('dataencoding.employees.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
