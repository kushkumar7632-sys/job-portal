@extends('layouts.company')

@section('title', 'Post New Job')
@section('header', 'Post a New Job')
@section('subheader', 'Create a job opening and find the right candidate for your company')

@section('content')
<div class="space-y-6">

    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-xs font-medium text-slate-400">
        <a href="{{ route('company.dashboard') }}" class="hover:text-blue-600 transition">Dashboard</a>
        <span>/</span>
        <a href="{{ route('company.jobs') }}" class="hover:text-blue-600 transition">Manage Jobs</a>
        <span>/</span>
        <span class="text-blue-600 font-semibold">Post New Job</span>
    </nav>

    <!-- Full Form Container -->
    <div class="bg-white border border-slate-200 rounded-2xl shadow-xs overflow-hidden">

        <form action="{{ route('company.job.store') }}" method="POST">
            @csrf

            <!-- Form Intro Header -->
            <div class="px-6 sm:px-8 py-5 border-b border-slate-100 bg-slate-50/50">
                <h2 class="text-lg font-bold text-slate-900">
                    Job Opening Details
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">
                    Provide complete and accurate role information to attract the most suitable candidates.
                </p>
            </div>

            <!-- Section 1: Core Job Details -->
            <div class="px-6 sm:px-8 py-6 border-b border-slate-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs shrink-0">
                        01
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide">
                            Basic Position Details
                        </h3>
                        <p class="text-xs text-slate-400">Title, employment type, location, and compensation</p>
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
                               value="{{ old('job_title') }}"
                               placeholder="e.g. Junior Web Developer, Data Analyst"
                               class="w-full rounded-lg border @error('job_title') border-red-300 ring-2 ring-red-100 @else border-slate-300 @enderror bg-white py-2.5 px-3.5 text-sm text-slate-800 outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100">
                        @error('job_title')
                            <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Job Type -->
                    <div>
                        <label for="job_type" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                            Employment Type <span class="text-red-500">*</span>
                        </label>
                        <select id="job_type"
                                name="job_type"
                                required
                                class="w-full rounded-lg border @error('job_type') border-red-300 ring-2 ring-red-100 @else border-slate-300 @enderror bg-white py-2.5 px-3.5 text-sm text-slate-800 outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100">
                            <option value="Full Time" {{ old('job_type') === 'Full Time' ? 'selected' : '' }}>Full Time</option>
                            <option value="Part Time" {{ old('job_type') === 'Part Time' ? 'selected' : '' }}>Part Time</option>
                            <option value="Internship" {{ old('job_type') === 'Internship' ? 'selected' : '' }}>Internship</option>
                            <option value="Contract" {{ old('job_type') === 'Contract' ? 'selected' : '' }}>Contract</option>
                            <option value="Remote" {{ old('job_type') === 'Remote' ? 'selected' : '' }}>Remote</option>
                        </select>
                        @error('job_type')
                            <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div>
                        <label for="location" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                            Job Location <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="location"
                               name="location"
                               required
                               value="{{ old('location') }}"
                               placeholder="e.g. Remote / Bangalore / New Delhi"
                               class="w-full rounded-lg border @error('location') border-red-300 ring-2 ring-red-100 @else border-slate-300 @enderror bg-white py-2.5 px-3.5 text-sm text-slate-800 outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100">
                        @error('location')
                            <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Salary -->
                    <div>
                        <label for="salary" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                            Salary / Compensation <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="salary"
                               name="salary"
                               required
                               value="{{ old('salary') }}"
                               placeholder="e.g. ₹5 - ₹7 LPA, Negotiable"
                               class="w-full rounded-lg border @error('salary') border-red-300 ring-2 ring-red-100 @else border-slate-300 @enderror bg-white py-2.5 px-3.5 text-sm text-slate-800 outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100">
                        @error('salary')
                            <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Experience -->
                    <div>
                        <label for="experience" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                            Required Experience <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="experience"
                               name="experience"
                               required
                               value="{{ old('experience') }}"
                               placeholder="e.g. Fresher / 0-2 Years"
                               class="w-full rounded-lg border @error('experience') border-red-300 ring-2 ring-red-100 @else border-slate-300 @enderror bg-white py-2.5 px-3.5 text-sm text-slate-800 outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100">
                        @error('experience')
                            <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Vacancy -->
                    <div>
                        <label for="vacancy" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                            Number of Vacancies <span class="text-red-500">*</span>
                        </label>
                        <input type="number"
                               id="vacancy"
                               name="vacancy"
                               required
                               min="1"
                               value="{{ old('vacancy') }}"
                               placeholder="e.g. 5"
                               class="w-full rounded-lg border @error('vacancy') border-red-300 ring-2 ring-red-100 @else border-slate-300 @enderror bg-white py-2.5 px-3.5 text-sm text-slate-800 outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100">
                        @error('vacancy')
                            <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>

            <!-- Section 2: Description -->
            <div class="px-6 sm:px-8 py-6 border-b border-slate-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xs shrink-0">
                        02
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide">
                            Job Description & Requirements
                        </h3>
                        <p class="text-xs text-slate-400">Detailed responsibilities, expectations, and desired skills</p>
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                        Description & Candidate Requirements <span class="text-red-500">*</span>
                    </label>
                    <textarea id="description"
                              name="description"
                              required
                              rows="8"
                              placeholder="Describe candidate responsibilities, day-to-day tasks, qualifications, required skills, and growth opportunities..."
                              class="w-full rounded-lg border @error('description') border-red-300 ring-2 ring-red-100 @else border-slate-300 @enderror bg-white py-3 px-3.5 text-sm leading-relaxed text-slate-800 outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Section 3: Deadline -->
            <div class="px-6 sm:px-8 py-6 border-b border-slate-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-xs shrink-0">
                        03
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide">
                            Application Deadline
                        </h3>
                        <p class="text-xs text-slate-400">Final date after which applications will automatically close</p>
                    </div>
                </div>

                <div class="w-full sm:w-80">
                    <label for="deadline" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                        Application Last Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date"
                           id="deadline"
                           name="deadline"
                           required
                           value="{{ old('deadline') }}"
                           class="w-full rounded-lg border @error('deadline') border-red-300 ring-2 ring-red-100 @else border-slate-300 @enderror bg-white py-2.5 px-3.5 text-sm text-slate-800 outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100">
                    @error('deadline')
                        <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Action Footer -->
            <div class="px-6 sm:px-8 py-5 bg-slate-50/50 flex flex-col sm:flex-row items-center justify-between gap-4">
                <a href="{{ route('company.jobs') }}"
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2 border border-slate-300 hover:bg-slate-100 text-slate-700 font-semibold text-sm px-6 py-2.5 rounded-lg transition">
                    Cancel
                </a>

                <button type="submit"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-8 py-3 rounded-lg shadow-sm transition">
                    <span>Publish Job Opening</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </div>

        </form>

    </div>

</div>
@endsection
