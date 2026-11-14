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

class StudentDashboardTest extends TestCase
{
    use RefreshDatabase;

    private function createStudent(array $attributes = []): Student
    {
        return Student::create(array_merge([
            'name'     => 'Alice Student',
            'email'    => strtolower('student_' . Str::random(5) . '@example.com'),
            'phone'    => '9876543210',
            'password' => Hash::make('secret123'),
        ], $attributes));
    }

    private function createCompany(array $attributes = []): Company
    {
        return Company::create(array_merge([
            'company_name' => 'Acme Technologies',
            'owner_name'   => 'John Owner',
            'email'        => strtolower('company_' . Str::random(5) . '@example.com'),
            'phone'        => '9123456780',
            'industry'     => 'Software',
            'address'      => '123 Tech Blvd',
            'password'     => Hash::make('secret123'),
            'is_approved'  => true,
        ], $attributes));
    }

    private function createJob(Company $company, array $attributes = []): Job
    {
        return Job::create(array_merge([
            'company_id'  => $company->id,
            'job_title'   => 'Backend Developer',
            'job_type'    => 'Full Time',
            'location'    => 'San Francisco, CA',
            'salary'      => '$120,000',
            'experience'  => '2+ Years',
            'vacancy'     => 2,
            'description' => 'Great role.',
            'deadline'    => now()->addDays(30)->toDateString(),
            'status'      => true,
        ], $attributes));
    }

    public function test_guest_is_redirected_to_student_login(): void
    {
        $response = $this->get(route('student.dashboard'));
        $response->assertRedirect(route('student.login'));
    }

    public function test_dashboard_with_zero_applications_handles_gracefully(): void
    {
        $student = $this->createStudent(['name' => 'Zero Apps Student']);

        $response = $this->withSession(['student_id' => $student->id])
                         ->get(route('student.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Zero Apps Student');
        $response->assertSee('No applications submitted yet');
        $response->assertSee('Browse Jobs →');

        // Check view data statistics are all zero
        $response->assertViewHas('totalApplications', 0);
        $response->assertViewHas('pendingApplications', 0);
        $response->assertViewHas('shortlistedApplications', 0);
        $response->assertViewHas('selectedApplications', 0);
        $response->assertViewHas('rejectedApplications', 0);
        $response->assertViewHas('recentApplications', function ($recent) {
            return $recent->count() === 0;
        });
    }

    public function test_dashboard_displays_dynamic_statistics_and_latest_three_applications(): void
    {
        $studentA = $this->createStudent(['name' => 'Alice Wonder']);
        $company = $this->createCompany(['company_name' => 'Starlight Media']);

        // Create 4 jobs
        $job1 = $this->createJob($company, ['job_title' => 'Frontend Engineer']);
        $job2 = $this->createJob($company, ['job_title' => 'DevOps Engineer']);
        $job3 = $this->createJob($company, ['job_title' => 'QA Specialist']);
        $job4 = $this->createJob($company, ['job_title' => 'Product Designer']);

        // Create 4 applications for studentA with different timestamps
        $app1 = Application::create([
            'student_id' => $studentA->id,
            'job_id'     => $job1->id,
            'status'     => 'Pending',
        ]);
        $app1->created_at = now()->subDays(4);
        $app1->save();

        $app2 = Application::create([
            'student_id' => $studentA->id,
            'job_id'     => $job2->id,
            'status'     => 'Shortlisted',
        ]);
        $app2->created_at = now()->subDays(3);
        $app2->save();

        $app3 = Application::create([
            'student_id' => $studentA->id,
            'job_id'     => $job3->id,
            'status'     => 'Selected',
        ]);
        $app3->created_at = now()->subDays(2);
        $app3->save();

        $app4 = Application::create([
            'student_id' => $studentA->id,
            'job_id'     => $job4->id,
            'status'     => 'Rejected',
            'resume'     => 'resumes/resume_test123.pdf',
        ]);
        $app4->created_at = now()->subDay();
        $app4->save();

        $response = $this->withSession(['student_id' => $studentA->id])
                         ->get(route('student.dashboard'));

        $response->assertStatus(200);

        // Verify view data stats
        $response->assertViewHas('totalApplications', 4);
        $response->assertViewHas('pendingApplications', 1);
        $response->assertViewHas('shortlistedApplications', 1);
        $response->assertViewHas('selectedApplications', 1);
        $response->assertViewHas('rejectedApplications', 1);

        // Verify recent applications contains exactly the latest 3 (job4, job3, job2)
        $response->assertViewHas('recentApplications', function ($recent) use ($job4, $job3, $job2) {
            return $recent->count() === 3
                && $recent[0]->job_id === $job4->id
                && $recent[1]->job_id === $job3->id
                && $recent[2]->job_id === $job2->id;
        });

        // Verify text rendered in response
        $response->assertSee('Product Designer');
        $response->assertSee('QA Specialist');
        $response->assertSee('DevOps Engineer');
        $response->assertSee('Starlight Media');
        $response->assertSee('Pending');
        $response->assertSee('Shortlisted');
        $response->assertSee('Selected');
        $response->assertSee('Rejected');

        // Verify Account Profile section & sidebar link
        $response->assertSee('#account-overview');
        $response->assertSee($studentA->email);
        $response->assertSee($studentA->phone);

        // Verify Manage Resume link
        $response->assertSee('Resume active on applications');
        $response->assertSee(route('applications.resume.download', $app4->id));
    }

    public function test_statistics_and_recent_applications_are_isolated_per_student(): void
    {
        $studentA = $this->createStudent(['name' => 'Student A']);
        $studentB = $this->createStudent(['name' => 'Student B']);
        $company = $this->createCompany();

        $jobA1 = $this->createJob($company, ['job_title' => 'Job for A']);
        $jobB1 = $this->createJob($company, ['job_title' => 'Job for B']);

        // Student A applies for Job A1
        Application::create([
            'student_id' => $studentA->id,
            'job_id'     => $jobA1->id,
            'status'     => 'Selected',
        ]);

        // Student B applies for Job B1
        Application::create([
            'student_id' => $studentB->id,
            'job_id'     => $jobB1->id,
            'status'     => 'Pending',
        ]);

        // Request dashboard as Student A
        $responseA = $this->withSession(['student_id' => $studentA->id])
                          ->get(route('student.dashboard'));

        $responseA->assertViewHas('totalApplications', 1);
        $responseA->assertViewHas('selectedApplications', 1);
        $responseA->assertViewHas('pendingApplications', 0);
        $responseA->assertSee('Job for A');
        $responseA->assertDontSee('Job for B');

        // Request dashboard as Student B
        $responseB = $this->withSession(['student_id' => $studentB->id])
                          ->get(route('student.dashboard'));

        $responseB->assertViewHas('totalApplications', 1);
        $responseB->assertViewHas('selectedApplications', 0);
        $responseB->assertViewHas('pendingApplications', 1);
        $responseB->assertSee('Job for B');
        $responseB->assertDontSee('Job for A');
    }
}
