<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Category::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'image' => 'img1.jpg',
    ];
});

$factory->state(App\Models\Category::class, 'parent', function (Faker $faker) {
    $category = App\Models\Category::all()->random();
    return [
        'name' => $faker->name,
        'parent_id' => $category->id,
        'image' => 'img1.jpg',
        'position' => 1
    ];
});