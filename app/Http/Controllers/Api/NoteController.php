<?php

namespace App\Http\Controllers\Api;

use App\Helpers\CommonHelper\CommonHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Note\NoteRequest;
use App\Services\NoteService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class NoteController extends Controller
{
    protected $noteService;

    public function __construct(NoteService $noteService)
    {
        $this->noteService = $noteService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $notes = $this->noteService->getNotes($user_id);
        $notes_resource = $this->noteService->createNoteResourceCollection($notes);
        Log::info(CommonHelper::getCurrentController().' success get list notes');

        return CommonHelper::makeResponse(
            'true',
            'success get list notes',
            $notes_resource,
            Response::HTTP_OK,
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NoteRequest $request)
    {
        $result = $this->noteService->createNote($request->all());
        Log::info(CommonHelper::getCurrentController().' success create note : user_id: '.$result->user_id.' , note_id: '.$result->id);

        return CommonHelper::makeResponse(
            true,
            'success get note',
            $result->toArray(),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(int $note_id)
    {
        $user_id = auth()->user()->id;
        $note = $this->noteService->getNote($user_id, $note_id);
        $note_resource = $this->noteService->createNoteResourceArray($note);
        Log::info(CommonHelper::getCurrentController()." success get note : note_id: $note_id");

        return CommonHelper::makeResponse(
            true,
            'success get note',
            $note_resource,
            Response::HTTP_OK
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NoteRequest $request, string $note_id)
    {
        $note_resource = $this->noteService->updateNote($note_id, $request->all());
        Log::info(CommonHelper::getCurrentController()." success update note : note_id: $note_id");

        return CommonHelper::makeResponse(
            true,
            'success update note',
            $note_resource->toArray(),
            Response::HTTP_OK
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $note_id)
    {
        $this->noteService->deleteNote($note_id);
        Log::info(CommonHelper::getCurrentController()." success delete note : note_id: $note_id");

        return CommonHelper::makeResponse(
            true,
            'Success delete note',
            status_code: Response::HTTP_NO_CONTENT,
        );
    }
}
