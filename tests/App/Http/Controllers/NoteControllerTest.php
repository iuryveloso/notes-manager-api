<?php

namespace Tests\App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use Tests\TestCase;

// php artisan test --filter=NoteControllerTest
class NoteControllerTest extends TestCase
{
    // php artisan test --filter=NoteControllerTest::testIndex
    public function testIndex(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum')
        ->getJson('api/notes')
        ->assertOk();
    }
    
    // php artisan test --filter=NoteControllerTest::testStore
    public function testStore(): void
    {
        $user = User::factory()->create();
        $madeNote = Note::factory()->makeOne();
        $noteToBeTested = [
            "title" => $madeNote->title,
            "body" => $madeNote->body,
            "color" => $madeNote->color,
            "favorited" => $madeNote->favorited
        ];
        $this->actingAs($user, 'sanctum')
        ->postJson('api/notes',$noteToBeTested)
        ->assertOk();
    }

    // php artisan test --filter=NoteControllerTest::testShow
    public function testShow(): void
    {
        $user = User::factory()->create();
        $note = Note::factory()->create(["user_id" => $user->id]);
        $this->actingAs($user, 'sanctum')
        ->getJson('api/notes/'.$note->id)
        ->assertOk();
    }

    // php artisan test --filter=NoteControllerTest::testUpdate
    public function testUpdate(): void
    {
        $user = User::factory()->create();
        $note = Note::factory()->create(["user_id" => $user->id]);
        $newNote = Note::factory()->makeOne();
        $noteToBeTested = [
            "title" => $newNote->title,
            "body" => $newNote->body,
            "color" => $newNote->color,
            "favorited" => $newNote->favorited
        ];
        $this->actingAs($user, 'sanctum')
        ->patchJson('api/notes/'.$note->id, $noteToBeTested)
        ->assertOk();
    }

    // php artisan test --filter=NoteControllerTest::testDestroy
    public function testDestroy(): void
    {
        $user = User::factory()->create();
        $note = Note::factory()->create(["user_id" => $user->id]);
        $this->actingAs($user, 'sanctum')
        ->deleteJson('api/notes/'.$note->id)
        ->assertOk();
    }

    // php artisan test --filter=NoteControllerTest::testRestore
    public function testRestore(): void
    {
        $user = User::factory()->create();
        $note = Note::factory()->create(["user_id" => $user->id]);
        $note->delete();
        $this->actingAs($user, 'sanctum')
        ->postJson('api/notes/restore/'.$note->id)
        ->assertOk();
    }
}
