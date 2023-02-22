<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Admin\Entities\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Termwind\Components\Dd;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin::Auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return redirect()->back()->withErrors(['message' => 'Invalid email or password']);
        }

        $user = User::where('email', $request->email)->first();
        $data = ['token' => $user->createToken('web')->plainTextToken];

        return redirect()->intended();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function passwordResetForm()
    {
        return view('admin::Auth.password-reset');
    }

    public function resetPassword(Request $request)
    {
        $user_details = User::where('id', auth()->id())->pluck('password');
        $password_hash = Hash::check($request->old_password, $user_details[0]);

        if($password_hash){
            if($request->new_password == $request->confirm_password){
                $data['password'] = Hash::make(trim($request->confirm_password));
                User::where('id', auth()->id())->update($data);
                return redirect()->back()->with('message', 'Password has been updated successfully');
            }else{
                return redirect()->back()->withErrors(['message' => 'Confirm Password does not match']);
            }
        }else{
            return redirect()->back()->withErrors(['message' => 'Old Password does not Exists']);
        }
    }

    public function dashboard()
    {
        return view('admin::index');
    }
}
