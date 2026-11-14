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

class CloudflareR2ResumeStorageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
        Storage::fake('public');
        Storage::fake('r2');
    }

    private function createTestData(string $resumeDisk = 'local'): array
    {
        $company = Company::create([
            'company_name' => 'Acme Cloud Corp',
            'owner_name'   => 'Alice Cloud',
            'email'        => 'acme_' . Str::random(5) . '@example.com',
            'phone'        => '9800000001',
            'industry'     => 'Cloud Computing',
            'address'      => '123 Cloud Way',
            'password'     => bcrypt('secret'),
            'is_approved'  => true,
        ]);

        $job = Job::create([
            'company_id'  => $company->id,
            'job_title'   => 'DevOps Engineer',
            'job_type'    => 'Full Time',
            'location'    => 'Remote',
            'salary'      => '15 LPA',
            'experience'  => '3 Years',
            'vacancy'     => 2,
            'description' => 'Manage cloud infrastructure.',
            'deadline'    => now()->addDays(30)->toDateString(),
            'status'      => true,
        ]);

        $student = Student::create([
            'name'     => 'Bob Candidate',
            'email'    => 'bob_' . Str::random(5) . '@example.com',
            'phone'    => '9810000001',
            'password' => bcrypt('secret'),
        ]);

        $otherStudent = Student::create([
            'name'     => 'Eve Intruder',
            'email'    => 'eve_' . Str::random(5) . '@example.com',
            'phone'    => '9810000002',
            'password' => bcrypt('secret'),
        ]);

        $admin = Admin::create([
            'name'     => 'Cloud Admin',
            'email'    => 'admin_' . Str::random(5) . '@example.com',
            'password' => bcrypt('secret'),
        ]);

        $resumePath = 'resumes/resume_' . Str::random(40) . '.pdf';
        Storage::disk($resumeDisk)->put($resumePath, '%PDF-1.4 test resume on ' . $resumeDisk);

        $application = Application::create([
            'student_id' => $student->id,
            'job_id'     => $job->id,
            'resume'     => $resumePath,
            'status'     => 'Pending',
        ]);

        return compact('company', 'job', 'student', 'otherStudent', 'admin', 'application', 'resumePath');
    }

    public function test_local_resume_upload_stores_on_configured_local_disk(): void
    {
        config(['filesystems.resume_disk' => 'local']);
        $data = $this->createTestData('local');

        $file = UploadedFile::fake()->create('local_resume.pdf', 300, 'application/pdf');

        $response = $this->withSession(['student_id' => $data['student']->id])
                         ->post(route('student.resume.store', $data['job']->id), [
                             'resume' => $file,
                         ]);

        $response->assertRedirect(route('student.job.details', $data['job']->id));
        $response->assertSessionHas('success', 'Resume uploaded successfully!');

        $data['application']->refresh();
        $this->assertNotNull($data['application']->resume);
        Storage::disk('local')->assertExists($data['application']->resume);
        Storage::disk('r2')->assertMissing($data['application']->resume);
    }

    public function test_r2_resume_upload_stores_on_configured_r2_disk(): void
    {
        config(['filesystems.resume_disk' => 'r2']);
        $data = $this->createTestData('r2');

        $file = UploadedFile::fake()->create('r2_resume.pdf', 400, 'application/pdf');

        $response = $this->withSession(['student_id' => $data['student']->id])
                         ->post(route('student.resume.store', $data['job']->id), [
                             'resume' => $file,
                         ]);

        $response->assertRedirect(route('student.job.details', $data['job']->id));
        $response->assertSessionHas('success', 'Resume uploaded successfully!');

        $data['application']->refresh();
        $this->assertNotNull($data['application']->resume);
        Storage::disk('r2')->assertExists($data['application']->resume);
        Storage::disk('local')->assertMissing($data['application']->resume);
    }

    public function test_resume_download_from_configured_r2_disk_by_authorized_roles(): void
    {
        config(['filesystems.resume_disk' => 'r2']);
        $data = $this->createTestData('r2');

        // 1. Owning student can download from R2
        $responseStudent = $this->withSession(['student_id' => $data['student']->id])
                                ->get(route('applications.resume.download', $data['application']->id));
        $responseStudent->assertStatus(200);
        $this->assertEquals('%PDF-1.4 test resume on r2', $responseStudent->streamedContent());

        // 2. Owning company can download from R2
        $responseCompany = $this->withSession(['company_id' => $data['company']->id])
                                ->get(route('applications.resume.download', $data['application']->id));
        $responseCompany->assertStatus(200);
        $this->assertEquals('%PDF-1.4 test resume on r2', $responseCompany->streamedContent());

        // 3. Admin can download from R2
        $responseAdmin = $this->actingAs($data['admin'], 'admin')
                              ->get(route('applications.resume.download', $data['application']->id));
        $responseAdmin->assertStatus(200);
        $this->assertEquals('%PDF-1.4 test resume on r2', $responseAdmin->streamedContent());
    }

    public function test_existing_local_resume_fallback_when_r2_is_configured(): void
    {
        // Production is set to R2, but existing applications still have files on local disk
        config(['filesystems.resume_disk' => 'r2']);
        $data = $this->createTestData('local'); // Put on local disk

        // Ensure file is NOT on r2 disk
        Storage::disk('r2')->assertMissing($data['resumePath']);
        Storage::disk('local')->assertExists($data['resumePath']);

        // Download request should fallback to local disk seamlessly
        $response = $this->withSession(['student_id' => $data['student']->id])
                         ->get(route('applications.resume.download', $data['application']->id));

        $response->assertStatus(200);
        $this->assertEquals('%PDF-1.4 test resume on local', $response->streamedContent());
    }

    public function test_unauthorized_resume_download_is_forbidden_on_r2_disk(): void
    {
        config(['filesystems.resume_disk' => 'r2']);
        $data = $this->createTestData('r2');

        // 1. Guest request
        $responseGuest = $this->get(route('applications.resume.download', $data['application']->id));
        $responseGuest->assertStatus(403);

        // 2. Cross student request
        $responseOther = $this->withSession(['student_id' => $data['otherStudent']->id])
                              ->get(route('applications.resume.download', $data['application']->id));
        $responseOther->assertStatus(403);
    }

    public function test_missing_resume_file_returns_404(): void
    {
        config(['filesystems.resume_disk' => 'r2']);
        $data = $this->createTestData('r2');

        // Delete physical file from all disks
        Storage::disk('r2')->delete($data['resumePath']);
        Storage::disk('local')->delete($data['resumePath']);
        Storage::disk('public')->delete($data['resumePath']);

        $response = $this->withSession(['student_id' => $data['student']->id])
                         ->get(route('applications.resume.download', $data['application']->id));

        $response->assertStatus(404);
    }

    public function test_application_with_no_resume_record_returns_404(): void
    {
        $data = $this->createTestData('local');
        $data['application']->update(['resume' => null]);

        $response = $this->withSession(['student_id' => $data['student']->id])
                         ->get(route('applications.resume.download', $data['application']->id));

        $response->assertStatus(404);
    }

    public function test_admin_application_deletion_removes_file_from_r2_disk(): void
    {
        config(['filesystems.resume_disk' => 'r2']);
        $data = $this->createTestData('r2');

        Storage::disk('r2')->assertExists($data['resumePath']);

        $response = $this->actingAs($data['admin'], 'admin')
                         ->delete(route('admin.applications.delete', $data['application']->id));

        $response->assertRedirect(route('admin.applications'));
        $this->assertDatabaseMissing('applications', ['id' => $data['application']->id]);
        Storage::disk('r2')->assertMissing($data['resumePath']);
    }
}
