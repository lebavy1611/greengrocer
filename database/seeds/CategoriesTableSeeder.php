<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 5; $i++) {
            factory(App\Models\Category::class,1)->create([
                'position' => $i
            ]);
        }
        factory(App\Models\Category::class, 5)->states('parent')->create();
    }
}
