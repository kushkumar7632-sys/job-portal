@extends('layouts.student')

@section('title', 'Upload Resume')
@section('header', 'Upload Resume')
@section('subheader', 'Manage your career documents')

@section('content')








            <!-- BREADCRUMB -->
            <nav class="mb-6 flex flex-wrap items-center gap-2 text-xs font-medium text-slate-400">

                <a href="{{ route('student.dashboard') }}"
                   class="hover:text-[#5140ef]">

                    Dashboard

                </a>

                <span>/</span>

                <a href="{{ route('student.jobs') }}"
                   class="hover:text-[#5140ef]">

                    Find Jobs

                </a>

                <span>/</span>

                <a href="{{ route('student.job.details', $application->job_id) }}"
                   class="hover:text-[#5140ef]">

                    Job Details

                </a>

                <span>/</span>

                <span class="text-slate-700">
                    Upload Resume
                </span>

            </nav>



            <!-- PAGE HEADING -->
            <section class="mb-8">

                <p class="text-xs font-semibold uppercase tracking-[0.15em] text-[#5140ef]">
                    CAREER DOCUMENTS
                </p>

                <h1 class="mt-2 text-2xl font-bold tracking-tight text-[#172b40] sm:text-3xl">

                    Upload Your Resume

                </h1>

                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">

                    Submit your latest resume to complete your job application and help employers understand your qualifications.

                </p>

            </section>



            <!-- BACK LINK -->
            <div class="mb-6">

                <a href="{{ route('student.job.details', $application->job_id) }}"
                   class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-[#5140ef]">

                    <svg class="h-4 w-4" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="1.8">

                        <path d="M19 12H5M12 19l-7-7 7-7"/>

                    </svg>

                    Back to Job Details

                </a>

            </div>



            <!-- MAIN GRID -->
            <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">


                <!-- UPLOAD FORM -->
                <section class="overflow-hidden border border-slate-200 bg-white xl:col-span-2">


                    <!-- CARD HEADER -->
                    <div class="border-b border-slate-200 px-6 py-5 sm:px-8">

                        <div class="flex items-center gap-4">

                            <div class="flex h-11 w-11 items-center justify-center bg-[#f0f2ff] text-[#5140ef]">

                                <svg class="h-6 w-6" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="1.7">

                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <path d="M14 2v6h6M8 13h8M8 17h8"/>

                                </svg>

                            </div>


                            <div>

                                <h2 class="text-lg font-semibold text-[#172b40]">
                                    Resume Information
                                </h2>

                                <p class="mt-1 text-xs text-slate-400">
                                    Upload a document for your job application.
                                </p>

                            </div>

                        </div>

                    </div>



                    <!-- CARD BODY -->
                    <div class="p-6 sm:p-8">










                        <!-- RESUME FORM -->
                        <form
                            action="{{ route('student.resume.store', $application->job_id) }}"
                            method="POST"
                            enctype="multipart/form-data">

                            @csrf


                            <!-- LABEL -->
                            <div class="mb-5">

                                <label for="resume"
                                       class="block text-sm font-semibold text-slate-700">

                                    Select Resume

                                    <span class="text-red-500">*</span>

                                </label>

                                <p class="mt-1 text-xs text-slate-400">

                                    Choose your latest professional resume.

                                </p>

                            </div>



                            <!-- UPLOAD AREA -->
                            <label for="resume"
                                   id="uploadArea"
                                   class="group flex min-h-[260px] cursor-pointer flex-col items-center justify-center border-2 border-dashed border-slate-300 bg-[#fafbfc] px-5 py-9 text-center transition hover:border-[#5140ef] hover:bg-[#f8f8ff]">


                                <!-- UPLOAD ICON -->
                                <div class="flex h-16 w-16 items-center justify-center bg-[#f0f2ff] text-[#5140ef] transition group-hover:bg-[#e8eaff]">

                                    <svg class="h-8 w-8" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="1.6">

                                        <path d="M12 16V4m-5 5 5-5 5 5"/>
                                        <path d="M4 16v3a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-3"/>

                                    </svg>

                                </div>



                                <h3 class="mt-5 text-base font-semibold text-[#172b40]">

                                    Choose your resume

                                </h3>


                                <p class="mt-2 text-sm text-slate-500">

                                    Click here to browse files from your device.

                                </p>


                                <p class="mt-2 text-xs text-slate-400">

                                    Supported formats: PDF, DOC, DOCX

                                </p>



                                <!-- FILE INPUT -->
                                <input
                                    type="file"
                                    id="resume"
                                    name="resume"
                                    accept=".pdf,.doc,.docx"
                                    required
                                    class="sr-only">


                                <!-- SELECTED FILE -->
                                <div id="fileInfo"
                                     class="mt-5 hidden w-full max-w-md items-center gap-3 border border-[#dce3ef] bg-white p-3 text-left">

                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center bg-[#f0f2ff] text-[#5140ef]">

                                        <svg class="h-5 w-5" viewBox="0 0 24 24"
                                             fill="none" stroke="currentColor" stroke-width="1.7">

                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                            <path d="M14 2v6h6"/>

                                        </svg>

                                    </div>


                                    <div class="min-w-0 flex-1">

                                        <p id="fileName"
                                           class="truncate text-sm font-semibold text-slate-700">

                                        </p>

                                        <p id="fileSize"
                                           class="mt-1 text-xs text-slate-400">

                                        </p>

                                    </div>


                                    <svg class="h-5 w-5 shrink-0 text-green-600"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="2">

                                        <path d="m5 12 4 4L19 6"/>

                                    </svg>

                                </div>


                            </label>



                            <!-- FILE REQUIREMENTS -->
                            <div class="mt-5 flex flex-wrap gap-3">

                                <span class="border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-medium text-slate-600">
                                    PDF
                                </span>

                                <span class="border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-medium text-slate-600">
                                    DOC
                                </span>

                                <span class="border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-medium text-slate-600">
                                    DOCX
                                </span>

                                <span class="border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-medium text-slate-600">
                                    Maximum 2 MB
                                </span>

                            </div>



                            <!-- SUBMIT BUTTON -->
                            <div class="mt-7 border-t border-slate-100 pt-6">

                                <button
                                    type="submit"
                                    class="inline-flex h-11 w-full items-center justify-center gap-2 bg-[#5140ef] px-6 text-sm font-semibold text-white transition hover:bg-[#4032d1] sm:w-auto">

                                    <svg class="h-4 w-4" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="1.8">

                                        <path d="M12 16V4m-5 5 5-5 5 5"/>
                                        <path d="M4 16v3a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-3"/>

                                    </svg>

                                    Upload Resume

                                </button>

                            </div>


                        </form>


                    </div>

                </section>



                <!-- RIGHT INFORMATION PANEL -->
                <aside class="space-y-6">


                    <!-- RESUME GUIDELINES -->
                    <section class="border border-slate-200 bg-white">

                        <div class="border-b border-slate-200 px-5 py-4">

                            <h3 class="text-sm font-semibold text-[#172b40]">
                                Resume Guidelines
                            </h3>

                        </div>


                        <div class="space-y-5 p-5">


                            <div class="flex gap-3">

                                <div class="flex h-8 w-8 shrink-0 items-center justify-center bg-[#f0f2ff] text-[#5140ef]">

                                    <svg class="h-4 w-4" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="1.8">

                                        <path d="M5 12h14M12 5l7 7-7 7"/>

                                    </svg>

                                </div>


                                <div>

                                    <p class="text-sm font-semibold text-slate-700">
                                        Keep it updated
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-slate-500">
                                        Include your latest educational and professional details.
                                    </p>

                                </div>

                            </div>



                            <div class="flex gap-3">

                                <div class="flex h-8 w-8 shrink-0 items-center justify-center bg-[#f0f2ff] text-[#5140ef]">

                                    <svg class="h-4 w-4" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="1.8">

                                        <path d="M12 20h9"/>
                                        <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L8 18l-4 1 1-4Z"/>

                                    </svg>

                                </div>


                                <div>

                                    <p class="text-sm font-semibold text-slate-700">
                                        Highlight your skills
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-slate-500">
                                        Mention relevant technical skills and projects.
                                    </p>

                                </div>

                            </div>



                            <div class="flex gap-3">

                                <div class="flex h-8 w-8 shrink-0 items-center justify-center bg-[#f0f2ff] text-[#5140ef]">

                                    <svg class="h-4 w-4" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="1.8">

                                        <circle cx="12" cy="12" r="9"/>
                                        <path d="M12 11v5M12 8h.01"/>

                                    </svg>

                                </div>


                                <div>

                                    <p class="text-sm font-semibold text-slate-700">
                                        Check your details
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-slate-500">
                                        Verify your contact information before uploading.
                                    </p>

                                </div>

                            </div>


                        </div>

                    </section>



                    <!-- FILE SECURITY -->
                    <section class="border border-slate-200 bg-white p-5">

                        <div class="flex items-start gap-3">

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center bg-[#eef8f2] text-[#268453]">

                                <svg class="h-5 w-5" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="1.7">

                                    <rect x="4" y="10" width="16" height="11" rx="2"/>
                                    <path d="M8 10V7a4 4 0 1 1 8 0v3"/>
                                    <circle cx="12" cy="15" r="1"/>

                                </svg>

                            </div>


                            <div>

                                <h3 class="text-sm font-semibold text-[#172b40]">
                                    Document Security
                                </h3>

                                <p class="mt-2 text-xs leading-5 text-slate-500">

                                    Your resume is associated with your job application and handled through the platform's existing document upload process.

                                </p>

                            </div>

                        </div>

                    </section>



                    <!-- SUPPORT INFORMATION -->
                    <section class="border border-slate-200 bg-white p-5">

                        <h3 class="text-sm font-semibold text-[#172b40]">
                            Need to update your resume?
                        </h3>

                        <p class="mt-2 text-xs leading-5 text-slate-500">

                            Select the latest version of your resume before submitting your application document.

                        </p>

                        <a href="{{ route('student.applications') }}"
                           class="mt-4 inline-flex items-center gap-2 text-xs font-semibold text-[#5140ef] hover:text-[#4032d1]">

                            View My Applications

                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.8">

                                <path d="M5 12h14M13 6l6 6-6 6"/>

                            </svg>

                        </a>

                    </section>


                </aside>


            </div>

@endsection

@push('scripts')
<script>
    const resumeInput = document.getElementById('resume');
    const fileInfo = document.getElementById('fileInfo');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');

    if (resumeInput) {
        resumeInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                fileName.textContent = file.name;
                fileSize.textContent = (file.size / 1024).toFixed(1) + ' KB';
                fileInfo.classList.remove('hidden');
                fileInfo.classList.add('flex');
            } else {
                fileInfo.classList.add('hidden');
                fileInfo.classList.remove('flex');
            }
        });
    }
</script>
@endpush