<?php

use Faker\Generator as Faker;

$factory->define(App\Models\PromotionDetail::class, function (Faker $faker) {
    return [
        'product_id' => App\Models\Product::all()->random()->id,
        'promotion_id' => App\Models\Promotion::all()->random()->id,
        'quantity' => 10,
    ];
});
