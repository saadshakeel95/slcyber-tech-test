<?php

namespace App\Http\Services\Book;

use App\Models\Book;

class Show
{
    public function __invoke(string $id)
    {
        return Book::findOrFail($id);
    }
}
