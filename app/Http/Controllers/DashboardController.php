<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {

        $user = Auth::user(); // returns the logged-in user model

        // Example: access name or email
        $name = Auth::user()->name;
        $email = $user->email;

        $data = [
            'page_title' => 'Dashboard',
            'user_name' => $name,
            'user_email' => $email,
        ];
        return view('dashboard',$data);
    }

    public function logout()
    {
        Auth::logout();
        session()->regenerate();
        session()->regenerateToken();
        session()->invalidate();
        return redirect()->route('auth.login');
    }
}
