<?php

namespace App\Policies;

use App\Models\Account;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Order;

class OrderPolicy
{
    use HandlesAuthorization;

    const RESOURCE = 'Order';

    const ENABLED = 1;
    /**
     * Determine whether the user can view the order.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Order  $order
     * @return mixed
     */
    public function view(Account $account, Order $order)
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
     * Determine whether the user can update the order.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Order  $order
     * @return mixed
     */
    public function update(Account $account, Order $order)
    {
        return getRoleResource(self::RESOURCE)->can_edit == self::ENABLED;                
    }

    /**
     * Determine whether the user can delete the order.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Order  $order
     * @return mixed
     */
    public function delete(Account $account, Order $order)
    {
        return getRoleResource(self::RESOURCE)->can_del == self::ENABLED;
    }
}
