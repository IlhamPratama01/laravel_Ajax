<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;


class GoogleController extends Controller
{
    public function redirectTogoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->getId())->first(); 
            if ($finduser) {
                Auth::login($finduser);
                return redirect('/dasboard');
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'username' => $user->email,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'role_id' => 1,
                    'password' => bcrypt('12345678'),
                ]);
                Auth::login(($newUser));
                return redirect('/dasboard');

            }
        } catch (\Throwable $th) {
            
        }
    }

    public function index(){
        return view('template/Dashboard',['title' => 'DashBoard']);
    }
}
