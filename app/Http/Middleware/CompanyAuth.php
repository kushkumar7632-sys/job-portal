<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Company;

class CompanyAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('company_id')) {
            return redirect('/company/login')->with('error', 'Please login first.');
        }

        $company = Company::find(session('company_id'));

        if (!$company) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/company/login')->with('error', 'Company account not found. Please login again.');
        }

        if (!$company->is_approved) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/company/login')->with('error', 'Your account is waiting for admin approval.');
        }

        return $next($request);
    }
}
