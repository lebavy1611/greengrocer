<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use App\Models\Category;
use App\Policies\CategoryPolicy;
use App\Models\Product;
use App\Policies\ProductPolicy;
use App\Models\Shop;
use App\Policies\ShopPolicy;
use App\Models\User;
use App\Policies\UserPolicy;
use App\Models\Order;
use App\Policies\OrderPolicy;
use App\Models\Promotion;
use App\Policies\PromotionPolicy;
use App\Models\Manager;
use App\Policies\ManagerPolicy;
use App\Models\Coupon;
use App\Policies\CouponPolicy;
use App\Models\Comment;
use App\Policies\CommentPolicy;
use App\Models\Rating;
use App\Policies\RatingPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        Category::class => CategoryPolicy::class,
        Product::class => ProductPolicy::class,
        Shop::class => ShopPolicy::class,
        User::class => UserPolicy::class,
        Order::class => OrderPolicy::class,
        Promotion::class => PromotionPolicy::class,
        Manager::class => ManagerPolicy::class,
        Coupon::class => CouponPolicy::class,
        Comment::class => CommentPolicy::class,
        Rating::class => RatingPolicy::class

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
    }
}
