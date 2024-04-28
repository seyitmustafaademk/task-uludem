<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Note\StoreRequest;
use App\Http\Requests\Note\UpdateRequest;
use App\Http\Resources\Note\NoteResource;
use App\Http\Resources\Note\NoteResourceCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $notes = auth()->user()->notes()->paginate();

            return new NoteResourceCollection($notes);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $note = auth()->user()->notes()->create([
                'title' => $request->get('title'),
                'content' => $request->get('content')
            ]);

            return response()->json([
                'message' => 'Note created successfully.',
                'data' => $note
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $note = auth()->user()->notes()->findOrFail($id);

            return new NoteResource($note);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        try {
            $note = auth()->user()->notes()->findOrFail($id);

            $note->update([
                'title' => $request->get('title'),
                'content' => $request->get('content')
            ]);

            return response()->json([
                'message' => 'Note updated successfully.',
                'data' => $note
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Note not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $note = auth()->user()->notes()->findOrFail($id);

            $note->delete();

            return response()->json([
                'message' => 'Note deleted successfully.'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Note not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
