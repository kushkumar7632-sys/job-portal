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

class AdminCompanyManagementTest extends TestCase
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
            'description' => 'Engineering job role.',
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
            'resume'     => 'resumes/sample.pdf',
        ], $attributes));
    }

    public function test_guest_cannot_access_company_management_routes()
    {
        $company = $this->createCompany();

        $this->get(route('admin.companies'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.companies.show', $company->id))->assertRedirect(route('admin.login'));
        $this->patch(route('admin.companies.approve', $company->id))->assertRedirect(route('admin.login'));
        $this->patch(route('admin.companies.reject', $company->id))->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_view_paginated_companies()
    {
        $admin = $this->createAdmin();

        // Create 15 companies
        for ($i = 0; $i < 15; $i++) {
            $this->createCompany();
        }

        $response = $this->actingAs($admin, 'admin')->get(route('admin.companies'));

        $response->assertStatus(200);
        $response->assertViewHas('companies');
        $companies = $response->viewData('companies');
        $this->assertEquals(10, $companies->perPage());
        $this->assertEquals(15, $companies->total());
    }

    public function test_admin_can_search_companies_by_company_name()
    {
        $admin = $this->createAdmin();
        $target = $this->createCompany(['company_name' => 'Starlight Media Innovations']);
        $other  = $this->createCompany(['company_name' => 'Quantum Cloud Systems']);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.companies', ['search' => 'Starlight']));

        $response->assertStatus(200);
        $response->assertSee('Starlight Media Innovations');
        $response->assertDontSee('Quantum Cloud Systems');
    }

    public function test_admin_can_search_companies_by_owner_name()
    {
        $admin = $this->createAdmin();
        $target = $this->createCompany([
            'company_name' => 'Solaris Logistics',
            'owner_name'   => 'Evelyn Montgomery',
        ]);
        $other  = $this->createCompany([
            'company_name' => 'Apex Global',
            'owner_name'   => 'Marcus Brody',
        ]);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.companies', ['search' => 'Evelyn']));

        $response->assertStatus(200);
        $response->assertSee('Solaris Logistics');
        $response->assertDontSee('Apex Global');
    }

    public function test_admin_can_search_companies_by_email()
    {
        $admin = $this->createAdmin();
        $target = $this->createCompany([
            'company_name' => 'Nebula Bio',
            'email'        => 'contact@nebulabio.example.com',
        ]);
        $other  = $this->createCompany([
            'company_name' => 'Vanguard Robotics',
            'email'        => 'info@vanguard.example.com',
        ]);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.companies', ['search' => 'nebulabio']));

        $response->assertStatus(200);
        $response->assertSee('Nebula Bio');
        $response->assertDontSee('Vanguard Robotics');
    }

    public function test_admin_can_search_companies_by_industry()
    {
        $admin = $this->createAdmin();
        $target = $this->createCompany([
            'company_name' => 'BioHealth Labs',
            'industry'     => 'Biotechnology & Genomics',
        ]);
        $other  = $this->createCompany([
            'company_name' => 'FinTrack Systems',
            'industry'     => 'Banking & Fintech',
        ]);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.companies', ['search' => 'Biotechnology']));

        $response->assertStatus(200);
        $response->assertSee('BioHealth Labs');
        $response->assertDontSee('FinTrack Systems');
    }

    public function test_admin_can_filter_companies_by_approved_status()
    {
        $admin = $this->createAdmin();
        $approved = $this->createCompany([
            'company_name' => 'Approved Partner Corp',
            'is_approved'  => true,
        ]);
        $pending  = $this->createCompany([
            'company_name' => 'Pending Verification Ltd',
            'is_approved'  => false,
        ]);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.companies', ['status' => 'approved']));

        $response->assertStatus(200);
        $response->assertSee('Approved Partner Corp');
        $response->assertDontSee('Pending Verification Ltd');
    }

    public function test_admin_can_filter_companies_by_pending_status()
    {
        $admin = $this->createAdmin();
        $approved = $this->createCompany([
            'company_name' => 'Approved Corp',
            'is_approved'  => true,
        ]);
        $pending  = $this->createCompany([
            'company_name' => 'Pending Startup Inc',
            'is_approved'  => false,
        ]);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.companies', ['status' => 'pending']));

        $response->assertStatus(200);
        $response->assertSee('Pending Startup Inc');
        $response->assertDontSee('Approved Corp');
    }

    public function test_search_and_filters_persist_across_pagination_links()
    {
        $admin = $this->createAdmin();

        for ($i = 0; $i < 15; $i++) {
            $this->createCompany([
                'company_name' => "Fintech Firm {$i}",
                'industry'     => 'Financial Services',
                'is_approved'  => true,
            ]);
        }

        $response = $this->actingAs($admin, 'admin')->get(route('admin.companies', [
            'search' => 'Fintech',
            'status' => 'approved',
        ]));

        $response->assertStatus(200);
        $companies = $response->viewData('companies');
        $this->assertNotNull($companies->nextPageUrl());
        $this->assertStringContainsString('search=Fintech', $companies->nextPageUrl());
        $this->assertStringContainsString('status=approved', $companies->nextPageUrl());
    }

    public function test_admin_can_view_company_details_with_accurate_counts()
    {
        $admin = $this->createAdmin();
        $company = $this->createCompany([
            'company_name' => 'Horizon Solutions',
            'owner_name'   => 'Diana Prince',
            'email'        => 'diana@horizon.example.com',
            'phone'        => '9888877777',
            'website'      => 'https://horizon.example.com',
            'industry'     => 'Cloud Infrastructure',
            'address'      => '500 Cloud Way, Seattle, WA',
            'is_approved'  => true,
        ]);

        $student1 = $this->createStudent();
        $student2 = $this->createStudent();

        // 2 jobs for this company
        $job1 = $this->createJob($company, ['job_title' => 'DevOps Engineer']);
        $job2 = $this->createJob($company, ['job_title' => 'Site Reliability Engineer']);

        // Applications for this company
        $this->createJobApplication($student1, $job1);
        $this->createJobApplication($student2, $job1);
        $this->createJobApplication($student1, $job2);

        // Another company's job and application
        $otherCompany = $this->createCompany(['company_name' => 'Competitor Corp']);
        $otherJob = $this->createJob($otherCompany, ['job_title' => 'Product Manager']);
        $this->createJobApplication($student1, $otherJob);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.companies.show', $company->id));

        $response->assertStatus(200);
        $response->assertSee('Horizon Solutions');
        $response->assertSee('Diana Prince');
        $response->assertSee('diana@horizon.example.com');
        $response->assertSee('9888877777');
        $response->assertSee('https://horizon.example.com');
        $response->assertSee('Cloud Infrastructure');
        $response->assertSee('500 Cloud Way, Seattle, WA');

        // Verify view data
        $response->assertViewHas('totalJobsCount', 2);
        $response->assertViewHas('totalApplicationsCount', 3);

        // Verify company's jobs are displayed
        $response->assertSee('DevOps Engineer');
        $response->assertSee('Site Reliability Engineer');

        // Verify competitor's job is NOT displayed
        $response->assertDontSee('Product Manager');
    }

    public function test_company_details_returns_404_for_non_existent_id()
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin, 'admin')->get(route('admin.companies.show', 999999));

        $response->assertStatus(404);
    }

    public function test_admin_can_approve_a_pending_company()
    {
        $admin = $this->createAdmin();
        $company = $this->createCompany(['is_approved' => false]);

        $response = $this->actingAs($admin, 'admin')->patch(route('admin.companies.approve', $company->id));

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertTrue((bool) $company->fresh()->is_approved);
    }

    public function test_admin_can_reject_an_approved_company()
    {
        $admin = $this->createAdmin();
        $company = $this->createCompany(['is_approved' => true]);

        $response = $this->actingAs($admin, 'admin')->patch(route('admin.companies.reject', $company->id));

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertFalse((bool) $company->fresh()->is_approved);
    }

    public function test_company_listing_extends_master_layout_and_displays_stats_and_filters()
    {
        $admin = $this->createAdmin();
        $approvedCompany = $this->createCompany(['is_approved' => true]);
        $pendingCompany = $this->createCompany(['is_approved' => false]);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.companies'));

        $response->assertStatus(200);
        $response->assertSee('Company Management');
        $response->assertSee('Total Companies');
        $response->assertSee('Approved Companies');
        $response->assertSee('Pending Approval');
        $response->assertSee('Search by company name, owner, email, or industry...');
        $response->assertSee('Apply Filter');
        $response->assertSee('Quick Filter:');
        $response->assertSee(route('admin.companies.show', $approvedCompany->id));
        $response->assertSee(route('admin.companies.show', $pendingCompany->id));
        $response->assertSee('confirm(\'Are you sure you want to approve', false);
        $response->assertSee('confirm(\'Are you sure you want to reject', false);
    }

    public function test_company_listing_displays_empty_state_when_search_yields_no_results()
    {
        $admin = $this->createAdmin();
        $this->createCompany(['company_name' => 'Existing Company']);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.companies', ['search' => 'NonExistentString12345']));

        $response->assertStatus(200);
        $response->assertSee('No matching companies found');
        $response->assertSee('Clear All Filters');
    }

    public function test_company_show_extends_master_layout_and_has_confirmation_dialogs()
    {
        $admin = $this->createAdmin();
        $company = $this->createCompany([
            'company_name' => 'Alpha Global',
            'is_approved'  => true,
        ]);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.companies.show', $company->id));

        $response->assertStatus(200);
        $response->assertSee('Back to Company Management');
        $response->assertSee('Alpha Global');
        $response->assertSee('Reject Company');
        $response->assertSee('confirm(\'Are you sure you want to reject', false);
    }
}
