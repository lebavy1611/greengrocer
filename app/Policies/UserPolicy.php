<?php

namespace App\Policies;

use App\Models\Account;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;

class UserPolicy
{
    use HandlesAuthorization;

    const RESOURCE = 'User';

    const ENABLED = 1;
    /**
     * Determine whether the user can view the user.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\User  $user
     * @return mixed
     */
    public function view(Account $account, User $user)
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
     * Determine whether the user can update the user.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\User  $user
     * @return mixed
     */
    public function update(Account $account, User $user)
    {
        return getRoleResource(self::RESOURCE)->can_edit == self::ENABLED;                
    }

    /**
     * Determine whether the user can delete the user.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\User  $user
     * @return mixed
     */
    public function delete(Account $account, User $user)
    {
        return getRoleResource(self::RESOURCE)->can_del == self::ENABLED;
    }
}
