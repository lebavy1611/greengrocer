<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Shop::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'provider_id' => App\Models\User::where('role_id', 2)->get()->random()->id,
        'address' => $faker->address,
        'phone' => '0352638375',
        'image' => $faker->image,
        'active' => $faker->numberBetween($min = 0, $max = 1),
    ];
});
