<?php

namespace Modules\Admin\Http\Controllers;

use App\Apsection;

//use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Modules\Admin\Entities\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\Dataencoding\Employee;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Dataencoding\Department;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use HasRoles;

    function __construct()
    {
        $this->middleware('permission:user-view|user-create|user-edit|user-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $users = User::latest()->get();
        return view('admin::users.index', compact('users'));
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
        $departments = Department::orderBy('name')->pluck('name', 'id');
        $employees = Employee::orderBy('name')->pluck('name', 'id');

        return view('admin::users.create', compact('formType', 'roles', 'employees', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->input('role'));
        try {
            Validator::make($request->all(), [
                'email' => 'required|email|unique:users,email',
                'password' => 'required|same:confirm-password',
            ])->validate();

            $input = $request->all();
            $input['password'] = Hash::make($request['password']);

            DB::transaction(function () use ($input, $request) {
                $user = User::create($input);
                $user->assignRole($request->input('role'));
            });

            return redirect()->route('users.index')->with('success', 'User created successfully.');
        } catch (QueryException $e) {
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
        $departments = Department::orderBy('name')->pluck('name', 'id');
        $employees = Employee::orderBy('name')->pluck('name', 'id');
        return view('admin::users.create', compact('formType', 'roles', 'employees', 'user', 'departments'));
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
        try {
            $userData = $request->all();
            if (!empty($userData['password'])) {
                $userData['password'] = Hash::make($request['password']);
            } else {
                $userData['password'] = $user->password;
            }
            $user->update($userData);
            DB::table('model_has_roles')->where('model_id', $user->id)->delete();
            $user->assignRole($userData['role']);
            //            $user->assignRole($request->input('role'));
            return redirect()->route('users.index')->with('success', 'User Updated successfully');
        } catch (QueryException $e) {
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
        try {
            $user->delete();
            return redirect()->route('users.index')->with('message', 'User has been deleted successfully.');
        } catch (QueryException $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
