<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function saveLogin(Request $request)
    {
        $credentials = $request->except('_token');
        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard')->withSuccess("Login Successfully.");
        }

        return back()->with('fail', 'Invalid Credentials');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
