<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Category::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'position' => 10,
        'image' => $faker->imageUrl(),
    ];
});

$factory->state(App\Models\Category::class, 'parent', function (Faker $faker) {
    $category = App\Models\Category::all()->random();
    return [
        'name' => $faker->name,
        'parent_id' => $category->id,
    ];
});
