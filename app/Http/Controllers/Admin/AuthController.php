<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // Show Admin Login Form
    public function showLogin()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    // Admin Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $normalizedEmail = Str::lower(trim($request->input('email', '')));
        $throttleKey = 'admin-login:' . $normalizedEmail . '|' . $request->ip();
        $ipKey = 'admin-login-ip:' . $request->ip();

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

        $authenticated = Auth::guard('admin')->attempt(['email' => $normalizedEmail, 'password' => $request->password])
            || Auth::guard('admin')->attempt(['email' => $request->input('email'), 'password' => $request->password]);

        if ($authenticated) {
            RateLimiter::clear($throttleKey);

            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
        }

        RateLimiter::hit($throttleKey, 60);
        RateLimiter::hit($ipKey, 60);

        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->with('error', 'Invalid email or password.')->onlyInput('email');
    }

    // Admin Logout
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}