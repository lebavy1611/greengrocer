<?php

namespace App\Policies;

use App\Models\Account;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Manager;

class ManagerPolicy
{
    use HandlesAuthorization;

    const RESOURCE = 'Manager';

    const ENABLED = 1;
    /**
     * Determine whether the user can view the manager.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Manager  $manager
     * @return mixed
     */
    public function view(Account $account, Manager $manager)
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
     * Determine whether the user can update the manager.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Manager  $manager
     * @return mixed
     */
    public function update(Account $account, Manager $manager)
    {
        return getRoleResource(self::RESOURCE)->can_edit == self::ENABLED;                
    }

    /**
     * Determine whether the user can delete the manager.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Manager  $manager
     * @return mixed
     */
    public function delete(Account $account, Manager $manager)
    {
        return getRoleResource(self::RESOURCE)->can_del == self::ENABLED;
    }
}
