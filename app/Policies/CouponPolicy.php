<?php

namespace App\Policies;

use App\Models\Account;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Coupon;

class CouponPolicy
{
    use HandlesAuthorization;

    const RESOURCE = 'Coupon';

    const ENABLED = 1;
    /**
     * Determine whether the user can view the coupon.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Coupon  $coupon
     * @return mixed
     */
    public function view(Account $account, Coupon $coupon)
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
     * Determine whether the user can update the coupon.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Coupon  $coupon
     * @return mixed
     */
    public function update(Account $account, Coupon $coupon)
    {
        return getRoleResource(self::RESOURCE)->can_edit == self::ENABLED;                
    }

    /**
     * Determine whether the user can delete the coupon.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Coupon  $coupon
     * @return mixed
     */
    public function delete(Account $account, Coupon $coupon)
    {
        return getRoleResource(self::RESOURCE)->can_del == self::ENABLED;
    }
}
