<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;
use App\Models\Job;

class CompanyAuthController extends Controller
{
    // show registration form
    public function showRegister()
    {
        return view('company.register');
    }

    // register company
    public function register(Request $request)
    {
        $request->validate([
            'company_name' => 'required|max:255',
            'owner_name' => 'required|max:255',
            'email' => 'required|email|unique:companies,email',
            'phone' => 'required|unique:companies,phone',
            'website' => 'nullable|url',
            'industry' => 'required|max:255',
            'address' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        Company::create([
            'company_name' => $request->company_name,
            'owner_name' => $request->owner_name,
            'email'        => $request->email,
            'phone'        => $request->phone,
            'website'      => $request->website,
            'industry'     => $request->industry,
            'address'      => $request->address,
            'password'     => Hash::make($request->password),
            'is_approved'  => false,
        ]);
        return redirect('/company/register')->with('success','Company registered successfully. Please wait for admin approval.');
    }

    public function showLogin()
    {
        return view('company.login');
    }

    public function login(Request $request)
    {
        $company = Company::where('email', $request->email)->first();

        if (!$company) {
            return back()->with('error', 'Email nor found.');
        }

        if (!Hash::check($request->password, $company->password)){
            return back()->with('error', 'invalid password');
        }

        if (!$company->is_approved){
            return back()->with('error', 'Your account is waiting for admin approval.');
        }

        session([
            'company_id' => $company->id,
            'company_name' => $company->company_name,
        ]);
        return redirect('/company/dashboard');
    }

    public function dashboard()
    {
        $companyId = session('company_id');

        $totalJobs = Job::where('company_id', $companyId)->count();

        return view('company.dashboard', compact('totalJobs'));
    }

    public function profile()
{
    $companyId = session('company_id');

    $company = Company::findOrFail($companyId);

    return view('company.profile', compact('company'));
}

    public function logout()
    {
        session()->forget([
            'company_id',
            'company_name',
        ]);
        return redirect('/company/login')->with('success', 'Logged out successfully.');
    }
}
