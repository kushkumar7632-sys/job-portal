<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Company;
use App\Models\Student;
use App\Models\Job;
use App\Models\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CompanyMasterLayoutTest extends TestCase
{
    use RefreshDatabase;

    private function createCompany(array $attributes = []): Company
    {
        return Company::create(array_merge([
            'company_name' => 'Acme Technologies',
            'owner_name'   => 'Alex Morgan',
            'email'        => strtolower('acme_' . Str::random(8) . '@example.com'),
            'phone'        => '9' . str_pad((string) mt_rand(100000000, 999999999), 9, '0', STR_PAD_LEFT),
            'industry'     => 'Software Engineering',
            'address'      => '100 Silicon Boulevard',
            'password'     => Hash::make('password123'),
            'is_approved'  => true,
        ], $attributes));
    }

    private function createStudent(array $attributes = []): Student
    {
        return Student::create(array_merge([
            'name'     => 'Jordan Candidate',
            'email'    => strtolower('candidate_' . Str::random(8) . '@example.com'),
            'phone'    => '9' . str_pad((string) mt_rand(100000000, 999999999), 9, '0', STR_PAD_LEFT),
            'password' => Hash::make('password123'),
        ], $attributes));
    }

    private function createJob(Company $company, array $attributes = []): Job
    {
        return Job::create(array_merge([
            'company_id'  => $company->id,
            'job_title'   => 'Full Stack Laravel Engineer',
            'job_type'    => 'Full Time',
            'location'    => 'Bengaluru, India',
            'salary'      => '12 LPA',
            'experience'  => '1-3 Years',
            'vacancy'     => 3,
            'description' => 'Work on cutting-edge Laravel applications.',
            'deadline'    => now()->addDays(20)->toDateString(),
            'status'      => true,
        ], $attributes));
    }

    public function test_company_dashboard_extends_company_master_layout(): void
    {
        $company = $this->createCompany(['company_name' => 'Acme Technologies']);

        $response = $this->withSession([
            'company_id'   => $company->id,
            'company_name' => $company->company_name,
        ])->get(route('company.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Company Dashboard - JobPortal');
        $response->assertSee('JobPortal Employer Workspace. All rights reserved.');
        $response->assertSee('Employer Dashboard');
        $response->assertSee('Workspace');
        $response->assertSee('Dashboard');
        $response->assertSee('Post New Job');
        $response->assertSee('Manage Jobs');
        $response->assertSee('Applications');
        $response->assertSee('Company Profile');
        $response->assertSee('Acme Technologies');
        $response->assertSee(route('company.logout'));
        $response->assertSee('toggleSidebar');
    }

    public function test_company_profile_extends_company_master_layout(): void
    {
        $company = $this->createCompany([
            'company_name' => 'Acme Technologies',
            'owner_name'   => 'Alex Morgan',
        ]);

        $response = $this->withSession([
            'company_id'   => $company->id,
            'company_name' => $company->company_name,
        ])->get(route('company.profile'));

        $response->assertStatus(200);
        $response->assertSee('Company Profile - JobPortal');
        $response->assertSee('JobPortal Employer Workspace. All rights reserved.');
        $response->assertSee('Acme Technologies');
        $response->assertSee('Alex Morgan');
        $response->assertSee(route('company.profile.update'));
        $response->assertSee(route('company.password.update'));
        $response->assertSee(route('company.logout'));
    }

    public function test_company_job_create_extends_company_master_layout(): void
    {
        $company = $this->createCompany();

        $response = $this->withSession([
            'company_id'   => $company->id,
            'company_name' => $company->company_name,
        ])->get(route('company.job.create'));

        $response->assertStatus(200);
        $response->assertSee('Post New Job - JobPortal');
        $response->assertSee('JobPortal Employer Workspace. All rights reserved.');
        $response->assertSee('Post a New Job');
        $response->assertSee(route('company.job.store'));
        $response->assertSee('name="job_title"', false);
        $response->assertSee('name="job_type"', false);
        $response->assertSee('name="location"', false);
        $response->assertSee('name="salary"', false);
        $response->assertSee('name="experience"', false);
        $response->assertSee('name="vacancy"', false);
        $response->assertSee('name="description"', false);
        $response->assertSee('name="deadline"', false);
        $response->assertSee(route('company.logout'));
    }

    public function test_company_jobs_index_extends_company_master_layout(): void
    {
        $company = $this->createCompany();
        $job = $this->createJob($company, ['job_title' => 'Senior Backend Architect']);

        $response = $this->withSession([
            'company_id'   => $company->id,
            'company_name' => $company->company_name,
        ])->get(route('company.jobs'));

        $response->assertStatus(200);
        $response->assertSee('Manage Jobs - JobPortal');
        $response->assertSee('JobPortal Employer Workspace. All rights reserved.');
        $response->assertSee('Senior Backend Architect');
        $response->assertSee(route('job.edit', $job->id));
        $response->assertSee(route('job.delete', $job->id));
        $response->assertSee(route('company.job.applications', $job->id));
        $response->assertSee(route('company.logout'));
    }

    public function test_company_job_edit_extends_company_master_layout(): void
    {
        $company = $this->createCompany();
        $job = $this->createJob($company, ['job_title' => 'DevOps Automation Specialist']);

        $response = $this->withSession([
            'company_id'   => $company->id,
            'company_name' => $company->company_name,
        ])->get(route('job.edit', $job->id));

        $response->assertStatus(200);
        $response->assertSee('Edit Job: DevOps Automation Specialist - JobPortal');
        $response->assertSee('JobPortal Employer Workspace. All rights reserved.');
        $response->assertSee('Edit Job');
        $response->assertSee(route('job.update', $job->id));
        $response->assertSee('DevOps Automation Specialist');
        $response->assertSee('name="status"', false);
        $response->assertSee(route('company.logout'));
    }

    public function test_company_applications_index_extends_company_master_layout(): void
    {
        $company = $this->createCompany();
        $student = $this->createStudent(['name' => 'Jordan Candidate']);
        $job = $this->createJob($company, ['job_title' => 'Cloud Operations Engineer']);

        $application = Application::create([
            'student_id' => $student->id,
            'job_id'     => $job->id,
            'status'     => 'Pending',
        ]);

        $response = $this->withSession([
            'company_id'   => $company->id,
            'company_name' => $company->company_name,
        ])->get(route('company.applications'));

        $response->assertStatus(200);
        $response->assertSee('Candidate Applications - JobPortal');
        $response->assertSee('JobPortal Employer Workspace. All rights reserved.');
        $response->assertSee('Jordan Candidate');
        $response->assertSee('Cloud Operations Engineer');
        $response->assertSee(route('company.application.show', $application->id));
        $response->assertSee(route('company.logout'));
    }

    public function test_company_application_show_extends_company_master_layout(): void
    {
        $company = $this->createCompany();
        $student = $this->createStudent(['name' => 'Jordan Candidate']);
        $job = $this->createJob($company, ['job_title' => 'QA Automation Lead']);

        $application = Application::create([
            'student_id' => $student->id,
            'job_id'     => $job->id,
            'status'     => 'Pending',
        ]);

        $response = $this->withSession([
            'company_id'   => $company->id,
            'company_name' => $company->company_name,
        ])->get(route('company.application.show', $application->id));

        $response->assertStatus(200);
        $response->assertSee('Applicant Review: Jordan Candidate - JobPortal');
        $response->assertSee('JobPortal Employer Workspace. All rights reserved.');
        $response->assertSee('Jordan Candidate');
        $response->assertSee('QA Automation Lead');
        $response->assertSee(route('company.application.updateStatus', $application->id));
        $response->assertSee(route('company.logout'));
    }

    public function test_company_master_layout_displays_flash_messages(): void
    {
        $company = $this->createCompany();

        $response = $this->withSession([
            'company_id'   => $company->id,
            'company_name' => $company->company_name,
            'success'      => 'Operation completed successfully!',
            'error'        => 'An unexpected error occurred!',
        ])->get(route('company.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Operation completed successfully!');
        $response->assertSee('An unexpected error occurred!');
    }
}
