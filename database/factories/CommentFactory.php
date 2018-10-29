<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Comment::class, function (Faker $faker) {
    return [
        'product_id' => App\Models\Product::all()->random()->id,
        'customer_id' => App\Models\User::all()->random()->id,
        'parent_id' => App\Models\Product::all()->random()->id,
        'content' => 'aaa',
    ];
});
