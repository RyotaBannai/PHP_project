<?php

namespace App\Builder;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CustomBuilder extends Builder
{
    public function findBySlug($slug, $columns = ['*'])
    {
        return $this->where('slug', $slug)->first($columns);
    }

    public function findBySlugOrFail($slug, $columns = ['*'])
    {
        return $this->where('slug', $slug)->firstOrFail($columns);
    }
}
