<?php

namespace App\Policies;

use App\Models\Account;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Shop;

class ShopPolicy
{
    use HandlesAuthorization;

    const RESOURCE = 'Shop';

    const ENABLED = 1;
    /**
     * Determine whether the user can view the shop.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Shop  $shop
     * @return mixed
     */
    public function view(Account $account, Shop $shop)
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
     * Determine whether the user can update the shop.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Shop  $shop
     * @return mixed
     */
    public function update(Account $account, Shop $shop)
    {
        return getRoleResource(self::RESOURCE)->can_edit == self::ENABLED;                
    }

    /**
     * Determine whether the user can delete the shop.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Shop  $shop
     * @return mixed
     */
    public function delete(Account $account, Shop $shop)
    {
        return getRoleResource(self::RESOURCE)->can_del == self::ENABLED;
    }
}
