<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Like extends Model
{
    protected $fillable = ['user_id'];

    /**
     * Get the parent likeable model (post or comment).
     */
    public function likeable()
    {
        return $this->morphTo();
    }

    /**
     * Get the user who liked.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
