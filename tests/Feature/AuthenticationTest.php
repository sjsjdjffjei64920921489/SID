<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_creates_a_user_and_starts_a_session(): void
    {
        $response = $this->post('/register', [
            'name' => 'SID Member',
            'email' => 'member@example.com',
            'password' => 'secure-password',
            'password_confirmation' => 'secure-password',
        ]);

        $user = User::where('email', 'member@example.com')->firstOrFail();

        $response->assertRedirect(route('home'))
            ->assertSessionHas('status', 'Your account is ready.');
        $this->assertAuthenticatedAs($user);
        $this->assertTrue(Hash::check('secure-password', $user->password));
    }

    public function test_registration_requires_unique_email_and_matching_confirmed_password(): void
    {
        User::factory()->create(['email' => 'member@example.com']);

        $response = $this->from('/register')->post('/register', [
            'name' => 'SID Member',
            'email' => 'member@example.com',
            'password' => 'secure-password',
            'password_confirmation' => 'different-password',
        ]);

        $response->assertRedirect('/register')
            ->assertSessionHasErrors(['email', 'password']);
        $this->assertGuest();
    }

    public function test_existing_user_can_log_in_and_log_out(): void
    {
        $user = User::factory()->create([
            'email' => 'member@example.com',
            'password' => 'secure-password',
        ]);

        $login = $this->post('/login', [
            'email' => 'MEMBER@example.com',
            'password' => 'secure-password',
            'remember' => '1',
        ]);

        $login->assertRedirect(route('home'))
            ->assertSessionHas('status', 'Welcome back.');
        $this->assertAuthenticatedAs($user);

        $this->post('/logout')->assertRedirect(route('home'));
        $this->assertGuest();
    }

    public function test_login_rejects_invalid_credentials(): void
    {
        User::factory()->create([
            'email' => 'member@example.com',
            'password' => 'secure-password',
        ]);

        $this->from('/login')->post('/login', [
            'email' => 'member@example.com',
            'password' => 'wrong-password',
        ])->assertRedirect('/login')
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_guest_sees_registration_and_login_pages(): void
    {
        $this->get('/register')->assertOk()->assertSee('Create account');
        $this->get('/login')->assertOk()->assertSee('Log in');
    }
}
