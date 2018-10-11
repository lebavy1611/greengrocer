<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\User;


class UserInforsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $inputId = User::doesntHave('userInfor')->pluck('id')->toArray();
        $inputCount = count($inputId);
        for ($i = 0; $i < $inputCount; $i++) {
            factory(App\Models\UserInfor::class,1)->create([
                'user_id' => $faker->unique()->randomElement($inputId),
            ]);
        }
    }
}
