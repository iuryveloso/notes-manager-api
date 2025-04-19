<?php

namespace Tests\App\Http\Controllers;

use App\Models\Todo;
use App\Models\User;
use Tests\TestCase;

// php artisan test --filter=TodoControllerTest
class TodoControllerTest extends TestCase
{
    // php artisan test --filter=TodoControllerTest::testIndex
    public function testIndex(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum')
        ->getJson('api/todos')
        ->assertOk();
    }
    
    // php artisan test --filter=TodoControllerTest::testStore
    public function testStore(): void
    {
        $user = User::factory()->create();
        $madeTodo = Todo::factory()->makeOne();
        $todoToBeTested = [
            "title" => $madeTodo->title,
            "body" => $madeTodo->body,
            "color" => $madeTodo->color,
            "favorited" => $madeTodo->favorited
        ];
        $this->actingAs($user, 'sanctum')
        ->postJson('api/todos',$todoToBeTested)
        ->assertOk();
    }

    // php artisan test --filter=TodoControllerTest::testShow
    public function testShow(): void
    {
        $user = User::factory()->create();
        $todo = Todo::factory()->create(["user_id" => $user->id]);
        $this->actingAs($user, 'sanctum')
        ->getJson('api/todos/'.$todo->id)
        ->assertOk();
    }

    // php artisan test --filter=TodoControllerTest::testUpdate
    public function testUpdate(): void
    {
        $user = User::factory()->create();
        $todo = Todo::factory()->create(["user_id" => $user->id]);
        $newTodo = Todo::factory()->makeOne();
        $todoToBeTested = [
            "title" => $newTodo->title,
            "body" => $newTodo->body,
            "color" => $newTodo->color,
            "favorited" => $newTodo->favorited
        ];
        $this->actingAs($user, 'sanctum')
        ->patchJson('api/todos/'.$todo->id, $todoToBeTested)
        ->assertOk();
    }

    // php artisan test --filter=TodoControllerTest::testDestroy
    public function testDestroy(): void
    {
        $user = User::factory()->create();
        $todo = Todo::factory()->create(["user_id" => $user->id]);
        $this->actingAs($user, 'sanctum')
        ->deleteJson('api/todos/'.$todo->id)
        ->assertOk();
    }

    // php artisan test --filter=TodoControllerTest::testRestore
    public function testRestore(): void
    {
        $user = User::factory()->create();
        $todo = Todo::factory()->create(["user_id" => $user->id]);
        $todo->delete();
        $this->actingAs($user, 'sanctum')
        ->postJson('api/todos/restore/'.$todo->id)
        ->assertOk();
    }
}
