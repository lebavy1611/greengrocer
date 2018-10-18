<?php

use Illuminate\Database\Seeder;

class PromotionDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\PromotionDetail::class, 15)->create();
    }
}
