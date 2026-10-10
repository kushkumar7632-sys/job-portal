<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Companies | JobPortal</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 min-h-screen text-slate-800">

    <!-- ================= NAVBAR ================= -->

    <header class="sticky top-0 z-50 bg-white border-b border-slate-200">

        <div class="h-16 px-5 md:px-8 flex items-center justify-between">

            <!-- Brand -->

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3">

                <div
                    class="w-10 h-10 rounded-xl bg-blue-600
                           text-white flex items-center justify-center
                           font-bold text-lg">

                    JP

                </div>

                <div>

                    <h1 class="font-bold text-lg leading-none">
                        JobPortal
                    </h1>

                    <p class="text-xs text-slate-500 mt-1">
                        Admin Panel
                    </p>

                </div>

            </a>


            <!-- Right -->

            <div class="flex items-center gap-4">

                <div class="hidden sm:block text-right">

                    <p class="text-sm font-semibold text-slate-700">
                        Administrator
                    </p>

                    <p class="text-xs text-slate-400">
                        System Admin
                    </p>

                </div>


                <div
                    class="w-10 h-10 rounded-full
                           bg-blue-100 text-blue-700
                           flex items-center justify-center
                           font-bold">

                    A

                </div>


                <form action="{{ route('admin.logout') }}" method="POST">

                    @csrf

                    <button
                        type="submit"
                        class="flex items-center gap-2
                               px-4 py-2 rounded-lg
                               border border-slate-200
                               text-sm font-medium text-slate-600
                               hover:bg-red-50
                               hover:text-red-600
                               hover:border-red-200
                               transition">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h5a2 2 0 012 2v1" />

                        </svg>

                        Logout

                    </button>

                </form>

            </div>

        </div>

    </header>


    <!-- ================= MAIN ================= -->

    <main class="max-w-7xl mx-auto px-5 md:px-8 py-8">


        <!-- Breadcrumb -->

        <div class="flex items-center gap-2 text-sm mb-5">

            <a
                href="{{ route('admin.dashboard') }}"
                class="text-blue-600 hover:text-blue-700">

                Dashboard

            </a>

            <span class="text-slate-400">
                /
            </span>

            <span class="text-slate-500">
                Companies
            </span>

        </div>


        <!-- Page Header -->

        <div
            class="flex flex-col md:flex-row
                   md:items-center md:justify-between
                   gap-4 mb-7">

            <div>

                <div class="flex items-center gap-3">

                    <div
                        class="w-11 h-11 rounded-xl
                               bg-blue-50 text-blue-600
                               flex items-center justify-center">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-6 h-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-4h6v4M9 10h1m4 0h1m-6 4h1m4 0h1" />

                        </svg>

                    </div>

                    <div>

                        <h2 class="text-2xl md:text-3xl font-bold text-slate-900">
                            Manage Companies
                        </h2>

                        <p class="text-sm text-slate-500 mt-1">
                            Review and manage registered companies.
                        </p>

                    </div>

                </div>

            </div>


            <!-- Company Count -->

            <div
                class="bg-white border border-slate-200
                       rounded-xl px-5 py-3 shadow-sm">

                <p class="text-xs text-slate-400">
                    Total Companies
                </p>

                <p class="text-xl font-bold text-slate-900 mt-1">
                    {{ $companies->count() }}
                </p>

            </div>

        </div>


        <!-- ================= SUCCESS MESSAGE ================= -->

        @if(session('success'))

            <div
                class="mb-6 flex items-start gap-3
                       bg-emerald-50
                       border border-emerald-200
                       text-emerald-700
                       rounded-xl p-4">

                <div
                    class="w-8 h-8 rounded-lg
                           bg-emerald-100
                           flex items-center justify-center
                           font-bold">

                    ✓

                </div>

                <div>

                    <p class="font-semibold text-sm">
                        Success
                    </p>

                    <p class="text-sm mt-1">
                        {{ session('success') }}
                    </p>

                </div>

            </div>

        @endif


        <!-- ================= COMPANY TABLE ================= -->

        <div
            class="bg-white border border-slate-200
                   rounded-2xl shadow-sm overflow-hidden">


            <!-- Table Header -->

            <div
                class="px-6 py-5
                       border-b border-slate-200
                       flex items-center justify-between">

                <div>

                    <h3 class="font-bold text-slate-900">
                        Registered Companies
                    </h3>

                    <p class="text-xs text-slate-500 mt-1">
                        Review company accounts and approval status.
                    </p>

                </div>

            </div>


            <!-- Responsive Table -->

            <div class="overflow-x-auto">

                <table class="w-full text-left">

                    <thead class="bg-slate-50 border-b border-slate-200">

                        <tr>

                            <th
                                class="px-6 py-4
                                       text-xs font-semibold
                                       uppercase tracking-wide
                                       text-slate-500">

                                Company

                            </th>

                            <th
                                class="px-6 py-4
                                       text-xs font-semibold
                                       uppercase tracking-wide
                                       text-slate-500">

                                Owner

                            </th>

                            <th
                                class="px-6 py-4
                                       text-xs font-semibold
                                       uppercase tracking-wide
                                       text-slate-500">

                                Email

                            </th>

                            <th
                                class="px-6 py-4
                                       text-xs font-semibold
                                       uppercase tracking-wide
                                       text-slate-500">

                                Industry

                            </th>

                            <th
                                class="px-6 py-4
                                       text-xs font-semibold
                                       uppercase tracking-wide
                                       text-slate-500">

                                Status

                            </th>

                            <th
                                class="px-6 py-4
                                       text-xs font-semibold
                                       uppercase tracking-wide
                                       text-slate-500">

                                Action

                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100">

                        @forelse($companies as $company)

                            <tr
                                class="hover:bg-slate-50
                                       transition">


                                <!-- Company -->

                                <td class="px-6 py-5">

                                    <div class="flex items-center gap-3">

                                        <div
                                            class="w-10 h-10 rounded-xl
                                                   bg-blue-50
                                                   text-blue-600
                                                   flex items-center
                                                   justify-center
                                                   font-bold">

                                            {{ strtoupper(substr($company->company_name, 0, 1)) }}

                                        </div>

                                        <div>

                                            <p
                                                class="font-semibold
                                                       text-slate-900">

                                                {{ $company->company_name }}

                                            </p>

                                            <p class="text-xs text-slate-400 mt-1">
                                                Company
                                            </p>

                                        </div>

                                    </div>

                                </td>


                                <!-- Owner -->

                                <td class="px-6 py-5">

                                    <p class="text-sm font-medium text-slate-700">

                                        {{ $company->owner_name }}

                                    </p>

                                </td>


                                <!-- Email -->

                                <td class="px-6 py-5">

                                    <p
                                        class="text-sm text-slate-600
                                               whitespace-nowrap">

                                        {{ $company->email }}

                                    </p>

                                </td>


                                <!-- Industry -->

                                <td class="px-6 py-5">

                                    <span
                                        class="inline-flex
                                               px-3 py-1
                                               rounded-lg
                                               bg-slate-100
                                               text-slate-600
                                               text-sm">

                                        {{ $company->industry }}

                                    </span>

                                </td>


                                <!-- Status -->

                                <td class="px-6 py-5">

                                    @if($company->is_approved)

                                        <span
                                            class="inline-flex
                                                   items-center gap-2
                                                   px-3 py-1.5
                                                   rounded-full
                                                   text-xs font-semibold
                                                   bg-emerald-50
                                                   text-emerald-700
                                                   border border-emerald-200">

                                            <span
                                                class="w-1.5 h-1.5
                                                       rounded-full
                                                       bg-emerald-500">
                                            </span>

                                            Approved

                                        </span>

                                    @else

                                        <span
                                            class="inline-flex
                                                   items-center gap-2
                                                   px-3 py-1.5
                                                   rounded-full
                                                   text-xs font-semibold
                                                   bg-amber-50
                                                   text-amber-700
                                                   border border-amber-200">

                                            <span
                                                class="w-1.5 h-1.5
                                                       rounded-full
                                                       bg-amber-500">
                                            </span>

                                            Pending

                                        </span>

                                    @endif

                                </td>


                                <!-- Action -->

                                <td class="px-6 py-5">

                                    @if(!$company->is_approved)

                                        <form
                                            action="{{ route('admin.companies.approve', $company->id) }}"
                                            method="POST">

                                            @csrf

                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="inline-flex
                                                       items-center gap-2
                                                       px-4 py-2
                                                       rounded-lg
                                                       bg-emerald-600
                                                       hover:bg-emerald-700
                                                       text-white
                                                       text-sm
                                                       font-semibold
                                                       transition">

                                                ✓
                                                Approve

                                            </button>

                                        </form>

                                    @else

                                        <form
                                            action="{{ route('admin.companies.reject', $company->id) }}"
                                            method="POST">

                                            @csrf

                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="inline-flex
                                                       items-center gap-2
                                                       px-4 py-2
                                                       rounded-lg
                                                       bg-red-50
                                                       hover:bg-red-100
                                                       text-red-600
                                                       border border-red-200
                                                       text-sm
                                                       font-semibold
                                                       transition">

                                                ✕
                                                Reject

                                            </button>

                                        </form>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <!-- Empty State -->

                            <tr>

                                <td
                                    colspan="6"
                                    class="px-6 py-16">

                                    <div
                                        class="flex flex-col
                                               items-center
                                               justify-center
                                               text-center">

                                        <div
                                            class="w-16 h-16 rounded-2xl
                                                   bg-slate-100
                                                   text-slate-400
                                                   flex items-center
                                                   justify-center
                                                   mb-4">

                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="w-8 h-8"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor">

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-4h6v4M9 10h1m4 0h1m-6 4h1m4 0h1" />

                                            </svg>

                                        </div>

                                        <h3
                                            class="text-lg font-semibold
                                                   text-slate-800">

                                            No companies registered

                                        </h3>

                                        <p
                                            class="text-sm text-slate-500
                                                   mt-1">

                                            Registered companies will appear here.

                                        </p>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        <!-- Footer -->

        <footer
            class="text-center text-xs
                   text-slate-400 mt-8 pb-5">

            © {{ date('Y') }} JobPortal Admin Panel.
            All rights reserved.

        </footer>

    </main>

</body>

</html>