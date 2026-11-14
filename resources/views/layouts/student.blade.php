<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="{{ asset('jobportal.svg') }}?v=4">

    <title>@yield('title', 'Student Portal') - JobPortal</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full antialiased text-slate-800">

    @php
        $studentSessionName = session('student_name');
        if (!$studentSessionName && isset($student) && is_object($student) && isset($student->name)) {
            $studentSessionName = $student->name;
        }
        $studentName = $studentSessionName ?: 'Student';
        $studentInitial = strtoupper(substr($studentName, 0, 1));
    @endphp

    <div class="min-h-full flex">

        <!-- Mobile Sidebar Backdrop -->
        <div id="mobile-backdrop"
             class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-sm hidden lg:hidden transition-opacity duration-300 opacity-0"
             onclick="toggleSidebar()"></div>

        <!-- Sidebar -->
        <aside id="sidebar"
               class="fixed inset-y-0 left-0 z-50 w-64 bg-[#080d20] text-white flex flex-col transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0 lg:static lg:inset-0 shrink-0">

            <!-- Logo Area -->
            <div class="h-16 px-6 flex items-center justify-between border-b border-white/10">
                <a href="{{ route('student.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-indigo-600 flex items-center justify-center rounded-lg font-bold text-lg text-white shadow-xs">
                        J
                    </div>
                    <span class="text-xl font-bold tracking-tight text-white">
                        Job<span class="text-indigo-400">Portal</span>
                    </span>
                    <span class="text-[10px] font-semibold uppercase tracking-wider bg-indigo-500/20 text-indigo-300 border border-indigo-400/30 px-2 py-0.5 rounded-full">
                        Student
                    </span>
                </a>

                <!-- Mobile Close Button -->
                <button type="button"
                        onclick="toggleSidebar()"
                        class="lg:hidden p-1.5 text-slate-400 hover:text-white rounded-lg hover:bg-white/10"
                        aria-label="Close sidebar">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Navigation Links -->
            <div class="flex-1 px-4 py-6 overflow-y-auto space-y-6">

                <div>
                    <p class="px-3 text-[11px] font-semibold uppercase tracking-[0.15em] text-slate-400 mb-3">
                        Workspace
                    </p>

                    <nav class="space-y-1">
                        <!-- Dashboard -->
                        <a href="{{ route('student.dashboard') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('student.dashboard*') ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 10.5L12 3l9 7.5V21H3V10.5Z"/>
                            </svg>
                            <span>Dashboard</span>
                        </a>

                        <!-- Find Jobs -->
                        <a href="{{ route('student.jobs') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ (request()->routeIs('student.jobs*') || request()->routeIs('student.job.*')) ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="11" cy="11" r="7" stroke-width="1.8"/>
                                <path d="m16 16 4 4" stroke-width="1.8" stroke-linecap="round"/>
                            </svg>
                            <span>Find Jobs</span>
                        </a>

                        <!-- My Applications -->
                        <a href="{{ route('student.applications') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ (request()->routeIs('student.applications*') || request()->routeIs('student.resume.*')) ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <rect x="4" y="3" width="16" height="18" rx="2" stroke-width="1.8"/>
                                <path d="M8 8h8M8 12h8M8 16h5" stroke-width="1.8" stroke-linecap="round"/>
                            </svg>
                            <span>My Applications</span>
                        </a>
                    </nav>
                </div>

                <div class="pt-4 border-t border-white/10">
                    <p class="px-3 text-[11px] font-semibold uppercase tracking-[0.15em] text-slate-400 mb-3">
                        Account
                    </p>

                    <nav class="space-y-1">
                        <!-- Account Profile -->
                        <a href="{{ route('student.profile') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('student.profile*') ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="8" r="4" stroke-width="1.8"/>
                                <path d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7" stroke-width="1.8"/>
                            </svg>
                            <span>Account Profile</span>
                        </a>
                    </nav>
                </div>

            </div>

            <!-- Student Account Card & Sign Out -->
            <div class="p-4 border-t border-white/10 bg-[#0f172a]/60">
                <div class="flex items-center gap-3 px-2 mb-3">
                    <div class="w-9 h-9 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-sm shrink-0 shadow-inner">
                        {{ $studentInitial }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold text-white truncate">
                            {{ $studentName }}
                        </p>
                        <p class="text-xs text-slate-400 truncate">
                            Student Account
                        </p>
                    </div>
                </div>

                <form action="{{ route('student.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold text-slate-300 hover:text-white bg-white/5 hover:bg-white/10 border border-white/10 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span>Sign Out</span>
                    </button>
                </form>
            </div>

        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 min-w-0 flex flex-col bg-slate-50">

            <!-- Top Header -->
            <header class="h-16 bg-white border-b border-slate-200 px-4 sm:px-6 lg:px-8 flex items-center justify-between sticky top-0 z-30 shadow-xs">
                <div class="flex items-center gap-4">
                    <!-- Mobile Hamburger -->
                    <button type="button"
                            onclick="toggleSidebar()"
                            class="lg:hidden p-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100 focus:outline-hidden focus:ring-2 focus:ring-indigo-500"
                            aria-label="Open sidebar">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                    <div>
                        <h1 class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight">
                            @yield('header', 'Student Dashboard')
                        </h1>
                        @hasSection('subheader')
                            <p class="text-xs text-slate-500 hidden sm:block">
                                @yield('subheader')
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Right Side Actions -->
                <div class="flex items-center gap-3 sm:gap-4">
                    <div class="hidden sm:block text-right">
                        <p class="text-sm font-semibold text-slate-800">
                            {{ $studentName }}
                        </p>
                        <p class="text-xs text-slate-500">
                            Student
                        </p>
                    </div>

                    <a href="{{ route('student.profile') }}"
                       title="View Account Profile"
                       class="w-9 h-9 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-sm transition hover:bg-indigo-100">
                        {{ $studentInitial }}
                    </a>

                    <form action="{{ route('student.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                                class="text-sm font-medium text-red-600 border border-red-200 px-3 py-1.5 rounded-lg hover:bg-red-50 transition">
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            <!-- Page Body -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto">

                <!-- Flash Alert Messages -->
                @if(session('success'))
                    <div class="mb-6 flex items-center gap-3 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 shadow-xs">
                        <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm font-medium">{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 flex items-center gap-3 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 shadow-xs">
                        <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm font-medium">{{ session('error') }}</p>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 shadow-xs">
                        <div class="flex items-center gap-2 mb-2 font-medium text-sm">
                            <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <span>Please correct the errors below:</span>
                        </div>
                        <ul class="list-disc list-inside text-xs space-y-1 text-rose-700 ml-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Content Slot -->
                @yield('content')

            </main>

            <!-- Footer -->
            <footer class="py-4 px-6 border-t border-slate-200 text-center text-xs text-slate-500 bg-white">
                <p>&copy; {{ date('Y') }} JobPortal Student Workspace. All rights reserved.</p>
            </footer>

        </div>

    </div>

    <!-- Mobile Sidebar Toggle Script -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('mobile-backdrop');

            const isClosed = sidebar.classList.contains('-translate-x-full');
            if (isClosed) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
                setTimeout(() => {
                    backdrop.classList.remove('opacity-0');
                    backdrop.classList.add('opacity-100');
                }, 10);
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.remove('opacity-100');
                backdrop.classList.add('opacity-0');
                setTimeout(() => {
                    backdrop.classList.add('hidden');
                }, 300);
            }
        }
    </script>

    @stack('scripts')

</body>

</html>
