<?php

use Faker\Generator as Faker;

$factory->define(App\Models\UserInfor::class, function (Faker $faker) {
    return [
        'fullname' => $faker->name,
        'avatar' => 'img.jpg',
        'gender' => $faker->numberBetween($min = 0, $max = 1),
        'birthday' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'address' => $faker->address,
        'phone' => '01652638375',
    ];
});
