<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller
{

    public function index()
    {
        return view('Auth/login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // if(Auth::user()->role->pangkat == 'Manager'){
        //     $request->session()->regenerate();
        //     return redirect('/blog')->with('sucess', 'Registration  successfull! Please login');
        // }


        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $cekrole = Auth::user()->role->pangkat;

            if ($cekrole == 'Admin') {
                return redirect('/admin')->with('sucess', 'Registration  successfull! Please login');

            } else {
                return redirect('/dasboard')->with('sucess', 'Registration  successfull! Please login');
            }

        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
