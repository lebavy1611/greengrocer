<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Product::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'shop_id' => App\Models\Shop::all()->random()->id,
        'category_id' => App\Models\Category::all()->random()->id,
        'describe' => 'aaa',
        'price' => 100000,
        'origin' => 'da nang',
        'quantity' => 5,
        'active' => $faker->numberBetween($min = 0, $max = 1),
        'imported_date' => \Carbon\Carbon::now(),
        'expired_date' => \Carbon\Carbon::now(),
    ];
});
