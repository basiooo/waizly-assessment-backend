<?php

namespace App\Repositories;

use App\Models\Note;
use App\Repositories\Interfaces\NoteRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NoteRepository implements NoteRepositoryInterface
{
    protected $note;

    public function __construct(Note $note)
    {
        $this->note = $note;
    }

    public function getUserNotes(int $user_id): Collection
    {
        return $this->note::where('user_id', $user_id)->get();
    }

    public function getUserNote(int $user_id, int $note_id): Note
    {
        $note = $this->note::where('user_id', $user_id)->where('id', $note_id)->first();
        if (! $note) {
            throw new NotFoundHttpException('Note not found');
        }

        return $note;
    }

    public function delete(Note $note): ?bool
    {
        return $note->delete();
    }

    public function create(array $data): Note
    {
        $note = $this->note;
        $note->title = $data['title'];
        $note->body = $data['body'];
        $note->user_id = $data['user_id'];
        $note->save();

        return $note->fresh();
    }

    public function update(Note $note, array $data): Note
    {
        $note->title = $data['title'];
        $note->body = $data['body'];
        $note->update();

        return $note;
    }
}
