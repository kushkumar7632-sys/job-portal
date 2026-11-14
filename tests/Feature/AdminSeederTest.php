<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Admin;
use Database\Seeders\AdminSeeder;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class AdminSeederTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        // Reset configuration to default after each test
        config([
            'auth.initial_admin.name'     => 'System Administrator',
            'auth.initial_admin.email'    => null,
            'auth.initial_admin.password' => null,
        ]);

        parent::tearDown();
    }

    public function test_admin_seeder_creates_admin_when_credentials_are_configured()
    {
        config([
            'auth.initial_admin.name'     => 'Super Admin',
            'auth.initial_admin.email'    => 'superadmin@example.com',
            'auth.initial_admin.password' => 'SecurePassword123!',
        ]);

        $this->seed(AdminSeeder::class);

        $this->assertDatabaseHas('admins', [
            'name'  => 'Super Admin',
            'email' => 'superadmin@example.com',
        ]);

        $admin = Admin::where('email', 'superadmin@example.com')->first();
        $this->assertNotNull($admin);
        $this->assertTrue(Hash::check('SecurePassword123!', $admin->password));
    }

    public function test_admin_seeder_is_idempotent_and_does_not_create_duplicate_accounts()
    {
        config([
            'auth.initial_admin.name'     => 'Super Admin',
            'auth.initial_admin.email'    => 'superadmin@example.com',
            'auth.initial_admin.password' => 'SecurePassword123!',
        ]);

        // Run seeder twice
        $this->seed(AdminSeeder::class);
        $this->seed(AdminSeeder::class);

        $this->assertEquals(1, Admin::where('email', 'superadmin@example.com')->count());
        $this->assertEquals(1, Admin::count());
    }

    public function test_admin_seeder_preserves_existing_admin_account_and_does_not_overwrite_password()
    {
        Admin::create([
            'name'     => 'Original Admin',
            'email'    => 'superadmin@example.com',
            'password' => Hash::make('OriginalProtectedPassword999!'),
        ]);

        config([
            'auth.initial_admin.name'     => 'Overwritten Admin',
            'auth.initial_admin.email'    => 'superadmin@example.com',
            'auth.initial_admin.password' => 'NewDifferentPassword888!',
        ]);

        $this->seed(AdminSeeder::class);

        $admin = Admin::where('email', 'superadmin@example.com')->first();
        $this->assertNotNull($admin);

        // Name and password must be preserved, never overwritten
        $this->assertEquals('Original Admin', $admin->name);
        $this->assertTrue(Hash::check('OriginalProtectedPassword999!', $admin->password));
        $this->assertFalse(Hash::check('NewDifferentPassword888!', $admin->password));
    }

    public function test_admin_seeder_skips_and_does_not_create_second_admin_when_different_admin_already_exists()
    {
        // An existing admin exists with email primary@example.com
        $existingAdmin = Admin::create([
            'name'     => 'Primary Admin',
            'email'    => 'primary@example.com',
            'password' => Hash::make('PrimaryPassword123!'),
        ]);

        // Environment / config specifies a completely different admin email
        config([
            'auth.initial_admin.name'     => 'Secondary Attempted Admin',
            'auth.initial_admin.email'    => 'secondary@example.com',
            'auth.initial_admin.password' => 'SecondaryPassword123!',
        ]);

        $this->seed(AdminSeeder::class);

        // GLOBAL EXISTING ADMIN PROTECTION:
        // No second admin should be created, total count must remain 1
        $this->assertEquals(1, Admin::count());
        $this->assertDatabaseMissing('admins', ['email' => 'secondary@example.com']);
        $this->assertDatabaseHas('admins', [
            'id'    => $existingAdmin->id,
            'email' => 'primary@example.com',
            'name'  => 'Primary Admin',
        ]);
    }

    public function test_admin_seeder_fails_safely_when_credentials_are_missing()
    {
        config([
            'auth.initial_admin.email'    => null,
            'auth.initial_admin.password' => null,
        ]);

        $this->seed(AdminSeeder::class);

        $this->assertEquals(0, Admin::count());
    }

    public function test_admin_seeder_aborts_when_password_is_too_short()
    {
        config([
            'auth.initial_admin.email'    => 'short@example.com',
            'auth.initial_admin.password' => 'short', // 5 chars < 8
        ]);

        $this->seed(AdminSeeder::class);

        $this->assertEquals(0, Admin::count());
    }

    public function test_database_seeder_calls_admin_seeder_safely()
    {
        config([
            'auth.initial_admin.name'     => 'Root Admin',
            'auth.initial_admin.email'    => 'root@example.com',
            'auth.initial_admin.password' => 'RootPassword2026!',
        ]);

        $this->seed(DatabaseSeeder::class);

        $this->assertDatabaseHas('admins', [
            'name'  => 'Root Admin',
            'email' => 'root@example.com',
        ]);

        $this->assertDatabaseHas('users', [
            'name'  => 'Test User',
            'email' => 'test@example.com',
        ]);
    }

    public function test_admin_seeder_reads_strictly_from_laravel_config_and_functions_without_direct_env()
    {
        // Explicitly clear any lingering environment variables
        putenv('INITIAL_ADMIN_EMAIL');
        putenv('INITIAL_ADMIN_PASSWORD');
        putenv('INITIAL_ADMIN_NAME');

        // Simulate config values present via Laravel configuration repository (e.g. after config:cache)
        config([
            'auth.initial_admin.name'     => 'Cached Config Admin',
            'auth.initial_admin.email'    => 'cached@example.com',
            'auth.initial_admin.password' => 'CachedConfigPassword2026!',
        ]);

        $this->seed(AdminSeeder::class);

        $this->assertDatabaseHas('admins', [
            'name'  => 'Cached Config Admin',
            'email' => 'cached@example.com',
        ]);

        $admin = Admin::where('email', 'cached@example.com')->first();
        $this->assertNotNull($admin);
        $this->assertTrue(Hash::check('CachedConfigPassword2026!', $admin->password));
    }
}
