<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Admin;
use App\Models\Student;
use App\Models\Company;
use App\Models\Job;
use App\Models\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminStudentManagementTest extends TestCase
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

    private function createStudent(array $attributes = []): Student
    {
        return Student::create(array_merge([
            'name'     => 'Candidate ' . Str::random(4),
            'email'    => strtolower('student_' . Str::random(5) . '@example.com'),
            'phone'    => '9' . str_pad((string) mt_rand(100000000, 999999999), 9, '0', STR_PAD_LEFT),
            'password' => Hash::make('secret123'),
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
            'industry'     => 'Software',
            'address'      => '123 Tech Way',
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
            'salary'      => '$100,000',
            'experience'  => '2+ Years',
            'vacancy'     => 2,
            'description' => 'Great role.',
            'deadline'    => now()->addDays(14)->toDateString(),
            'status'      => true,
        ], $attributes));
    }

    private function createJobApplication(Student $student, Job $job, array $attributes = []): Application
    {
        return Application::create(array_merge([
            'student_id' => $student->id,
            'job_id'     => $job->id,
            'status'     => 'Pending',
            'resume'     => 'resumes/sample_candidate_resume.pdf',
        ], $attributes));
    }

    public function test_guest_cannot_access_student_management_routes()
    {
        $student = $this->createStudent();

        $this->get(route('admin.students'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.students.show', $student->id))->assertRedirect(route('admin.login'));
        $this->delete(route('admin.students.delete', $student->id))->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_view_paginated_student_list()
    {
        $admin = $this->createAdmin();

        for ($i = 0; $i < 15; $i++) {
            $this->createStudent();
        }

        $response = $this->actingAs($admin, 'admin')->get(route('admin.students'));

        $response->assertStatus(200);
        $response->assertViewHas('students');
        $students = $response->viewData('students');
        $this->assertEquals(10, $students->perPage());
        $this->assertEquals(15, $students->total());
    }

    public function test_admin_can_search_students_by_name()
    {
        $admin = $this->createAdmin();
        $target = $this->createStudent(['name' => 'Alexander Hamilton']);
        $other  = $this->createStudent(['name' => 'Benjamin Franklin']);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.students', ['search' => 'Alexander']));

        $response->assertStatus(200);
        $response->assertSee('Alexander Hamilton');
        $response->assertDontSee('Benjamin Franklin');
    }

    public function test_admin_can_search_students_by_email()
    {
        $admin = $this->createAdmin();
        $target = $this->createStudent([
            'name'  => 'Target Candidate',
            'email' => 'unique.candidate@domain.com',
        ]);
        $other  = $this->createStudent([
            'name'  => 'Other Candidate',
            'email' => 'other.person@somewhere.com',
        ]);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.students', ['search' => 'unique.candidate']));

        $response->assertStatus(200);
        $response->assertSee('unique.candidate@domain.com');
        $response->assertDontSee('other.person@somewhere.com');
    }

    public function test_admin_can_search_students_by_phone()
    {
        $admin = $this->createAdmin();
        $target = $this->createStudent([
            'name'  => 'Phone Target',
            'phone' => '9876501234',
        ]);
        $other  = $this->createStudent([
            'name'  => 'Phone Other',
            'phone' => '9111122222',
        ]);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.students', ['search' => '9876501234']));

        $response->assertStatus(200);
        $response->assertSee('Phone Target');
        $response->assertDontSee('Phone Other');
    }

    public function test_search_parameters_persist_across_pagination()
    {
        $admin = $this->createAdmin();

        for ($i = 0; $i < 15; $i++) {
            $this->createStudent(['name' => "Student Match {$i}"]);
        }

        $response = $this->actingAs($admin, 'admin')->get(route('admin.students', ['search' => 'Student Match']));

        $response->assertStatus(200);
        $students = $response->viewData('students');
        $this->assertNotNull($students->nextPageUrl());
        $this->assertTrue(
            str_contains($students->nextPageUrl(), 'search=Student%20Match') ||
            str_contains($students->nextPageUrl(), 'search=Student+Match')
        );
        $this->assertStringContainsString('page=2', $students->nextPageUrl());
    }

    public function test_student_list_displays_accurate_application_counts()
    {
        $admin = $this->createAdmin();
        $studentWithApps = $this->createStudent(['name' => 'Active Applicant']);
        $studentZeroApps = $this->createStudent(['name' => 'Inactive Student']);

        $company = $this->createCompany();
        $job1 = $this->createJob($company, ['job_title' => 'Job One']);
        $job2 = $this->createJob($company, ['job_title' => 'Job Two']);

        $this->createJobApplication($studentWithApps, $job1);
        $this->createJobApplication($studentWithApps, $job2);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.students'));

        $response->assertStatus(200);
        $response->assertSee('2 Applications');
        $response->assertSee('0 Applications');
    }

    public function test_student_detail_shows_application_history_with_job_and_company_names()
    {
        $admin = $this->createAdmin();
        $student = $this->createStudent([
            'name'  => 'Eleanor Vance',
            'email' => 'eleanor@example.com',
            'phone' => '9876543210',
        ]);

        $company1 = $this->createCompany(['company_name' => 'Apex Cloud Inc']);
        $company2 = $this->createCompany(['company_name' => 'Beacon Health']);

        $job1 = $this->createJob($company1, ['job_title' => 'Senior Backend Engineer']);
        $job2 = $this->createJob($company2, ['job_title' => 'Fullstack Developer']);

        // Another student's application to verify scoping
        $otherStudent = $this->createStudent();
        $otherJob = $this->createJob($company1, ['job_title' => 'Unrelated Job Role']);
        $this->createJobApplication($otherStudent, $otherJob);

        $app1 = $this->createJobApplication($student, $job1, ['status' => 'Shortlisted']);
        $app2 = $this->createJobApplication($student, $job2, ['status' => 'Pending']);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.students.show', $student->id));

        $response->assertStatus(200);
        $response->assertSee('Eleanor Vance');
        $response->assertSee('eleanor@example.com');
        $response->assertSee('9876543210');

        // Check Job & Company names for this student
        $response->assertSee('Senior Backend Engineer');
        $response->assertSee('Apex Cloud Inc');
        $response->assertSee('Shortlisted');

        $response->assertSee('Fullstack Developer');
        $response->assertSee('Beacon Health');
        $response->assertSee('Pending');

        // Verify other student's job is NOT visible on Eleanor's profile
        $response->assertDontSee('Unrelated Job Role');

        // Verify view data
        $this->assertEquals(2, $response->viewData('student')->applications_count);
    }

    public function test_resume_links_use_the_secure_download_route()
    {
        $admin = $this->createAdmin();
        $student = $this->createStudent();
        $company = $this->createCompany();
        $job = $this->createJob($company);
        $application = $this->createJobApplication($student, $job, [
            'resume' => 'resumes/eleanor_private_resume.pdf',
        ]);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.students.show', $student->id));

        $response->assertStatus(200);
        $expectedUrl = route('applications.resume.download', $application->id);
        $response->assertSee($expectedUrl);
        $response->assertDontSee('resumes/eleanor_private_resume.pdf'); // Never expose raw path
    }

    public function test_student_with_applications_cannot_be_deleted_and_records_are_preserved()
    {
        $admin = $this->createAdmin();
        $student = $this->createStudent(['name' => 'Protected Candidate']);
        $company = $this->createCompany();
        $job = $this->createJob($company);
        $application = $this->createJobApplication($student, $job);

        // Attempt deletion
        $response = $this->actingAs($admin, 'admin')->delete(route('admin.students.delete', $student->id));

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertStringContainsString('Cannot delete student account because', session('error'));

        // STRICT SAFETY ASSERTION: Verify student and application still exist in database
        $this->assertDatabaseHas('students', ['id' => $student->id]);
        $this->assertDatabaseHas('applications', ['id' => $application->id]);
    }

    public function test_student_with_no_applications_can_be_deleted_safely()
    {
        $admin = $this->createAdmin();
        $student = $this->createStudent(['name' => 'Deletable Candidate']);

        $response = $this->actingAs($admin, 'admin')->delete(route('admin.students.delete', $student->id));

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Student deleted successfully.');

        // Student should be removed
        $this->assertDatabaseMissing('students', ['id' => $student->id]);
    }

    public function test_non_existent_student_id_returns_404()
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin, 'admin')
            ->get(route('admin.students.show', 999999))
            ->assertStatus(404);

        $this->actingAs($admin, 'admin')
            ->delete(route('admin.students.delete', 999999))
            ->assertStatus(404);
    }

    public function test_student_listing_extends_master_layout_and_displays_stats_and_confirmation_dialog()
    {
        $admin = $this->createAdmin();
        $student = $this->createStudent(['name' => 'UI Candidate']);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.students'));

        $response->assertStatus(200);
        $response->assertSee('Student Management');
        $response->assertSee('Total Students');
        $response->assertSee('Active Applicants');
        $response->assertSee('Total Applications');
        $response->assertSee('Search by student name, email, or phone...');
        $response->assertSee('Search Students');
        $response->assertSee(route('admin.students.show', $student->id));
        $response->assertSee('confirm(\'Are you sure you want to delete', false);
    }

    public function test_student_listing_displays_empty_state_when_search_yields_no_results()
    {
        $admin = $this->createAdmin();
        $this->createStudent(['name' => 'Existing Student']);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.students', ['search' => 'NonExistentCandidate999']));

        $response->assertStatus(200);
        $response->assertSee('No matching students found');
        $response->assertSee('Clear Search');
    }

    public function test_student_show_extends_master_layout_and_displays_profile_card_and_empty_state()
    {
        $admin = $this->createAdmin();
        $student = $this->createStudent(['name' => 'Profile Candidate']);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.students.show', $student->id));

        $response->assertStatus(200);
        $response->assertSee('Back to Student Management');
        $response->assertSee('Profile Candidate');
        $response->assertSee('Active Account');
        $response->assertSee('No Applications Submitted Yet');
        $response->assertSee('confirm(\'Are you sure you want to delete', false);
    }
}
