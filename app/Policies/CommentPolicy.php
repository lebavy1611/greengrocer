<?php

namespace App\Policies;

use App\Models\Account;
use App\Models\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    const RESOURCE = 'Comment';

    const ENABLED = 1;
    /**
     * Determine whether the user can view the comment.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Comment  $comment
     * @return mixed
     */
    public function view(Account $account, Comment $comment)
    {
        return getRoleResource(self::RESOURCE)->can_view == self::ENABLED;
    }

    /**
     * Determine whether the user can create categories.
     *
     * @param  \App\Models\Account  $account
     * @return mixed
     */
    public function create(Account $account)
    {
        return getRoleResource(self::RESOURCE)->can_add == self::ENABLED;        
    }

    /**
     * Determine whether the user can update the comment.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Comment  $comment
     * @return mixed
     */
    public function update(Account $account, Comment $comment)
    {
        return getRoleResource(self::RESOURCE)->can_edit == self::ENABLED;                
    }

    /**
     * Determine whether the user can delete the comment.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Comment  $comment
     * @return mixed
     */
    public function delete(Account $account, Comment $comment)
    {
        return getRoleResource(self::RESOURCE)->can_del == self::ENABLED;
    }
}
