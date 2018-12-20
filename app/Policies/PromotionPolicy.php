<?php

namespace App\Policies;

use App\Models\Account;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Promotion;

class PromotionPolicy
{
    use HandlesAuthorization;

    const RESOURCE = 'Promotion';

    const ENABLED = 1;
    /**
     * Determine whether the user can view the promotion.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Promotion  $promotion
     * @return mixed
     */
    public function view(Account $account, Promotion $promotion)
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
     * Determine whether the user can update the promotion.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Promotion  $promotion
     * @return mixed
     */
    public function update(Account $account, Promotion $promotion)
    {
        return getRoleResource(self::RESOURCE)->can_edit == self::ENABLED;                
    }

    /**
     * Determine whether the user can delete the promotion.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Promotion  $promotion
     * @return mixed
     */
    public function delete(Account $account, Promotion $promotion)
    {
        return getRoleResource(self::RESOURCE)->can_del == self::ENABLED;
    }
}
