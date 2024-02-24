<?php

namespace Tests\Feature;

use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use function PHPUnit\Framework\assertSame;

class NoteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_user_get_notes_without_credential(): void
    {
        $response = $this->json('Get', route('api.notes.index'));
        $response->assertStatus(401);
    }

    public function test_user_get_notes_with_credential(): void
    {
        $this->seed();
        $user = User::where('email', 'test@test.com')->first();
        $token = $user->createToken('auth_token')->plainTextToken;
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$token,
        ];
        $response = $this->json('Get', route('api.notes.index'), headers: $headers);
        $response->assertStatus(200);
    }

    public function test_user_get_note(): void
    {
        $this->seed();
        $user = User::where('email', 'test@test.com')->first();
        $token = $user->createToken('auth_token')->plainTextToken;
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$token,
        ];
        $response = $this->json('Get', route('api.notes.show', ['note' => 1]), headers: $headers);
        $response->assertStatus(200);
    }

    public function test_user_delete_note(): void
    {
        $this->seed();
        $user = User::where('email', 'test@test.com')->first();
        $token = $user->createToken('auth_token')->plainTextToken;
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$token,
        ];
        assertSame(1, Note::where('id', 1)->count());
        $response = $this->json('Delete', route('api.notes.destroy', ['note' => 1]), headers: $headers);
        $response->assertStatus(204);
        assertSame(0, Note::where('id', 1)->count());
    }

    public function test_user_create_note(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$token,
        ];
        assertSame(0, Note::count());
        $response = $this->json('Post', route('api.notes.index'), headers: $headers, data: [
            'title' => 'test title',
            'body' => 'test body',
        ]);
        $response->assertStatus(201);
        assertSame(1, Note::count());
    }

    public function test_user_create_note_invalid_payload(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$token,
        ];
        assertSame(0, Note::count());
        $response = $this->json('Post', route('api.notes.store'), headers: $headers, data: [
            'title' => 'test title',
        ]);
        $response->assertStatus(400);
        assertSame(0, Note::count());
    }

    public function test_user_update_note(): void
    {
        $this->seed();
        $user = User::where('email', 'test@test.com')->first();
        $token = $user->createToken('auth_token')->plainTextToken;
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$token,
        ];
        assertSame(1, Note::where('id', 1)->count());
        $response = $this->json('Patch', route('api.notes.update', ['note' => 1]), headers: $headers, data: [
            'title' => 'test title123',
            'body' => 'test body',
        ]);
        $response->assertStatus(200);
        assertSame('test title123', Note::where('id', 1)->first()->title);
    }
}
