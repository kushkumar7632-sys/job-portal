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

class CompanyApplicantManagementTest extends TestCase
{
    use RefreshDatabase;

    private function createCompany(array $attributes = []): Company
    {
        return Company::create(array_merge([
            'company_name' => 'Acme Corp',
            'owner_name'   => 'John Owner',
            'email'        => strtolower('company_' . Str::random(8) . '@example.com'),
            'phone'        => '9' . str_pad((string) mt_rand(100000000, 999999999), 9, '0', STR_PAD_LEFT),
            'industry'     => 'Technology',
            'address'      => '123 Tech Park',
            'password'     => Hash::make('secret123'),
            'is_approved'  => true,
        ], $attributes));
    }

    private function createStudent(array $attributes = []): Student
    {
        return Student::create(array_merge([
            'name'     => 'Alice Student',
            'email'    => strtolower('student_' . Str::random(8) . '@example.com'),
            'phone'    => '9' . str_pad((string) mt_rand(100000000, 999999999), 9, '0', STR_PAD_LEFT),
            'password' => Hash::make('secret123'),
        ], $attributes));
    }

    private function createJob(Company $company, array $attributes = []): Job
    {
        return Job::create(array_merge([
            'company_id'  => $company->id,
            'job_title'   => 'Software Engineer',
            'job_type'    => 'Full-Time',
            'location'    => 'Remote',
            'salary'      => '80,000 - 100,000 USD',
            'experience'  => '2+ Years',
            'vacancy'     => 3,
            'description' => 'Build high-scale web applications.',
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

    // 1. Approved company can view its own applicants list
    public function test_approved_company_can_view_own_applicants_list(): void
    {
        $company = $this->createCompany();
        $job = $this->createJob($company, ['job_title' => 'Backend Developer']);
        $student = $this->createStudent(['name' => 'Jane Candidate']);
        $application = $this->createJobApplication($student, $job);

        $response = $this->withSession(['company_id' => $company->id])
            ->get(route('company.applications'));

        $response->assertStatus(200);
        $response->assertViewIs('company.applications.index');
        $response->assertSee('Jane Candidate');
        $response->assertSee('Backend Developer');
    }

    // 2. Approved company can view applicants for a specific job it owns
    public function test_approved_company_can_view_applicants_for_own_job(): void
    {
        $company = $this->createCompany();
        $job1 = $this->createJob($company, ['job_title' => 'React Developer']);
        $job2 = $this->createJob($company, ['job_title' => 'DevOps Engineer']);

        $student1 = $this->createStudent(['name' => 'Frontend Specialist']);
        $student2 = $this->createStudent(['name' => 'Cloud Specialist']);

        $this->createJobApplication($student1, $job1);
        $this->createJobApplication($student2, $job2);

        $response = $this->withSession(['company_id' => $company->id])
            ->get(route('company.job.applications', $job1->id));

        $response->assertStatus(200);
        $response->assertSee('Frontend Specialist');
        $response->assertDontSee('Cloud Specialist');
        $response->assertSee('React Developer');
    }

    // 3. Company CANNOT view applicants for another company's job (returns 404)
    public function test_company_cannot_view_applicants_for_another_companys_job(): void
    {
        $companyA = $this->createCompany(['company_name' => 'Company Alpha']);
        $companyB = $this->createCompany(['company_name' => 'Company Beta']);

        $jobB = $this->createJob($companyB, ['job_title' => 'Confidential Lead']);

        $response = $this->withSession(['company_id' => $companyA->id])
            ->get(route('company.job.applications', $jobB->id));

        $response->assertStatus(404);
    }

    // 4. Approved company can view individual applicant details for its own job
    public function test_approved_company_can_view_applicant_details_for_own_job(): void
    {
        $company = $this->createCompany();
        $job = $this->createJob($company, ['job_title' => 'Full Stack Engineer']);
        $student = $this->createStudent([
            'name'  => 'John Applicant',
            'email' => 'john.applicant@example.com',
            'phone' => '9876543210',
        ]);
        $application = $this->createJobApplication($student, $job, [
            'status' => 'Pending',
            'resume' => 'resumes/john_resume.pdf',
        ]);

        $response = $this->withSession(['company_id' => $company->id])
            ->get(route('company.application.show', $application->id));

        $response->assertStatus(200);
        $response->assertViewIs('company.applications.show');
        $response->assertSee('John Applicant');
        $response->assertSee('john.applicant@example.com');
        $response->assertSee('9876543210');
        $response->assertSee('Full Stack Engineer');
        $response->assertSee('Download Resume');
    }

    // 5. Company CANNOT view applicant details for another company's job (returns 404)
    public function test_company_cannot_view_applicant_details_for_another_companys_job(): void
    {
        $companyA = $this->createCompany(['company_name' => 'Company Alpha']);
        $companyB = $this->createCompany(['company_name' => 'Company Beta']);

        $jobB = $this->createJob($companyB);
        $student = $this->createStudent();
        $applicationB = $this->createJobApplication($student, $jobB);

        $response = $this->withSession(['company_id' => $companyA->id])
            ->get(route('company.application.show', $applicationB->id));

        $response->assertStatus(404);
    }

    // 6. Approved company can update application status (Pending -> Shortlisted -> Selected/Rejected)
    public function test_approved_company_can_update_application_status(): void
    {
        $company = $this->createCompany();
        $job = $this->createJob($company);
        $student = $this->createStudent();
        $application = $this->createJobApplication($student, $job, ['status' => 'Pending']);

        // Update to Shortlisted
        $response = $this->withSession(['company_id' => $company->id])
            ->patch(route('company.application.updateStatus', $application->id), [
                'status' => 'Shortlisted',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('applications', [
            'id'     => $application->id,
            'status' => 'Shortlisted',
        ]);

        // Update to Selected
        $response = $this->withSession(['company_id' => $company->id])
            ->patch(route('company.application.updateStatus', $application->id), [
                'status' => 'Selected',
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('applications', [
            'id'     => $application->id,
            'status' => 'Selected',
        ]);

        // Update to Rejected
        $response = $this->withSession(['company_id' => $company->id])
            ->patch(route('company.application.updateStatus', $application->id), [
                'status' => 'Rejected',
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('applications', [
            'id'     => $application->id,
            'status' => 'Rejected',
        ]);
    }

    // 7. Status update rejects invalid status values (validation error)
    public function test_status_update_rejects_invalid_status_values(): void
    {
        $company = $this->createCompany();
        $job = $this->createJob($company);
        $student = $this->createStudent();
        $application = $this->createJobApplication($student, $job, ['status' => 'Pending']);

        $response = $this->withSession(['company_id' => $company->id])
            ->patch(route('company.application.updateStatus', $application->id), [
                'status' => 'Hired', // Invalid value
            ]);

        $response->assertSessionHasErrors('status');
        $this->assertDatabaseHas('applications', [
            'id'     => $application->id,
            'status' => 'Pending',
        ]);
    }

    // 8. Company CANNOT update status of another company's applicant (returns 404)
    public function test_company_cannot_update_status_of_another_companys_applicant(): void
    {
        $companyA = $this->createCompany(['company_name' => 'Company Alpha']);
        $companyB = $this->createCompany(['company_name' => 'Company Beta']);

        $jobB = $this->createJob($companyB);
        $student = $this->createStudent();
        $applicationB = $this->createJobApplication($student, $jobB, ['status' => 'Pending']);

        $response = $this->withSession(['company_id' => $companyA->id])
            ->patch(route('company.application.updateStatus', $applicationB->id), [
                'status' => 'Selected',
            ]);

        $response->assertStatus(404);
        $this->assertDatabaseHas('applications', [
            'id'     => $applicationB->id,
            'status' => 'Pending',
        ]);
    }

    // 9. Unapproved company CANNOT access applicant pages
    public function test_unapproved_company_cannot_access_applicant_pages(): void
    {
        $unapprovedCompany = $this->createCompany(['is_approved' => false]);
        $job = $this->createJob($unapprovedCompany);
        $student = $this->createStudent();
        $application = $this->createJobApplication($student, $job);

        $response = $this->withSession(['company_id' => $unapprovedCompany->id])
            ->get(route('company.applications'));

        $response->assertRedirect('/company/login');

        $responseShow = $this->withSession(['company_id' => $unapprovedCompany->id])
            ->get(route('company.application.show', $application->id));

        $responseShow->assertRedirect('/company/login');
    }

    // 10. Unauthenticated company (guest) CANNOT access applicant pages
    public function test_guest_cannot_access_company_applicant_pages(): void
    {
        $company = $this->createCompany();
        $job = $this->createJob($company);
        $student = $this->createStudent();
        $application = $this->createJobApplication($student, $job);

        $responseIndex = $this->get(route('company.applications'));
        $responseIndex->assertRedirect('/company/login');

        $responseJob = $this->get(route('company.job.applications', $job->id));
        $responseJob->assertRedirect('/company/login');

        $responseShow = $this->get(route('company.application.show', $application->id));
        $responseShow->assertRedirect('/company/login');

        $responsePatch = $this->patch(route('company.application.updateStatus', $application->id), [
            'status' => 'Shortlisted',
        ]);
        $responsePatch->assertRedirect('/company/login');
    }

    // 11. Status filter works on applicant list
    public function test_status_filter_works_on_applicant_list(): void
    {
        $company = $this->createCompany();
        $job = $this->createJob($company);

        $student1 = $this->createStudent(['name' => 'Shortlisted Candidate']);
        $student2 = $this->createStudent(['name' => 'Pending Candidate']);

        $this->createJobApplication($student1, $job, ['status' => 'Shortlisted']);
        $this->createJobApplication($student2, $job, ['status' => 'Pending']);

        $response = $this->withSession(['company_id' => $company->id])
            ->get(route('company.applications', ['status' => 'Shortlisted']));

        $response->assertStatus(200);
        $response->assertSee('Shortlisted Candidate');
        $response->assertDontSee('Pending Candidate');
    }

    // 12. Search filter works on applicant list
    public function test_search_filter_works_on_applicant_list(): void
    {
        $company = $this->createCompany();
        $job = $this->createJob($company);

        $student1 = $this->createStudent(['name' => 'Alexander Hamilton', 'email' => 'alex@treasury.gov']);
        $student2 = $this->createStudent(['name' => 'Thomas Jefferson', 'email' => 'thomas@monticello.org']);

        $this->createJobApplication($student1, $job);
        $this->createJobApplication($student2, $job);

        // Search by candidate name
        $response = $this->withSession(['company_id' => $company->id])
            ->get(route('company.applications', ['search' => 'Alexander']));

        $response->assertStatus(200);
        $response->assertSee('Alexander Hamilton');
        $response->assertDontSee('Thomas Jefferson');

        // Search by email
        $responseEmail = $this->withSession(['company_id' => $company->id])
            ->get(route('company.applications', ['search' => 'monticello.org']));

        $responseEmail->assertStatus(200);
        $responseEmail->assertSee('Thomas Jefferson');
        $responseEmail->assertDontSee('Alexander Hamilton');
    }

    // 13. Job filter works on applicant list
    public function test_job_filter_works_on_applicant_list(): void
    {
        $company = $this->createCompany();
        $jobA = $this->createJob($company, ['job_title' => 'Principal Architect']);
        $jobB = $this->createJob($company, ['job_title' => 'Junior QA']);

        $studentA = $this->createStudent(['name' => 'Architect Candidate']);
        $studentB = $this->createStudent(['name' => 'QA Candidate']);

        $this->createJobApplication($studentA, $jobA);
        $this->createJobApplication($studentB, $jobB);

        $response = $this->withSession(['company_id' => $company->id])
            ->get(route('company.applications', ['job_id' => $jobA->id]));

        $response->assertStatus(200);
        $response->assertSee('Architect Candidate');
        $response->assertDontSee('QA Candidate');
    }

    // 14. Company dashboard shows accurate statistics matching the database for that company
    public function test_company_dashboard_shows_accurate_statistics(): void
    {
        $company = $this->createCompany();
        $job = $this->createJob($company);

        $student1 = $this->createStudent();
        $student2 = $this->createStudent();
        $student3 = $this->createStudent();
        $student4 = $this->createStudent();

        $this->createJobApplication($student1, $job, ['status' => 'Pending']);
        $this->createJobApplication($student2, $job, ['status' => 'Shortlisted']);
        $this->createJobApplication($student3, $job, ['status' => 'Selected']);
        $this->createJobApplication($student4, $job, ['status' => 'Rejected']);

        $response = $this->withSession([
            'company_id'   => $company->id,
            'company_name' => $company->company_name,
        ])->get(route('company.dashboard'));

        $response->assertStatus(200);
        $response->assertViewHas('totalApplications', 4);
        $response->assertViewHas('pendingApplications', 1);
        $response->assertViewHas('shortlistedApplications', 1);
        $response->assertViewHas('selectedApplications', 1);
        $response->assertViewHas('rejectedApplications', 1);
    }

    // 15. Company dashboard shows recent applications for that company only
    public function test_company_dashboard_shows_recent_applications_for_company_only(): void
    {
        $companyA = $this->createCompany(['company_name' => 'Company Alpha']);
        $companyB = $this->createCompany(['company_name' => 'Company Beta']);

        $jobA = $this->createJob($companyA, ['job_title' => 'Job Alpha']);
        $jobB = $this->createJob($companyB, ['job_title' => 'Job Beta']);

        $studentA = $this->createStudent(['name' => 'Candidate Alpha']);
        $studentB = $this->createStudent(['name' => 'Candidate Beta']);

        $this->createJobApplication($studentA, $jobA);
        $this->createJobApplication($studentB, $jobB);

        $response = $this->withSession([
            'company_id'   => $companyA->id,
            'company_name' => $companyA->company_name,
        ])->get(route('company.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Candidate Alpha');
        $response->assertDontSee('Candidate Beta');
    }

    // 16. Company job list displays correct applicant count and View Applicants link
    public function test_company_job_list_displays_applicant_count_and_view_link(): void
    {
        $company = $this->createCompany();
        $job = $this->createJob($company, ['job_title' => 'Platform Engineer']);

        $student1 = $this->createStudent();
        $student2 = $this->createStudent();

        $this->createJobApplication($student1, $job);
        $this->createJobApplication($student2, $job);

        $response = $this->withSession(['company_id' => $company->id])
            ->get(route('company.jobs'));

        $response->assertStatus(200);
        $response->assertSee('2 Applicants');
        $response->assertSee(route('company.job.applications', $job->id));
        $response->assertSee('View Applicants');
    }

    // 17. Applicant without resume does not show broken download link
    public function test_applicant_without_resume_does_not_show_download_link(): void
    {
        $company = $this->createCompany();
        $job = $this->createJob($company);
        $student = $this->createStudent(['name' => 'No Resume Candidate']);
        $application = $this->createJobApplication($student, $job, ['resume' => null]);

        $response = $this->withSession(['company_id' => $company->id])
            ->get(route('company.application.show', $application->id));

        $response->assertStatus(200);
        $response->assertSee('No Resume Attached');
        $response->assertDontSee(route('applications.resume.download', $application->id));
    }
}
