<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Student;
use App\Models\Company;
use App\Models\Job;
use App\Models\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentMasterLayoutTest extends TestCase
{
    use RefreshDatabase;

    private function createStudent(array $attributes = []): Student
    {
        return Student::create(array_merge([
            'name'     => 'Samantha Student',
            'email'    => strtolower('student_' . Str::random(8) . '@example.com'),
            'phone'    => '9' . str_pad((string) mt_rand(100000000, 999999999), 9, '0', STR_PAD_LEFT),
            'password' => Hash::make('secret123'),
        ], $attributes));
    }

    private function createCompany(array $attributes = []): Company
    {
        return Company::create(array_merge([
            'company_name' => 'Nexus Innovations',
            'owner_name'   => 'Jane Founder',
            'email'        => strtolower('nexus_' . Str::random(8) . '@example.com'),
            'phone'        => '9' . str_pad((string) mt_rand(100000000, 999999999), 9, '0', STR_PAD_LEFT),
            'industry'     => 'Technology',
            'address'      => '456 Innovation Way',
            'password'     => Hash::make('secret123'),
            'is_approved'  => true,
        ], $attributes));
    }

    private function createJob(Company $company, array $attributes = []): Job
    {
        return Job::create(array_merge([
            'company_id'  => $company->id,
            'job_title'   => 'Full Stack Engineer',
            'job_type'    => 'Full Time',
            'location'    => 'Bengaluru, India',
            'salary'      => '14 LPA',
            'experience'  => '1-3 Years',
            'vacancy'     => 2,
            'description' => 'Exciting role for full stack developer.',
            'deadline'    => now()->addDays(25)->toDateString(),
            'status'      => true,
        ], $attributes));
    }

    public function test_student_dashboard_extends_student_master_layout(): void
    {
        $student = $this->createStudent(['name' => 'Samantha Student']);

        $response = $this->withSession(['student_id' => $student->id])
                         ->get(route('student.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Student Dashboard - JobPortal');
        $response->assertSee('JobPortal Student Workspace. All rights reserved.');
        $response->assertSee('Workspace');
        $response->assertSee('Dashboard');
        $response->assertSee('Find Jobs');
        $response->assertSee('My Applications');
        $response->assertSee('Account Profile');
        $response->assertSee('Samantha Student');
        $response->assertSee(route('student.logout'));
        $response->assertSee('toggleSidebar');
    }

    public function test_student_profile_extends_student_master_layout(): void
    {
        $student = $this->createStudent(['name' => 'Samantha Student']);

        $response = $this->withSession(['student_id' => $student->id])
                         ->get(route('student.profile'));

        $response->assertStatus(200);
        $response->assertSee('Student Profile - JobPortal');
        $response->assertSee('JobPortal Student Workspace. All rights reserved.');
        $response->assertSee('Manage your personal details and account security');
        $response->assertSee('Samantha Student');
        $response->assertSee(route('student.profile.update'));
        $response->assertSee(route('student.password.update'));
        $response->assertSee(route('student.logout'));
    }

    public function test_student_jobs_index_extends_student_master_layout(): void
    {
        $student = $this->createStudent();
        $company = $this->createCompany();
        $this->createJob($company, ['job_title' => 'Cloud Infrastructure Specialist']);

        $response = $this->withSession(['student_id' => $student->id])
                         ->get(route('student.jobs'));

        $response->assertStatus(200);
        $response->assertSee('Find Jobs - JobPortal');
        $response->assertSee('JobPortal Student Workspace. All rights reserved.');
        $response->assertSee('Cloud Infrastructure Specialist');
        $response->assertSee(route('student.logout'));
    }

    public function test_student_job_details_extends_student_master_layout(): void
    {
        $student = $this->createStudent();
        $company = $this->createCompany();
        $job = $this->createJob($company, ['job_title' => 'Senior Frontend Architect']);

        $response = $this->withSession(['student_id' => $student->id])
                         ->get(route('student.job.details', $job->id));

        $response->assertStatus(200);
        $response->assertSee('Senior Frontend Architect - JobPortal');
        $response->assertSee('JobPortal Student Workspace. All rights reserved.');
        $response->assertSee(route('student.job.apply', $job->id));
        $response->assertSee(route('student.logout'));
    }

    public function test_student_applications_extends_student_master_layout(): void
    {
        $student = $this->createStudent(['name' => 'Samantha Student']);
        $company = $this->createCompany();
        $job = $this->createJob($company, ['job_title' => 'Product Analyst']);

        Application::create([
            'student_id' => $student->id,
            'job_id'     => $job->id,
            'status'     => 'Pending',
        ]);

        $response = $this->withSession(['student_id' => $student->id])
                         ->get(route('student.applications'));

        $response->assertStatus(200);
        $response->assertSee('My Applications - JobPortal');
        $response->assertSee('JobPortal Student Workspace. All rights reserved.');
        $response->assertSee('Product Analyst');
        $response->assertSee('Samantha Student');
        $response->assertSee(route('student.logout'));
    }

    public function test_student_resume_upload_extends_student_master_layout(): void
    {
        $student = $this->createStudent(['name' => 'Samantha Student']);
        $company = $this->createCompany();
        $job = $this->createJob($company, ['job_title' => 'Mobile Developer']);

        Application::create([
            'student_id' => $student->id,
            'job_id'     => $job->id,
            'status'     => 'Pending',
        ]);

        $response = $this->withSession(['student_id' => $student->id])
                         ->get(route('student.resume.upload', $job->id));

        $response->assertStatus(200);
        $response->assertSee('Upload Resume - JobPortal');
        $response->assertSee('JobPortal Student Workspace. All rights reserved.');
        $response->assertSee(route('student.resume.store', $job->id));
        $response->assertSee('resumeInput');
    }
}
