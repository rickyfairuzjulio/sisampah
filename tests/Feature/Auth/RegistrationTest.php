<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $bank = \App\Models\BankSampah::create([
            'nama' => 'Bank Sampah Unit Test',
            'kode_bank' => 'BSUT01',
            'alamat' => 'Jl. Test No. 1',
            'telepon' => '08123456789',
            'email' => 'unit@test.com',
            'status' => 'aktif',
            'is_active' => true,
        ]);

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'bank_sampah_id' => $bank->id,
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('nasabah.dashboard', absolute: false));
    }
}
