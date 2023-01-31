<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Renderable;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return redirect()->back()->withErrors(['message' => 'Invalid email or password']);
        }

        return redirect()->route('home');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

}
