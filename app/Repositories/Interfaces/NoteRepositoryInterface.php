<?php

namespace App\Repositories\Interfaces;

use App\Models\Note;
use Illuminate\Database\Eloquent\Collection;

interface NoteRepositoryInterface
{
    public function getUserNotes(int $user_id): Collection;

    public function getUserNote(int $user_id, int $note_id): Note;

    public function delete(Note $note): ?bool;

    public function create(array $data): Note;

    public function update(Note $note, array $data): Note;
}
