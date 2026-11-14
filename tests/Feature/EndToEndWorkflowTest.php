<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Admin;
use App\Models\Company;
use App\Models\Student;
use App\Models\Job;
use App\Models\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EndToEndWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
        Storage::fake('public');
    }

    private function createAdmin(): Admin
    {
        return Admin::create([
            'name'     => 'System Admin',
            'email'    => 'admin@jobportal.test',
            'password' => Hash::make('AdminPass123!'),
        ]);
    }

    /**
     * Workflow A: Student End-to-End Journey
     * Registration -> Login -> Dashboard -> Browse Jobs -> Job Details -> Apply -> Upload Resume -> My Applications
     */
    public function test_workflow_a_student_complete_journey(): void
    {
        // 1. Prepare active approved job
        $company = Company::create([
            'company_name' => 'TechCorp Global',
            'owner_name'   => 'Alice Founder',
            'email'        => 'techcorp@example.com',
            'phone'        => '9876543210',
            'industry'     => 'Technology',
            'address'      => '123 Innovation St',
            'password'     => Hash::make('password123'),
            'is_approved'  => true,
        ]);

        $job = Job::create([
            'company_id'  => $company->id,
            'job_title'   => 'Software Engineer Graduate',
            'job_type'    => 'Full Time',
            'location'    => 'Bengaluru',
            'salary'      => '8 LPA',
            'experience'  => 'Fresher',
            'vacancy'     => 5,
            'description' => 'Great role for young tech talent.',
            'deadline'    => now()->addDays(30)->toDateString(),
            'status'      => true,
        ]);

        // 2. Student Registration
        $registerResponse = $this->post(route('student.store'), [
            'name'                  => 'John Student',
            'email'                 => 'john.student@example.com',
            'phone'                 => '9123456789',
            'password'              => 'studentpass123',
            'password_confirmation' => 'studentpass123',
        ]);
        $registerResponse->assertRedirect('/student/register');
        $registerResponse->assertSessionHas('success');

        $this->assertDatabaseHas('students', [
            'email' => 'john.student@example.com',
            'name'  => 'John Student',
        ]);

        $student = Student::where('email', 'john.student@example.com')->first();

        // 3. Student Login
        $loginResponse = $this->post(route('student.login.submit'), [
            'email'    => 'john.student@example.com',
            'password' => 'studentpass123',
        ]);
        $loginResponse->assertRedirect('/student/dashboard');
        $this->assertEquals($student->id, session('student_id'));

        // 4. Student Dashboard
        $dashboardResponse = $this->get(route('student.dashboard'));
        $dashboardResponse->assertStatus(200);
        $dashboardResponse->assertSee('John Student');
        $dashboardResponse->assertSee('Overview');

        // 5. Browse Jobs
        $browseResponse = $this->get(route('student.jobs'));
        $browseResponse->assertStatus(200);
        $browseResponse->assertSee('Software Engineer Graduate');
        $browseResponse->assertSee('TechCorp Global');

        // 6. Job Details
        $detailsResponse = $this->get(route('student.job.details', $job->id));
        $detailsResponse->assertStatus(200);
        $detailsResponse->assertSee('Software Engineer Graduate');
        $detailsResponse->assertSee('Apply Now');

        // 7. Apply for Job
        $applyResponse = $this->post(route('student.job.apply', $job->id));
        $applyResponse->assertRedirect(route('student.resume.upload', $job->id));
        $applyResponse->assertSessionHas('success');

        $this->assertDatabaseHas('applications', [
            'student_id' => $student->id,
            'job_id'     => $job->id,
            'status'     => 'Pending',
        ]);

        $application = Application::where('student_id', $student->id)->where('job_id', $job->id)->first();

        // 8. Upload Resume
        $resumeFile = UploadedFile::fake()->create('john_resume.pdf', 500, 'application/pdf');
        $uploadResponse = $this->post(route('student.resume.store', $job->id), [
            'resume' => $resumeFile,
        ]);
        $uploadResponse->assertRedirect(route('student.job.details', $job->id));
        $uploadResponse->assertSessionHas('success');

        $application->refresh();
        $this->assertNotNull($application->resume);
        Storage::disk('local')->assertExists($application->resume);

        // 9. View My Applications
        $myAppsResponse = $this->get(route('student.applications'));
        $myAppsResponse->assertStatus(200);
        $myAppsResponse->assertSee('Software Engineer Graduate');
        $myAppsResponse->assertSee('Pending');
    }

    /**
     * Workflow B: Company End-to-End Journey
     * Registration -> Login Attempt (Pending) -> Admin Approval -> Login -> Dashboard -> Post Job -> Manage Jobs -> View Applicants -> Review Applicant -> Update Status
     */
    public function test_workflow_b_company_complete_journey(): void
    {
        $admin = $this->createAdmin();

        // 1. Company Registration
        $regResponse = $this->post(route('company.register.submit'), [
            'company_name'          => 'Apex Analytics',
            'owner_name'            => 'Sarah Miller',
            'email'                 => 'sarah@apexanalytics.test',
            'phone'                 => '9988776655',
            'website'               => 'https://apexanalytics.test',
            'industry'              => 'Data Analytics',
            'address'               => '789 Data Parkway',
            'password'              => 'securepass123',
            'password_confirmation' => 'securepass123',
        ]);
        $regResponse->assertRedirect('/company/register');
        $regResponse->assertSessionHas('success');

        $company = Company::where('email', 'sarah@apexanalytics.test')->first();
        $this->assertFalse((bool) $company->is_approved);

        // 2. Company attempts login while unapproved (must be rejected)
        $unapprovedLogin = $this->post(route('company.login.submit'), [
            'email'    => 'sarah@apexanalytics.test',
            'password' => 'securepass123',
        ]);
        $unapprovedLogin->assertSessionHas('error', 'Your account is waiting for admin approval.');

        // 3. Admin Approves Company
        $approveResponse = $this->actingAs($admin, 'admin')
            ->patch(route('admin.companies.approve', $company->id));
        $approveResponse->assertSessionHas('success');
        $company->refresh();
        $this->assertTrue((bool) $company->is_approved);

        // 4. Company Logs in successfully
        $loginResponse = $this->post(route('company.login.submit'), [
            'email'    => 'sarah@apexanalytics.test',
            'password' => 'securepass123',
        ]);
        $loginResponse->assertRedirect('/company/dashboard');
        $this->assertEquals($company->id, session('company_id'));

        // 5. Company Dashboard
        $dashResponse = $this->get(route('company.dashboard'));
        $dashResponse->assertStatus(200);
        $dashResponse->assertSee('Apex Analytics');

        // 6. Company Posts a Job
        $postJobResponse = $this->post(route('company.job.store'), [
            'job_title'   => 'Data Science Lead',
            'job_type'    => 'Full Time',
            'location'    => 'Hyderabad',
            'salary'      => '25 LPA',
            'experience'  => '5+ Years',
            'vacancy'     => 2,
            'description' => 'Lead our core data science and machine learning research initiatives.',
            'deadline'    => now()->addDays(45)->toDateString(),
        ]);
        $postJobResponse->assertRedirect('/company/jobs');
        $postJobResponse->assertSessionHas('success');

        $job = Job::where('company_id', $company->id)->first();
        $this->assertNotNull($job);
        $this->assertEquals('Data Science Lead', $job->job_title);

        // 7. Manage Jobs page shows newly created job
        $manageJobsResponse = $this->get(route('company.jobs'));
        $manageJobsResponse->assertStatus(200);
        $manageJobsResponse->assertSee('Data Science Lead');
        $manageJobsResponse->assertSee('Active');

        // 8. Candidate applies to this job
        $student = Student::create([
            'name'     => 'Emma Candidate',
            'email'    => 'emma@candidate.test',
            'phone'    => '9123412345',
            'password' => Hash::make('secretpass'),
        ]);

        $application = Application::create([
            'student_id' => $student->id,
            'job_id'     => $job->id,
            'status'     => 'Pending',
            'resume'     => 'resumes/emma_resume.pdf',
        ]);
        Storage::disk('local')->put($application->resume, 'Dummy resume content');

        // 9. Company views applicants
        $appsListResponse = $this->get(route('company.applications'));
        $appsListResponse->assertStatus(200);
        $appsListResponse->assertSee('Emma Candidate');
        $appsListResponse->assertSee('Data Science Lead');

        // 10. Company reviews applicant details
        $appDetailResponse = $this->get(route('company.application.show', $application->id));
        $appDetailResponse->assertStatus(200);
        $appDetailResponse->assertSee('Emma Candidate');
        $appDetailResponse->assertSee('Download Resume');

        // 11. Company updates status to Shortlisted
        $updateStatusResponse = $this->patch(route('company.application.updateStatus', $application->id), [
            'status' => 'Shortlisted',
        ]);
        $updateStatusResponse->assertSessionHas('success');

        $application->refresh();
        $this->assertEquals('Shortlisted', $application->status);
    }

    /**
     * Workflow C: Admin End-to-End Journey
     * Admin Login -> Dashboard -> Review Companies -> Approve -> Manage Jobs -> Manage Applications
     */
    public function test_workflow_c_admin_complete_journey(): void
    {
        $admin = $this->createAdmin();

        // 1. Admin Login
        $loginResponse = $this->post(route('admin.login.submit'), [
            'email'    => 'admin@jobportal.test',
            'password' => 'AdminPass123!',
        ]);
        $loginResponse->assertRedirect(route('admin.dashboard'));

        // 2. Admin Dashboard
        $dashResponse = $this->actingAs($admin, 'admin')->get(route('admin.dashboard'));
        $dashResponse->assertStatus(200);
        $dashResponse->assertSee('Admin Dashboard');

        // 3. Pending company exists
        $company = Company::create([
            'company_name' => 'Beta Systems',
            'owner_name'   => 'Robert Beta',
            'email'        => 'robert@betasystems.test',
            'phone'        => '9000000001',
            'industry'     => 'Cloud',
            'address'      => '1 Cloud Way',
            'password'     => Hash::make('password123'),
            'is_approved'  => false,
        ]);

        // 4. Admin reviews companies list
        $compList = $this->actingAs($admin, 'admin')->get(route('admin.companies', ['status' => 'pending']));
        $compList->assertStatus(200);
        $compList->assertSee('Beta Systems');

        // 5. Admin approves company
        $approveResp = $this->actingAs($admin, 'admin')->patch(route('admin.companies.approve', $company->id));
        $approveResp->assertSessionHas('success');
        $this->assertTrue((bool) $company->fresh()->is_approved);

        // 6. Company has a job and application
        $job = Job::create([
            'company_id'  => $company->id,
            'job_title'   => 'Cloud Infrastructure Architect',
            'job_type'    => 'Remote',
            'location'    => 'Remote',
            'salary'      => '30 LPA',
            'experience'  => '7+ Years',
            'vacancy'     => 1,
            'description' => 'Architect cloud infrastructure across multi-region environments.',
            'deadline'    => now()->addDays(20)->toDateString(),
            'status'      => true,
        ]);

        $student = Student::create([
            'name'     => 'Liam Cloud Specialist',
            'email'    => 'liam@cloud.test',
            'phone'    => '9000000002',
            'password' => Hash::make('password123'),
        ]);

        $app = Application::create([
            'student_id' => $student->id,
            'job_id'     => $job->id,
            'status'     => 'Pending',
            'resume'     => 'resumes/liam_resume.pdf',
        ]);
        Storage::disk('local')->put($app->resume, 'Liam Cloud Resume PDF Content');

        // 7. Admin manages jobs
        $jobsResponse = $this->actingAs($admin, 'admin')->get(route('admin.jobs'));
        $jobsResponse->assertStatus(200);
        $jobsResponse->assertSee('Cloud Infrastructure Architect');

        // 8. Admin manages applications
        $appsResponse = $this->actingAs($admin, 'admin')->get(route('admin.applications'));
        $appsResponse->assertStatus(200);
        $appsResponse->assertSee('Liam Cloud Specialist');
        $appsResponse->assertSee('Cloud Infrastructure Architect');

        // 9. Admin views application details and downloads resume securely
        $appShowResponse = $this->actingAs($admin, 'admin')->get(route('admin.applications.show', $app->id));
        $appShowResponse->assertStatus(200);
        $appShowResponse->assertSee('Liam Cloud Specialist');

        $resumeResponse = $this->actingAs($admin, 'admin')->get(route('applications.resume.download', $app->id));
        $resumeResponse->assertStatus(200);
    }
}
