<?php

namespace App\Http\Controllers;

use App\Apsection;
use App\Department;
use App\Employee;
use App\Http\Requests\UserRequest;

//use Illuminate\Foundation\Auth\User;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;


class UserController extends Controller
{
    use HasRoles;

//    function __construct()
//    {
//        $this->middleware('permission:user-view|user-create|user-edit|user-delete', ['only' => ['index','show']]);
//        $this->middleware('permission:user-create', ['only' => ['create','store']]);
//        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
//        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
//    }

    public function index()
    {
        $users = User::latest()->get();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";
        $roles = Role::orderBy('name')->pluck('name', 'id');
        $departments=Department::orderBy('name')->pluck('name','id');
        $employees = Employee::orderBy('fname')->get(['fname', 'lname', 'id'])->pluck('fullName', 'id');
        return view('users.create', compact('formType','roles','employees','departments'));
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
            $this->validate($request, [
                'email' => 'required|email|unique:users,email',
                'password' => 'required|same:confirm-password',
            ]);

            $input = $request->all();
            $input['password'] = Hash::make($request['password']);

            $user = User::create($input);
            $user->assignRole($request->input('role'));

            return redirect()->route('users.index')->with('success','User created successfully');
        }catch(QueryException $e){
            return redirect()->route('users.edit')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $formType = "edit";
        $roles = Role::orderBy('name')->pluck('name', 'id');
        $departments=Department::orderBy('name')->pluck('name','id');

        $employees = Employee::orderBy('fname')->get(['fname', 'lname', 'id'])->pluck('fullName', 'id');
        return view('users.create', compact('formType','roles','employees', 'user','departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        try{
            $userData = $request->all();
            if(!empty($userData['password'])){
                $userData['password'] = Hash::make($request['password']);
            }else{
                $userData['password'] = $user->password;
            }
            $user->update($userData);
            DB::table('model_has_roles')->where('model_id',$user->id)->delete();
            $user->assignRole($userData['role']);
//            $user->assignRole($request->input('role'));
            return redirect()->route('users.index')->with('success','User Updated successfully');
        }catch(QueryException $e){
            return redirect()->route('users.edit')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try{
            $user->delete();
            return redirect()->route('users.index')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

}
