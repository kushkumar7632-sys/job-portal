<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        RateLimiter::clear('admin-login:admin@example.com|127.0.0.1');
        RateLimiter::clear('admin-login-ip:127.0.0.1');
    }

    private function createAdmin(array $attributes = []): Admin
    {
        return Admin::create(array_merge([
            'name'     => 'System Admin',
            'email'    => strtolower('admin_' . Str::random(5) . '@example.com'),
            'password' => Hash::make('password123'),
        ], $attributes));
    }

    public function test_guest_cannot_access_dashboard_and_is_redirected_to_admin_login()
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_authenticated_admin_can_access_dashboard()
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin, 'admin')->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('System Overview');
        $response->assertSee($admin->name);
    }

    public function test_authenticated_admin_visiting_login_page_is_redirected_to_dashboard()
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin, 'admin')->get(route('admin.login'));

        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_admin_can_login_with_valid_credentials()
    {
        $admin = $this->createAdmin([
            'email'    => 'admin@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post(route('admin.login.submit'), [
            'email'    => 'admin@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertTrue(Auth::guard('admin')->check());
        $this->assertEquals($admin->id, Auth::guard('admin')->id());
    }

    public function test_admin_login_fails_with_invalid_credentials()
    {
        $this->createAdmin([
            'email'    => 'admin@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->from(route('admin.login'))->post(route('admin.login.submit'), [
            'email'    => 'admin@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertRedirect(route('admin.login'));
        $response->assertSessionHasErrors('email');
        $this->assertFalse(Auth::guard('admin')->check());
    }

    public function test_admin_login_is_rate_limited_after_five_failed_attempts()
    {
        $this->createAdmin([
            'email'    => 'admin@example.com',
            'password' => Hash::make('password123'),
        ]);

        for ($i = 0; $i < 5; $i++) {
            $this->from(route('admin.login'))->post(route('admin.login.submit'), [
                'email'    => 'admin@example.com',
                'password' => 'wrongpassword',
            ]);
        }

        // 6th attempt should be blocked by rate limiter
        $response = $this->from(route('admin.login'))->post(route('admin.login.submit'), [
            'email'    => 'admin@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertRedirect(route('admin.login'));
        $response->assertSessionHas('error');
        $this->assertStringContainsString('Too many login attempts', session('error'));
    }

    public function test_admin_logout_invalidates_session_and_redirects_to_login()
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin, 'admin')->post(route('admin.logout'));

        $response->assertRedirect(route('admin.login'));
        $this->assertFalse(Auth::guard('admin')->check());
    }

    public function test_guest_cannot_call_admin_logout()
    {
        $response = $this->post(route('admin.logout'));

        $response->assertRedirect(route('admin.login'));
    }
}
