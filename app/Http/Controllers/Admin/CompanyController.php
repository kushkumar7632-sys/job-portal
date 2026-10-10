<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
 // Show all companies
    public function index()
    {
        $companies = Company::latest()->get();

        return view('admin.company.index', compact('companies'));
    }

    // Approve company
    public function approve($id)
    {
        $company = Company::findOrFail($id);

        $company->update([
            'is_approved' => true,
        ]);

        return back()->with('success', 'Company approved successfully.');
    }

    // Reject company
    public function reject($id)
    {
        $company = Company::findOrFail($id);

        $company->update([
            'is_approved' => false,
        ]);

        return back()->with('success', 'Company rejected successfully.');
    }  
}
