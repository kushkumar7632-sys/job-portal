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

class StudentJobSearchTest extends TestCase
{
    use RefreshDatabase;

    private function createStudent(array $attributes = []): Student
    {
        return Student::create(array_merge([
            'name'     => 'Alice Student',
            'email'    => strtolower('student_' . Str::random(8) . '@example.com'),
            'phone'    => '9' . str_pad((string) mt_rand(100000000, 999999999), 9, '0', STR_PAD_LEFT),
            'password' => Hash::make('secret123'),
        ], $attributes));
    }

    private function createCompany(array $attributes = []): Company
    {
        return Company::create(array_merge([
            'company_name' => 'Acme Technologies',
            'owner_name'   => 'John Owner',
            'email'        => strtolower('company_' . Str::random(8) . '@example.com'),
            'phone'        => '9' . str_pad((string) mt_rand(100000000, 999999999), 9, '0', STR_PAD_LEFT),
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
            'location'    => 'Pune, Maharashtra',
            'salary'      => '₹8 - ₹12 LPA',
            'experience'  => '2-4 Years',
            'vacancy'     => 3,
            'description' => 'A wonderful software engineering role building scalable systems.',
            'deadline'    => now()->addDays(20)->toDateString(),
            'status'      => true,
        ], $attributes));
    }

    public function test_keyword_search_by_job_title(): void
    {
        $student = $this->createStudent();
        $company = $this->createCompany();

        $laravelJob = $this->createJob($company, [
            'job_title' => 'Senior Laravel Engineer',
        ]);
        $pythonJob = $this->createJob($company, [
            'job_title' => 'Python Django Specialist',
        ]);

        $response = $this->withSession(['student_id' => $student->id])
            ->get(route('student.jobs', ['search' => 'Laravel']));

        $response->assertStatus(200);
        $response->assertSee('Senior Laravel Engineer');
        $response->assertDontSee('Python Django Specialist');
    }

    public function test_keyword_search_by_description(): void
    {
        $student = $this->createStudent();
        $company = $this->createCompany();

        $redisJob = $this->createJob($company, [
            'job_title'   => 'Distributed Systems Engineer',
            'description' => 'Must have high proficiency in Redis cluster caching and queue workers.',
        ]);
        $reactJob = $this->createJob($company, [
            'job_title'   => 'UI Components Author',
            'description' => 'Must have expertise in Vue and Tailwind UI design systems.',
        ]);

        $response = $this->withSession(['student_id' => $student->id])
            ->get(route('student.jobs', ['search' => 'Redis']));

        $response->assertStatus(200);
        $response->assertSee('Distributed Systems Engineer');
        $response->assertDontSee('UI Components Author');
    }

    public function test_job_type_filtering(): void
    {
        $student = $this->createStudent();
        $company = $this->createCompany();

        $remoteJob = $this->createJob($company, [
            'job_title' => 'Global Remote Architect',
            'job_type'  => 'Remote',
        ]);
        $fullTimeJob = $this->createJob($company, [
            'job_title' => 'Onsite Office Engineer',
            'job_type'  => 'Full Time',
        ]);

        $response = $this->withSession(['student_id' => $student->id])
            ->get(route('student.jobs', ['job_type' => 'Remote']));

        $response->assertStatus(200);
        $response->assertSee('Global Remote Architect');
        $response->assertDontSee('Onsite Office Engineer');
    }

    public function test_location_filtering(): void
    {
        $student = $this->createStudent();
        $company = $this->createCompany();

        $puneJob = $this->createJob($company, [
            'job_title' => 'Pune Developer Position',
            'location'  => 'Pune, Maharashtra',
        ]);
        $hyderabadJob = $this->createJob($company, [
            'job_title' => 'Hyderabad Developer Position',
            'location'  => 'Hyderabad, Telangana',
        ]);

        $response = $this->withSession(['student_id' => $student->id])
            ->get(route('student.jobs', ['location' => 'Pune']));

        $response->assertStatus(200);
        $response->assertSee('Pune Developer Position');
        $response->assertDontSee('Hyderabad Developer Position');
    }

    public function test_experience_filtering(): void
    {
        $student = $this->createStudent();
        $company = $this->createCompany();

        $juniorJob = $this->createJob($company, [
            'job_title'  => 'Junior Associate Engineer',
            'experience' => '0-2 Years',
        ]);
        $leadJob = $this->createJob($company, [
            'job_title'  => 'Principal Software Architect',
            'experience' => '8-10 Years',
        ]);

        $response = $this->withSession(['student_id' => $student->id])
            ->get(route('student.jobs', ['experience' => '0-2']));

        $response->assertStatus(200);
        $response->assertSee('Junior Associate Engineer');
        $response->assertDontSee('Principal Software Architect');
    }

    public function test_expired_jobs_hidden_from_listing(): void
    {
        $student = $this->createStudent();
        $company = $this->createCompany();

        $activeJob = $this->createJob($company, [
            'job_title' => 'Current Active Posting',
            'deadline'  => now()->addDays(5)->toDateString(),
        ]);
        $expiredJob = $this->createJob($company, [
            'job_title' => 'Old Expired Posting',
            'deadline'  => now()->subDays(2)->toDateString(),
        ]);

        $response = $this->withSession(['student_id' => $student->id])
            ->get(route('student.jobs'));

        $response->assertStatus(200);
        $response->assertSee('Current Active Posting');
        $response->assertDontSee('Old Expired Posting');
    }

    public function test_expired_job_details_inaccessible(): void
    {
        $student = $this->createStudent();
        $company = $this->createCompany();

        $expiredJob = $this->createJob($company, [
            'job_title' => 'Inaccessible Expired Job',
            'deadline'  => now()->subDays(3)->toDateString(),
        ]);

        $response = $this->withSession(['student_id' => $student->id])
            ->get(route('student.job.details', $expiredJob->id));

        $response->assertStatus(404);
    }

