<?php

namespace Tests\Feature\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('name="role"', false);
        $response->assertSee('value="patient"', false);
        $response->assertSee('value="medecin"', false);
        $response->assertSee('value="secretaire"', false);
        $response->assertSee('value="responsable_prestation"', false);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'prenom' => 'Demo',
            'role' => 'patient',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_new_users_can_register_with_a_demo_role(): void
    {
        $response = $this->post('/register', [
            'name' => 'Demo Doctor',
            'prenom' => 'Role',
            'role' => 'medecin',
            'email' => 'doctor@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $this->assertTrue(auth()->user()->hasRole('medecin'));
        $response->assertRedirect(RouteServiceProvider::HOME);
    }
}
