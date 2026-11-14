<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentProfileTest extends TestCase
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

    public function test_guest_cannot_access_student_profile(): void
    {
        $response = $this->get(route('student.profile'));
        $response->assertRedirect(route('student.login'));

        $putProfileResponse = $this->put(route('student.profile.update'), [
            'name'  => 'New Name',
            'email' => 'new@example.com',
            'phone' => '9876543210',
        ]);
        $putProfileResponse->assertRedirect(route('student.login'));

        $putPasswordResponse = $this->put(route('student.password.update'), [
            'current_password'      => 'secret123',
            'password'              => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);
        $putPasswordResponse->assertRedirect(route('student.login'));
    }

    public function test_authenticated_student_can_view_profile(): void
    {
        $student = $this->createStudent([
            'name'  => 'John Doe',
            'email' => 'johndoe@example.com',
        ]);

        $response = $this->withSession(['student_id' => $student->id])
            ->get(route('student.profile'));

        $response->assertStatus(200);
        $response->assertViewIs('student.profile');
        $response->assertViewHas('student', function ($viewStudent) use ($student) {
            return $viewStudent->id === $student->id;
        });
    }

    public function test_profile_details_display_correctly(): void
    {
        $student = $this->createStudent([
            'name'  => 'Marcus Aurelius',
            'email' => 'marcus@philosophy.edu',
            'phone' => '9123456789',
        ]);

        $response = $this->withSession(['student_id' => $student->id])
            ->get(route('student.profile'));

        $response->assertStatus(200);
        $response->assertSee('Marcus Aurelius');
        $response->assertSee('marcus@philosophy.edu');
        $response->assertSee('9123456789');
        $response->assertSee('Active Account');
    }

    public function test_name_email_and_phone_update_successfully(): void
    {
        $student = $this->createStudent([
            'name'  => 'Old Name',
            'email' => 'oldemail@example.com',
            'phone' => '9000000001',
        ]);

        $response = $this->withSession(['student_id' => $student->id])
            ->put(route('student.profile.update'), [
                'name'  => 'Updated Name',
                'email' => 'updatedemail@example.com',
                'phone' => '9988776655',
            ]);

        $response->assertRedirect(route('student.profile'));
        $response->assertSessionHas('success', 'Profile updated successfully.');

        $this->assertDatabaseHas('students', [
            'id'    => $student->id,
            'name'  => 'Updated Name',
            'email' => 'updatedemail@example.com',
            'phone' => '9988776655',
        ]);
    }

    public function test_duplicate_email_is_rejected(): void
    {
        $studentA = $this->createStudent(['email' => 'studenta@example.com']);
        $studentB = $this->createStudent(['email' => 'studentb@example.com']);

        $response = $this->withSession(['student_id' => $studentB->id])
            ->put(route('student.profile.update'), [
                'name'  => 'Student B Name',
                'email' => 'studenta@example.com', // Duplicate of student A
                'phone' => '9111111111',
            ]);

        $response->assertSessionHasErrors(['email']);

        $this->assertDatabaseHas('students', [
            'id'    => $studentB->id,
            'email' => 'studentb@example.com',
        ]);
    }

    public function test_student_can_retain_their_existing_email(): void
    {
        $student = $this->createStudent([
            'name'  => 'Original Name',
            'email' => 'retained@example.com',
            'phone' => '9222222222',
        ]);

        $response = $this->withSession(['student_id' => $student->id])
            ->put(route('student.profile.update'), [
                'name'  => 'New Modified Name',
                'email' => 'retained@example.com', // Same email retained
                'phone' => '9333333333',
            ]);

        $response->assertRedirect(route('student.profile'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('students', [
            'id'    => $student->id,
            'name'  => 'New Modified Name',
            'email' => 'retained@example.com',
            'phone' => '9333333333',
        ]);
    }

    public function test_session_student_name_updates_immediately(): void
    {
        $student = $this->createStudent(['name' => 'Initial Name']);

        $response = $this->withSession([
            'student_id'   => $student->id,
            'student_name' => 'Initial Name',
        ])->put(route('student.profile.update'), [
            'name'  => 'Brand New Name',
            'email' => $student->email,
            'phone' => '9444444444',
        ]);

        $response->assertRedirect(route('student.profile'));
        $response->assertSessionHas('student_name', 'Brand New Name');

        // Subsequent authenticated request verifies StudentAuth middleware synchronization
        $subsequentResponse = $this->withSession([
            'student_id'   => $student->id,
            'student_name' => 'Brand New Name',
        ])->get(route('student.dashboard'));

        $subsequentResponse->assertStatus(200);
        $subsequentResponse->assertSessionHas('student_name', 'Brand New Name');
    }

    public function test_valid_current_password_allows_password_change(): void
    {
        $student = $this->createStudent(['password' => Hash::make('oldSecret123')]);

        $response = $this->withSession(['student_id' => $student->id])
            ->put(route('student.password.update'), [
                'current_password'      => 'oldSecret123',
                'password'              => 'newSecret456',
                'password_confirmation' => 'newSecret456',
            ]);

        $response->assertRedirect(route('student.profile'));
        $response->assertSessionHas('success', 'Password updated successfully.');

        $this->assertTrue(Hash::check('newSecret456', $student->fresh()->password));
        $this->assertFalse(Hash::check('oldSecret123', $student->fresh()->password));
    }

    public function test_incorrect_current_password_is_rejected(): void
    {
        $student = $this->createStudent(['password' => Hash::make('correctPassword123')]);

        $response = $this->withSession(['student_id' => $student->id])
            ->put(route('student.password.update'), [
                'current_password'      => 'wrongPassword999',
                'password'              => 'newSecret456',
                'password_confirmation' => 'newSecret456',
            ]);

        $response->assertSessionHasErrors(['current_password']);

        // Password in database remains unchanged
        $this->assertTrue(Hash::check('correctPassword123', $student->fresh()->password));
        $this->assertFalse(Hash::check('newSecret456', $student->fresh()->password));
    }

    public function test_password_confirmation_mismatch_is_rejected(): void
    {
        $student = $this->createStudent(['password' => Hash::make('currentPass123')]);

        $response = $this->withSession(['student_id' => $student->id])
            ->put(route('student.password.update'), [
                'current_password'      => 'currentPass123',
                'password'              => 'validNewPass1',
                'password_confirmation' => 'mismatchingPass2',
            ]);

        $response->assertSessionHasErrors(['password']);
        $this->assertTrue(Hash::check('currentPass123', $student->fresh()->password));
    }

    public function test_password_shorter_than_6_characters_is_rejected(): void
    {
        $student = $this->createStudent(['password' => Hash::make('currentPass123')]);

        $response = $this->withSession(['student_id' => $student->id])
            ->put(route('student.password.update'), [
                'current_password'      => 'currentPass123',
                'password'              => '12345',
                'password_confirmation' => '12345',
            ]);

        $response->assertSessionHasErrors(['password']);
        $this->assertTrue(Hash::check('currentPass123', $student->fresh()->password));
    }

    public function test_new_password_is_properly_hashed(): void
    {
        $student = $this->createStudent(['password' => Hash::make('startingSecret1')]);

        $response = $this->withSession(['student_id' => $student->id])
            ->put(route('student.password.update'), [
                'current_password'      => 'startingSecret1',
                'password'              => 'superSecretHashed99',
                'password_confirmation' => 'superSecretHashed99',
            ]);

        $response->assertRedirect(route('student.profile'));

        $freshStudent = $student->fresh();
        $this->assertNotEquals('superSecretHashed99', $freshStudent->password);
        $this->assertTrue(str_starts_with($freshStudent->password, '$2y$'));
        $this->assertTrue(Hash::check('superSecretHashed99', $freshStudent->password));
    }
}
