<?php

namespace App\Http\Services\Book;

use App\Models\Book;
use Illuminate\Support\Arr;

class Update
{
    public function __invoke(array $data, Book $book): Book
    {
        $book->update([
            'title' => $data['title'] ?? $book->title,
            'author' => $data['author'] ?? $book->author,
            'rating' => $data['rating'] ?? $book->rating,
        ]);

        // Attach genres to the book
        $book->genres()->sync(Arr::get($data, 'genres', []));

        return $book;
    }
}
