<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds safely and idempotently.
     */
    public function run(): void
    {
        // GLOBAL EXISTING ADMIN PROTECTION:
        // If ANY admin account already exists in the database, skip seeding immediately
        // to preserve existing credentials and prevent unauthorized or duplicate account creation.
        if (Admin::count() > 0) {
            $this->command?->info('Admin account(s) already exist in the database. Skipping admin seeding to preserve existing accounts.');
            return;
        }

        // Retrieve credentials mapped via config/auth.php for full config:cache compatibility
        $email    = config('auth.initial_admin.email');
        $password = config('auth.initial_admin.password');
        $name     = config('auth.initial_admin.name', 'System Administrator');

        $normalizedEmail = $email ? Str::lower(trim($email)) : null;

        // If credentials are not configured, fail safely without creating an insecure account
        if (empty($normalizedEmail) || empty($password)) {
            $this->command?->warn('Initial admin credentials not configured (INITIAL_ADMIN_EMAIL and/or INITIAL_ADMIN_PASSWORD not set). Skipping admin seeding to prevent insecure account creation.');
            return;
        }

        // Validate password minimum length for production security
        if (strlen($password) < 8) {
            $this->command?->error('INITIAL_ADMIN_PASSWORD must be at least 8 characters. Admin seeding aborted.');
            return;
        }

        // Safely create initial admin account using hashed password (never plaintext)
        Admin::firstOrCreate(
            ['email' => $normalizedEmail],
            [
                'name'     => trim($name),
                'password' => Hash::make($password),
            ]
        );

        $this->command?->info("Initial admin account [{$normalizedEmail}] created successfully.");
    }
}
