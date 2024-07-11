<?php

namespace App\Http\Controllers\Api\Notes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Notes\StoreNoteRequest;
use App\Http\Requests\Api\Notes\UpdateNoteRequest;
use App\Http\Resources\Notes\NoteResource;
use App\Models\Note;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class NoteController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function index():AnonymousResourceCollection
    {
        return NoteResource::collection(
            Auth::user()->notes()->get()
        )->additional([
            'message' => __('Notes retrieved successfully'),
            'status' => Response::HTTP_OK
        ]);
    }

    /**
     * @param StoreNoteRequest $request
     * @return NoteResource
     */
    public function store(
        StoreNoteRequest $request
    ):NoteResource
    {
        return NoteResource::make(
            Auth::user()->notes()->create($request->validated())
        )->additional([
            'message' => __('Note created successfully'),
            'status' => Response::HTTP_CREATED
        ]);
    }

    /**
     * @param Note $note
     * @return NoteResource
     */
    public function show(
        Note $note
    ):NoteResource
    {
        return NoteResource::make(
            $note
        )->additional([
            'message' => __('Note retrieved successfully'),
            'status' => Response::HTTP_OK
        ]);
    }

    /**
     * @param Note $note
     * @param UpdateNoteRequest $request
     * @return NoteResource|JsonResponse
     */
    public function update(
        $note,
        UpdateNoteRequest $request
    ):NoteResource|JsonResponse
    {
        $note = Note::where([
            'id'=>$note,
            'user_id'=>Auth::user()->id
        ])->first();
        if(! $note instanceof  Note){
            return response()->json([
                'message' => __("We couldn't update the Note"),
                'status' => Response::HTTP_BAD_REQUEST
            ], Response::HTTP_BAD_REQUEST);
        }
        if( $note->update($request->validated())) {
            return NoteResource::make(
                $note
            )->additional([
                'message' => __('Note Updated successfully'),
                'status' => Response::HTTP_OK
            ]);
        }
        return response()->json([
            'message' => __("We couldn't update the Note"),
            'status' => Response::HTTP_BAD_REQUEST
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param Note $note
     * @return JsonResponse
     */
    public function destroy(
        Note $note
    ):JsonResponse
    {
        if($note->delete())
        {
            return response()->json([
                'message' => __("Note deleted successfully."),
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
        }
        return response()->json([
            'message' => __("We couldn't delete the Note"),
            'status' => Response::HTTP_BAD_REQUEST
        ], Response::HTTP_BAD_REQUEST);

    }
}
