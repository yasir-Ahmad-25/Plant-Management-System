<?php

namespace App\Http\Controllers;

use App\Models\CompanyInfo;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    public function settings()
    {
        // Fetch company info
        $companyInfo = CompanyInfo::first();
        if (!$companyInfo) {
            // If no company info exists, create a default one
            $companyInfo = new CompanyInfo();
            $companyInfo->company_name = 'Default Company';
            $companyInfo->company_email = 'company@mail.com';
            $companyInfo->company_phone = '1234567890';
            $companyInfo->company_address = '123 Default St, City, Country';
            $companyInfo->company_logo = null; // or set a default logo path
            $companyInfo->company_slogan = 'Your Slogan Here';
            $companyInfo->save();
        }


        $data = [
            'page_title' => 'Settings',
            'company_info' => $companyInfo,
            'user_email' => Auth::user()->email,
        ];
        return view('settings.index', $data);
    }

    public function update_settings(Request $request)
    {
        $user = Auth::user();

        // Validate inputs
        $request->validate([
            // company
            'company_name'    => 'required|string|max:255',
            'company_email'   => 'nullable|email|max:255',
            'company_phone'   => 'required|string|max:20',
            'company_address' => 'required|string|max:255',
            'company_logo'    => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'company_slogan'  => 'nullable|string|max:255',
            // credentials
            'admin_email'     => 'required|email|max:255|unique:users,email,' . $user->id,
            'current_password'=> 'required_with:new_password,new_password_confirmation|string',
            'new_password'    => 'nullable|string|min:3|confirmed', // expects new_password_confirmation
        ]);

        // Wrap in a transaction
        return DB::transaction(function () use ($request, $user) {
            // 1) Update company info
            $companyInfo = CompanyInfo::first();
            if (!$companyInfo) {
                return response()->json(['status' => false, 'error' => 'Company information not found'], 404);
            }
            $companyInfo->company_name    = $request->company_name;
            $companyInfo->company_email   = $request->company_email;   // optional per your form
            $companyInfo->company_phone   = $request->company_phone;
            $companyInfo->company_address = $request->company_address;
            $companyInfo->company_slogan  = $request->company_slogan;

            if ($request->hasFile('company_logo')) {
                // optionally delete old: if ($companyInfo->company_logo) Storage::disk('public')->delete($companyInfo->company_logo);
                $path = $request->file('company_logo')->store('company_logos', 'public');
                $companyInfo->company_logo = $path; // e.g. storage/app/public/company_logos/...
            }

            $companyInfo->save();

            // 2) Update user credentials (email always; password only if provided)
            $user->email = $request->admin_email;

            if ($request->filled('new_password')) {
                // require current password to be correct
                if (!$request->filled('current_password') || !Hash::check($request->current_password, $user->password)) {
                    // throw to rollback transaction
                    abort(response()->json([
                        'status' => false,
                        'error'  => 'Current password is incorrect.'
                    ], 422));
                }
                $user->password = bcrypt($request->new_password);
            }

            $user->save();

            return response()->json([
                'status'  => true,
                'success' => 'Settings updated successfully',
                'company' => $companyInfo,
                'user'    => ['email' => $user->email],
            ]);
        });
    }
}
