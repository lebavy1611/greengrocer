<?php

namespace App\Policies;

use App\Models\Account;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Product;

class ProductPolicy
{
    use HandlesAuthorization;

    const RESOURCE = 'Product';

    const ENABLED = 1;
    /**
     * Determine whether the user can view the product.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Product  $product
     * @return mixed
     */
    public function view(Account $account, Product $product)
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
     * Determine whether the user can update the product.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Product  $product
     * @return mixed
     */
    public function update(Account $account, Product $product)
    {
        return getRoleResource(self::RESOURCE)->can_edit == self::ENABLED;                
    }

    /**
     * Determine whether the user can delete the product.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Product  $product
     * @return mixed
     */
    public function delete(Account $account, Product $product)
    {
        return getRoleResource(self::RESOURCE)->can_del == self::ENABLED;
    }
}
