<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Admin;
use App\Models\Company;
use App\Models\Job;
use App\Models\Student;
use App\Models\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminJobManagementTest extends TestCase
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

    private function createCompany(array $attributes = []): Company
    {
        return Company::create(array_merge([
            'company_name' => 'Acme Global ' . Str::random(4),
            'owner_name'   => 'John Owner',
            'email'        => strtolower('company_' . Str::random(5) . '@example.com'),
            'phone'        => '9' . str_pad((string) mt_rand(100000000, 999999999), 9, '0', STR_PAD_LEFT),
            'website'      => 'https://example.com',
            'industry'     => 'Information Technology',
            'address'      => '100 Silicon Way, Tech City',
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
            'salary'      => '$110,000',
            'experience'  => '2+ Years',
            'vacancy'     => 2,
            'description' => 'Engineering job role description.',
            'deadline'    => now()->addDays(14)->toDateString(),
            'status'      => true,
        ], $attributes));
    }

    private function createStudent(array $attributes = []): Student
    {
        return Student::create(array_merge([
            'name'     => 'Candidate ' . Str::random(4),
            'email'    => strtolower('student_' . Str::random(5) . '@example.com'),
            'phone'    => '9' . str_pad((string) mt_rand(100000000, 999999999), 9, '0', STR_PAD_LEFT),
            'password' => Hash::make('secret123'),
        ], $attributes));
    }

    private function createJobApplication(Student $student, Job $job, array $attributes = []): Application
    {
        return Application::create(array_merge([
            'student_id' => $student->id,
            'job_id'     => $job->id,
            'status'     => 'Pending',
            'resume'     => 'resumes/sample_candidate_resume.pdf',
        ], $attributes));
    }

    public function test_guest_cannot_access_job_management_routes()
    {
        $company = $this->createCompany();
        $job = $this->createJob($company);

        $this->get(route('admin.jobs'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.jobs.show', $job->id))->assertRedirect(route('admin.login'));
        $this->delete(route('admin.jobs.delete', $job->id))->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_view_paginated_jobs_list()
    {
        $admin = $this->createAdmin();
        $company = $this->createCompany();

        for ($i = 0; $i < 15; $i++) {
            $this->createJob($company, ['job_title' => "Role Number {$i}"]);
        }

        $response = $this->actingAs($admin, 'admin')->get(route('admin.jobs'));

        $response->assertStatus(200);
        $response->assertViewHas('jobs');
        $jobs = $response->viewData('jobs');
        $this->assertEquals(10, $jobs->perPage());
        $this->assertEquals(15, $jobs->total());
    }

    public function test_admin_can_search_jobs_by_title()
    {
        $admin = $this->createAdmin();
        $company = $this->createCompany();

        $target = $this->createJob($company, ['job_title' => 'Senior Rust Systems Architect']);
        $other  = $this->createJob($company, ['job_title' => 'Junior React Frontend Developer']);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.jobs', ['search' => 'Rust Systems']));

        $response->assertStatus(200);
        $response->assertSee('Senior Rust Systems Architect');
        $response->assertDontSee('Junior React Frontend Developer');
    }

    public function test_admin_can_search_jobs_by_location()
    {
        $admin = $this->createAdmin();
        $company = $this->createCompany();

        $target = $this->createJob($company, [
            'job_title' => 'Backend Developer',
            'location'  => 'Bengaluru Cyber City',
        ]);
        $other  = $this->createJob($company, [
            'job_title' => 'Cloud Engineer',
            'location'  => 'San Francisco Financial District',
        ]);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.jobs', ['search' => 'Bengaluru']));

        $response->assertStatus(200);
        $response->assertSee('Bengaluru Cyber City');
        $response->assertDontSee('San Francisco Financial District');
    }

    public function test_admin_can_search_jobs_by_company_name()
    {
        $admin = $this->createAdmin();
        $companyA = $this->createCompany(['company_name' => 'Acme Robotics International']);
        $companyB = $this->createCompany(['company_name' => 'Zeta Media Group']);

        $jobA = $this->createJob($companyA, ['job_title' => 'Robotics Engineer']);
        $jobB = $this->createJob($companyB, ['job_title' => 'Video Editor']);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.jobs', ['search' => 'Acme Robotics']));

        $response->assertStatus(200);
        $response->assertSee('Acme Robotics International');
        $response->assertSee('Robotics Engineer');
        $response->assertDontSee('Zeta Media Group');
    }

    public function test_admin_can_filter_jobs_by_active_status()
    {
        $admin = $this->createAdmin();
        $company = $this->createCompany();

        $activeJob = $this->createJob($company, [
            'job_title' => 'Active Opportunity',
            'status'    => true,
            'deadline'  => now()->addDays(10)->toDateString(),
        ]);
        $expiredJob = $this->createJob($company, [
            'job_title' => 'Expired Opportunity',
            'status'    => true,
            'deadline'  => now()->subDays(5)->toDateString(),
        ]);
        $closedJob = $this->createJob($company, [
            'job_title' => 'Closed Opportunity',
            'status'    => false,
            'deadline'  => now()->addDays(10)->toDateString(),
        ]);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.jobs', ['status' => 'active']));

        $response->assertStatus(200);
        $response->assertSee('Active Opportunity');
        $response->assertDontSee('Expired Opportunity');
        $response->assertDontSee('Closed Opportunity');
    }

    public function test_admin_can_filter_jobs_by_expired_status()
    {
        $admin = $this->createAdmin();
        $company = $this->createCompany();

        $activeJob = $this->createJob($company, [
            'job_title' => 'Active Posting',
            'status'    => true,
            'deadline'  => now()->addDays(10)->toDateString(),
        ]);
        $expiredJob = $this->createJob($company, [
            'job_title' => 'Expired Posting',
            'status'    => true,
            'deadline'  => now()->subDays(5)->toDateString(),
        ]);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.jobs', ['status' => 'expired']));

        $response->assertStatus(200);
        $response->assertSee('Expired Posting');
        $response->assertDontSee('Active Posting');
    }

    public function test_admin_can_filter_jobs_by_closed_status()
    {
        $admin = $this->createAdmin();
        $company = $this->createCompany();

        $closedJob = $this->createJob($company, [
            'job_title' => 'Closed Posting',
            'status'    => false,
            'deadline'  => now()->addDays(10)->toDateString(),
        ]);
        $activeJob = $this->createJob($company, [
            'job_title' => 'Open Posting',
            'status'    => true,
            'deadline'  => now()->addDays(10)->toDateString(),
        ]);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.jobs', ['status' => 'closed']));

        $response->assertStatus(200);
        $response->assertSee('Closed Posting');
        $response->assertDontSee('Open Posting');
    }

    public function test_query_parameters_persist_across_pagination()
    {
        $admin = $this->createAdmin();
        $company = $this->createCompany();

        for ($i = 0; $i < 15; $i++) {
            $this->createJob($company, [
                'job_title' => "Specialist Architect {$i}",
                'status'    => true,
                'deadline'  => now()->addDays(10)->toDateString(),
            ]);
        }

        $response = $this->actingAs($admin, 'admin')->get(route('admin.jobs', [
            'search' => 'Architect',
            'status' => 'active',
        ]));

        $response->assertStatus(200);
        $paginator = $response->viewData('jobs');
        $nextPageUrl = $paginator->nextPageUrl();

        $this->assertNotNull($nextPageUrl);
        $this->assertStringContainsString('search=Architect', $nextPageUrl);
        $this->assertStringContainsString('status=active', $nextPageUrl);
    }

    public function test_accurate_application_counts_are_computed_for_jobs()
    {
        $admin = $this->createAdmin();
        $company = $this->createCompany();
        $jobWithApps = $this->createJob($company, ['job_title' => 'High Demand Job']);
        $jobZeroApps = $this->createJob($company, ['job_title' => 'New Low Demand Job']);

        $student1 = $this->createStudent();
        $student2 = $this->createStudent();
        $student3 = $this->createStudent();

        $this->createJobApplication($student1, $jobWithApps);
        $this->createJobApplication($student2, $jobWithApps);
        $this->createJobApplication($student3, $jobWithApps);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.jobs'));

        $response->assertStatus(200);
        $jobs = $response->viewData('jobs');

        $jobWithAppsRecord = $jobs->firstWhere('id', $jobWithApps->id);
        $jobZeroAppsRecord = $jobs->firstWhere('id', $jobZeroApps->id);

        $this->assertEquals(3, $jobWithAppsRecord->applications_count);
        $this->assertEquals(0, $jobZeroAppsRecord->applications_count);

        $response->assertSee('3 applicants');
        $response->assertSee('0 applicants');
    }

    public function test_job_details_displays_correct_job_and_company_information()
    {
        $admin = $this->createAdmin();
        $company = $this->createCompany([
            'company_name' => 'Apex Cloud Inc',
            'owner_name'   => 'Sarah Connor',
            'email'        => 'sarah@apexcloud.com',
            'industry'     => 'Cloud Infrastructure',
        ]);

        $job = $this->createJob($company, [
            'job_title'   => 'Lead Site Reliability Engineer',
            'job_type'    => 'Full Time',
            'location'    => 'Austin, TX',
            'salary'      => '$160,000 - $180,000',
            'experience'  => '5+ Years',
            'vacancy'     => 4,
            'description' => 'Manage multi-region Kubernetes clusters.',
            'deadline'    => now()->addDays(20)->toDateString(),
            'status'      => true,
        ]);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.jobs.show', $job->id));

        $response->assertStatus(200);
        $response->assertSee('Lead Site Reliability Engineer');
        $response->assertSee('Full Time');
        $response->assertSee('Austin, TX');
        $response->assertSee('$160,000 - $180,000');
        $response->assertSee('5+ Years');
        $response->assertSee('4');
        $response->assertSee('Manage multi-region Kubernetes clusters.');

        // Company Details
        $response->assertSee('Apex Cloud Inc');
        $response->assertSee('Sarah Connor');
        $response->assertSee('sarah@apexcloud.com');
        $response->assertSee('Cloud Infrastructure');
        $response->assertSee(route('admin.companies.show', $company->id));
    }

    public function test_application_history_belongs_strictly_to_the_selected_job()
    {
        $admin = $this->createAdmin();
        $company = $this->createCompany();

        $targetJob = $this->createJob($company, ['job_title' => 'Target Position']);
        $otherJob  = $this->createJob($company, ['job_title' => 'Unrelated Position']);

        $candidateA = $this->createStudent(['name' => 'Alice Walker', 'email' => 'alice@walker.com']);
        $candidateB = $this->createStudent(['name' => 'Bob Builder', 'email' => 'bob@builder.com']);

        $this->createJobApplication($candidateA, $targetJob, ['status' => 'Shortlisted']);
        $this->createJobApplication($candidateB, $otherJob, ['status' => 'Pending']);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.jobs.show', $targetJob->id));

        $response->assertStatus(200);
        $response->assertSee('Alice Walker');
        $response->assertSee('alice@walker.com');
        $response->assertSee('Shortlisted');

        // Other job's candidate must NOT appear on this job's application list
        $response->assertDontSee('Bob Builder');
        $response->assertDontSee('bob@builder.com');
    }

    public function test_resume_download_link_uses_secure_download_route()
    {
        $admin = $this->createAdmin();
        $company = $this->createCompany();
        $job = $this->createJob($company);
        $student = $this->createStudent();

        $application = $this->createJobApplication($student, $job, [
            'resume' => 'resumes/confidential_candidate_resume.pdf',
        ]);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.jobs.show', $job->id));

        $response->assertStatus(200);
        $expectedDownloadUrl = route('applications.resume.download', $application->id);
        $response->assertSee($expectedDownloadUrl);
        $response->assertDontSee('resumes/confidential_candidate_resume.pdf');
    }

    public function test_job_with_applications_cannot_be_deleted_and_records_are_preserved()
    {
        $admin = $this->createAdmin();
        $company = $this->createCompany();
        $job = $this->createJob($company, ['job_title' => 'Protected Job Posting']);
        $student = $this->createStudent();
        $application = $this->createJobApplication($student, $job);

        $response = $this->actingAs($admin, 'admin')->delete(route('admin.jobs.delete', $job->id));

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertStringContainsString('Cannot delete job posting because', session('error'));

        // STRICT SAFETY CHECK: Both job and application records must remain in database
        $this->assertDatabaseHas('jobs', ['id' => $job->id]);
        $this->assertDatabaseHas('applications', ['id' => $application->id]);
    }

    public function test_job_without_applications_can_be_deleted_safely()
    {
        $admin = $this->createAdmin();
        $company = $this->createCompany();
        $job = $this->createJob($company, ['job_title' => 'Removable Job Posting']);

        $response = $this->actingAs($admin, 'admin')->delete(route('admin.jobs.delete', $job->id));

        $response->assertRedirect(route('admin.jobs'));
        $response->assertSessionHas('success', 'Job posting deleted successfully.');

        // Job should be deleted from database
        $this->assertDatabaseMissing('jobs', ['id' => $job->id]);
    }

    public function test_non_existent_job_id_returns_404_for_show_and_delete()
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin, 'admin')
            ->get(route('admin.jobs.show', 999999))
            ->assertStatus(404);

        $this->actingAs($admin, 'admin')
            ->delete(route('admin.jobs.delete', 999999))
            ->assertStatus(404);
    }

    public function test_admin_views_extend_master_layout_and_display_consistent_elements()
    {
        $admin = $this->createAdmin();
        $company = $this->createCompany();
        $job = $this->createJob($company, ['job_title' => 'Master Layout UI Job']);

        // Index page check
        $indexResponse = $this->actingAs($admin, 'admin')->get(route('admin.jobs'));
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('Job Management');
        $indexResponse->assertSee('Total Jobs');
        $indexResponse->assertSee('Active Jobs');
        $indexResponse->assertSee('Expired Jobs');
        $indexResponse->assertSee('Applications');
        $indexResponse->assertSee('Search by job title, company name, or location...');
        $indexResponse->assertSee('Master Layout UI Job');
        $indexResponse->assertSee('confirm(\'Are you sure you want to delete this job posting?', false);

        // Show page check
        $showResponse = $this->actingAs($admin, 'admin')->get(route('admin.jobs.show', $job->id));
        $showResponse->assertStatus(200);
        $showResponse->assertSee('Back to Job Management');
        $showResponse->assertSee('Employer Details');
        $showResponse->assertSee('Job Description & Requirements', false);
        $showResponse->assertSee('Candidate Applications');
        $showResponse->assertSee('No Candidate Applications Yet');
    }
}
