<?php

namespace App\Http\Controllers;

use App\Http\Requests\Genre\DestroyRequest;
use App\Http\Requests\Genre\IndexRequest;
use App\Http\Requests\Genre\StoreRequest;
use App\Http\Requests\Genre\UpdateRequest;
use App\Http\Services\Genre\Destroy;
use App\Http\Services\Genre\Index;
use App\Http\Services\Genre\Show;
use App\Http\Services\Genre\Store;
use App\Http\Services\Genre\Update;
use App\Models\Genre;

class GenreController extends Controller
{
    public function index(IndexRequest $request, Index $index)
    {
        return response()->json([
            'message' => 'Successfully fetched the genres.',
            'data' => $index($request->validated()),
        ]);
    }

    public function show(Genre $genre, Show $show)
    {
        return response()->json([
            'message' => 'Successfully fetched a genre.',
            'data' => $genre,
        ]);
    }

    public function store(StoreRequest $request, Store $store)
    {
        $genre = $store($request->validated());

        return response()->json([
            'message' => 'Successfully stored the genre.',
            'data' => $genre
        ]);
    }

    public function update(UpdateRequest $request, Update $update, Genre $genreToUpdate)
    {
        $updatedGenre = $update($request->validated(), $genreToUpdate);

        return response()->json([
            'message' => 'Successfully updated the genre.',
            'data' => $updatedGenre
        ]);
    }

    public function destroy(DestroyRequest $request, Destroy $destroy, Genre $genre)
    {
        $destroy($genre);

        return response()->json([
            'message' => 'Successfully deleted the genre.',
        ]);
    }
}
