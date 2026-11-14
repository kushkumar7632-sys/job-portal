@extends('layouts.student')

@section('title', 'Student Profile')
@section('header', 'Student Profile')
@section('subheader', 'Manage your personal details and account security')

@section('content')
@php
    $studentName = session('student_name', $student->name ?? 'Student');
    $initial = strtoupper(substr($studentName, 0, 1));
@endphp

<div class="max-w-6xl">

                <!-- PROFILE OVERVIEW HERO CARD -->
                <section class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 mb-8 shadow-sm">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">

                        <div class="flex items-start sm:items-center gap-5">
                            <div class="w-16 h-16 rounded-2xl bg-indigo-50 border border-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-2xl shrink-0">
                                {{ $initial }}
                            </div>

                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-3">
                                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                                        {{ $student->name }}
                                    </h1>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Active Account
                                    </span>
                                </div>

                                <p class="text-sm text-slate-500 mt-1">
                                    {{ $student->email }}
                                </p>

                                <div class="mt-3 flex flex-wrap items-center gap-4 text-xs text-slate-400 font-medium">
                                    <span class="inline-flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                        </svg>
                                        {{ $student->phone }}
                                    </span>

                                    <span class="inline-flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                            <circle cx="12" cy="12" r="10"/>
                                            <path d="M12 6v6l4 2"/>
                                        </svg>
                                        Registered {{ $student->created_at ? $student->created_at->format('F Y') : 'N/A' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="flex sm:flex-col items-center sm:items-end gap-2 shrink-0">
                            <span class="text-xs text-slate-400">Account Type</span>
                            <span class="text-xs font-semibold px-3 py-1 rounded-md bg-slate-100 text-slate-700 border border-slate-200">
                                Student Candidate
                            </span>
                        </div>

                    </div>
                </section>

                <!-- FORMS GRID -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                    <!-- EDIT PERSONAL DETAILS -->
                    <section class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm flex flex-col">

                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-slate-900">
                                    Personal Details
                                </h2>
                                <p class="text-xs text-slate-500">
                                    Update your name, email address, and phone number
                                </p>
                            </div>
                        </div>

                        <form action="{{ route('student.profile.update') }}" method="POST" class="space-y-5 flex-1 flex flex-col justify-between">
                            @csrf
                            @method('PUT')

                            <div class="space-y-5">
                                <!-- FULL NAME -->
                                <div>
                                    <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                                        Full Name
                                    </label>
                                    <input type="text"
                                           id="name"
                                           name="name"
                                           value="{{ old('name', $student->name) }}"
                                           required
                                           class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-800 outline-none transition focus:border-indigo-600 focus:ring-2 focus:ring-indigo-600/10">
                                    @error('name')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- EMAIL -->
                                <div>
                                    <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                                        Email Address
                                    </label>
                                    <input type="email"
                                           id="email"
                                           name="email"
                                           value="{{ old('email', $student->email) }}"
                                           required
                                           class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-800 outline-none transition focus:border-indigo-600 focus:ring-2 focus:ring-indigo-600/10">
                                    @error('email')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- PHONE -->
                                <div>
                                    <label for="phone" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                                        Phone Number (10 digits)
                                    </label>
                                    <input type="tel"
                                           id="phone"
                                           name="phone"
                                           value="{{ old('phone', $student->phone) }}"
                                           placeholder="e.g. 9876543210"
                                           maxlength="10"
                                           required
                                           class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-800 outline-none transition focus:border-indigo-600 focus:ring-2 focus:ring-indigo-600/10">
                                    @error('phone')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="pt-6 border-t border-slate-100">
                                <button type="submit"
                                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm px-6 py-2.5 rounded-lg shadow-sm transition">
                                    Save Changes
                                </button>
                            </div>

                        </form>

                    </section>

                    <!-- CHANGE PASSWORD -->
                    <section class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm flex flex-col">

                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-slate-900">
                                    Change Password
                                </h2>
                                <p class="text-xs text-slate-500">
                                    Update your password to keep your account secure
                                </p>
                            </div>
                        </div>

                        <form action="{{ route('student.password.update') }}" method="POST" class="space-y-5 flex-1 flex flex-col justify-between">
                            @csrf
                            @method('PUT')

                            <div class="space-y-5">
                                <!-- CURRENT PASSWORD -->
                                <div>
                                    <label for="current_password" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                                        Current Password
                                    </label>
                                    <input type="password"
                                           id="current_password"
                                           name="current_password"
                                           required
                                           class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-800 outline-none transition focus:border-indigo-600 focus:ring-2 focus:ring-indigo-600/10">
                                    @error('current_password')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- NEW PASSWORD -->
                                <div>
                                    <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                                        New Password
                                    </label>
                                    <input type="password"
                                           id="password"
                                           name="password"
                                           required
                                           placeholder="Minimum 6 characters"
                                           class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-800 outline-none transition focus:border-indigo-600 focus:ring-2 focus:ring-indigo-600/10">
                                    @error('password')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- CONFIRM NEW PASSWORD -->
                                <div>
                                    <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                                        Confirm New Password
                                    </label>
                                    <input type="password"
                                           id="password_confirmation"
                                           name="password_confirmation"
                                           required
                                           placeholder="Re-type new password"
                                           class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-800 outline-none transition focus:border-indigo-600 focus:ring-2 focus:ring-indigo-600/10">
                                </div>
                            </div>

                            <div class="pt-6 border-t border-slate-100">
                                <button type="submit"
                                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-sm px-6 py-2.5 rounded-lg shadow-sm transition">
                                    Update Password
                                </button>
                            </div>

                        </form>

                    </section>

                </div>

            </div>
@endsection
