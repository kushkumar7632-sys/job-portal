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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminApplicationManagementTest extends TestCase
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

    public function test_guest_cannot_access_admin_application_routes()
    {
        $company = $this->createCompany();
        $job = $this->createJob($company);
        $student = $this->createStudent();
        $application = $this->createJobApplication($student, $job);

        $this->get(route('admin.applications'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.applications.show', $application->id))->assertRedirect(route('admin.login'));
        $this->delete(route('admin.applications.delete', $application->id))->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_view_paginated_applications()
    {
        $admin = $this->createAdmin();
        $company = $this->createCompany();
        $job = $this->createJob($company);

        for ($i = 0; $i < 15; $i++) {
            $student = $this->createStudent();
            $this->createJobApplication($student, $job);
        }

        $response = $this->actingAs($admin, 'admin')->get(route('admin.applications'));

        $response->assertStatus(200);
        $response->assertViewHas('applications');
        $applications = $response->viewData('applications');
        $this->assertEquals(10, $applications->perPage());
        $this->assertEquals(15, $applications->total());
    }

    public function test_admin_can_search_applications_by_student_name()
    {
        $admin = $this->createAdmin();
        $company = $this->createCompany();
        $job = $this->createJob($company);

        $studentTarget = $this->createStudent(['name' => 'Alexander Montgomery']);
        $studentOther  = $this->createStudent(['name' => 'Samantha Collins']);

        $targetApp = $this->createJobApplication($studentTarget, $job);
        $otherApp  = $this->createJobApplication($studentOther, $job);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.applications', ['search' => 'Alexander']));

        $response->assertStatus(200);
        $response->assertSee('Alexander Montgomery');
        $response->assertDontSee('Samantha Collins');
    }

    public function test_admin_can_search_applications_by_student_email()
    {
        $admin = $this->createAdmin();
        $company = $this->createCompany();
        $job = $this->createJob($company);

        $studentTarget = $this->createStudent(['name' => 'Target Candidate', 'email' => 'unique.target@example.com']);
        $studentOther  = $this->createStudent(['name' => 'Other Candidate', 'email' => 'other.person@example.com']);

        $targetApp = $this->createJobApplication($studentTarget, $job);
        $otherApp  = $this->createJobApplication($studentOther, $job);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.applications', ['search' => 'unique.target']));

        $response->assertStatus(200);
        $response->assertSee('unique.target@example.com');
        $response->assertDontSee('other.person@example.com');
    }

    public function test_admin_can_search_applications_by_job_title()
    {
        $admin = $this->createAdmin();
        $company = $this->createCompany();

        $jobTarget = $this->createJob($company, ['job_title' => 'Kubernetes Infrastructure Specialist']);
        $jobOther  = $this->createJob($company, ['job_title' => 'WordPress Content Editor']);

        $studentA = $this->createStudent(['name' => 'Candidate Alpha']);
        $studentB = $this->createStudent(['name' => 'Candidate Beta']);

        $this->createJobApplication($studentA, $jobTarget);
        $this->createJobApplication($studentB, $jobOther);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.applications', ['search' => 'Kubernetes']));

        $response->assertStatus(200);
        $response->assertSee('Kubernetes Infrastructure Specialist');
        $response->assertSee('Candidate Alpha');
        $response->assertDontSee('WordPress Content Editor');
        $response->assertDontSee('Candidate Beta');
    }

    public function test_admin_can_search_applications_by_company_name()
    {
        $admin = $this->createAdmin();
        $companyA = $this->createCompany(['company_name' => 'Solaris Dynamics Group']);
        $companyB = $this->createCompany(['company_name' => 'Pinnacle Health Systems']);

        $jobA = $this->createJob($companyA, ['job_title' => 'Solar Panel Technician']);
        $jobB = $this->createJob($companyB, ['job_title' => 'Clinical Nurse Specialist']);

        $studentA = $this->createStudent(['name' => 'Solar Applicant']);
        $studentB = $this->createStudent(['name' => 'Health Applicant']);

        $this->createJobApplication($studentA, $jobA);
        $this->createJobApplication($studentB, $jobB);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.applications', ['search' => 'Solaris Dynamics']));

        $response->assertStatus(200);
        $response->assertSee('Solaris Dynamics Group');
        $response->assertSee('Solar Applicant');
        $response->assertDontSee('Pinnacle Health Systems');
        $response->assertDontSee('Health Applicant');
    }

    public function test_admin_can_filter_applications_by_all_supported_statuses()
    {
        $admin = $this->createAdmin();
        $company = $this->createCompany();
        $job = $this->createJob($company);

        $studentPending     = $this->createStudent(['name' => 'Pending Student']);
        $studentShortlisted = $this->createStudent(['name' => 'Shortlisted Student']);
        $studentSelected    = $this->createStudent(['name' => 'Selected Student']);
        $studentRejected    = $this->createStudent(['name' => 'Rejected Student']);

        $this->createJobApplication($studentPending, $job, ['status' => 'Pending']);
        $this->createJobApplication($studentShortlisted, $job, ['status' => 'Shortlisted']);
        $this->createJobApplication($studentSelected, $job, ['status' => 'Selected']);
        $this->createJobApplication($studentRejected, $job, ['status' => 'Rejected']);

        // 1. Pending filter
        $responsePending = $this->actingAs($admin, 'admin')->get(route('admin.applications', ['status' => 'Pending']));
        $responsePending->assertStatus(200);
        $responsePending->assertSee('Pending Student');
        $responsePending->assertDontSee('Shortlisted Student');
        $responsePending->assertDontSee('Selected Student');
        $responsePending->assertDontSee('Rejected Student');

        // 2. Shortlisted filter
        $responseShortlisted = $this->actingAs($admin, 'admin')->get(route('admin.applications', ['status' => 'Shortlisted']));
        $responseShortlisted->assertStatus(200);
        $responseShortlisted->assertSee('Shortlisted Student');
        $responseShortlisted->assertDontSee('Pending Student');
        $responseShortlisted->assertDontSee('Selected Student');
        $responseShortlisted->assertDontSee('Rejected Student');

        // 3. Selected filter
        $responseSelected = $this->actingAs($admin, 'admin')->get(route('admin.applications', ['status' => 'Selected']));
        $responseSelected->assertStatus(200);
        $responseSelected->assertSee('Selected Student');
        $responseSelected->assertDontSee('Pending Student');
        $responseSelected->assertDontSee('Shortlisted Student');
        $responseSelected->assertDontSee('Rejected Student');

        // 4. Rejected filter
        $responseRejected = $this->actingAs($admin, 'admin')->get(route('admin.applications', ['status' => 'Rejected']));
        $responseRejected->assertStatus(200);
        $responseRejected->assertSee('Rejected Student');
        $responseRejected->assertDontSee('Pending Student');
        $responseRejected->assertDontSee('Shortlisted Student');
        $responseRejected->assertDontSee('Selected Student');
    }

    public function test_query_parameters_persist_across_pagination()
    {
        $admin = $this->createAdmin();
        $company = $this->createCompany();
        $job = $this->createJob($company, ['job_title' => 'Persistent Query Job']);

        for ($i = 0; $i < 15; $i++) {
            $student = $this->createStudent(['name' => "Special Candidate {$i}"]);
            $this->createJobApplication($student, $job, ['status' => 'Pending']);
        }

        $response = $this->actingAs($admin, 'admin')->get(route('admin.applications', [
            'search' => 'Special',
            'status' => 'Pending',
        ]));

        $response->assertStatus(200);
        $paginator = $response->viewData('applications');
        $nextPageUrl = $paginator->nextPageUrl();

        $this->assertNotNull($nextPageUrl);
        $this->assertStringContainsString('search=Special', $nextPageUrl);
        $this->assertStringContainsString('status=Pending', $nextPageUrl);
    }

    public function test_accurate_application_statistics_are_computed()
    {
        $admin = $this->createAdmin();
        $company = $this->createCompany();
        $job = $this->createJob($company);

        // 3 Pending, 2 Shortlisted, 1 Selected, 2 Rejected = 8 Total
        for ($i = 0; $i < 3; $i++) {
            $student = $this->createStudent();
            $this->createJobApplication($student, $job, ['status' => 'Pending']);
        }
        for ($i = 0; $i < 2; $i++) {
            $student = $this->createStudent();
            $this->createJobApplication($student, $job, ['status' => 'Shortlisted']);
        }
        for ($i = 0; $i < 1; $i++) {
            $student = $this->createStudent();
            $this->createJobApplication($student, $job, ['status' => 'Selected']);
        }
        for ($i = 0; $i < 2; $i++) {
            $student = $this->createStudent();
            $this->createJobApplication($student, $job, ['status' => 'Rejected']);
        }

        $response = $this->actingAs($admin, 'admin')->get(route('admin.applications'));

        $response->assertStatus(200);
        $this->assertEquals(8, $response->viewData('totalApplicationsCount'));
        $this->assertEquals(3, $response->viewData('pendingCount'));
        $this->assertEquals(2, $response->viewData('shortlistedCount'));
        $this->assertEquals(1, $response->viewData('selectedCount'));
        $this->assertEquals(2, $response->viewData('rejectedCount'));
    }

    public function test_application_details_shows_correct_relationships()
    {
        $admin = $this->createAdmin();
        $company = $this->createCompany([
            'company_name' => 'Apex Cloud Inc',
            'owner_name'   => 'Sarah Connor',
            'email'        => 'sarah@apexcloud.com',
            'industry'     => 'Cloud Platforms',
        ]);

        $job = $this->createJob($company, [
            'job_title' => 'Senior Infrastructure Architect',
            'location'  => 'Austin, TX',
            'job_type'  => 'Full Time',
            'salary'    => '$180,000',
        ]);

        $student = $this->createStudent([
            'name'  => 'David Miller',
            'email' => 'david.miller@example.com',
            'phone' => '9876543210',
        ]);

        $application = $this->createJobApplication($student, $job, [
            'status' => 'Shortlisted',
            'resume' => 'resumes/david_miller_resume.pdf',
        ]);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.applications.show', $application->id));

        $response->assertStatus(200);

        // Candidate details
        $response->assertSee('David Miller');
        $response->assertSee('david.miller@example.com');
        $response->assertSee('9876543210');
        $response->assertSee(route('admin.students.show', $student->id));

        // Job details
        $response->assertSee('Senior Infrastructure Architect');
        $response->assertSee('Austin, TX');
        $response->assertSee('Full Time');
        $response->assertSee('$180,000');
        $response->assertSee(route('admin.jobs.show', $job->id));

        // Company details
        $response->assertSee('Apex Cloud Inc');
        $response->assertSee('Sarah Connor');
        $response->assertSee('sarah@apexcloud.com');
        $response->assertSee('Cloud Platforms');
        $response->assertSee(route('admin.companies.show', $company->id));

        // Status
        $response->assertSee('Shortlisted');
    }

    public function test_application_details_does_not_expose_other_application_records()
    {
        $admin = $this->createAdmin();
        $company = $this->createCompany();
        $job = $this->createJob($company);

        $studentA = $this->createStudent(['name' => 'Candidate Alpha', 'email' => 'alpha@exclusive.com']);
        $studentB = $this->createStudent(['name' => 'Candidate Beta', 'email' => 'beta@unrelated.com']);

        $appA = $this->createJobApplication($studentA, $job);
        $appB = $this->createJobApplication($studentB, $job);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.applications.show', $appA->id));

        $response->assertStatus(200);
        $response->assertSee('Candidate Alpha');
        $response->assertSee('alpha@exclusive.com');

        // Other candidate's application info must NOT appear
        $response->assertDontSee('Candidate Beta');
        $response->assertDontSee('beta@unrelated.com');
    }

    public function test_resume_links_use_protected_download_route_and_never_expose_raw_storage_paths()
    {
        $admin = $this->createAdmin();
        $company = $this->createCompany();
        $job = $this->createJob($company);
        $student = $this->createStudent();

        $rawResumePath = 'resumes/super_confidential_student_resume_123.pdf';
        $application = $this->createJobApplication($student, $job, ['resume' => $rawResumePath]);

        // 1. Index page check
        $indexResponse = $this->actingAs($admin, 'admin')->get(route('admin.applications'));
        $indexResponse->assertStatus(200);
        $expectedUrl = route('applications.resume.download', $application->id);
        $indexResponse->assertSee($expectedUrl);
        $indexResponse->assertDontSee($rawResumePath);

        // 2. Show page check
        $showResponse = $this->actingAs($admin, 'admin')->get(route('admin.applications.show', $application->id));
        $showResponse->assertStatus(200);
        $showResponse->assertSee($expectedUrl);
        $showResponse->assertDontSee($rawResumePath);
    }

    public function test_application_deletion_removes_record_and_cleans_up_unique_physical_resume_file()
    {
        Storage::fake('local');

        $admin = $this->createAdmin();
        $company = $this->createCompany();
        $job = $this->createJob($company);
        $student = $this->createStudent();

        $resumePath = 'resumes/unique_candidate_resume.pdf';
        Storage::disk('local')->put($resumePath, 'Resume binary content');
        Storage::disk('local')->assertExists($resumePath);

        $application = $this->createJobApplication($student, $job, ['resume' => $resumePath]);

        $response = $this->actingAs($admin, 'admin')->delete(route('admin.applications.delete', $application->id));

        $response->assertRedirect(route('admin.applications'));
        $response->assertSessionHas('success', 'Application deleted successfully.');

        // Record removed from database
        $this->assertDatabaseMissing('applications', ['id' => $application->id]);

        // File cleaned up from private disk
        Storage::disk('local')->assertMissing($resumePath);
    }

    public function test_shared_resume_file_is_preserved_when_one_application_is_deleted()
    {
        Storage::fake('local');

        $admin = $this->createAdmin();
        $company = $this->createCompany();
        $job1 = $this->createJob($company);
        $job2 = $this->createJob($company);

        $student1 = $this->createStudent();
        $student2 = $this->createStudent();

        $sharedResumePath = 'resumes/shared_resume_master.pdf';
        Storage::disk('local')->put($sharedResumePath, 'Shared resume document bytes');
        Storage::disk('local')->assertExists($sharedResumePath);

        $app1 = $this->createJobApplication($student1, $job1, ['resume' => $sharedResumePath]);
        $app2 = $this->createJobApplication($student2, $job2, ['resume' => $sharedResumePath]);

        // Delete App 1
        $response = $this->actingAs($admin, 'admin')->delete(route('admin.applications.delete', $app1->id));

        $response->assertRedirect(route('admin.applications'));
        $this->assertDatabaseMissing('applications', ['id' => $app1->id]);
        $this->assertDatabaseHas('applications', ['id' => $app2->id]);

        // CRITICAL GUARD: Shared resume file must NOT be deleted because App 2 still references it!
        Storage::disk('local')->assertExists($sharedResumePath);

        // Now delete App 2 (last remaining reference)
        $this->actingAs($admin, 'admin')->delete(route('admin.applications.delete', $app2->id));

        $this->assertDatabaseMissing('applications', ['id' => $app2->id]);
        // Now that no references remain, file should be cleaned up
        Storage::disk('local')->assertMissing($sharedResumePath);
    }

    public function test_missing_physical_resume_file_is_handled_gracefully_during_deletion()
    {
        Storage::fake('local');

        $admin = $this->createAdmin();
        $company = $this->createCompany();
        $job = $this->createJob($company);
        $student = $this->createStudent();

        $missingPath = 'resumes/ghost_file_that_does_not_exist.pdf';
        // Do NOT create the file in storage
        $application = $this->createJobApplication($student, $job, ['resume' => $missingPath]);

        $response = $this->actingAs($admin, 'admin')->delete(route('admin.applications.delete', $application->id));

        $response->assertRedirect(route('admin.applications'));
        $response->assertSessionHas('success', 'Application deleted successfully.');

        // Deletion completes without error
        $this->assertDatabaseMissing('applications', ['id' => $application->id]);
    }

    public function test_failed_database_deletion_preserves_the_physical_resume_file()
    {
        Storage::fake('local');

        $admin = $this->createAdmin();
        $company = $this->createCompany();
        $job = $this->createJob($company);
        $student = $this->createStudent();

        $resumePath = 'resumes/preserve_on_db_failure.pdf';
        Storage::disk('local')->put($resumePath, 'Important private resume bytes');
        Storage::disk('local')->assertExists($resumePath);

        $application = $this->createJobApplication($student, $job, ['resume' => $resumePath]);

        // Hook into deleting model event to simulate a database failure/exception during deletion
        Application::deleting(function () {
            throw new \RuntimeException('Simulated database deadlock or query failure');
        });

        try {
            $this->actingAs($admin, 'admin')->delete(route('admin.applications.delete', $application->id));
        } catch (\RuntimeException $e) {
            // Expected exception caught
        }

        // SAFETY VERIFICATION: Both database record and physical file must be preserved
        $this->assertDatabaseHas('applications', ['id' => $application->id]);
        Storage::disk('local')->assertExists($resumePath);
    }

    public function test_non_existent_application_id_returns_404_for_show_and_delete()
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin, 'admin')
            ->get(route('admin.applications.show', 999999))
            ->assertStatus(404);

        $this->actingAs($admin, 'admin')
            ->delete(route('admin.applications.delete', 999999))
            ->assertStatus(404);
    }

    public function test_admin_views_extend_master_layout_and_display_consistent_elements()
    {
        $admin = $this->createAdmin();
        $company = $this->createCompany();
        $job = $this->createJob($company);
        $student = $this->createStudent();
        $application = $this->createJobApplication($student, $job);

        // Index page check
        $indexResponse = $this->actingAs($admin, 'admin')->get(route('admin.applications'));
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('Application Management');
        $indexResponse->assertSee('Application Records');
        $indexResponse->assertSee('Search by student name, email, job title, or company...');
        $indexResponse->assertSee('confirm(\'Are you sure you want to delete this application record?', false);

        // Show page check
        $showResponse = $this->actingAs($admin, 'admin')->get(route('admin.applications.show', $application->id));
        $showResponse->assertStatus(200);
        $showResponse->assertSee('Back to Applications');
        $showResponse->assertSee('Candidate Information');
        $showResponse->assertSee('Job Posting Information');
        $showResponse->assertSee('Employer Information');
        $showResponse->assertSee('confirm(\'Are you sure you want to delete this application record?', false);
    }
}
