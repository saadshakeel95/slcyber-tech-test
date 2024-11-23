<?php

namespace App\Http\Services\Book;

use App\Models\Book;
use Illuminate\Support\Arr;

class Index
{
    public function __invoke(array $params = [])
    {
        $searchTerm = Arr::get($params, 'search', '');

        return Book::where('title', 'like', '%'.$searchTerm.'%')->get();
    }
}
