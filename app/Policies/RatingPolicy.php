<?php

namespace App\Policies;

use App\Models\Account;
use App\Models\Rating;
use Illuminate\Auth\Access\HandlesAuthorization;

class RatingPolicy
{
    use HandlesAuthorization;

    const RESOURCE = 'Rating';

    const ENABLED = 1;
    /**
     * Determine whether the user can view the rating.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Rating  $rating
     * @return mixed
     */
    public function view(Account $account, Rating $rating)
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
     * Determine whether the user can update the rating.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Rating  $rating
     * @return mixed
     */
    public function update(Account $account, Rating $rating)
    {
        return getRoleResource(self::RESOURCE)->can_edit == self::ENABLED;                
    }

    /**
     * Determine whether the user can delete the rating.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Rating  $rating
     * @return mixed
     */
    public function delete(Account $account, Rating $rating)
    {
        return getRoleResource(self::RESOURCE)->can_del == self::ENABLED;
    }
}
