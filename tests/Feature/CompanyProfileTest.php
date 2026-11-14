<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CompanyProfileTest extends TestCase
{
    use RefreshDatabase;

    private function createCompany(array $attributes = []): Company
    {
        return Company::create(array_merge([
            'company_name' => 'Acme Corporation',
            'owner_name'   => 'Jane Owner',
            'email'        => strtolower('company_' . Str::random(8) . '@example.com'),
            'phone'        => '9' . str_pad((string) mt_rand(100000000, 999999999), 9, '0', STR_PAD_LEFT),
            'website'      => 'https://acme.example.com',
            'industry'     => 'Software & Technology',
            'address'      => '100 Silicon Way, Tech City',
            'password'     => Hash::make('secret1234'),
            'is_approved'  => true,
        ], $attributes));
    }

    // 1. Guest cannot access company profile or update routes
    public function test_guest_cannot_access_company_profile_or_update_routes(): void
    {
        $responseGet = $this->get(route('company.profile'));
        $responseGet->assertRedirect('/company/login');

        $responsePutProfile = $this->put(route('company.profile.update'), [
            'company_name' => 'New Name',
        ]);
        $responsePutProfile->assertRedirect('/company/login');

        $responsePutPassword = $this->put(route('company.password.update'), [
            'current_password' => 'secret1234',
        ]);
        $responsePutPassword->assertRedirect('/company/login');
    }

    // 2. Unapproved company cannot access profile pages
    public function test_unapproved_company_cannot_access_profile_pages(): void
    {
        $unapprovedCompany = $this->createCompany(['is_approved' => false]);

        $responseGet = $this->withSession(['company_id' => $unapprovedCompany->id])
            ->get(route('company.profile'));
        $responseGet->assertRedirect('/company/login');

        $responsePut = $this->withSession(['company_id' => $unapprovedCompany->id])
            ->put(route('company.profile.update'), [
                'company_name' => 'Attempted Change',
            ]);
        $responsePut->assertRedirect('/company/login');
    }

    // 3. Authenticated company can view profile
    public function test_authenticated_company_can_view_profile(): void
    {
        $company = $this->createCompany([
            'company_name' => 'Apex Innovations',
            'owner_name'   => 'Arthur Pendelton',
            'email'        => 'apex@innovations.com',
            'phone'        => '9876543210',
            'website'      => 'https://apex.example.com',
            'industry'     => 'Robotics',
            'address'      => '742 Evergreen Terrace',
        ]);

        $response = $this->withSession([
            'company_id'   => $company->id,
            'company_name' => $company->company_name,
        ])->get(route('company.profile'));

        $response->assertStatus(200);
        $response->assertViewIs('company.profile');
        $response->assertSee('Apex Innovations');
        $response->assertSee('Arthur Pendelton');
        $response->assertSee('apex@innovations.com');
        $response->assertSee('9876543210');
        $response->assertSee('https://apex.example.com');
        $response->assertSee('Robotics');
        $response->assertSee('742 Evergreen Terrace');
    }

    // 4. Company can update all profile details
    public function test_company_can_update_all_profile_details(): void
    {
        $company = $this->createCompany();

        $response = $this->withSession(['company_id' => $company->id])
            ->put(route('company.profile.update'), [
                'company_name' => 'Updated Global Corp',
                'owner_name'   => 'Jonathan Wick',
                'email'        => 'newcontact@global.com',
                'phone'        => '9123456789',
                'website'      => 'https://global.example.com',
                'industry'     => 'Cybersecurity',
                'address'      => '12 Continental Plaza, Suite 400',
            ]);

        $response->assertRedirect(route('company.profile'));
        $response->assertSessionHas('success', 'Profile updated successfully.');

        $this->assertDatabaseHas('companies', [
            'id'           => $company->id,
            'company_name' => 'Updated Global Corp',
            'owner_name'   => 'Jonathan Wick',
            'email'        => 'newcontact@global.com',
            'phone'        => '9123456789',
            'website'      => 'https://global.example.com',
            'industry'     => 'Cybersecurity',
            'address'      => '12 Continental Plaza, Suite 400',
        ]);
    }

    // 5. Company can retain existing email and phone
    public function test_company_can_retain_existing_email_and_phone(): void
    {
        $company = $this->createCompany([
            'email' => 'keepsame@company.org',
            'phone' => '9998887776',
        ]);

        $response = $this->withSession(['company_id' => $company->id])
            ->put(route('company.profile.update'), [
                'company_name' => 'Retained Details Corp',
                'owner_name'   => 'Jane Owner',
                'email'        => 'keepsame@company.org',
                'phone'        => '9998887776',
                'website'      => 'https://company.org',
                'industry'     => 'Logistics',
                'address'      => '55 Central Ave',
            ]);

        $response->assertRedirect(route('company.profile'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('companies', [
            'id'           => $company->id,
            'company_name' => 'Retained Details Corp',
            'email'        => 'keepsame@company.org',
            'phone'        => '9998887776',
        ]);
    }

    // 6. Duplicate email is rejected
    public function test_duplicate_email_is_rejected(): void
    {
        $companyA = $this->createCompany(['email' => 'first@company.com']);
        $companyB = $this->createCompany(['email' => 'second@company.com']);

        $response = $this->withSession(['company_id' => $companyB->id])
            ->put(route('company.profile.update'), [
                'company_name' => 'Company B Updated',
                'owner_name'   => 'Owner B',
                'email'        => 'first@company.com', // Duplicate of Company A
                'phone'        => '9555666777',
                'industry'     => 'Finance',
                'address'      => 'Wall St',
            ]);

        $response->assertSessionHasErrors('email');
        $this->assertDatabaseHas('companies', [
            'id'    => $companyB->id,
            'email' => 'second@company.com',
        ]);
    }

    // 7. Duplicate phone is rejected
    public function test_duplicate_phone_is_rejected(): void
    {
        $companyA = $this->createCompany(['phone' => '9000000001']);
        $companyB = $this->createCompany(['phone' => '9000000002']);

        $response = $this->withSession(['company_id' => $companyB->id])
            ->put(route('company.profile.update'), [
                'company_name' => 'Company B Updated',
                'owner_name'   => 'Owner B',
                'email'        => 'unique_email@company.com',
                'phone'        => '9000000001', // Duplicate of Company A
                'industry'     => 'Finance',
                'address'      => 'Wall St',
            ]);

        $response->assertSessionHasErrors('phone');
        $this->assertDatabaseHas('companies', [
            'id'    => $companyB->id,
            'phone' => '9000000002',
        ]);
    }

    // 8. Email normalization and input trimming work
    public function test_email_normalization_and_input_trimming_work(): void
    {
        $company = $this->createCompany();

        $response = $this->withSession(['company_id' => $company->id])
            ->put(route('company.profile.update'), [
                'company_name' => '  Spaced Company Name  ',
                'owner_name'   => '  Spaced Owner  ',
                'email'        => '  UPPERCASE_EMAIL@DOMAIN.COM  ',
                'phone'        => '  9123456789  ',
                'website'      => '  https://trimmed.example.com  ',
                'industry'     => '  Aerospace  ',
                'address'      => '  100 Launch Complex Road  ',
            ]);

        $response->assertRedirect(route('company.profile'));

        $this->assertDatabaseHas('companies', [
            'id'           => $company->id,
            'company_name' => 'Spaced Company Name',
            'owner_name'   => 'Spaced Owner',
            'email'        => 'uppercase_email@domain.com',
            'phone'        => '9123456789',
            'website'      => 'https://trimmed.example.com',
            'industry'     => 'Aerospace',
            'address'      => '100 Launch Complex Road',
        ]);
    }

    // 9. Company name update synchronizes session
    public function test_company_name_update_synchronizes_session(): void
    {
        $company = $this->createCompany(['company_name' => 'Original Name']);

        $this->withSession([
            'company_id'   => $company->id,
            'company_name' => 'Original Name',
        ])->put(route('company.profile.update'), [
            'company_name' => 'Brand New Name',
            'owner_name'   => $company->owner_name,
            'email'        => $company->email,
            'phone'        => $company->phone,
            'industry'     => $company->industry,
            'address'      => $company->address,
        ]);

        $this->assertEquals('Brand New Name', session('company_name'));
    }

    // 10. Company cannot modify is_approved through profile update
    public function test_company_cannot_modify_is_approved_through_profile_update(): void
    {
        $company = $this->createCompany(['is_approved' => true]);

        // Attempt to pass is_approved = 0 / false
        $this->withSession(['company_id' => $company->id])
            ->put(route('company.profile.update'), [
                'company_name' => 'Testing Approval Immutability',
                'owner_name'   => $company->owner_name,
                'email'        => $company->email,
                'phone'        => $company->phone,
                'industry'     => $company->industry,
                'address'      => $company->address,
                'is_approved'  => false, // Malicious input attempt
            ]);

        $company->refresh();
        $this->assertTrue((bool)$company->is_approved);
    }

    // 11. Company can only update its own profile
    public function test_company_can_only_update_own_profile(): void
    {
        $companyA = $this->createCompany(['company_name' => 'Company A']);
        $companyB = $this->createCompany(['company_name' => 'Company B']);

        // Company A attempts to update with an injected company_id for Company B
        $this->withSession(['company_id' => $companyA->id])
            ->put(route('company.profile.update'), [
                'company_id'   => $companyB->id, // Injected IDOR attempt
                'company_name' => 'Comp A Changed',
                'owner_name'   => 'Owner A',
                'email'        => $companyA->email,
                'phone'        => $companyA->phone,
                'industry'     => $companyA->industry,
                'address'      => $companyA->address,
            ]);

        $companyA->refresh();
        $companyB->refresh();

        $this->assertEquals('Comp A Changed', $companyA->company_name);
        $this->assertEquals('Company B', $companyB->company_name); // Remained untouched
    }

    // 12. Valid current password permits password change
    public function test_valid_current_password_permits_password_change(): void
    {
        $company = $this->createCompany([
            'password' => Hash::make('oldpassword123'),
        ]);

        $response = $this->withSession(['company_id' => $company->id])
            ->put(route('company.password.update'), [
                'current_password'      => 'oldpassword123',
                'password'              => 'newpassword123',
                'password_confirmation' => 'newpassword123',
            ]);

        $response->assertRedirect(route('company.profile'));
        $response->assertSessionHas('success', 'Password updated successfully.');

        $company->refresh();
        $this->assertTrue(Hash::check('newpassword123', $company->password));
    }

    // 13. Incorrect current password is rejected
    public function test_incorrect_current_password_is_rejected(): void
    {
        $company = $this->createCompany([
            'password' => Hash::make('correctpassword'),
        ]);

        $response = $this->withSession(['company_id' => $company->id])
            ->put(route('company.password.update'), [
                'current_password'      => 'wrongpassword',
                'password'              => 'newpassword123',
                'password_confirmation' => 'newpassword123',
            ]);

        $response->assertSessionHasErrors('current_password');

        $company->refresh();
        $this->assertTrue(Hash::check('correctpassword', $company->password));
    }

    // 14. Password confirmation mismatch is rejected
    public function test_password_confirmation_mismatch_is_rejected(): void
    {
        $company = $this->createCompany([
            'password' => Hash::make('currentpassword123'),
        ]);

        $response = $this->withSession(['company_id' => $company->id])
            ->put(route('company.password.update'), [
                'current_password'      => 'currentpassword123',
                'password'              => 'newpassword123',
                'password_confirmation' => 'mismatched456',
            ]);

        $response->assertSessionHasErrors('password');
    }

    // 15. Password shorter than 8 characters is rejected
    public function test_password_shorter_than_8_characters_is_rejected(): void
    {
        $company = $this->createCompany([
            'password' => Hash::make('currentpassword123'),
        ]);

        $response = $this->withSession(['company_id' => $company->id])
            ->put(route('company.password.update'), [
                'current_password'      => 'currentpassword123',
                'password'              => 'short12',
                'password_confirmation' => 'short12',
            ]);

        $response->assertSessionHasErrors('password');
    }

    // 16. New password identical to current password is rejected
    public function test_new_password_identical_to_current_password_is_rejected(): void
    {
        $company = $this->createCompany([
            'password' => Hash::make('identicalpass123'),
        ]);

        $response = $this->withSession(['company_id' => $company->id])
            ->put(route('company.password.update'), [
                'current_password'      => 'identicalpass123',
                'password'              => 'identicalpass123',
                'password_confirmation' => 'identicalpass123',
            ]);

        $response->assertSessionHasErrors('password');
    }

    // 17. Password is stored as a secure hash
    public function test_password_is_stored_as_a_secure_hash(): void
    {
        $company = $this->createCompany([
            'password' => Hash::make('oldpass1234'),
        ]);

        $this->withSession(['company_id' => $company->id])
            ->put(route('company.password.update'), [
                'current_password'      => 'oldpass1234',
                'password'              => 'brandnewsecurepass',
                'password_confirmation' => 'brandnewsecurepass',
            ]);

        $company->refresh();

        $this->assertNotEquals('brandnewsecurepass', $company->password);
        $this->assertTrue(Hash::check('brandnewsecurepass', $company->password));
        $this->assertStringStartsWith('$2y$', $company->password);
    }
}
