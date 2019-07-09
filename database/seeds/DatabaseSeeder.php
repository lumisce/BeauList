<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CategoriesTableSeeder::class);
        factory(App\Brand::class, 10)->create()->each(function ($brand) {
            $brand->products()->save(factory(App\Product::class)->make());
            $brand->products()->save(factory(App\Product::class)->make());
            $brand->products()->save(factory(App\Product::class)->make());
        });
        factory(App\User::class)->create();
    }
}
