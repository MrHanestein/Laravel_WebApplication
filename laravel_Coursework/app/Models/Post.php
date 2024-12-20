<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Like;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Post extends Model
{
    protected $fillable = ['title', 'description', 'image', 'user_id'];

    /**
     * Get all of the post's likes.
     */
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    /**
     * The tags that belong to the post.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Get the user that owns the post.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the post's comments.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
