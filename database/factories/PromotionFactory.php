<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Promotion::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'start_date' => Carbon\Carbon::now()->toDateString(),
        'end_date'   => Carbon\Carbon::now()->addMonth(1)->toDateString(),
        'image' => 'img1.png',
    ];
});
