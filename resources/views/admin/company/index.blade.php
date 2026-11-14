@extends('layouts.admin')

@section('title', 'Company Management')
@section('header', 'Company Management')

@section('content')
<div class="space-y-6">

    @php
        $totalCompanies = \App\Models\Company::count();
        $approvedCompanies = \App\Models\Company::where('is_approved', 1)->count();
        $pendingCompanies = \App\Models\Company::where('is_approved', 0)->count();
    @endphp

    <!-- Statistics Overview Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <!-- Total Companies -->
        <a href="{{ route('admin.companies') }}"
           class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs hover:border-indigo-300 transition-colors flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total Companies</p>
                <p class="text-2xl font-extrabold text-slate-900 mt-1">{{ number_format($totalCompanies) }}</p>
                <p class="text-xs text-slate-400 mt-0.5">Registered employer accounts</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <rect x="4" y="2" width="16" height="20" rx="2" stroke-width="2"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 22v-4h6v4M8 6h.01M16 6h.01M8 10h.01M16 10h.01M8 14h.01M16 14h.01"/>
                </svg>
            </div>
        </a>

        <!-- Approved Companies -->
        <a href="{{ route('admin.companies', ['status' => 'approved']) }}"
           class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs hover:border-emerald-300 transition-colors flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Approved Companies</p>
                <p class="text-2xl font-extrabold text-emerald-600 mt-1">{{ number_format($approvedCompanies) }}</p>
                <p class="text-xs text-slate-400 mt-0.5">Active & verified employers</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </a>

        <!-- Pending Verification -->
        <a href="{{ route('admin.companies', ['status' => 'pending']) }}"
           class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs hover:border-amber-300 transition-colors flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Pending Approval</p>
                <p class="text-2xl font-extrabold text-amber-600 mt-1">{{ number_format($pendingCompanies) }}</p>
                <p class="text-xs text-slate-400 mt-0.5">Awaiting administrative review</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
        </a>
    </div>

    <!-- Search & Filters Container -->
    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs">
        <form method="GET" action="{{ route('admin.companies') }}" class="space-y-4">
            <div class="flex flex-col md:flex-row gap-3">
                <!-- Search Input -->
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Search by company name, owner, email, or industry..."
                           class="w-full pl-10 pr-4 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-slate-50/50">
                </div>

                <!-- Approval Status Filter -->
                <div class="w-full md:w-48">
                    <select name="status"
                            class="w-full px-3 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-slate-50/50 text-slate-700">
                        <option value="">All Statuses</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved Only</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending Only</option>
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-2">
                    <button type="submit"
                            class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold bg-indigo-600 hover:bg-indigo-700 text-white shadow-xs transition-colors shrink-0">
                        Apply Filter
                    </button>

                    @if(request()->filled('search') || request()->filled('status'))
                        <a href="{{ route('admin.companies') }}"
                           class="px-3 py-2 rounded-xl text-xs sm:text-sm font-semibold text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 transition-colors shrink-0">
                            Clear
                        </a>
                    @endif
                </div>
            </div>

            <!-- Quick Status Filter Pills -->
            <div class="flex items-center gap-2 pt-2 border-t border-slate-100 text-xs">
                <span class="text-slate-400 font-medium">Quick Filter:</span>
                <a href="{{ route('admin.companies', array_merge(request()->except('status', 'page'), ['status' => ''])) }}"
                   class="px-2.5 py-1 rounded-lg font-medium transition-colors {{ empty(request('status')) ? 'bg-slate-900 text-white font-semibold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    All ({{ $totalCompanies }})
                </a>
                <a href="{{ route('admin.companies', array_merge(request()->except('status', 'page'), ['status' => 'pending'])) }}"
                   class="px-2.5 py-1 rounded-lg font-medium transition-colors {{ request('status') === 'pending' ? 'bg-amber-600 text-white font-semibold' : 'bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200' }}">
                    Pending ({{ $pendingCompanies }})
                </a>
                <a href="{{ route('admin.companies', array_merge(request()->except('status', 'page'), ['status' => 'approved'])) }}"
                   class="px-2.5 py-1 rounded-lg font-medium transition-colors {{ request('status') === 'approved' ? 'bg-emerald-600 text-white font-semibold' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200' }}">
                    Approved ({{ $approvedCompanies }})
                </a>
            </div>
        </form>
    </div>

    <!-- Companies Table Container -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm sm:text-base font-bold text-slate-900">
                    Registered Companies
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">
                    Showing {{ $companies->firstItem() ?? 0 }} to {{ $companies->lastItem() ?? 0 }} of {{ $companies->total() }} companies
                </p>
            </div>
        </div>

        @if($companies->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-slate-50/75 border-b border-slate-100 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">
                            <th class="px-5 py-3.5">Company</th>
                            <th class="px-5 py-3.5">Owner</th>
                            <th class="px-5 py-3.5">Email</th>
                            <th class="px-5 py-3.5">Industry</th>
                            <th class="px-5 py-3.5">Jobs Posted</th>
                            <th class="px-5 py-3.5">Status</th>
                            <th class="px-5 py-3.5">Registered</th>
                            <th class="px-5 py-3.5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($companies as $company)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <!-- Company Name + Avatar -->
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xs shrink-0 border border-indigo-100">
                                            {{ strtoupper(substr($company->company_name, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <a href="{{ route('admin.companies.show', $company->id) }}"
                                               class="font-bold text-slate-900 hover:text-indigo-600 truncate block">
                                                {{ $company->company_name }}
                                            </a>
                                            <span class="text-[11px] text-slate-400 block truncate">
                                                ID: #{{ $company->id }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Owner Name -->
                                <td class="px-5 py-4 text-slate-700 font-medium whitespace-nowrap">
                                    {{ $company->owner_name }}
                                </td>

                                <!-- Email -->
                                <td class="px-5 py-4 text-slate-600 whitespace-nowrap">
                                    {{ $company->email }}
                                </td>

                                <!-- Industry -->
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700">
                                        {{ $company->industry }}
                                    </span>
                                </td>

                                <!-- Jobs Count -->
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1 font-semibold text-slate-700">
                                        {{ $company->jobs_count ?? 0 }} Jobs
                                    </span>
                                </td>

                                <!-- Status Badge -->
                                <td class="px-5 py-4 whitespace-nowrap">
                                    @if($company->is_approved)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Approved
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            Pending
                                        </span>
                                    @endif
                                </td>

                                <!-- Registered Date -->
                                <td class="px-5 py-4 text-xs text-slate-500 whitespace-nowrap">
                                    {{ $company->created_at ? $company->created_at->format('M d, Y') : 'N/A' }}
                                </td>

                                <!-- Actions -->
                                <td class="px-5 py-4 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5">
                                        <!-- View Details -->
                                        <a href="{{ route('admin.companies.show', $company->id) }}"
                                           class="px-2.5 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">
                                            View
                                        </a>

                                        @if(!$company->is_approved)
                                            <!-- Approve Form -->
                                            <form action="{{ route('admin.companies.approve', $company->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Are you sure you want to approve {{ addslashes($company->company_name) }}?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="px-2.5 py-1.5 rounded-lg text-xs font-semibold bg-emerald-600 hover:bg-emerald-700 text-white shadow-xs transition-colors">
                                                    Approve
                                                </button>
                                            </form>
                                        @else
                                            <!-- Reject Form -->
                                            <form action="{{ route('admin.companies.reject', $company->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Are you sure you want to reject {{ addslashes($company->company_name) }}? Their employer session will be revoked and job postings hidden.');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="px-2.5 py-1.5 rounded-lg text-xs font-semibold bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 transition-colors">
                                                    Reject
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination Bar -->
            @if($companies->hasPages())
                <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $companies->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="py-16 px-6 text-center">
                <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 mx-auto flex items-center justify-center mb-3">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <rect x="4" y="2" width="16" height="20" rx="2" stroke-width="2"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 22v-4h6v4M8 6h.01M16 6h.01M8 10h.01M16 10h.01M8 14h.01M16 14h.01"/>
                    </svg>
                </div>
                @if(request()->filled('search') || request()->filled('status'))
                    <h4 class="text-sm font-bold text-slate-900">No matching companies found</h4>
                    <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                        No companies matched your current search filters. Try adjusting your query or resetting filters.
                    </p>
                    <div class="mt-4">
                        <a href="{{ route('admin.companies') }}"
                           class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-indigo-600 text-white hover:bg-indigo-700 transition-colors shadow-xs">
                            Clear All Filters
                        </a>
                    </div>
                @else
                    <h4 class="text-sm font-bold text-slate-900">No companies registered yet</h4>
                    <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                        When employers register on JobPortal, their accounts and verification details will appear here.
                    </p>
                @endif
            </div>
        @endif
    </div>

</div>
@endsection
