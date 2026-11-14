@extends('layouts.company')

@section('title', 'Company Profile')
@section('header', 'Company Profile')
@section('subheader', 'Manage your organization identity, contact details, and account security')

@section('content')
<div class="space-y-8">

    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-xs font-medium text-slate-400">
        <a href="{{ route('company.dashboard') }}" class="hover:text-blue-600 transition">Dashboard</a>
        <span>/</span>
        <span class="text-blue-600 font-semibold">Company Profile</span>
    </nav>

    <!-- Company Overview Hero Card -->
    <section class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">

            <div class="flex items-start sm:items-center gap-5">
                <div class="w-16 h-16 rounded-2xl bg-blue-50 border border-blue-100 text-blue-700 flex items-center justify-center font-bold text-2xl shrink-0 shadow-inner">
                    {{ strtoupper(substr($company->company_name ?? 'C', 0, 1)) }}
                </div>

                <div class="min-w-0">
                    <div class="flex flex-wrap items-center gap-3">
                        <h2 class="text-2xl font-bold tracking-tight text-slate-900">
                            {{ $company->company_name }}
                        </h2>

                        @if($company->is_approved)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Verified Account
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                Pending Approval
                            </span>
                        @endif
                    </div>

                    <p class="text-sm text-slate-500 mt-1">
                        {{ $company->industry }} &bull; Managed by <span class="font-medium text-slate-700">{{ $company->owner_name }}</span>
                    </p>

                    <div class="mt-3 flex flex-wrap items-center gap-4 text-xs text-slate-400 font-medium">
                        <span class="inline-flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l9 6 9-6M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            {{ $company->email }}
                        </span>

                        <span class="inline-flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.95.68l1.5 4.49a1 1 0 01-.5 1.21l-2.1 1.05a11 11 0 005.42 5.42l1.05-2.1a1 1 0 011.21-.5l4.49 1.5a1 1 0 01.68.95V19a2 2 0 01-2 2h-1C9.16 21 3 14.84 3 7V5z"/>
                            </svg>
                            {{ $company->phone }}
                        </span>

                        @if($company->website)
                            <span class="inline-flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="9" stroke-width="1.8"/>
                                    <path stroke-linecap="round" stroke-width="1.8" d="M3 12h18m-9-9a14 14 0 010 18"/>
                                </svg>
                                <a href="{{ $company->website }}" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline">
                                    {{ $company->website }}
                                </a>
                            </span>
                        @endif

                        <span class="inline-flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" stroke-width="1.8"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6v6l4 2"/>
                            </svg>
                            Joined {{ $company->created_at ? $company->created_at->format('M Y') : 'N/A' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="flex sm:flex-col items-start sm:items-end gap-1.5 shrink-0">
                <span class="text-xs text-slate-400 font-medium">Account Status</span>
                <span class="text-xs font-semibold px-3 py-1 rounded-md bg-slate-100 text-slate-700 border border-slate-200">
                    Verified Employer
                </span>
            </div>

        </div>
    </section>

    <!-- Forms Grid: Organization Details & Account Security -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <!-- Organization Details Form -->
        <section class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">
                            Organization Details
                        </h3>
                        <p class="text-xs text-slate-400 mt-0.5">
                            Update your organization profile and public contact information
                        </p>
                    </div>
                </div>

                <form action="{{ route('company.profile.update') }}" method="POST" id="profileForm" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <!-- Company Name -->
                    <div>
                        <label for="company_name" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                            Company Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="company_name"
                               name="company_name"
                               required
                               value="{{ old('company_name', $company->company_name) }}"
                               placeholder="e.g. Acme Corporation"
                               class="w-full rounded-lg border @error('company_name') border-red-300 ring-2 ring-red-100 @else border-slate-300 @enderror bg-white py-2.5 px-3.5 text-sm text-slate-800 outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100">
                        @error('company_name')
                            <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Owner Name -->
                    <div>
                        <label for="owner_name" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                            Owner / Contact Person <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="owner_name"
                               name="owner_name"
                               required
                               value="{{ old('owner_name', $company->owner_name) }}"
                               placeholder="e.g. Jane Doe"
                               class="w-full rounded-lg border @error('owner_name') border-red-300 ring-2 ring-red-100 @else border-slate-300 @enderror bg-white py-2.5 px-3.5 text-sm text-slate-800 outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100">
                        @error('owner_name')
                            <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email & Phone Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <input type="email"
                                   id="email"
                                   name="email"
                                   required
                                   value="{{ old('email', $company->email) }}"
                                   placeholder="contact@company.com"
                                   class="w-full rounded-lg border @error('email') border-red-300 ring-2 ring-red-100 @else border-slate-300 @enderror bg-white py-2.5 px-3.5 text-sm text-slate-800 outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100">
                            @error('email')
                                <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                                Phone Number <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   id="phone"
                                   name="phone"
                                   required
                                   maxlength="10"
                                   value="{{ old('phone', $company->phone) }}"
                                   placeholder="10 digit number"
                                   class="w-full rounded-lg border @error('phone') border-red-300 ring-2 ring-red-100 @else border-slate-300 @enderror bg-white py-2.5 px-3.5 text-sm text-slate-800 outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100">
                            @error('phone')
                                <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Industry & Website Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="industry" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                                Industry Sector <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   id="industry"
                                   name="industry"
                                   required
                                   value="{{ old('industry', $company->industry) }}"
                                   placeholder="e.g. Information Technology"
                                   class="w-full rounded-lg border @error('industry') border-red-300 ring-2 ring-red-100 @else border-slate-300 @enderror bg-white py-2.5 px-3.5 text-sm text-slate-800 outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100">
                            @error('industry')
                                <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="website" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                                Website (Optional)
                            </label>
                            <input type="url"
                                   id="website"
                                   name="website"
                                   value="{{ old('website', $company->website) }}"
                                   placeholder="https://example.com"
                                   class="w-full rounded-lg border @error('website') border-red-300 ring-2 ring-red-100 @else border-slate-300 @enderror bg-white py-2.5 px-3.5 text-sm text-slate-800 outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100">
                            @error('website')
                                <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Address -->
                    <div>
                        <label for="address" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                            Office Address <span class="text-red-500">*</span>
                        </label>
                        <textarea id="address"
                                  name="address"
                                  required
                                  rows="3"
                                  placeholder="Enter complete office address..."
                                  class="w-full rounded-lg border @error('address') border-red-300 ring-2 ring-red-100 @else border-slate-300 @enderror bg-white py-2.5 px-3.5 text-sm text-slate-800 outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100">{{ old('address', $company->address) }}</textarea>
                        @error('address')
                            <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-3">
                        <button type="submit"
                                class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-6 py-2.5 rounded-lg shadow-sm transition w-full sm:w-auto">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </section>

        <!-- Account Security / Change Password Form -->
        <section class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center font-bold shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2" stroke-width="2"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11V7a5 5 0 0110 0v4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">
                            Account Security
                        </h3>
                        <p class="text-xs text-slate-400 mt-0.5">
                            Update your password to keep your company workspace protected
                        </p>
                    </div>
                </div>

                <form action="{{ route('company.password.update') }}" method="POST" id="passwordForm" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <!-- Current Password -->
                    <div>
                        <label for="current_password" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                            Current Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password"
                               id="current_password"
                               name="current_password"
                               required
                               placeholder="Enter your current password"
                               class="w-full rounded-lg border @error('current_password') border-red-300 ring-2 ring-red-100 @else border-slate-300 @enderror bg-white py-2.5 px-3.5 text-sm text-slate-800 outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100">
                        @error('current_password')
                            <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div>
                        <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                            New Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password"
                               id="password"
                               name="password"
                               required
                               placeholder="Minimum 8 characters"
                               class="w-full rounded-lg border @error('password') border-red-300 ring-2 ring-red-100 @else border-slate-300 @enderror bg-white py-2.5 px-3.5 text-sm text-slate-800 outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100">
                        @error('password')
                            <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                            Confirm New Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password"
                               id="password_confirmation"
                               name="password_confirmation"
                               required
                               placeholder="Re-enter your new password"
                               class="w-full rounded-lg border border-slate-300 bg-white py-2.5 px-3.5 text-sm text-slate-800 outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100">
                    </div>

                    <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl text-xs text-slate-500 space-y-1">
                        <p class="font-semibold text-slate-700">Password requirements:</p>
                        <ul class="list-disc pl-4 space-y-0.5 text-slate-400">
                            <li>Must be at least 8 characters long</li>
                            <li>Must differ from your current password</li>
                            <li>Both password fields must match exactly</li>
                        </ul>
                    </div>

                    <div class="pt-3">
                        <button type="submit"
                                class="inline-flex items-center justify-center gap-2 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-sm px-6 py-2.5 rounded-lg shadow-sm transition w-full sm:w-auto">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </section>

    </div>

</div>
@endsection
