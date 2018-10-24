<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Coupon::class, function (Faker $faker){
     return [
         'code' => \Carbon\Carbon::now(),
         'percents' => 10,
         'start_date' => \Carbon\Carbon::now(),
         'end_date' => \Carbon\Carbon::now(),
         'times' => 6,
     ];
});
