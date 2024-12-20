<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Comment $comment): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        // Any authenticated user can create comments
        return $user != null;
    }

    public function update(User $user, Comment $comment): bool
    {
        // Admin or owner of comment can update
        return $user->usertype === 'admin' || $comment->user_id == $user->id;
    }

    public function delete(User $user, Comment $comment): bool
    {
        // Admin or owner of comment can delete
        return $user->usertype === 'admin' || $comment->user_id == $user->id;
    }

    public function restore(User $user, Comment $comment): bool
    {
        return false;
    }

    public function forceDelete(User $user, Comment $comment): bool
    {
        return false;
    }
}
