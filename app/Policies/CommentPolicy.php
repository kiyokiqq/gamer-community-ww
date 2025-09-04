<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    /**
     * Користувач може створювати коментарі.
     */
    public function create(User $user): bool
    {
        return $user !== null; // будь-який авторизований користувач
    }

    /**
     * Користувач може редагувати тільки свій коментар.
     */
    public function update(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id;
    }

    /**
     * Користувач може видаляти тільки свій коментар.
     */
    public function delete(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id;
    }
}
