<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Order::class, function (Faker $faker) {
    return [
        'customer_id' => App\Models\User::all()->random()->id,
        'full_name' => $faker->name,
        'phone' => '0865791234',
        'address' => $faker->address,
        'delivery_time' => \Carbon\Carbon::now(),
        'note' => 'nhanh',
        'processing_status' => 1,
        'payment_status' => 1,
        'payment_method_id' => 1,
        'coupon_id' => 1,
    ];
});
