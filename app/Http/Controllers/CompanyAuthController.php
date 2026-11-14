<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Job;
use App\Models\Application;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $normalizedEmail = Str::lower(trim($request->input('email', '')));
        $throttleKey = 'company-login:' . $normalizedEmail . '|' . $request->ip();
        $ipKey = 'company-login-ip:' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()
                ->withErrors(['email' => "Too many login attempts. Please try again in {$seconds} seconds."])
                ->with('error', "Too many login attempts. Please try again in {$seconds} seconds.")
                ->onlyInput('email');
        }

        if (RateLimiter::tooManyAttempts($ipKey, 20)) {
            $seconds = RateLimiter::availableIn($ipKey);
            return back()
                ->withErrors(['email' => "Too many login attempts from this IP address. Please try again in {$seconds} seconds."])
                ->with('error', "Too many login attempts from this IP address. Please try again in {$seconds} seconds.")
                ->onlyInput('email');
        }

        $company = Company::where('email', $normalizedEmail)
                          ->orWhere('email', $request->input('email'))
                          ->first();

        if (!$company || !Hash::check($request->password, $company->password)) {
            RateLimiter::hit($throttleKey, 60);
            RateLimiter::hit($ipKey, 60);

            return back()
                ->withErrors(['email' => 'Invalid email or password.'])
                ->with('error', 'Invalid email or password.')
                ->onlyInput('email');
        }

        if (!$company->is_approved) {
            return back()
                ->with('error', 'Your account is waiting for admin approval.')
                ->onlyInput('email');
        }

        RateLimiter::clear($throttleKey);

        session([
            'company_id' => $company->id,
            'company_name' => $company->company_name,
        ]);

        $request->session()->regenerate();

        return redirect('/company/dashboard');
    }

    public function dashboard()
    {
        $companyId = session('company_id');

        $totalJobs = Job::where('company_id', $companyId)->count();

        // Application metrics scoped to this company
        $totalApplications = Application::whereHas('job', function ($q) use ($companyId) {
            $q->where('company_id', $companyId);
        })->count();

        $pendingApplications = Application::whereHas('job', function ($q) use ($companyId) {
            $q->where('company_id', $companyId);
        })->where('status', 'Pending')->count();

        $shortlistedApplications = Application::whereHas('job', function ($q) use ($companyId) {
            $q->where('company_id', $companyId);
        })->where('status', 'Shortlisted')->count();

        $selectedApplications = Application::whereHas('job', function ($q) use ($companyId) {
            $q->where('company_id', $companyId);
        })->where('status', 'Selected')->count();

        $rejectedApplications = Application::whereHas('job', function ($q) use ($companyId) {
            $q->where('company_id', $companyId);
        })->where('status', 'Rejected')->count();

        // Latest 5 applications
        $recentApplications = Application::whereHas('job', function ($q) use ($companyId) {
            $q->where('company_id', $companyId);
        })->with(['student', 'job'])->latest()->take(5)->get();

        return view('company.dashboard', compact(
            'totalJobs',
            'totalApplications',
            'pendingApplications',
            'shortlistedApplications',
            'selectedApplications',
            'rejectedApplications',
            'recentApplications'
        ));
    }

    public function profile()
    {
        $companyId = session('company_id');

        $company = Company::findOrFail($companyId);

        return view('company.profile', compact('company'));
    }

    public function updateProfile(Request $request)
    {
        $company = Company::findOrFail(session('company_id'));

        $request->validate([
            'company_name' => 'required|string|min:2|max:255',
            'owner_name'   => 'required|string|min:2|max:255',
            'email'        => [
                'required',
                'email',
                'max:255',
                Rule::unique('companies', 'email')->ignore($company->id),
            ],
            'phone'        => [
                'required',
                'digits:10',
                Rule::unique('companies', 'phone')->ignore($company->id),
            ],
            'website'      => 'nullable|url|max:255',
            'industry'     => 'required|string|max:255',
            'address'      => 'required|string|max:500',
        ]);

        $normalizedEmail = Str::lower(trim($request->input('email')));
        $website = $request->filled('website') ? trim($request->input('website')) : null;

        $company->update([
            'company_name' => trim($request->input('company_name')),
            'owner_name'   => trim($request->input('owner_name')),
            'email'        => $normalizedEmail,
            'phone'        => trim($request->input('phone')),
            'website'      => $website,
            'industry'     => trim($request->input('industry')),
            'address'      => trim($request->input('address')),
        ]);

        session(['company_name' => $company->company_name]);

        return redirect()->route('company.profile')->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $company = Company::findOrFail(session('company_id'));

        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|string|min:8|confirmed|different:current_password',
        ], [
            'password.different' => 'The new password must be different from your current password.',
        ]);

        if (!Hash::check($request->input('current_password'), $company->password)) {
            return back()->withErrors(['current_password' => 'The provided current password does not match our records.']);
        }

        $company->update([
            'password' => Hash::make($request->input('password')),
        ]);

        $request->session()->regenerate();

        return redirect()->route('company.profile')->with('success', 'Password updated successfully.');
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/company/login')->with('success', 'Logged out successfully.');
    }
}
