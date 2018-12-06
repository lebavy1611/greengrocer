<?php

namespace App\Factories;

use Illuminate\Database\Eloquent\Model;
use App\Traits\FilterTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Interfaces\StatisticInterface;
use App\Models\User;
use App\Models\Manager;
use App\Models\Category;
use App\Models\Shop;
use App\Models\Product;
use App\Models\Order;


class StatisticFactory
{
    public static function build($model) 
    {
        if(empty($model)){
            return null;
        }
        switch ($model) {
            case 'User':
                return new User();
                break;
            case 'Manager':
                return new Manager();
                break;
            case 'Category':
                return new Category();
                break;
            case 'Shop':
                return new Shop();
                break;
            case 'Product':
                return new Product();
                break;
            case 'Order':
                return new Order();
                break;
        }
    }
}
