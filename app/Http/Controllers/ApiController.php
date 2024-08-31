<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;

class ApiController extends Controller
{
    /**
     * Return the list of articles.
     */
    public function articles(): Collection
    {
        return Article::with('tags')
            ->get();
    }

    /**
     * Return the list of tags, filtered by the app focused ones.
     */
    public function tags(): Collection
    {
        return Tag::whereIn('name', config('app.tags'))
            ->orderBy('name')
            ->get();
    }
}
