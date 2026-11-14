<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Student;
use App\Models\Company;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SessionSecurityTest extends TestCase
{
    use RefreshDatabase;

    private function createStudent(array $attributes = []): Student
    {
        return Student::create(array_merge([
            'name'     => 'Test Student',
            'email'    => 'student_' . Str::random(6) . '@example.com',
            'phone'    => '9876543210',
            'password' => Hash::make('password123'),
        ], $attributes));
    }

    private function createCompany(array $attributes = []): Company
    {
        return Company::create(array_merge([
            'company_name' => 'Acme Corp',
            'owner_name'   => 'John Doe',
            'email'        => 'company_' . Str::random(6) . '@example.com',
            'phone'        => '9123456780',
            'industry'     => 'IT',
            'address'      => '123 Tech Park',
            'password'     => Hash::make('password123'),
            'is_approved'  => true,
        ], $attributes));
    }

    private function createAdmin(array $attributes = []): Admin
    {
        return Admin::create(array_merge([
            'name'     => 'Super Admin',
            'email'    => 'admin_' . Str::random(6) . '@example.com',
            'password' => Hash::make('admin123'),
        ], $attributes));
    }

    // --- STUDENT LOGIN & LOGOUT TESTS ---

    public function test_student_login_authenticates_and_regenerates_session(): void
    {
        $student = $this->createStudent(['password' => Hash::make('secret123')]);

        $this->startSession();
        $initialSessionId = session()->getId();

        $response = $this->post(route('student.login.submit'), [
            'email'    => $student->email,
            'password' => 'secret123',
        ]);

        $response->assertRedirect('/student/dashboard');
        $this->assertEquals($student->id, session('student_id'));
        $this->assertEquals($student->name, session('student_name'));
        $this->assertNotEquals($initialSessionId, session()->getId());
    }

    public function test_student_login_fails_with_invalid_credentials(): void
    {
        $student = $this->createStudent(['password' => Hash::make('secret123')]);

        $response = $this->post(route('student.login.submit'), [
            'email'    => $student->email,
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHas('error');
        $this->assertNull(session('student_id'));
    }

    public function test_student_logout_requires_post_and_invalidates_session(): void
    {
        $student = $this->createStudent();

        // GET request to logout should fail (405 Method Not Allowed)
        $getResponse = $this->withSession(['student_id' => $student->id])
                            ->get('/student/logout');
        $getResponse->assertStatus(405);

        // POST request to logout should succeed and invalidate session
        $this->startSession();
        session(['student_id' => $student->id]);
        $oldSessionId = session()->getId();
        $oldToken = session()->token();

        $postResponse = $this->post(route('student.logout'));

        $postResponse->assertRedirect(route('student.login'));
        $this->assertNull(session('student_id'));
        $this->assertNotEquals($oldSessionId, session()->getId());
        $this->assertNotEquals($oldToken, session()->token());
    }

    // --- COMPANY LOGIN & LOGOUT TESTS ---

    public function test_company_login_validates_inputs(): void
    {
        $response = $this->post('/company/login', []);
        $response->assertSessionHasErrors(['email', 'password']);
    }

    public function test_company_login_authenticates_and_regenerates_session(): void
    {
        $company = $this->createCompany([
            'password'    => Hash::make('secret123'),
            'is_approved' => true,
        ]);

        $this->startSession();
        $initialSessionId = session()->getId();

        $response = $this->post('/company/login', [
            'email'    => $company->email,
            'password' => 'secret123',
        ]);

        $response->assertRedirect('/company/dashboard');
        $this->assertEquals($company->id, session('company_id'));
        $this->assertEquals($company->company_name, session('company_name'));
        $this->assertNotEquals($initialSessionId, session()->getId());
    }

    public function test_unapproved_company_cannot_login(): void
    {
        $company = $this->createCompany([
            'password'    => Hash::make('secret123'),
            'is_approved' => false,
        ]);

        $response = $this->post('/company/login', [
            'email'    => $company->email,
            'password' => 'secret123',
        ]);

        $response->assertSessionHas('error', 'Your account is waiting for admin approval.');
        $this->assertNull(session('company_id'));
    }

    public function test_company_logout_invalidates_session_and_regenerates_token(): void
    {
        $company = $this->createCompany();

        $this->startSession();
        session(['company_id' => $company->id]);
        $oldSessionId = session()->getId();
        $oldToken = session()->token();

        $response = $this->post(route('company.logout'));

        $response->assertRedirect('/company/login');
        $this->assertNull(session('company_id'));
        $this->assertNotEquals($oldSessionId, session()->getId());
        $this->assertNotEquals($oldToken, session()->token());
    }

    // --- MIDDLEWARE SECURITY TESTS ---

    public function test_student_auth_middleware_allows_active_student(): void
    {
        $student = $this->createStudent();

        $response = $this->withSession(['student_id' => $student->id])
                         ->get(route('student.dashboard'));

        $response->assertStatus(200);
    }

    public function test_student_auth_middleware_invalidates_deleted_student_session(): void
    {
        $response = $this->withSession(['student_id' => 99999])
                         ->get(route('student.dashboard'));

        $response->assertRedirect(route('student.login'));
        $response->assertSessionHas('error', 'Account not found. Please login again.');
        $this->assertNull(session('student_id'));
    }

    public function test_company_auth_middleware_allows_approved_company(): void
    {
        $company = $this->createCompany(['is_approved' => true]);

        $response = $this->withSession(['company_id' => $company->id])
                         ->get(route('company.dashboard'));

        $response->assertStatus(200);
    }

    public function test_company_auth_middleware_invalidates_deleted_company_session(): void
    {
        $response = $this->withSession(['company_id' => 99999])
                         ->get(route('company.dashboard'));

        $response->assertRedirect('/company/login');
        $response->assertSessionHas('error', 'Company account not found. Please login again.');
        $this->assertNull(session('company_id'));
    }

    public function test_company_auth_middleware_invalidates_unapproved_company_session(): void
    {
        $company = $this->createCompany(['is_approved' => false]);

        $response = $this->withSession(['company_id' => $company->id])
                         ->get(route('company.dashboard'));

        $response->assertRedirect('/company/login');
        $response->assertSessionHas('error', 'Your account is waiting for admin approval.');
        $this->assertNull(session('company_id'));
    }

    // --- ADMIN AUTH TESTS (VERIFY NO REGRESSION) ---

    public function test_admin_login_and_logout_still_works(): void
    {
        $admin = $this->createAdmin(['password' => Hash::make('adminpass')]);

        $loginResponse = $this->post(route('admin.login.submit'), [
            'email'    => $admin->email,
            'password' => 'adminpass',
        ]);

        $loginResponse->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin, 'admin');

        $logoutResponse = $this->post(route('admin.logout'));
        $logoutResponse->assertRedirect(route('admin.login'));
        $this->assertGuest('admin');
    }
}
