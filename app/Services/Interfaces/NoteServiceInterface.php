<?php

namespace App\Services\Interfaces;

use App\Models\Note;
use Illuminate\Database\Eloquent\Collection;

interface NoteServiceInterface
{
    public function getNotes(int $user_id): Collection;

    public function getNote(int $user_id, int $note_id): Note;

    public function createNoteResourceCollection(Collection $notes);

    public function createNoteResourceArray($note): array;

    public function deleteNote(int $note_id): ?bool;

    public function createNote(array $data): Note;

    public function updateNote(int $note_id, array $data): Note;
}
