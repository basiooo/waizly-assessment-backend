<?php

namespace App\Services;

use App\Http\Resources\NoteResource;
use App\Models\Note;
use App\Repositories\NoteRepository;
use App\Services\Interfaces\NoteServiceInterface;
use Illuminate\Database\Eloquent\Collection;

class NoteService implements NoteServiceInterface
{
    protected $noteRepository;

    public function __construct(NoteRepository $noteRepository)
    {
        $this->noteRepository = $noteRepository;
    }

    public function getNotes(int $user_id): Collection
    {
        return $this->noteRepository->getUserNotes($user_id);
    }

    public function getNote(int $user_id, int $note_id): Note
    {
        return $this->noteRepository->getUserNote($user_id, $note_id);
    }

    public function createNoteResourceCollection(Collection $notes)
    {
        return NoteResource::collection($notes)->all();
    }

    public function createNoteResourceArray($note): array
    {
        return (new NoteResource($note))->toArray(request());
    }

    public function deleteNote(int $note_id): ?bool
    {
        $user_id = auth()->user()->id;
        $note = $this->getNote($user_id, $note_id);

        return $this->noteRepository->delete($note);
    }

    public function createNote(array $data): Note
    {
        $data['user_id'] = auth()->user()->id;

        return $this->noteRepository->create($data);
    }

    public function updateNote(int $note_id, array $data): Note
    {
        $user_id = auth()->user()->id;
        $note = $this->getNote($user_id, $note_id);

        return $this->noteRepository->update($note, $data);
    }
}
