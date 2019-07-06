<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Product;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->colorName,
        'category_id' => $faker->numberBetween(14,43),
        'image' => $faker->imageUrl(600, 600, 'abstract'),
        'description' => $faker->text(50),
        'released_on' => $faker->dateTimeThisYear()
    ];
});
