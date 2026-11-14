<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>JobPortal | Welcome</title>
    <link rel="icon" type="image/svg+xml"
      href="{{ asset('jobportal.svg') }}?v=4">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            background: #f5f7fa;
            color: #263449;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */

        .sidebar {
            width: 256px;
            background: #17243a;
            color: #fff;
            padding: 28px 20px;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }

        .brand {
            font-size: 25px;
            font-weight: 800;
            padding: 0 10px 35px;
            letter-spacing: -0.7px;
        }

        .brand span {
            color: #7da7d9;
        }

        .sidebar-label {
            color: #8d9bb0;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.2px;
            padding: 0 12px;
            margin: 15px 0;
        }

        .sidebar-link {
            display: block;
            padding: 13px 14px;
            margin-bottom: 7px;
            border-radius: 6px;
            color: #c5cfdd;
            font-size: 14px;
            text-decoration: none;
        }

        .sidebar-link.active {
            background: #263d5b;
            color: #ffffff;
            border-left: 3px solid #79a9e5;
        }

        .sidebar-bottom {
            margin-top: auto;
            border-top: 1px solid #34445a;
            padding: 20px 10px 0;
            color: #aab6c7;
            font-size: 12px;
            line-height: 1.8;
        }

        /* Main Content */

        .main-content {
            flex: 1;
            min-width: 0;
        }

        .topbar {
            height: 76px;
            background: #ffffff;
            border-bottom: 1px solid #e5e9ef;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
        }

        .topbar h3 {
            font-size: 17px;
            color: #263449;
            font-weight: 700;
        }

        .topbar-right {
            font-size: 13px;
            color: #64748b;
        }

        .content {
            max-width: 1440px;
            margin: auto;
            padding: 42px 40px;
        }

        /* Welcome Section */

        .welcome-section {
            background: #ffffff;
            border: 1px solid #e4e9f0;
            border-radius: 9px;
            padding: 38px 40px;
            margin-bottom: 30px;
        }

        .welcome-label {
            color: #557ba8;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.3px;
            margin-bottom: 15px;
        }

        .welcome-section h1 {
            font-size: 31px;
            color: #17243a;
            margin-bottom: 12px;
            line-height: 1.3;
        }

        .welcome-section h1 span {
            color: #557ba8;
        }

        .welcome-section p {
            font-size: 14px;
            color: #738096;
            line-height: 1.8;
            max-width: 650px;
        }

        /* Section Heading */

        .section-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 35px 0 20px;
        }

        .section-heading h2 {
            font-size: 19px;
            color: #263449;
        }

        .section-heading p {
            color: #8490a0;
            font-size: 12px;
            margin-top: 6px;
        }

        /* Role Cards */

        .role-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
        }

        .role-card {
            background: #ffffff;
            border: 1px solid #e1e7ef;
            border-radius: 9px;
            padding: 26px;
            min-height: 285px;
            display: flex;
            flex-direction: column;
            transition: 0.25s ease;
        }

        .role-card:hover {
            border-color: #9bb7d7;
            box-shadow: 0 8px 24px rgba(23, 36, 58, 0.07);
            transform: translateY(-3px);
        }

        .role-index {
            font-size: 11px;
            font-weight: 700;
            color: #557ba8;
            letter-spacing: 1px;
            margin-bottom: 24px;
        }

        .role-card h3 {
            font-size: 20px;
            color: #263449;
            margin-bottom: 12px;
        }

        .role-card p {
            color: #78869a;
            font-size: 13px;
            line-height: 1.8;
            margin-bottom: 25px;
            flex: 1;
        }

        .card-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            flex: 1;
            text-align: center;
            text-decoration: none;
            padding: 12px 10px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: 700;
            transition: 0.2s;
        }

        .btn-primary {
            background: #24466b;
            border: 1px solid #24466b;
            color: #ffffff;
        }

        .btn-primary:hover {
            background: #193653;
        }

        .btn-outline {
            background: #ffffff;
            border: 1px solid #d4deea;
            color: #385b82;
        }

        .btn-outline:hover {
            background: #f0f5fa;
        }

        /* Admin Card */

        .admin-card {
            background: #17243a;
            border-color: #17243a;
        }

        .admin-card .role-index {
            color: #91b5df;
        }

        .admin-card h3 {
            color: #ffffff;
        }

        .admin-card p {
            color: #b3c0d1;
        }

        .admin-card .btn-primary {
            background: #ffffff;
            color: #24466b;
            border-color: #ffffff;
        }

        .admin-card .btn-primary:hover {
            background: #e9f0f8;
        }

        /* Footer */

        .footer {
            margin-top: 35px;
            padding: 22px 0;
            border-top: 1px solid #e1e7ef;
            display: flex;
            justify-content: space-between;
            color: #8995a5;
            font-size: 12px;
        }

        /* Responsive */

        @media(max-width: 1100px) {
            .role-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media(max-width: 768px) {
            .sidebar {
                display: none;
            }

            .topbar {
                padding: 0 20px;
                height: 65px;
            }

            .content {
                padding: 25px 18px;
            }

            .welcome-section {
                padding: 28px 22px;
            }

            .welcome-section h1 {
                font-size: 25px;
            }
        }

        @media(max-width: 520px) {
            .role-grid {
                grid-template-columns: 1fr;
            }

            .section-heading {
                align-items: flex-start;
            }

            .topbar-right {
                font-size: 11px;
            }

            .footer {
                flex-direction: column;
                gap: 8px;
            }
        }
    </style>
</head>

<body>

<div class="layout">

    <!-- Sidebar -->
    <aside class="sidebar">

        <div class="brand">
            Job<span>Portal</span>
        </div>

        <div class="sidebar-label">MAIN MENU</div>

        <a href="{{ url('/') }}" class="sidebar-link active">
            Home
        </a>

        <div class="sidebar-label">ACCOUNT ACCESS</div>

        <a href="{{ url('/student/login') }}" class="sidebar-link">
            Student Login
        </a>

        <a href="{{ url('/company/login') }}" class="sidebar-link">
            Company Login
        </a>

        <a href="{{ url('/admin/login') }}" class="sidebar-link">
            Admin Login
        </a>

        <div class="sidebar-bottom">
            <strong>JobPortal</strong><br>
            Connecting Talent With Opportunity.
        </div>

    </aside>

    <!-- Main Content -->
    <main class="main-content">

        <!-- Topbar -->
        <header class="topbar">
            <h3>Welcome to JobPortal</h3>

            <div class="topbar-right">
                Career &nbsp; | &nbsp; Opportunities
            </div>
        </header>

        <div class="content">

            <!-- Welcome Section -->
            <section class="welcome-section">

                <div class="welcome-label">
                    CAREER MANAGEMENT PLATFORM
                </div>

                <h1>
                    Build Your Future With
                    <span>JobPortal</span>
                </h1>

                <p>
                    Discover opportunities, connect with companies and
                    find the right talent. Choose your account type to
                    access your personalized JobPortal workspace.
                </p>

            </section>

            <!-- Role Selection -->
            <section>

                <div class="section-heading">
                    <div>
                        <h2>Select Your Account</h2>
                        <p>Choose your role to continue.</p>
                    </div>
                </div>

                <div class="role-grid">

                    <!-- Student -->
                    <div class="role-card">

                        <div class="role-index">01 / STUDENT</div>

                        <h3>Student Account</h3>

                        <p>
                            Explore job opportunities, discover companies,
                            apply for suitable positions and track your
                            applications through your personal dashboard.
                        </p>

                        <div class="card-actions">

                            <a href="{{ url('/student/login') }}"
                               class="btn btn-primary">
                                Login
                            </a>

                            <a href="{{ url('/student/register') }}"
                               class="btn btn-outline">
                                Register
                            </a>

                        </div>

                    </div>

                    <!-- Company -->
                    <div class="role-card">

                        <div class="role-index">02 / COMPANY</div>

                        <h3>Company Account</h3>

                        <p>
                            Publish job openings, manage your job listings,
                            review candidates and connect with talented
                            students looking for opportunities.
                        </p>

                        <div class="card-actions">

                            <a href="{{ url('/company/login') }}"
                               class="btn btn-primary">
                                Login
                            </a>

                            <a href="{{ url('/company/register') }}"
                               class="btn btn-outline">
                                Register
                            </a>

                        </div>

                    </div>

                    <!-- Admin -->
                    <div class="role-card admin-card">

                        <div class="role-index">03 / ADMINISTRATION</div>

                        <h3>Administrator</h3>

                        <p>
                            Manage registered students, approve companies,
                            monitor job listings and oversee applications
                            through the administration panel.
                        </p>

                        <div class="card-actions">

                            <a href="{{ route('admin.login') }}"
                               class="btn btn-primary">
                                Admin Login
                            </a>

                        </div>

                    </div>

                </div>

            </section>

            <!-- Footer -->
            <footer class="footer">

                <span>
                    &copy; {{ date('Y') }} JobPortal. All rights reserved.
                </span>

                <span>
                    Connecting Talent With Opportunity
                </span>

            </footer>

        </div>

    </main>

</div>

</body>
</html>