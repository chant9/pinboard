<?php

namespace App\Models;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'url',
        'available',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Attach the tags to the article.
     *
     * @param array $tags
     * @return void
     */
    public function setTags(array $tags)
    {
        // Make any tags that don't exist.
        foreach($tags as $tag){
            Tag::firstOrCreate(['name' => $tag])->save();
        }

        // Get the tag IDs to sync to the article.
        $tags = Tag::whereIn('name', $tags)->get()->pluck('id');
        $this->tags()->sync($tags);
    }
}
