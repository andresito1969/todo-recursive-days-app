<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
class UserTest extends TestCase
{
    // Common method in class
    private function fakerRegister($testMail) {
        return $this->post('/api/register', [
            'name' => 'Andrés',
            'email' => $testMail,
            'password' => 'test12345'
        ]);
    }

    /**
     * Register Tests
     */
    public function test_register(): void
    {
        $testMail = 'andres@test.api';
        $response = $this->fakerRegister($testMail);
        $user = User::where('email', $testMail)->delete();
        $response->assertStatus(200);
    }

    public function test_incorrect_register_missing_info(): void
    {
        $response = $this->post('/api/register', [
            'email' => 'new@test.api',
            'password' => bcrypt(12345678),
        ]);

        $response->assertStatus(400);
    }

    public function test_incorrect_register_duplicated_mail(): void
    {
        // first call (to test dups)
        $testMail = 'andres@test.api';
        $this->fakerRegister($testMail);

        $response = $this->fakerRegister($testMail);
        $user = User::where('email', $testMail)->delete();
        $response->assertStatus(400);
    }

    /*
     * Login Tests
     */
    public function test_login(): void
    {
        $testMail = 'andres@test.api';
        $this->fakerRegister($testMail);

        $response = $this->post('/api/login', [
            'email' => $testMail,
            'password' => 'test12345' // if we use bcrypt here it will assume that the encryption is the password (we never send in the front or in a request this)
        ]);

        $user = User::where('email', $testMail)->delete();
        $response->assertStatus(200);
    }

    public function test_incorrect_login_wrong_pass(): void
    {
        $testMail = 'andres@test.api';
        $this->fakerRegister($testMail);

        $response = $this->post('/api/login', [
            'email' => $testMail,
            'password' => 'test'
        ]);

        $user = User::where('email', $testMail)->delete();
        $response->assertStatus(401);
    }
}
