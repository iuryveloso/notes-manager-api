<?php

namespace Tests\App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

// php artisan test --filter=UserControllerTest
class UserControllerTest extends TestCase
{
    // php artisan test --filter=UserControllerTest::testShow
    public function testShow(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum')
        ->getJson('api/user')
        ->assertOk();
    }

    // php artisan test --filter=UserControllerTest::testUpdate
    public function testUpdate(): void
    {
        $user = User::factory()->create();
        $madeUser = User::factory()->makeOne();
        $userToBeTested = [
            "name" => $madeUser->name,
            "email" => $madeUser->email,
        ];
        $this->actingAs($user, 'sanctum')
        ->patchJson('api/user/update', $userToBeTested)
        ->assertOk();
    }
    
    // php artisan test --filter=UserControllerTest::testUpdateAvatar
    public function testUpdateAvatar(): void
    {
        $user = User::factory()->create();
        $file = UploadedFile::fake()->image('avatar.png');
        $userToBeTested = [
            "file" => $file,
        ];
        $this->actingAs($user, 'sanctum')
        ->postJson('api/user/update/avatar', $userToBeTested)
        ->assertOk();
    }

    // php artisan test --filter=UserControllerTest::testUpdateAvatarWithWrongFile
    public function testUpdateAvatarWithWrongFile(): void
    {
        $user = User::factory()->create();
        // supported files : jpeg, png and svg
        $wrongFile = UploadedFile::fake()->image('avatar.bmp');
        $userToBeTested = [
            "file" => $wrongFile,
        ];
        $this->actingAs($user, 'sanctum')
        ->postJson('api/user/update/avatar', $userToBeTested)
        ->assertStatus(422);
    }

    // php artisan test --filter=UserControllerTest::testUpdatePassword
    public function testUpdatePassword(): void
    {
        $userPassword = fake()->password(26,26);
        $hashedUserPassword = Hash::make($userPassword);
        $user = User::factory()->create(["password" => $hashedUserPassword]);
        
        $newUserpassword = fake()->password(26,26);

        $userToBeTested = [
            "old_password" => $userPassword,
            "password" => $newUserpassword,
            "password_confirmation" => $newUserpassword,
        ];

        $this->actingAs($user, 'sanctum')
        ->patchJson('api/user/update/password', $userToBeTested)
        ->assertOk();
    }

}
