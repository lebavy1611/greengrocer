<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Rating::class, function (Faker $faker) {
    return [
        'product_id' => App\Models\Product::all()->random()->id,
        'customer_id' => App\Models\User::all()->random()->id,
        'stars' => $faker->numberBetween($min = 1, $max = 5),
        'content' => 'aaa',
    ];
});
