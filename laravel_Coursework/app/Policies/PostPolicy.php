<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function viewAny(User $user): bool
    {
        // Allow admin or user to view any posts
        return true;
    }

    public function view(User $user, Post $post): bool
    {
        // Everyone can view
        return true;
    }

    public function create(User $user): bool
    {
        // Any authenticated user can create posts
        return $user != null;
    }

    public function update(User $user, Post $post): bool
    {
        // Admin or owner of post can update
        return $user->usertype === 'admin' || $post->user_id == $user->id;
    }

    public function delete(User $user, Post $post): bool
    {
        // Admin or owner of post can delete
        return $user->usertype === 'admin' || $post->user_id == $user->id;
    }

    public function restore(User $user, Post $post): bool
    {
        return false;
    }

    public function forceDelete(User $user, Post $post): bool
    {
        return false;
    }
}
