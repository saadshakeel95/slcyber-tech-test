<?php

namespace App\Http\Services\Book;

use App\Models\Book;


class Index
{
    public function __invoke($request)
    {
        $data=Book::query();
        if (!empty($request->search)) {
            $data=$data->where('title', 'like', '%' . $request->search . '%');
        }
        return $data->get();
    }
}
