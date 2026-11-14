<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Company;
use App\Models\Job;
use App\Models\Student;
use App\Models\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CompanyJobManagementTest extends TestCase
{
    use RefreshDatabase;

    private function createCompany(array $attributes = []): Company
    {
        return Company::create(array_merge([
            'company_name' => 'Acme Corporation',
            'owner_name'   => 'Jane Owner',
            'email'        => strtolower('company_' . Str::random(8) . '@example.com'),
            'phone'        => '9' . str_pad((string) mt_rand(100000000, 999999999), 9, '0', STR_PAD_LEFT),
            'website'      => 'https://acme.example.com',
            'industry'     => 'Software & Technology',
            'address'      => '100 Silicon Way, Tech City',
            'password'     => Hash::make('secret1234'),
            'is_approved'  => true,
        ], $attributes));
    }

    private function createStudent(array $attributes = []): Student
    {
        return Student::create(array_merge([
            'name'     => 'Alice Student',
            'email'    => strtolower('student_' . Str::random(8) . '@example.com'),
            'phone'    => '9' . str_pad((string) mt_rand(100000000, 999999999), 9, '0', STR_PAD_LEFT),
            'password' => Hash::make('secret1234'),
        ], $attributes));
    }

    private function createJob(Company $company, array $attributes = []): Job
    {
        return Job::create(array_merge([
            'company_id'  => $company->id,
            'job_title'   => 'Senior Software Engineer',
            'job_type'    => 'Full Time',
            'location'    => 'Remote',
            'salary'      => '120,000 - 140,000 USD',
            'experience'  => '3+ Years',
            'vacancy'     => 2,
            'description' => 'Build high-performance web applications and APIs.',
            'deadline'    => now()->addDays(30)->toDateString(),
            'status'      => true,
        ], $attributes));
    }

    private function createJobApplication(Student $student, Job $job, array $attributes = []): Application
    {
        return Application::create(array_merge([
            'student_id' => $student->id,
            'job_id'     => $job->id,
            'resume'     => 'resumes/sample_' . Str::random(8) . '.pdf',
            'status'     => 'Pending',
        ], $attributes));
    }

    // 1. Guest cannot access job-management routes
    public function test_guest_cannot_access_job_management_routes(): void
    {
        $company = $this->createCompany();
        $job = $this->createJob($company);

        $this->get(route('company.jobs'))->assertRedirect('/company/login');
        $this->get(route('company.job.create'))->assertRedirect('/company/login');
        $this->post(route('company.job.store'), ['job_title' => 'Test'])->assertRedirect('/company/login');
        $this->get(route('job.edit', $job->id))->assertRedirect('/company/login');
        $this->put(route('job.update', $job->id), ['job_title' => 'Test'])->assertRedirect('/company/login');
        $this->delete(route('job.delete', $job->id))->assertRedirect('/company/login');
    }

    // 2. Unapproved company cannot access job-management routes
    public function test_unapproved_company_cannot_access_job_management_routes(): void
    {
        $unapprovedCompany = $this->createCompany(['is_approved' => false]);
        $job = $this->createJob($unapprovedCompany);

        $responseIndex = $this->withSession(['company_id' => $unapprovedCompany->id])
            ->get(route('company.jobs'));
        $responseIndex->assertRedirect('/company/login');

        $responseEdit = $this->withSession(['company_id' => $unapprovedCompany->id])
            ->get(route('job.edit', $job->id));
        $responseEdit->assertRedirect('/company/login');
    }

    // 3. Company can view its own jobs
    public function test_company_can_view_own_jobs(): void
    {
        $companyA = $this->createCompany(['company_name' => 'Company A']);
        $companyB = $this->createCompany(['company_name' => 'Company B']);

        $jobA = $this->createJob($companyA, ['job_title' => 'Frontend Architect']);
        $jobB = $this->createJob($companyB, ['job_title' => 'Backend Specialist']);

        $response = $this->withSession(['company_id' => $companyA->id])
            ->get(route('company.jobs'));

        $response->assertStatus(200);
        $response->assertViewIs('company.jobs.index');
        $response->assertSee('Frontend Architect');
        $response->assertDontSee('Backend Specialist');
    }

    // 4. Company can edit its own job
    public function test_company_can_view_edit_page_for_own_job(): void
    {
        $company = $this->createCompany();
        $job = $this->createJob($company, [
            'job_title'   => 'Cloud DevOps Lead',
            'location'    => 'Austin, TX',
            'salary'      => '130,000 USD',
            'description' => 'Architect cloud infrastructure on AWS and Kubernetes.',
        ]);

        $response = $this->withSession(['company_id' => $company->id])
            ->get(route('job.edit', $job->id));

        $response->assertStatus(200);
        $response->assertViewIs('company.jobs.edit');
        $response->assertSee('Cloud DevOps Lead');
        $response->assertSee('Austin, TX');
        $response->assertSee('130,000 USD');
        $response->assertSee('Architect cloud infrastructure on AWS and Kubernetes.');
    }

    // 5. Company cannot edit another company's job
    public function test_company_cannot_edit_another_companys_job(): void
    {
        $companyA = $this->createCompany();
        $companyB = $this->createCompany();

        $jobB = $this->createJob($companyB, ['job_title' => 'Confidential Role']);

        $response = $this->withSession(['company_id' => $companyA->id])
            ->get(route('job.edit', $jobB->id));

        $response->assertStatus(404);
    }

    // 6. Company can update its own job
    public function test_company_can_update_own_job(): void
    {
        $company = $this->createCompany();
        $job = $this->createJob($company, [
            'job_title' => 'Old Title',
            'location'  => 'Old Location',
        ]);

        $response = $this->withSession(['company_id' => $company->id])
            ->put(route('job.update', $job->id), [
                'job_title'   => 'Principal Engineer',
                'job_type'    => 'Full Time',
                'location'    => 'San Francisco, CA',
                'salary'      => '160,000 - 180,000 USD',
                'experience'  => '5+ Years',
                'vacancy'     => 3,
                'description' => 'Lead technical initiatives and mentor developers.',
                'deadline'    => now()->addDays(45)->toDateString(),
                'status'      => '1',
            ]);

        $response->assertRedirect('/company/jobs');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('jobs', [
            'id'          => $job->id,
            'job_title'   => 'Principal Engineer',
            'location'    => 'San Francisco, CA',
            'salary'      => '160,000 - 180,000 USD',
            'vacancy'     => 3,
            'status'      => true,
        ]);
    }

    // 7. Company can change job status to Closed
    public function test_company_can_change_job_status_to_closed(): void
    {
        $company = $this->createCompany();
        $job = $this->createJob($company, ['status' => true]);

        $response = $this->withSession(['company_id' => $company->id])
            ->put(route('job.update', $job->id), [
                'job_title'   => $job->job_title,
                'job_type'    => $job->job_type,
                'location'    => $job->location,
                'salary'      => $job->salary,
                'experience'  => $job->experience,
                'vacancy'     => $job->vacancy,
                'description' => $job->description,
                'deadline'    => $job->deadline,
                'status'      => '0', // Closed
            ]);

        $response->assertRedirect('/company/jobs');

        $job->refresh();
        $this->assertFalse((bool) $job->status);
    }

    // 8. Closed jobs cannot accept new applications
    public function test_closed_jobs_cannot_accept_new_applications(): void
    {
        $company = $this->createCompany();
        $job = $this->createJob($company, ['status' => false]); // Closed job
        $student = $this->createStudent();

        $response = $this->withSession(['student_id' => $student->id])
            ->post(route('student.job.apply', $job->id));

        $response->assertStatus(404);

        $this->assertDatabaseMissing('applications', [
            'student_id' => $student->id,
            'job_id'     => $job->id,
        ]);
    }

    // 9. Invalid job type is rejected
    public function test_invalid_job_type_is_rejected(): void
    {
        $company = $this->createCompany();
        $job = $this->createJob($company);

        $response = $this->withSession(['company_id' => $company->id])
            ->put(route('job.update', $job->id), [
                'job_title'   => 'Software Engineer',
                'job_type'    => 'Freelance_GIG_Invalid', // Invalid type
                'location'    => 'Remote',
                'salary'      => '100k',
                'experience'  => '2 Years',
                'vacancy'     => 1,
                'description' => 'Valid long description for testing.',
                'deadline'    => now()->addDays(10)->toDateString(),
                'status'      => '1',
            ]);

        $response->assertSessionHasErrors('job_type');
    }

    // 10. Invalid vacancy is rejected
    public function test_invalid_vacancy_is_rejected(): void
    {
        $company = $this->createCompany();
        $job = $this->createJob($company);

        $response = $this->withSession(['company_id' => $company->id])
            ->put(route('job.update', $job->id), [
                'job_title'   => 'Software Engineer',
                'job_type'    => 'Full Time',
                'location'    => 'Remote',
                'salary'      => '100k',
                'experience'  => '2 Years',
                'vacancy'     => 0, // Invalid: must be >= 1
                'description' => 'Valid long description for testing.',
                'deadline'    => now()->addDays(10)->toDateString(),
                'status'      => '1',
            ]);

        $response->assertSessionHasErrors('vacancy');
    }

    // 11. Inputs are trimmed
    public function test_inputs_are_trimmed(): void
    {
        $company = $this->createCompany();
        $job = $this->createJob($company);

        $response = $this->withSession(['company_id' => $company->id])
            ->put(route('job.update', $job->id), [
                'job_title'   => '   Whitespace Title   ',
                'job_type'    => 'Part Time',
                'location'    => '   New York City   ',
                'salary'      => '   $90,000   ',
                'experience'  => '   1+ Year   ',
                'vacancy'     => 2,
                'description' => '   Description with extra surrounding whitespace   ',
                'deadline'    => now()->addDays(20)->toDateString(),
                'status'      => '1',
            ]);

        $response->assertRedirect('/company/jobs');

        $this->assertDatabaseHas('jobs', [
            'id'          => $job->id,
            'job_title'   => 'Whitespace Title',
            'location'    => 'New York City',
            'salary'      => '$90,000',
            'experience'  => '1+ Year',
            'description' => 'Description with extra surrounding whitespace',
        ]);
    }

    // 12. Company cannot tamper with company_id
    public function test_company_cannot_tamper_with_company_id(): void
    {
        $companyA = $this->createCompany(['company_name' => 'Original Owner']);
        $companyB = $this->createCompany(['company_name' => 'Target Hijack']);

        $jobA = $this->createJob($companyA);

        $this->withSession(['company_id' => $companyA->id])
            ->put(route('job.update', $jobA->id), [
                'company_id'  => $companyB->id, // Injected tampering payload
                'job_title'   => 'Legit Update',
                'job_type'    => 'Full Time',
                'location'    => 'Remote',
                'salary'      => '100k',
                'experience'  => '2 Years',
                'vacancy'     => 1,
                'description' => 'Valid description.',
                'deadline'    => now()->addDays(10)->toDateString(),
                'status'      => '1',
            ]);

        $jobA->refresh();
        $this->assertEquals($companyA->id, $jobA->company_id);
    }

    // 13. Company can delete a job with no applications
    public function test_company_can_delete_job_with_no_applications(): void
    {
        $company = $this->createCompany();
        $job = $this->createJob($company);

        $response = $this->withSession(['company_id' => $company->id])
            ->delete(route('job.delete', $job->id));

        $response->assertRedirect(route('company.jobs'));
        $response->assertSessionHas('success', 'Job deleted successfully.');

        $this->assertDatabaseMissing('jobs', [
            'id' => $job->id,
        ]);
    }

    // 14. Company cannot delete a job with existing applications
    public function test_company_cannot_delete_job_with_existing_applications(): void
    {
        $company = $this->createCompany();
        $job = $this->createJob($company);
        $student = $this->createStudent();
        $application = $this->createJobApplication($student, $job, [
            'resume' => 'resumes/critical_candidate_resume.pdf',
            'status' => 'Shortlisted',
        ]);

        $response = $this->withSession(['company_id' => $company->id])
            ->delete(route('job.delete', $job->id));

        $response->assertRedirect(route('company.jobs'));
        $response->assertSessionHas('error');

        // Job MUST remain in the database
        $this->assertDatabaseHas('jobs', [
            'id' => $job->id,
        ]);

        // Application record MUST remain in the database with status intact
        $this->assertDatabaseHas('applications', [
            'id'         => $application->id,
            'job_id'     => $job->id,
            'student_id' => $student->id,
            'resume'     => 'resumes/critical_candidate_resume.pdf',
            'status'     => 'Shortlisted',
        ]);
    }

    // 15. Company cannot delete another company's job
    public function test_company_cannot_delete_another_companys_job(): void
    {
        $companyA = $this->createCompany();
        $companyB = $this->createCompany();

        $jobB = $this->createJob($companyB);

        $response = $this->withSession(['company_id' => $companyA->id])
            ->delete(route('job.delete', $jobB->id));

        $response->assertStatus(404);

        $this->assertDatabaseHas('jobs', [
            'id' => $jobB->id,
        ]);
    }
}
