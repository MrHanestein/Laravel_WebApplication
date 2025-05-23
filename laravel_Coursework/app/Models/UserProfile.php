<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    protected $table = 'user_profiles';
    protected $fillable = ['user_id','bio','avatar'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
