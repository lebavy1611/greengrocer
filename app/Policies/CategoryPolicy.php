<?php

namespace App\Policies;

use App\Models\Account;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Category;
use App\Models\RoleResource;
use App\Models\Resource;

class CategoryPolicy
{
    use HandlesAuthorization;

    const RESOURCE = 'Category';

    const ENABLED = 1;
    /**
     * Determine whether the user can view the category.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Category  $category
     * @return mixed
     */
    public function view(Account $account, Category $category)
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
     * Determine whether the user can update the category.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Category  $category
     * @return mixed
     */
    public function update(Account $account, Category $category)
    {
        return getRoleResource(self::RESOURCE)->can_edit == self::ENABLED;                
    }

    /**
     * Determine whether the user can delete the category.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Category  $category
     * @return mixed
     */
    public function delete(Account $account, Category $category)
    {
        return getRoleResource(self::RESOURCE)->can_del == self::ENABLED;
    }
}
