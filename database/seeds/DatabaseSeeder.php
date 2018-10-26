<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserRolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(UserInforsTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(ShopsTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(PromotionsTableSeeder::class);
        $this->call(PromotionDetailsTableSeeder::class);
        $this->call(CouponsTableSeeder::class);
        $this->call(PaymentMethodsTableSeeder::class);
        //$this->call(OrdersTableSeeder::class);
    }
}
