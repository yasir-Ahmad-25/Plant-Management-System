<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function login(){
        return view('auth.login');
    } 


    public function Authenticate(Request $request){
        // Validate The Request Data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:3',
        ]);
 
        // check if the user exists
        $user = User::where('email', $request->email)->first();
        if (!$user || !password_verify($request->password, $user->password)) {
            return redirect()->back()->with('error' ,'Incorrect email or password. Please try again.');
        }

        // Attempt to log the user in
        Auth::login($user);
        session()->regenerate();
        session()->regenerateToken();
        return redirect()->route('admin.dashboard')->with('message', 'Logged in successfully');
    }
}