    public function test_expired_job_application_rejected_through_direct_post(): void
    {
        $student = $this->createStudent();
        $company = $this->createCompany();

        $expiredJob = $this->createJob($company, [
            'job_title' => 'Expired Backend Position',
            'deadline'  => now()->subDays(1)->toDateString(),
        ]);

        $response = $this->withSession(['student_id' => $student->id])
            ->post(route('student.job.apply', $expiredJob->id));

        $response->assertRedirect(route('student.jobs'));
        $response->assertSessionHas('error');

        $this->assertDatabaseMissing('applications', [
            'student_id' => $student->id,
            'job_id'     => $expiredJob->id,
        ]);
    }

    public function test_unapproved_company_jobs_hidden_in_listing(): void
    {
        $student = $this->createStudent();
        $approvedCompany = $this->createCompany(['company_name' => 'Approved Corp', 'is_approved' => true]);
        $unapprovedCompany = $this->createCompany(['company_name' => 'Pending Corp', 'is_approved' => false]);

        $approvedJob = $this->createJob($approvedCompany, ['job_title' => 'Approved Role']);
        $unapprovedJob = $this->createJob($unapprovedCompany, ['job_title' => 'Unapproved Role']);

        $response = $this->withSession(['student_id' => $student->id])
            ->get(route('student.jobs'));

        $response->assertStatus(200);
        $response->assertSee('Approved Role');
        $response->assertDontSee('Unapproved Role');
    }

    public function test_unapproved_company_job_details_inaccessible(): void
    {
        $student = $this->createStudent();
        $unapprovedCompany = $this->createCompany(['is_approved' => false]);

        $job = $this->createJob($unapprovedCompany, ['job_title' => 'Pending Company Job']);

        $response = $this->withSession(['student_id' => $student->id])
            ->get(route('student.job.details', $job->id));

        $response->assertStatus(404);
    }

    public function test_applications_to_unapproved_companies_rejected(): void
    {
        $student = $this->createStudent();
        $unapprovedCompany = $this->createCompany(['is_approved' => false]);

        $job = $this->createJob($unapprovedCompany);

        $response = $this->withSession(['student_id' => $student->id])
            ->post(route('student.job.apply', $job->id));

        $response->assertStatus(404);

        $this->assertDatabaseMissing('applications', [
            'student_id' => $student->id,
            'job_id'     => $job->id,
        ]);
    }

    public function test_pagination_shows_9_jobs_per_page(): void
    {
        $student = $this->createStudent();
        $company = $this->createCompany();

        for ($i = 1; $i <= 12; $i++) {
            $this->createJob($company, [
                'job_title' => sprintf('Software Position %02d', $i),
            ]);
        }

        // Page 1
        $responsePage1 = $this->withSession(['student_id' => $student->id])
            ->get(route('student.jobs', ['page' => 1]));

        $responsePage1->assertStatus(200);
        $paginatedJobs1 = $responsePage1->viewData('jobs');
        $this->assertEquals(9, $paginatedJobs1->count());
        $this->assertEquals(12, $paginatedJobs1->total());
        $this->assertTrue($paginatedJobs1->hasMorePages());

        // Page 2
        $responsePage2 = $this->withSession(['student_id' => $student->id])
            ->get(route('student.jobs', ['page' => 2]));

        $responsePage2->assertStatus(200);
        $paginatedJobs2 = $responsePage2->viewData('jobs');
        $this->assertEquals(3, $paginatedJobs2->count());
        $this->assertFalse($paginatedJobs2->hasMorePages());
    }

    public function test_search_filter_parameters_persist_across_pagination(): void
    {
        $student = $this->createStudent();
        $company = $this->createCompany();

        for ($i = 1; $i <= 11; $i++) {
            $this->createJob($company, [
                'job_title' => "FullTime Role {$i}",
                'job_type'  => 'Full Time',
                'location'  => 'Pune, Maharashtra',
            ]);
        }

        $response = $this->withSession(['student_id' => $student->id])
            ->get(route('student.jobs', [
                'job_type' => 'Full Time',
                'location' => 'Pune',
                'page'     => 1,
            ]));

        $response->assertStatus(200);
        $jobs = $response->viewData('jobs');
        $page2Url = $jobs->url(2);

        $this->assertStringContainsString('job_type=Full+Time', str_replace('%20', '+', $page2Url));
        $this->assertStringContainsString('location=Pune', $page2Url);
    }

    public function test_existing_duplicate_application_prevention_still_works(): void
    {
        $student = $this->createStudent();
        $company = $this->createCompany();
        $job = $this->createJob($company);

        // First application
        $firstResponse = $this->withSession(['student_id' => $student->id])
            ->post(route('student.job.apply', $job->id));

        $firstResponse->assertRedirect(route('student.resume.upload', $job->id));
        $firstResponse->assertSessionHas('success');

        $this->assertDatabaseHas('applications', [
            'student_id' => $student->id,
            'job_id'     => $job->id,
            'status'     => 'Pending',
        ]);
        $this->assertEquals(1, Application::where('student_id', $student->id)->where('job_id', $job->id)->count());

        // Second application attempt
        $secondResponse = $this->withSession(['student_id' => $student->id])
            ->post(route('student.job.apply', $job->id));

        $secondResponse->assertRedirect(route('student.job.details', $job->id));
        $secondResponse->assertSessionHas('error', 'You have already applied for this job.');

        $this->assertEquals(1, Application::where('student_id', $student->id)->where('job_id', $job->id)->count());
    }
}
