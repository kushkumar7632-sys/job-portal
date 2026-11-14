<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Student;
use App\Models\Company;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginRateLimitingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        RateLimiter::clear('student-login:*');
        RateLimiter::clear('company-login:*');
        RateLimiter::clear('admin-login:*');
    }

    private function createStudent(array $attributes = []): Student
    {
        return Student::create(array_merge([
            'name'     => 'Student User',
            'email'    => strtolower('student_' . Str::random(5) . '@example.com'),
            'phone'    => '9876543210',
            'password' => Hash::make('password123'),
        ], $attributes));
    }

    private function createCompany(array $attributes = []): Company
    {
        return Company::create(array_merge([
            'company_name' => 'Tech Corp',
            'owner_name'   => 'Owner User',
            'email'        => strtolower('company_' . Str::random(5) . '@example.com'),
            'phone'        => '9123456780',
            'industry'     => 'IT',
            'address'      => 'Silicon Valley',
            'password'     => Hash::make('password123'),
            'is_approved'  => true,
        ], $attributes));
    }

    private function createAdmin(array $attributes = []): Admin
    {
        return Admin::create(array_merge([
            'name'     => 'Admin User',
            'email'    => strtolower('admin_' . Str::random(5) . '@example.com'),
            'password' => Hash::make('admin123'),
        ], $attributes));
    }

    // --- 1. STUDENT RATE LIMITING TESTS ---

    public function test_student_login_throttles_on_sixth_failed_attempt(): void
    {
        $student = $this->createStudent(['password' => Hash::make('correct_pass')]);

        // 5 consecutive failed attempts
        for ($i = 1; $i <= 5; $i++) {
            $response = $this->post(route('student.login.submit'), [
                'email'    => $student->email,
                'password' => 'wrong_pass_' . $i,
            ]);
            $response->assertSessionHas('error', 'Invalid email or password.');
        }

        // 6th attempt should be blocked by rate limiter
        $response = $this->post(route('student.login.submit'), [
            'email'    => $student->email,
            'password' => 'wrong_pass_6',
        ]);

        $response->assertSessionHas('error');
        $this->assertStringContainsString('Too many login attempts', session('error'));
        $this->assertStringContainsString('seconds', session('error'));
    }

    public function test_successful_student_login_clears_failed_attempts_counter(): void
    {
        $student = $this->createStudent(['password' => Hash::make('correct_pass')]);

        // 3 failed attempts
        for ($i = 1; $i <= 3; $i++) {
            $this->post(route('student.login.submit'), [
                'email'    => $student->email,
                'password' => 'wrong_pass',
            ]);
        }

        // 4th attempt: successful login
        $response = $this->post(route('student.login.submit'), [
            'email'    => $student->email,
            'password' => 'correct_pass',
        ]);

        $response->assertRedirect('/student/dashboard');
        $this->assertEquals($student->id, session('student_id'));

        // Counter must be reset: next 5 bad attempts should not trigger throttle immediately
        $throttleKey = 'student-login:' . Str::lower(trim($student->email)) . '|127.0.0.1';
        $this->assertEquals(0, RateLimiter::attempts($throttleKey));
    }

    // --- 2. COMPANY RATE LIMITING TESTS ---

    public function test_company_login_throttles_on_sixth_failed_attempt(): void
    {
        $company = $this->createCompany(['password' => Hash::make('correct_pass')]);

        for ($i = 1; $i <= 5; $i++) {
            $response = $this->post('/company/login', [
                'email'    => $company->email,
                'password' => 'wrong_pass_' . $i,
            ]);
            $response->assertSessionHas('error', 'Invalid email or password.');
        }

        $response = $this->post('/company/login', [
            'email'    => $company->email,
            'password' => 'wrong_pass_6',
        ]);

        $response->assertSessionHas('error');
        $this->assertStringContainsString('Too many login attempts', session('error'));
    }

    public function test_successful_company_login_clears_failed_attempts_counter(): void
    {
        $company = $this->createCompany(['password' => Hash::make('correct_pass')]);

        for ($i = 1; $i <= 3; $i++) {
            $this->post('/company/login', [
                'email'    => $company->email,
                'password' => 'wrong_pass',
            ]);
        }

        $response = $this->post('/company/login', [
            'email'    => $company->email,
            'password' => 'correct_pass',
        ]);

        $response->assertRedirect('/company/dashboard');
        $this->assertEquals($company->id, session('company_id'));

        $throttleKey = 'company-login:' . Str::lower(trim($company->email)) . '|127.0.0.1';
        $this->assertEquals(0, RateLimiter::attempts($throttleKey));
    }

    public function test_unapproved_company_approval_message_remains_functional(): void
    {
        $company = $this->createCompany([
            'password'    => Hash::make('correct_pass'),
            'is_approved' => false,
        ]);

        $response = $this->post('/company/login', [
            'email'    => $company->email,
            'password' => 'correct_pass',
        ]);

        $response->assertSessionHas('error', 'Your account is waiting for admin approval.');
        $this->assertNull(session('company_id'));
    }

    // --- 3. ADMIN RATE LIMITING TESTS ---

    public function test_admin_login_throttles_on_sixth_failed_attempt(): void
    {
        $admin = $this->createAdmin(['password' => Hash::make('correct_pass')]);

        for ($i = 1; $i <= 5; $i++) {
            $response = $this->post(route('admin.login.submit'), [
                'email'    => $admin->email,
                'password' => 'wrong_pass_' . $i,
            ]);
            $response->assertSessionHasErrors('email');
        }

        $response = $this->post(route('admin.login.submit'), [
            'email'    => $admin->email,
            'password' => 'wrong_pass_6',
        ]);

        $response->assertSessionHasErrors('email');
        $errors = session('errors')->get('email');
        $this->assertStringContainsString('Too many login attempts', $errors[0]);
    }

    public function test_successful_admin_login_clears_failed_attempts_counter(): void
    {
        $admin = $this->createAdmin(['password' => Hash::make('correct_pass')]);

        for ($i = 1; $i <= 3; $i++) {
            $this->post(route('admin.login.submit'), [
                'email'    => $admin->email,
                'password' => 'wrong_pass',
            ]);
        }

        $response = $this->post(route('admin.login.submit'), [
            'email'    => $admin->email,
            'password' => 'correct_pass',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin, 'admin');

        $throttleKey = 'admin-login:' . Str::lower(trim($admin->email)) . '|127.0.0.1';
        $this->assertEquals(0, RateLimiter::attempts($throttleKey));
    }

    // --- 4. INDEPENDENCE OF RATE LIMITS ---

    public function test_student_company_and_admin_rate_limits_are_independent(): void
    {
        $sharedEmail = strtolower('shared_' . Str::random(5) . '@example.com');

        $student = $this->createStudent(['email' => $sharedEmail, 'password' => Hash::make('student_pass')]);
        $company = $this->createCompany(['email' => $sharedEmail, 'password' => Hash::make('company_pass')]);
        $admin   = $this->createAdmin(['email' => $sharedEmail, 'password' => Hash::make('admin_pass')]);

        // 1. Lock out student login
        for ($i = 1; $i <= 5; $i++) {
            $this->post(route('student.login.submit'), [
                'email'    => $sharedEmail,
                'password' => 'bad_pass',
            ]);
        }

        // Student is now throttled
        $studentBlocked = $this->post(route('student.login.submit'), [
            'email'    => $sharedEmail,
            'password' => 'bad_pass',
        ]);
        $this->assertStringContainsString('Too many login attempts', session('error'));

        // 2. Company login for the SAME email must NOT be throttled
        $companyResponse = $this->post('/company/login', [
            'email'    => $sharedEmail,
            'password' => 'company_pass',
        ]);
        $companyResponse->assertRedirect('/company/dashboard');
        $this->assertEquals($company->id, session('company_id'));

        // 3. Admin login for the SAME email must NOT be throttled
        $adminResponse = $this->post(route('admin.login.submit'), [
            'email'    => $sharedEmail,
            'password' => 'admin_pass',
        ]);
        $adminResponse->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin, 'admin');
    }

    // --- 5. EMAIL NORMALIZATION & ENUMERATION DEFENSE ---

    public function test_email_normalization_and_whitespace_trimming(): void
    {
        $student = $this->createStudent([
            'email'    => 'case.test@example.com',
            'password' => Hash::make('secret123'),
        ]);

        // Login with uppercase and leading/trailing whitespace
        $response = $this->post(route('student.login.submit'), [
            'email'    => '  CASE.TEST@EXAMPLE.COM  ',
            'password' => 'secret123',
        ]);

        $response->assertRedirect('/student/dashboard');
        $this->assertEquals($student->id, session('student_id'));
    }

    public function test_non_existent_email_returns_identical_error_to_bad_password(): void
    {
        $existingStudent = $this->createStudent(['password' => Hash::make('valid_pass')]);

        // Attempt 1: Existing student with bad password
        $this->post(route('student.login.submit'), [
            'email'    => $existingStudent->email,
            'password' => 'wrong_pass',
        ]);
        $existingUserError = session('error');

        // Attempt 2: Non-existent student
        $this->post(route('student.login.submit'), [
            'email'    => 'nonexistent_' . Str::random(5) . '@example.com',
            'password' => 'any_pass',
        ]);
        $nonExistentUserError = session('error');

        // Both must return identical generic message
        $this->assertEquals('Invalid email or password.', $existingUserError);
        $this->assertEquals('Invalid email or password.', $nonExistentUserError);
    }
}
