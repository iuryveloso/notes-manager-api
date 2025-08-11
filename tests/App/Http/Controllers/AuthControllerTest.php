<?php

namespace Tests\App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

// php artisan test --filter=AuthControllerTest
class AuthControllerTest extends TestCase
{
    // php artisan test --filter=AuthControllerTest::testLogin
    public function testLogin(): void
    {
        $userPassword = fake()->password(26, 26);
        $hashedUserPassword = Hash::make($userPassword);
        $user = User::factory()->create(["password" => $hashedUserPassword]);
        $userToBeTested = [
            "email" => $user->email,
            "password" => $userPassword,
        ];
        $this->postJson('api/login', $userToBeTested)->assertOk();
    }

    // php artisan test --filter=AuthControllerTest::testLoginWithWrongPassword
    public function testLoginWithWrongPassword(): void
    {
        $wrongPassword = fake()->password(26, 26);
        $user =User::factory()->create();
        $userToBeTested = [
            "email" => $user->email,
            "password" => $wrongPassword,
        ];
        $this->postJson('api/login', $userToBeTested)->assertStatus(422);
    }

    // php artisan test --filter=AuthControllerTest::testLoginWithWrongEmail
    public function testLoginWithWrongEmail(): void
    {
        $userPassword = fake()->password(26, 26);
        $hashedUserPassword = Hash::make($userPassword);
        User::factory()->create(["password" => $hashedUserPassword]);
        $wrongEmail = fake()->unique()->safeEmail();
        $userToBeTested = [
            "email" => $wrongEmail,
            "password" => $userPassword,
        ];
        $this->postJson('api/login', $userToBeTested)->assertStatus(422);
    }

    // php artisan test --filter=AuthControllerTest::testRegister
    public function testRegister(): void
    {
        $userPassword = fake()->password(26, 26);
        $user = User::factory()->makeOne();
        $file = UploadedFile::fake()->image('avatar.png');

        $userToBeTested = [
            "name" => $user->name,
            "email" => $user->email,
            "file" => $file,
            "password" => $userPassword,
            "password_confirmation" => $userPassword,
        ];
        $this->postJson('api/register', $userToBeTested)->assertOk();
    }

    // php artisan test --filter=AuthControllerTest::testLogout
    public function testLogout(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum')
            ->postJson('api/logout')
            ->assertOk();
    }

}
