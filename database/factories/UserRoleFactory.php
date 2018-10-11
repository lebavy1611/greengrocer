<?php

use Faker\Generator as Faker;

$factory->define(App\Models\UserRole::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
