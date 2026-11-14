<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Job;
use App\Models\Company;
use App\Models\Student;
use App\Models\Admin;
use App\Models\Application;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ResumeDownloadSecurityTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
        Storage::fake('public');
    }

    private function createTestData()
    {
        $companyA = Company::create([
            'company_name' => 'Company A',
            'owner_name'   => 'Owner A',
            'email'        => 'compA_' . Str::random(5) . '@example.com',
            'phone'        => '9000000001',
            'industry'     => 'IT',
            'address'      => 'Address A',
            'password'     => bcrypt('secret'),
            'is_approved'  => true,
        ]);

        $companyB = Company::create([
            'company_name' => 'Company B',
            'owner_name'   => 'Owner B',
            'email'        => 'compB_' . Str::random(5) . '@example.com',
            'phone'        => '9000000002',
            'industry'     => 'IT',
            'address'      => 'Address B',
            'password'     => bcrypt('secret'),
            'is_approved'  => true,
        ]);

        $unapprovedCompany = Company::create([
            'company_name' => 'Unapproved Co',
            'owner_name'   => 'Owner U',
            'email'        => 'compU_' . Str::random(5) . '@example.com',
            'phone'        => '9000000003',
            'industry'     => 'IT',
            'address'      => 'Address U',
            'password'     => bcrypt('secret'),
            'is_approved'  => false,
        ]);

        $jobA = Job::create([
            'company_id'  => $companyA->id,
            'job_title'   => 'Job at Company A',
            'job_type'    => 'Full Time',
            'location'    => 'Remote',
            'salary'      => '10 LPA',
            'experience'  => '2 Years',
            'vacancy'     => 1,
            'description' => 'Job description',
            'deadline'    => now()->addDays(30)->toDateString(),
            'status'      => true,
        ]);

        $studentA = Student::create([
            'name'     => 'Student A',
            'email'    => 'studA_' . Str::random(5) . '@example.com',
            'phone'    => '9100000001',
            'password' => bcrypt('secret'),
        ]);

        $studentB = Student::create([
            'name'     => 'Student B',
            'email'    => 'studB_' . Str::random(5) . '@example.com',
            'phone'    => '9100000002',
            'password' => bcrypt('secret'),
        ]);

        $admin = Admin::create([
            'name'     => 'Super Admin',
            'email'    => 'admin_' . Str::random(5) . '@example.com',
            'password' => bcrypt('secret'),
        ]);

        // Place test file on private 'local' disk
        $localResumePath = 'resumes/resume_' . Str::random(40) . '.pdf';
        Storage::disk('local')->put($localResumePath, '%PDF-1.4 test resume content');

        $application = Application::create([
            'student_id' => $studentA->id,
            'job_id'     => $jobA->id,
            'resume'     => $localResumePath,
            'status'     => 'Pending',
        ]);

        return compact('companyA', 'companyB', 'unapprovedCompany', 'jobA', 'studentA', 'studentB', 'admin', 'application', 'localResumePath');
    }

    public function test_guest_cannot_download_resume(): void
    {
        $data = $this->createTestData();

        $response = $this->get(route('applications.resume.download', $data['application']->id));

        $response->assertStatus(403);
    }

    public function test_cross_student_cannot_download_other_students_resume(): void
    {
        $data = $this->createTestData();

        // Student B tries to download Student A's application resume
        $response = $this->withSession(['student_id' => $data['studentB']->id])
                         ->get(route('applications.resume.download', $data['application']->id));

        $response->assertStatus(403);
    }

    public function test_cross_company_cannot_download_other_companies_applicant_resume(): void
    {
        $data = $this->createTestData();

        // Company B tries to download resume submitted to Company A's job
        $response = $this->withSession(['company_id' => $data['companyB']->id])
                         ->get(route('applications.resume.download', $data['application']->id));

        $response->assertStatus(403);
    }

    public function test_unapproved_company_cannot_download_resume(): void
    {
        $data = $this->createTestData();

        // Put unapproved company in session for a job they somehow own
        $data['jobA']->update(['company_id' => $data['unapprovedCompany']->id]);

        $response = $this->withSession(['company_id' => $data['unapprovedCompany']->id])
                         ->get(route('applications.resume.download', $data['application']->id));

        $response->assertStatus(403);
    }

    public function test_deleted_student_session_cannot_download_resume(): void
    {
        $data = $this->createTestData();

        // Session has student_id 99999 which does not exist in DB
        $response = $this->withSession(['student_id' => 99999])
                         ->get(route('applications.resume.download', $data['application']->id));

        $response->assertStatus(403);
    }

    public function test_deleted_company_session_cannot_download_resume(): void
    {
        $data = $this->createTestData();

        // Session has company_id 99999 which does not exist in DB
        $response = $this->withSession(['company_id' => 99999])
                         ->get(route('applications.resume.download', $data['application']->id));

        $response->assertStatus(403);
    }

    public function test_admin_can_download_any_resume(): void
    {
        $data = $this->createTestData();

        $response = $this->actingAs($data['admin'], 'admin')
                         ->get(route('applications.resume.download', $data['application']->id));

        $response->assertStatus(200);
        $this->assertEquals('%PDF-1.4 test resume content', $response->streamedContent());
    }

    public function test_student_owner_can_download_own_resume(): void
    {
        $data = $this->createTestData();

        $response = $this->withSession(['student_id' => $data['studentA']->id])
                         ->get(route('applications.resume.download', $data['application']->id));

        $response->assertStatus(200);
        $this->assertEquals('%PDF-1.4 test resume content', $response->streamedContent());
    }

    public function test_company_job_owner_can_download_applicant_resume(): void
    {
        $data = $this->createTestData();

        $response = $this->withSession(['company_id' => $data['companyA']->id])
                         ->get(route('applications.resume.download', $data['application']->id));

        $response->assertStatus(200);
        $this->assertEquals('%PDF-1.4 test resume content', $response->streamedContent());
    }

    public function test_legacy_public_disk_resume_is_downloadable(): void
    {
        $data = $this->createTestData();

        // Put legacy resume on 'public' disk
        $legacyPath = 'resumes/1790337858_1.pdf';
        Storage::disk('public')->put($legacyPath, '%PDF-1.4 legacy public resume');

        $data['application']->update(['resume' => $legacyPath]);

        // Student owner requests legacy resume
        $response = $this->withSession(['student_id' => $data['studentA']->id])
                         ->get(route('applications.resume.download', $data['application']->id));

        $response->assertStatus(200);
        $this->assertEquals('%PDF-1.4 legacy public resume', $response->streamedContent());
    }

    public function test_upload_resume_stores_in_private_storage_with_unguessable_name(): void
    {
        $data = $this->createTestData();

        $file = UploadedFile::fake()->create('my_resume.pdf', 500, 'application/pdf');

        $response = $this->withSession(['student_id' => $data['studentA']->id])
                         ->post(route('student.resume.store', $data['jobA']->id), [
                             'resume' => $file,
                         ]);

        $response->assertRedirect(route('student.job.details', $data['jobA']->id));

        $data['application']->refresh();

        // 1. Path must be in private 'local' disk
        $this->assertNotNull($data['application']->resume);
        Storage::disk('local')->assertExists($data['application']->resume);

        // 2. Must NOT be in public disk
        Storage::disk('public')->assertMissing($data['application']->resume);

        // 3. Must use randomized unguessable filename format
        $this->assertStringStartsWith('resumes/resume_', $data['application']->resume);
        $this->assertGreaterThan(30, strlen($data['application']->resume));
    }

    public function test_upload_resume_validates_mime_and_size(): void
    {
        $data = $this->createTestData();

        // Test executable / invalid extension
        $badFile = UploadedFile::fake()->create('malware.exe', 100, 'application/x-dosexec');
        $response = $this->withSession(['student_id' => $data['studentA']->id])
                         ->post(route('student.resume.store', $data['jobA']->id), [
                             'resume' => $badFile,
                         ]);
        $response->assertSessionHasErrors('resume');

        // Test oversized file (> 2048 KB)
        $bigFile = UploadedFile::fake()->create('huge.pdf', 3000, 'application/pdf');
        $response2 = $this->withSession(['student_id' => $data['studentA']->id])
                          ->post(route('student.resume.store', $data['jobA']->id), [
                              'resume' => $bigFile,
                          ]);
        $response2->assertSessionHasErrors('resume');
    }
}
