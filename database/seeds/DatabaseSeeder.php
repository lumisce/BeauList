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
            for ($i=0; $i < 4; $i++) { 
                $product = factory(App\Product::class)->make();
                $brand->products()->save($product);
                $product->quantityprices()->save(factory(App\QuantityPrice::class)->make());
            }
        });
        factory(App\User::class)->create(['email' => 'abc@abc.com']);
        factory(App\User::class)->create(['email' => 'def@abc.com']);
    }
}
