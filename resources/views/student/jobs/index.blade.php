@extends('layouts.student')

@section('title', 'Find Jobs')
@section('header', 'Find Jobs')
@section('subheader', 'Discover opportunities for your career')

@section('content')

            <!-- PAGE HEADING -->
            <section class="mb-8 flex flex-col justify-between gap-5 md:flex-row md:items-end">

                <div>

                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-[#5140ef]">
                        CAREER OPPORTUNITIES
                    </p>

                    <h1 class="mt-2 text-2xl font-bold tracking-tight text-[#172b40] sm:text-3xl">
                        Find your next opportunity
                    </h1>

                    <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">
                        Explore available positions and discover opportunities that match your skills and career goals.
                    </p>

                </div>


                <!-- JOB COUNT -->
                <div class="inline-flex items-center gap-3 self-start border border-slate-200 bg-white px-4 py-3">

                    <span class="h-2 w-2 rounded-full {{ $jobs->total() > 0 ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>

                    <span class="text-sm font-medium text-slate-600">
                        @if($jobs->total() > 0)
                            Showing {{ $jobs->firstItem() }} - {{ $jobs->lastItem() }} of {{ $jobs->total() }} Jobs
                        @else
                            0 Jobs Available
                        @endif
                    </span>

                </div>

            </section>


            <!-- SEARCH & FILTER TOOLBAR -->
            <section class="mb-8 border border-slate-200 bg-white p-5 sm:p-6 shadow-[0_2px_8px_rgba(15,23,42,0.04)]">

                <form action="{{ route('student.jobs') }}" method="GET" class="space-y-4">

                    <!-- PRIMARY ROW -->
                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-12">

                        <!-- KEYWORD SEARCH -->
                        <div class="lg:col-span-5">

                            <label for="search" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Keywords
                            </label>

                            <div class="relative">

                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="11" cy="11" r="7"/>
                                        <path d="m16 16 4 4"/>
                                    </svg>
                                </div>

                                <input
                                    type="text"
                                    id="search"
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Search by job title or description..."
                                    class="w-full rounded-md border border-slate-300 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-800 placeholder-slate-400 outline-none transition focus:border-[#5140ef] focus:ring-2 focus:ring-[#5140ef]/10">

                            </div>

                        </div>


                        <!-- JOB TYPE FILTER -->
                        <div class="lg:col-span-3">

                            <label for="job_type" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Job Type
                            </label>

                            <select
                                id="job_type"
                                name="job_type"
                                class="w-full rounded-md border border-slate-300 bg-white py-2.5 pl-3.5 pr-8 text-sm text-slate-800 outline-none transition focus:border-[#5140ef] focus:ring-2 focus:ring-[#5140ef]/10">

                                <option value="">All Job Types</option>
                                <option value="Full Time" {{ request('job_type') === 'Full Time' ? 'selected' : '' }}>Full Time</option>
                                <option value="Part Time" {{ request('job_type') === 'Part Time' ? 'selected' : '' }}>Part Time</option>
                                <option value="Internship" {{ request('job_type') === 'Internship' ? 'selected' : '' }}>Internship</option>
                                <option value="Contract" {{ request('job_type') === 'Contract' ? 'selected' : '' }}>Contract</option>
                                <option value="Remote" {{ request('job_type') === 'Remote' ? 'selected' : '' }}>Remote</option>

                            </select>

                        </div>


                        <!-- LOCATION FILTER -->
                        <div class="lg:col-span-4">

                            <label for="location" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Location
                            </label>

                            <div class="relative">

                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z"/>
                                        <circle cx="12" cy="10" r="2.5"/>
                                    </svg>
                                </div>

                                <input
                                    type="text"
                                    id="location"
                                    name="location"
                                    value="{{ request('location') }}"
                                    placeholder="Filter by location (e.g. Pune)..."
                                    class="w-full rounded-md border border-slate-300 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-800 placeholder-slate-400 outline-none transition focus:border-[#5140ef] focus:ring-2 focus:ring-[#5140ef]/10">

                            </div>

                        </div>

                    </div>


                    <!-- SECONDARY ROW -->
                    <div class="grid grid-cols-1 gap-4 pt-1 sm:grid-cols-12 sm:items-end">

                        <!-- EXPERIENCE FILTER -->
                        <div class="sm:col-span-6 lg:col-span-5">

                            <label for="experience" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Experience
                            </label>

                            <div class="relative">

                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="9"/>
                                        <path d="M12 7v5l3 2"/>
                                    </svg>
                                </div>

                                <input
                                    type="text"
                                    id="experience"
                                    name="experience"
                                    value="{{ request('experience') }}"
                                    placeholder="Filter by experience (e.g. 0-2 Years)..."
                                    class="w-full rounded-md border border-slate-300 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-800 placeholder-slate-400 outline-none transition focus:border-[#5140ef] focus:ring-2 focus:ring-[#5140ef]/10">

                            </div>

                        </div>


                        <!-- ACTION BUTTONS -->
                        <div class="flex flex-wrap items-center gap-3 sm:col-span-6 sm:justify-end lg:col-span-7">

                            @if(request()->hasAny(['search', 'job_type', 'location', 'experience']) && (request('search') || request('job_type') || request('location') || request('experience')))
                                <a href="{{ route('student.jobs') }}"
                                   class="inline-flex h-10 items-center justify-center gap-2 rounded-md border border-slate-300 bg-white px-4 text-sm font-medium text-slate-600 transition hover:bg-slate-50 hover:text-slate-900">
                                    <svg class="h-4 w-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M18 6 6 18M6 6l12 12"/>
                                    </svg>
                                    Clear Filters
                                </a>
                            @endif

                            <button
                                type="submit"
                                class="inline-flex h-10 items-center justify-center gap-2 rounded-md bg-[#5140ef] px-6 text-sm font-semibold text-white shadow-sm transition hover:bg-[#4032d1] focus:outline-none focus:ring-2 focus:ring-[#5140ef] focus:ring-offset-2">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 3H2l8 9.46V19l4 2v-8.54L22 3z"/>
                                </svg>
                                Filter
                            </button>

                        </div>

                    </div>

                </form>

            </section>



            <!-- JOB LISTINGS -->
            @if($jobs->count() > 0)

                <section>

                    <div class="mb-5 flex items-center justify-between border-b border-slate-200 pb-4">

                        <h2 class="text-base font-semibold text-[#172b40]">
                            Available Positions
                        </h2>

                        <p class="text-xs text-slate-400">
                            Page {{ $jobs->currentPage() }} of {{ $jobs->lastPage() }}
                        </p>

                    </div>


                    <!-- JOB GRID -->
                    <div class="grid grid-cols-1 gap-5 xl:grid-cols-2 2xl:grid-cols-3">


                        @foreach($jobs as $job)


                            <!-- JOB CARD -->
                            <article class="group flex flex-col border border-slate-200 bg-white transition duration-200 hover:border-slate-300 hover:shadow-[0_5px_20px_rgba(15,23,42,0.06)]">


                                <!-- CARD HEADER -->
                                <div class="p-5 sm:p-6">


                                    <div class="flex items-start justify-between gap-3">


                                        <div class="flex min-w-0 items-start gap-3">

                                            <div class="flex h-12 w-12 shrink-0 items-center justify-center border border-[#e3e8f0] bg-[#f4f6fb] text-lg font-bold text-[#344f75]">

                                                {{ strtoupper(substr($job->job_title, 0, 1)) }}

                                            </div>


                                            <div class="min-w-0">

                                                <h3 class="break-words text-lg font-semibold leading-6 text-[#172b40] transition group-hover:text-[#5140ef]">

                                                    {{ $job->job_title }}

                                                </h3>

                                                <!-- COMPANY NAME -->
                                                <p class="mt-1 flex items-center gap-1.5 text-xs font-medium text-slate-600">
                                                    <svg class="h-3.5 w-3.5 shrink-0 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                                        <path d="M3 21h18M3 7v14M21 7v14M6 11h4M6 15h4M14 11h4M14 15h4M9 21v-4h6v4M3 7l9-4 9 4"/>
                                                    </svg>
                                                    <span class="truncate">{{ $job->company->company_name ?? 'Company' }}</span>
                                                </p>

                                            </div>

                                        </div>


                                        <!-- JOB TYPE -->
                                        <span class="shrink-0 border border-[#dce4f3] bg-[#f3f6fc] px-2.5 py-1 text-[11px] font-semibold text-[#45648a]">

                                            {{ $job->job_type }}

                                        </span>

                                    </div>



                                    <!-- DIVIDER -->
                                    <div class="my-5 border-t border-slate-100"></div>



                                    <!-- JOB DETAILS -->
                                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">


                                        <!-- LOCATION -->
                                        <div class="flex items-start gap-3">

                                            <div class="flex h-9 w-9 shrink-0 items-center justify-center bg-slate-50 text-slate-500">

                                                <svg class="h-[18px] w-[18px]"
                                                     viewBox="0 0 24 24"
                                                     fill="none"
                                                     stroke="currentColor"
                                                     stroke-width="1.7">

                                                    <path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z"/>
                                                    <circle cx="12" cy="10" r="2.5"/>

                                                </svg>

                                            </div>


                                            <div class="min-w-0">

                                                <p class="text-[11px] text-slate-400">
                                                    Location
                                                </p>

                                                <p class="mt-1 break-words text-sm font-medium text-slate-700">
                                                    {{ $job->location }}
                                                </p>

                                            </div>

                                        </div>



                                        <!-- SALARY -->
                                        <div class="flex items-start gap-3">

                                            <div class="flex h-9 w-9 shrink-0 items-center justify-center bg-slate-50 text-slate-500">

                                                <svg class="h-[18px] w-[18px]"
                                                     viewBox="0 0 24 24"
                                                     fill="none"
                                                     stroke="currentColor"
                                                     stroke-width="1.7">

                                                    <path d="M12 3v18M17 7.5c0-1.7-1.9-3-5-3s-5 1.3-5 3 1.5 2.5 5 3 5 1.3 5 3-1.9 3-5 3-5-1.3-5-3"/>

                                                </svg>

                                            </div>


                                            <div class="min-w-0">

                                                <p class="text-[11px] text-slate-400">
                                                    Salary
                                                </p>

                                                <p class="mt-1 break-words text-sm font-medium text-slate-700">
                                                    {{ $job->salary }}
                                                </p>

                                            </div>

                                        </div>



                                        <!-- EXPERIENCE -->
                                        <div class="flex items-start gap-3">

                                            <div class="flex h-9 w-9 shrink-0 items-center justify-center bg-slate-50 text-slate-500">

                                                <svg class="h-[18px] w-[18px]"
                                                     viewBox="0 0 24 24"
                                                     fill="none"
                                                     stroke="currentColor"
                                                     stroke-width="1.7">

                                                    <circle cx="12" cy="12" r="9"/>
                                                    <path d="M12 7v5l3 2"/>

                                                </svg>

                                            </div>


                                            <div>

                                                <p class="text-[11px] text-slate-400">
                                                    Experience
                                                </p>

                                                <p class="mt-1 text-sm font-medium text-slate-700">
                                                    {{ $job->experience }}
                                                </p>

                                            </div>

                                        </div>



                                        <!-- VACANCY -->
                                        <div class="flex items-start gap-3">

                                            <div class="flex h-9 w-9 shrink-0 items-center justify-center bg-slate-50 text-slate-500">

                                                <svg class="h-[18px] w-[18px]"
                                                     viewBox="0 0 24 24"
                                                     fill="none"
                                                     stroke="currentColor"
                                                     stroke-width="1.7">

                                                    <circle cx="9" cy="8" r="3"/>
                                                    <path d="M3 20v-1a6 6 0 0 1 12 0v1M16 5a3 3 0 0 1 0 6M18 14a5 5 0 0 1 3 5v1"/>

                                                </svg>

                                            </div>


                                            <div>

                                                <p class="text-[11px] text-slate-400">
                                                    Open Positions
                                                </p>

                                                <p class="mt-1 text-sm font-medium text-slate-700">
                                                    {{ $job->vacancy }} Vacancies
                                                </p>

                                            </div>

                                        </div>


                                    </div>


                                </div>



                                <!-- CARD FOOTER -->
                                <div class="mt-auto flex flex-col justify-between gap-4 border-t border-slate-100 bg-[#fafbfc] px-5 py-4 sm:flex-row sm:items-center sm:px-6">


                                    <!-- DEADLINE -->
                                    <div>

                                        <p class="text-[11px] text-slate-400">
                                            Application Deadline
                                        </p>

                                        <p class="mt-1 text-sm font-semibold text-slate-700">

                                            {{ $job->deadline }}

                                        </p>

                                    </div>



                                    <!-- VIEW DETAILS -->
                                    <a href="{{ route('student.job.details', $job->id) }}"
                                       class="inline-flex h-10 items-center justify-center gap-2 bg-[#5140ef] px-5 text-sm font-semibold text-white transition hover:bg-[#4032d1]">

                                        View Details

                                        <svg class="h-4 w-4"
                                             viewBox="0 0 24 24"
                                             fill="none"
                                             stroke="currentColor"
                                             stroke-width="1.8">

                                            <path d="M5 12h14M13 6l6 6-6 6"/>

                                        </svg>

                                    </a>


                                </div>


                            </article>


                        @endforeach


                    </div>


                    <!-- PAGINATION LINKS -->
                    <div class="mt-8">
                        {{ $jobs->links() }}
                    </div>

                </section>



            @else


                <!-- EMPTY STATE -->
                <section class="flex min-h-[380px] flex-col items-center justify-center border border-slate-200 bg-white px-6 py-14 text-center">


                    <div class="flex h-16 w-16 items-center justify-center border border-slate-200 bg-slate-50 text-slate-400">

                        <svg class="h-8 w-8"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.5">

                            <circle cx="11" cy="11" r="7"/>
                            <path d="m16 16 4 4"/>

                        </svg>

                    </div>


                    <h2 class="mt-5 text-xl font-semibold text-[#172b40]">
                        No Jobs Found
                    </h2>


                    <p class="mt-2 max-w-md text-sm leading-6 text-slate-500">
                        @if(request()->hasAny(['search', 'job_type', 'location', 'experience']) && (request('search') || request('job_type') || request('location') || request('experience')))
                            No jobs matched your current search and filter criteria. Try adjusting your search keywords or clearing filters.
                        @else
                            There are currently no active job openings available. Please check again later for new opportunities.
                        @endif
                    </p>


                    <div class="mt-6 flex flex-wrap items-center justify-center gap-3">

                        @if(request()->hasAny(['search', 'job_type', 'location', 'experience']) && (request('search') || request('job_type') || request('location') || request('experience')))
                            <a href="{{ route('student.jobs') }}"
                               class="inline-flex h-10 items-center justify-center gap-2 bg-[#5140ef] px-5 text-sm font-semibold text-white transition hover:bg-[#4032d1]">
                                Clear Filters
                            </a>
                        @endif

                        <a href="{{ route('student.dashboard') }}"
                           class="inline-flex h-10 items-center justify-center border border-slate-200 bg-white px-5 text-sm font-medium text-slate-600 transition hover:bg-slate-50">
                            Back to Dashboard
                        </a>

                    </div>


                </section>


            @endif


@endsection