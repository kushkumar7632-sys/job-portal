@extends('layouts.company')

@section('title', 'Edit Job: ' . $job->job_title)
@section('header', 'Edit Job')
@section('subheader', 'Update job details, requirements, and opening status')

@section('content')
<div class="space-y-6">

    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-xs font-medium text-slate-400">
        <a href="{{ route('company.dashboard') }}" class="hover:text-blue-600 transition">Dashboard</a>
        <span>/</span>
        <a href="{{ route('company.jobs') }}" class="hover:text-blue-600 transition">Manage Jobs</a>
        <span>/</span>
        <span class="text-blue-600 font-semibold">Edit Job</span>
    </nav>

    <!-- Job Summary Hero Card -->
    <section class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-blue-50 border border-blue-100 text-blue-700 flex items-center justify-center font-bold text-xl shrink-0">
                    {{ strtoupper(substr($job->job_title, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-xl font-bold tracking-tight text-slate-900">
                        {{ $job->job_title }}
                    </h2>
                    <p class="text-xs text-slate-400 mt-1">
                        {{ $job->location }} &bull; {{ $job->job_type }} &bull; Posted {{ $job->created_at ? $job->created_at->format('M d, Y') : 'N/A' }}
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                @if($job->status)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        Active Listing
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                        Closed Listing
                    </span>
                @endif

                <a href="{{ route('company.job.applications', $job->id) }}"
                   class="text-xs font-semibold text-blue-600 hover:underline">
                    {{ $job->applications()->count() }} Applicants &rarr;
                </a>
            </div>
        </div>
    </section>

    <!-- Edit Form -->
    <form action="{{ route('job.update', $job->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Section 1: Job Details & Hiring Status -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-xs">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-900">
                        Job Details & Hiring Status
                    </h3>
                    <p class="text-xs text-slate-400 mt-0.5">
                        Update position information, compensation, and active recruitment status
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Job Title -->
                <div class="md:col-span-2">
                    <label for="job_title" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                        Job Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="job_title"
                           name="job_title"
                           required
                           value="{{ old('job_title', $job->job_title) }}"
                           placeholder="e.g. Senior Software Engineer"
                           class="w-full rounded-lg border @error('job_title') border-red-300 ring-2 ring-red-100 @else border-slate-300 @enderror bg-white py-2.5 px-3.5 text-sm text-slate-800 outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100">
                    @error('job_title')
                        <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status (Active / Closed) -->
                <div>
                    <label for="status" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                        Hiring Status <span class="text-red-500">*</span>
                    </label>
                    <select id="status"
                            name="status"
                            required
                            class="w-full rounded-lg border @error('status') border-red-300 ring-2 ring-red-100 @else border-slate-300 @enderror bg-white py-2.5 px-3.5 text-sm text-slate-800 outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100">
                        <option value="1" {{ (string) old('status', $job->status ? '1' : '0') === '1' ? 'selected' : '' }}>
                            Active (Accepting Applications)
                        </option>
                        <option value="0" {{ (string) old('status', $job->status ? '1' : '0') === '0' ? 'selected' : '' }}>
                            Closed (No New Applications)
                        </option>
                    </select>
                    @error('status')
                        <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Job Type -->
                <div>
                    <label for="job_type" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                        Job Type <span class="text-red-500">*</span>
                    </label>
                    <select id="job_type"
                            name="job_type"
                            required
                            class="w-full rounded-lg border @error('job_type') border-red-300 ring-2 ring-red-100 @else border-slate-300 @enderror bg-white py-2.5 px-3.5 text-sm text-slate-800 outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100">
                        <option value="Full Time" {{ old('job_type', $job->job_type) === 'Full Time' ? 'selected' : '' }}>Full Time</option>
                        <option value="Part Time" {{ old('job_type', $job->job_type) === 'Part Time' ? 'selected' : '' }}>Part Time</option>
                        <option value="Internship" {{ old('job_type', $job->job_type) === 'Internship' ? 'selected' : '' }}>Internship</option>
                        <option value="Contract" {{ old('job_type', $job->job_type) === 'Contract' ? 'selected' : '' }}>Contract</option>
                        <option value="Remote" {{ old('job_type', $job->job_type) === 'Remote' ? 'selected' : '' }}>Remote</option>
                    </select>
                    @error('job_type')
                        <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                        Location <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="location"
                           name="location"
                           required
                           value="{{ old('location', $job->location) }}"
                           placeholder="e.g. Remote / New York, NY"
                           class="w-full rounded-lg border @error('location') border-red-300 ring-2 ring-red-100 @else border-slate-300 @enderror bg-white py-2.5 px-3.5 text-sm text-slate-800 outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100">
                    @error('location')
                        <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Salary -->
                <div>
                    <label for="salary" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                        Salary Range <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="salary"
                           name="salary"
                           required
                           value="{{ old('salary', $job->salary) }}"
                           placeholder="e.g. $80,000 - $100,000"
                           class="w-full rounded-lg border @error('salary') border-red-300 ring-2 ring-red-100 @else border-slate-300 @enderror bg-white py-2.5 px-3.5 text-sm text-slate-800 outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100">
                    @error('salary')
                        <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Experience -->
                <div>
                    <label for="experience" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                        Experience Required <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="experience"
                           name="experience"
                           required
                           value="{{ old('experience', $job->experience) }}"
                           placeholder="e.g. 2+ Years"
                           class="w-full rounded-lg border @error('experience') border-red-300 ring-2 ring-red-100 @else border-slate-300 @enderror bg-white py-2.5 px-3.5 text-sm text-slate-800 outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100">
                    @error('experience')
                        <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Vacancy -->
                <div>
                    <label for="vacancy" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                        Vacancies <span class="text-red-500">*</span>
                    </label>
                    <input type="number"
                           id="vacancy"
                           name="vacancy"
                           required
                           min="1"
                           max="9999"
                           value="{{ old('vacancy', $job->vacancy) }}"
                           class="w-full rounded-lg border @error('vacancy') border-red-300 ring-2 ring-red-100 @else border-slate-300 @enderror bg-white py-2.5 px-3.5 text-sm text-slate-800 outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100">
                    @error('vacancy')
                        <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deadline -->
                <div>
                    <label for="deadline" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                        Application Deadline <span class="text-red-500">*</span>
                    </label>
                    <input type="date"
                           id="deadline"
                           name="deadline"
                           required
                           value="{{ old('deadline', $job->deadline) }}"
                           class="w-full rounded-lg border @error('deadline') border-red-300 ring-2 ring-red-100 @else border-slate-300 @enderror bg-white py-2.5 px-3.5 text-sm text-slate-800 outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100">
                    @error('deadline')
                        <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>

        <!-- Section 2: Description -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-xs">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-900">
                        Job Description & Requirements
                    </h3>
                    <p class="text-xs text-slate-400 mt-0.5">
                        Describe responsibilities, expectations, qualifications, and role specifics
                    </p>
                </div>
            </div>

            <div>
                <label for="description" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                    Description <span class="text-red-500">*</span>
                </label>
                <textarea id="description"
                          name="description"
                          required
                          rows="8"
                          placeholder="Provide detailed description of the role, responsibilities, and required qualifications..."
                          class="w-full rounded-lg border @error('description') border-red-300 ring-2 ring-red-100 @else border-slate-300 @enderror bg-white py-2.5 px-3.5 text-sm text-slate-800 outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100">{{ old('description', $job->description) }}</textarea>
                @error('description')
                    <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-2">
            <a href="{{ route('company.jobs') }}"
               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 border border-slate-300 hover:bg-slate-100 text-slate-700 font-semibold text-sm px-6 py-2.5 rounded-lg transition">
                Cancel
            </a>

            <button type="submit"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-8 py-3 rounded-lg shadow-sm transition">
                Save Changes
            </button>
        </div>

    </form>

</div>
@endsection
