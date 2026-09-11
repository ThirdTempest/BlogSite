<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthAndUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen_and_receive_otp(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('Admin@12345!'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'Admin@12345!',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/verify-otp');
        $this->assertNotNull($user->fresh()->otp_code);

        // Submit the OTP
        $otpResponse = $this->post('/verify-otp', [
            'otp' => $user->fresh()->otp_code,
        ]);

        $otpResponse->assertRedirect('/dashboard');
        $this->assertTrue(session('auth.otp_verified'));
    }

    public function test_super_admin_bypasses_otp_and_logs_in_directly_to_dashboard(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@blogsite.com',
            'password' => Hash::make('Admin@12345!'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@blogsite.com',
            'password' => 'Admin@12345!',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');
        $this->assertTrue(session('auth.otp_verified'));
    }

    public function test_users_cannot_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('Admin@12345!'),
        ]);

        $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function test_new_users_cannot_register_with_short_or_weak_password(): void
    {
        // 1. Less than 10 characters
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'Pass@1',
            'password_confirmation' => 'Pass@1',
        ]);
        $response->assertSessionHasErrors('password');

        // 2. Missing special character
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'Password12345',
            'password_confirmation' => 'Password12345',
        ]);
        $response->assertSessionHasErrors('password');

        // 3. Missing uppercase letter
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password@12345',
            'password_confirmation' => 'password@12345',
        ]);
        $response->assertSessionHasErrors('password');
    }

    public function test_new_users_can_register_with_strict_password(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'Valid@Password123',
            'password_confirmation' => 'Valid@Password123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/verify-otp');
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'role' => 'user',
            'email_verified_at' => null,
        ]);
    }

    public function test_unverified_user_is_redirected_to_otp_screen(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
            'otp_code' => '123456',
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertRedirect('/verify-otp');
    }

    public function test_user_cannot_verify_with_invalid_otp(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
            'otp_code' => '123456',
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        $response = $this->actingAs($user)->post('/verify-otp', [
            'otp' => '999999',
        ]);

        $response->assertSessionHasErrors('otp');
        $this->assertNull($user->fresh()->email_verified_at);
    }

    public function test_user_can_verify_email_with_valid_otp_and_access_dashboard(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
            'otp_code' => '123456',
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        $response = $this->actingAs($user)->post('/verify-otp', [
            'otp' => '123456',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertNotNull($user->fresh()->email_verified_at);
        $this->assertNull($user->fresh()->otp_code);
    }

    public function test_user_can_resend_otp(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
            'otp_code' => '123456',
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        $response = $this->actingAs($user)->post('/resend-otp');
        $response->assertSessionHas('status');
        $this->assertNotNull($user->fresh()->otp_code);
    }

    public function test_forgot_password_can_be_requested(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
        ]);

        $response = $this->post('/forgot-password', [
            'email' => 'test@example.com',
        ]);

        $response->assertSessionHas('status');
        $this->assertDatabaseHas('password_reset_tokens', [
            'email' => 'test@example.com',
        ]);
    }

    public function test_password_can_be_reset_with_valid_token_and_strict_password(): void
    {
        $user = User::factory()->create([
            'email' => 'resetuser@example.com',
            'password' => Hash::make('OldPassword@123!'),
        ]);

        $token = 'test-reset-token-12345';
        \Illuminate\Support\Facades\DB::table('password_reset_tokens')->insert([
            'email' => 'resetuser@example.com',
            'token' => Hash::make($token),
            'created_at' => now(),
        ]);

        // Access the reset password page
        $pageResponse = $this->get('/reset-password/' . $token . '?email=resetuser@example.com');
        $pageResponse->assertStatus(200);

        // Submit new strict password
        $response = $this->post('/reset-password', [
            'token' => $token,
            'email' => 'resetuser@example.com',
            'password' => 'NewPassword@2026!',
            'password_confirmation' => 'NewPassword@2026!',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHas('status');
        $this->assertTrue(Hash::check('NewPassword@2026!', $user->fresh()->password));
        $this->assertDatabaseMissing('password_reset_tokens', [
            'email' => 'resetuser@example.com',
        ]);
    }

    public function test_regular_user_cannot_access_user_management(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)
            ->withSession(['auth.otp_verified' => true])
            ->get('/users');
        $response->assertStatus(403);
    }

    public function test_admin_can_access_user_management(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($admin)
            ->withSession(['auth.otp_verified' => true])
            ->get('/users');
        $response->assertStatus(200);
        $response->assertSee('User Management');
    }

    public function test_admin_can_create_user_with_role(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($admin)
            ->withSession(['auth.otp_verified' => true])
            ->post('/users', [
                'name' => 'Manager User',
                'email' => 'manager@automata.com',
                'role' => 'admin',
                'password' => 'Admin@Secure999!',
                'password_confirmation' => 'Admin@Secure999!',
            ]);

        $response->assertRedirect('/users');
        $this->assertDatabaseHas('users', [
            'email' => 'manager@automata.com',
            'role' => 'admin',
        ]);
    }
}
