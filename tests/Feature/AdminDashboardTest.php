<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Admin;
use App\Models\Student;
use App\Models\Company;
use App\Models\Job;
use App\Models\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    private function createAdmin(array $attributes = []): Admin
    {
        return Admin::create(array_merge([
            'name'     => 'System Admin',
            'email'    => strtolower('admin_' . Str::random(5) . '@example.com'),
            'password' => Hash::make('password123'),
        ], $attributes));
    }

    private function createStudent(array $attributes = []): Student
    {
        return Student::create(array_merge([
            'name'     => 'John Candidate',
            'email'    => strtolower('student_' . Str::random(5) . '@example.com'),
            'phone'    => '9' . str_pad((string) mt_rand(100000000, 999999999), 9, '0', STR_PAD_LEFT),
            'password' => Hash::make('secret123'),
        ], $attributes));
    }

    private function createCompany(array $attributes = []): Company
    {
        return Company::create(array_merge([
            'company_name' => 'Acme Corporation',
            'owner_name'   => 'Jane Owner',
            'email'        => strtolower('company_' . Str::random(5) . '@example.com'),
            'phone'        => '9' . str_pad((string) mt_rand(100000000, 999999999), 9, '0', STR_PAD_LEFT),
            'industry'     => 'Technology',
            'address'      => '123 Tech Way',
            'password'     => Hash::make('secret123'),
            'is_approved'  => true,
        ], $attributes));
    }

    private function createJob(Company $company, array $attributes = []): Job
    {
        return Job::create(array_merge([
            'company_id'  => $company->id,
            'job_title'   => 'Software Engineer',
            'job_type'    => 'Full Time',
            'location'    => 'Remote',
            'salary'      => '$100,000',
            'experience'  => '2+ Years',
            'vacancy'     => 3,
            'description' => 'Great role.',
            'deadline'    => now()->addDays(14)->toDateString(),
            'status'      => true,
        ], $attributes));
    }

    private function createJobApplication(Student $student, Job $job, array $attributes = []): Application
    {
        return Application::create(array_merge([
            'student_id' => $student->id,
            'job_id'     => $job->id,
            'status'     => 'Pending',
            'resume'     => 'resumes/sample.pdf',
        ], $attributes));
    }

    public function test_guest_is_redirected_from_dashboard_to_admin_login()
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_dashboard_renders_empty_states_gracefully_when_no_records_exist()
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin, 'admin')->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('All Companies Verified');
        $response->assertSee('No Job Postings Yet');
        $response->assertSee('No Applications Submitted');
        $response->assertSee('0'); // zero counts for metrics
    }

    public function test_dashboard_displays_accurate_dynamic_statistics()
    {
        $admin = $this->createAdmin();

        // 3 students
        $student1 = $this->createStudent();
        $student2 = $this->createStudent();
        $student3 = $this->createStudent();

        // 2 approved companies, 1 pending company
        $comp1 = $this->createCompany(['is_approved' => true]);
        $comp2 = $this->createCompany(['is_approved' => true]);
        $comp3 = $this->createCompany(['is_approved' => false]);

        // Jobs: 2 active, 1 closed status, 1 expired deadline
        $jobActive1 = $this->createJob($comp1, ['status' => true, 'deadline' => now()->addDays(10)->toDateString()]);
        $jobActive2 = $this->createJob($comp1, ['status' => true, 'deadline' => now()->addDays(5)->toDateString()]);
        $jobClosed  = $this->createJob($comp1, ['status' => false, 'deadline' => now()->addDays(5)->toDateString()]);
        $jobExpired = $this->createJob($comp1, ['status' => true, 'deadline' => now()->subDays(2)->toDateString()]);

        // Applications: 1 Pending, 1 Shortlisted, 1 Selected, 1 Rejected
        $this->createJobApplication($student1, $jobActive1, ['status' => 'Pending']);
        $this->createJobApplication($student2, $jobActive1, ['status' => 'Shortlisted']);
        $this->createJobApplication($student3, $jobActive1, ['status' => 'Selected']);
        $this->createJobApplication($student1, $jobActive2, ['status' => 'Rejected']);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.dashboard'));

        $response->assertStatus(200);

        // Verify view data
        $response->assertViewHas('studentCount', 3);
        $response->assertViewHas('companyCount', 3);
        $response->assertViewHas('approvedCompanyCount', 2);
        $response->assertViewHas('pendingCompanyCount', 1);

        $response->assertViewHas('jobCount', 4);
        $response->assertViewHas('activeJobCount', 2);
        $response->assertViewHas('closedJobCount', 2);

        $response->assertViewHas('applicationCount', 4);
        $response->assertViewHas('pendingApplicationCount', 1);
        $response->assertViewHas('shortlistedApplicationCount', 1);
        $response->assertViewHas('selectedApplicationCount', 1);
        $response->assertViewHas('rejectedApplicationCount', 1);
    }

    public function test_dashboard_cards_point_to_correct_management_routes()
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin, 'admin')->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee(route('admin.students'));
        $response->assertSee(route('admin.companies'));
        $response->assertSee(route('admin.jobs'));
        $response->assertSee(route('admin.applications'));
    }

    public function test_dashboard_renders_pending_company_approvals_with_quick_action()
    {
        $admin = $this->createAdmin();

        $pendingCompany = $this->createCompany([
            'company_name' => 'Pending Startup Ltd',
            'owner_name'   => 'Alex Founder',
            'is_approved'  => false,
        ]);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Pending Startup Ltd');
        $response->assertSee('Alex Founder');
        $response->assertSee(route('admin.companies.approve', $pendingCompany->id));
    }

    public function test_dashboard_renders_recent_jobs_and_recent_applications()
    {
        $admin = $this->createAdmin();
        $student = $this->createStudent(['name' => 'Dev Candidate']);
        $company = $this->createCompany(['company_name' => 'Tech Corp']);
        $job = $this->createJob($company, ['job_title' => 'Senior Laravel Engineer']);
        $application = $this->createJobApplication($student, $job, ['status' => 'Shortlisted']);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Senior Laravel Engineer');
        $response->assertSee('Tech Corp');
        $response->assertSee('Dev Candidate');
        $response->assertSee('Shortlisted');
        $response->assertSee(route('admin.jobs.show', $job->id));
        $response->assertSee(route('admin.applications.show', $application->id));
    }
}
