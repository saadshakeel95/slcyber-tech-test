<?php

namespace App\Http\Services\Genre;

use App\Models\Genre;

class Show
{
    public function __invoke(string $id)
    {
        return Genre::findOrFail($id);
    }
}
