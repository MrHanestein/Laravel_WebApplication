<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Post;
use App\Models\Comment;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * The posts that belong to the tag.
     */
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }

    /**
     * Example additional relationship (if needed).
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
