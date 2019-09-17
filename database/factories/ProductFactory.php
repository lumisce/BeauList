<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
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
	$name = $faker->unique()->colorName;
	$filepath = 'images/products/'.$name.'.jpg';
	Storage::put($filepath, file_get_contents('http://lorempixel.com/200/200/abstract/'));

    return [
        'name' => $name,
        'category_id' => $faker->numberBetween(14,43),
        'image' => Storage::url($filepath),
        'description' => $faker->text(50),
        'released_on' => $faker->dateTimeThisYear()
    ];
});
